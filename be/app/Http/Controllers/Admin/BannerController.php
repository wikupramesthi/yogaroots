<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lightweight: only 6 per type for the initial render (rest via load more).
        // Albums: withCount + 2 photos for the collage cover (no full load).
        $fotos = Banner::where('tipe', 'foto')->withCount('albums')->orderBy('created_at', 'desc')->limit(6)->get();
        $videos = Banner::where('tipe', 'video')->orderBy('created_at', 'desc')->limit(6)->get();
        $albums = Album::withCount('fotos')->with(['fotos' => fn($q) => $q->select('banner.uuid', 'banner.nama', 'banner.gambar')])
            ->orderBy('created_at', 'desc')->limit(6)->get();
        // Album options for the select in the photo form (lightweight, uuid+nama only)
        $albumOptions = Album::select('uuid', 'nama')->orderBy('nama')->limit(100)->get();

        $counts = [
            'foto' => Banner::where('tipe', 'foto')->count(),
            'video' => Banner::where('tipe', 'video')->count(),
            'album' => Album::count(),
            'foto_active' => Banner::where('tipe', 'foto')->where('status', 'active')->count(),
        ];

        return view('pages.banner.index', [
            'title'        => 'Media Library',
            'fotos'        => $fotos,
            'videos'       => $videos,
            'albums'       => $albums,
            'albumOptions' => $albumOptions,
            'counts'       => $counts,
        ]);
    }

    /**
     * Photo picker for the album modal (called via AJAX when the modal opens).
     * GET /backend/banner/foto-picker?search=&limit=30&except=
     */
    public function fotoPicker(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $limit = min(50, max(10, (int) $request->query('limit', 30)));
        $q = Banner::where('tipe', 'foto')->select('uuid', 'nama', 'gambar');
        if ($search !== '') {
            $q->where('nama', 'like', '%' . $search . '%');
        }
        $items = $q->orderBy('created_at', 'desc')->limit($limit)->get()
            ->map(fn($b) => ['uuid' => $b->uuid, 'nama' => $b->nama, 'thumb' => $b->gambar()]);
        return response()->json(['data' => $items]);
    }

    /**
     * Album contents for the view modal (called via AJAX when an album is clicked).
     * GET /backend/banner/album-fotos/{album}
     */
    public function albumFotos($uuid)
    {
        $album = Album::where('uuid', $uuid)->firstOrFail();
        $fotos = $album->fotos()->select('banner.uuid', 'banner.nama', 'banner.gambar')->orderBy('banner.created_at', 'desc')->get()
            ->map(fn($b) => ['uuid' => $b->uuid, 'nama' => $b->nama, 'thumb' => $b->gambar()]);
        return response()->json([
            'album' => ['uuid' => $album->uuid, 'nama' => $album->nama, 'deskripsi' => $album->deskripsi, 'count' => $fotos->count()],
            'fotos' => $fotos,
        ]);
    }

    /**
     * On-demand edit/view modal (lightweight, not preloaded in index).
     * GET /backend/banner/modal/{tipe}/{uuid}  tipe: foto|video|album|view-album
     */
    public function modal($tipe, $uuid)
    {
        if ($tipe === 'foto') {
            $item = Banner::where('uuid', $uuid)->with('albums')->firstOrFail();
            $albums = Album::select('uuid', 'nama')->orderBy('nama')->limit(100)->get();
            return view('pages.banner.modal-edit-foto', ['item' => $item, 'albums' => $albums, 'albumOptions' => $albums])->render();
        }
        if ($tipe === 'video') {
            $item = Banner::where('uuid', $uuid)->firstOrFail();
            return view('pages.banner.modal-edit-video', ['item' => $item])->render();
        }
        if ($tipe === 'album') {
            $album = Album::where('uuid', $uuid)->firstOrFail();
            $selected = $album->fotos()->pluck('banner.uuid')->toArray();
            return view('pages.banner.modal-edit-album-dynamic', ['album' => $album, 'selected' => $selected])->render();
        }
        if ($tipe === 'view-album') {
            $album = Album::where('uuid', $uuid)->firstOrFail();
            $viewFotos = $album->fotos()->select('banner.uuid', 'banner.nama', 'banner.gambar')->orderBy('banner.created_at', 'desc')->get();
            return view('pages.banner.modal-view-album', ['album' => $album, 'viewFotos' => $viewFotos])->render();
        }
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tipe = $request->input('tipe', 'foto');

        $rules   = [
            'nama'       => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'status'     => 'required|in:active,inactive',
        ];
        $messages = [
            'nama.required' => 'The media name is required.',
            'status.required' => 'The status field is required.',
        ];

        if ($tipe === 'video') {
            $rules['video_url'] = 'required|string|max:500';
            $messages['video_url.required'] = 'The video link is required.';
        } else {
            $rules['gambar'] = 'required|image|mimes:jpg,jpeg,png,webp|max:5120';
            $rules['posisi'] = 'required|in:slider,pengumuman,infografis,galeri,popup,mitra,lainnya';
            $messages['gambar.required'] = 'A photo must be uploaded.';
            $messages['posisi.required'] = 'The position field is required.';
        }

        $validated = $request->validate($rules, $messages);

        DB::beginTransaction();
        try {
            $data = [
                'uuid'      => Str::uuid(),
                'tipe'      => $tipe,
                'nama'      => $validated['nama'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'status'    => $validated['status'],
                'link'      => $request->input('link'),
            ];

            if ($tipe === 'video') {
                $data['video_url'] = $validated['video_url'];
                $data['posisi']    = 'lainnya';
                $data['gambar']    = '';
            } else {
                $data['posisi'] = $validated['posisi'];
                $data['gambar'] = $this->storeImage($request->file('gambar'));
            }

            $banner = Banner::create($data);

            if ($tipe === 'foto' && $request->filled('album_ids')) {
                $this->syncAlbumFotos($banner, (array) $request->input('album_ids'));
            }

            DB::commit();
            return redirect()->back()->with('success', 'Media added successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Fetch the next media batch for the "load more" button.
     * Lightweight: cards HTML only, edit/view modals are fetched on-demand via /modal/{tipe}/{uuid}.
     */
    public function loadMore(Request $request)
    {
        $tipe   = $request->query('tipe', 'foto');
        $offset = max(0, (int) $request->query('offset', 0));
        $limit  = 6;

        $html       = '';
        $hasMore    = false;
        $nextOffset = $offset + $limit;

        if (! in_array($tipe, ['foto', 'video', 'album'], true)) {
            $tipe = 'foto';
        }

        if ($tipe === 'video') {
            $count = Banner::where('tipe', 'video')->count();
            $items = Banner::where('tipe', 'video')
                ->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($limit + 1)
                ->get();
            $hasMore = $items->count() > $limit;
            $items   = $items->take($limit);
            $html    = view('pages.banner.partials.cards-video', compact('items'))->render();
        } elseif ($tipe === 'album') {
            $count  = Album::count();
            $albums = Album::withCount('fotos')->with(['fotos' => fn($q) => $q->select('banner.uuid', 'banner.nama', 'banner.gambar')])
                ->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($limit + 1)
                ->get();
            $hasMore = $albums->count() > $limit;
            $albums  = $albums->take($limit);
            $html    = view('pages.banner.partials.cards-album', compact('albums'))->render();
        } else {
            $count = Banner::where('tipe', 'foto')->count();
            $items = Banner::where('tipe', 'foto')
                ->withCount('albums')
                ->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($limit + 1)
                ->get();
            $hasMore = $items->count() > $limit;
            $items   = $items->take($limit);
            $html    = view('pages.banner.partials.cards-foto', compact('items'))->render();
        }

        return response()->json([
            'type'      => $tipe,
            'html'      => $html,
            'hasMore'   => $hasMore,
            'offset'    => $nextOffset,
            'remaining' => max(0, $count - $nextOffset),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $banner = Banner::findOrFail($uuid);
        $tipe   = $banner->tipe;

        $rules   = [
            'nama'       => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'status'     => 'required|in:active,inactive',
        ];
        $messages = [
            'nama.required' => 'The media name is required.',
            'status.required' => 'The status field is required.',
        ];

        if ($tipe === 'video') {
            $rules['video_url'] = 'required|string|max:500';
            $messages['video_url.required'] = 'The video link is required.';
        } else {
            $rules['gambar'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120';
            $rules['posisi'] = 'required|in:slider,pengumuman,infografis,galeri,popup,mitra,lainnya';
            $messages['posisi.required'] = 'The position field is required.';
        }

        $validated = $request->validate($rules, $messages);

        DB::beginTransaction();
        try {
            $data = [
                'nama'       => $validated['nama'],
                'deskripsi'  => $validated['deskripsi'] ?? null,
                'status'     => $validated['status'],
                'link'       => $request->input('link'),
            ];

            if ($tipe === 'video') {
                $data['video_url'] = $validated['video_url'];
            } else {
                $data['posisi'] = $validated['posisi'];
                if ($request->hasFile('gambar')) {
                    if ($banner->gambar && Storage::disk('public')->exists($banner->gambar)) {
                        Storage::disk('public')->delete($banner->gambar);
                    }
                    $data['gambar'] = $this->storeImage($request->file('gambar'));
                }
                $this->syncAlbumFotos($banner, $request->filled('album_ids') ? (array) $request->input('album_ids') : []);
            }

            $banner->update($data);

            DB::commit();
            return redirect()->back()->with('success', 'Media updated successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        DB::beginTransaction();
        try {
            $banner = Banner::findOrFail($uuid);

            if ($banner->gambar && Storage::disk('public')->exists($banner->gambar)) {
                Storage::disk('public')->delete($banner->gambar);
            }

            DB::table('album_foto')->where('banner_uuid', $banner->uuid)->delete();
            DB::table('albums')->where('cover', $banner->uuid)->update(['cover' => null]);

            $banner->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Media deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Store a newly created album.
     */
    public function storeAlbum(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status'    => 'required|in:active,inactive',
            'foto_ids'  => 'required|array|min:1',
        ], [
            'nama.required'     => 'The album name is required.',
            'foto_ids.required' => 'Select at least one photo for the album.',
            'foto_ids.min'      => 'Select at least one photo for the album.',
        ]);

        DB::beginTransaction();
        try {
            $fotoIds = array_values($validated['foto_ids']);

            $album = Album::create([
                'uuid'      => Str::uuid(),
                'nama'      => $validated['nama'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'status'    => $validated['status'],
                'cover'     => $fotoIds[0],
            ]);

            $album->fotos()->sync($fotoIds);

            DB::commit();
            return redirect()->back()->with('success', 'Album created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified album.
     */
    public function updateAlbum(Request $request, $uuid)
    {
        $album = Album::findOrFail($uuid);

        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status'    => 'required|in:active,inactive',
            'foto_ids'  => 'required|array|min:1',
        ], [
            'nama.required'     => 'The album name is required.',
            'foto_ids.required' => 'Select at least one photo for the album.',
            'foto_ids.min'      => 'Select at least one photo for the album.',
        ]);

        DB::beginTransaction();
        try {
            $fotoIds = array_values($validated['foto_ids']);

            $album->update([
                'nama'      => $validated['nama'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'status'    => $validated['status'],
                'cover'     => $album->cover && in_array($album->cover, $fotoIds) ? $album->cover : $fotoIds[0],
            ]);

            $album->fotos()->sync($fotoIds);

            DB::commit();
            return redirect()->back()->with('success', 'Album updated successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified album.
     */
    public function destroyAlbum($uuid)
    {
        DB::beginTransaction();
        try {
            $album = Album::findOrFail($uuid);

            DB::table('album_foto')->where('album_uuid', $album->uuid)->delete();
            $album->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Album deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Sync a photo into the selected albums.
     */
    private function syncAlbumFotos(Banner $banner, array $albumIds)
    {
        $albumIds = array_unique(array_values($albumIds));

        DB::table('album_foto')->where('banner_uuid', $banner->uuid)->delete();

        foreach ($albumIds as $albumId) {
            $album = Album::find($albumId);
            if (! $album) {
                continue;
            }

            $exists = DB::table('album_foto')
                ->where('album_uuid', $album->uuid)
                ->where('banner_uuid', $banner->uuid)
                ->exists();

            if (! $exists) {
                DB::table('album_foto')->insert([
                    'album_uuid'  => $album->uuid,
                    'banner_uuid' => $banner->uuid,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }

            if (empty($album->cover)) {
                $album->update(['cover' => $banner->uuid]);
            }
        }
    }

    /**
     * Store an uploaded image compressed & downscaled (max width 1600px)
     * so the media library stays lightweight. No extra dependency (GD only).
     * Returns the storage path, e.g. "banners/xxxx.jpg".
     */
    private function storeImage(UploadedFile $file, string $dir = 'banners', int $maxWidth = 1600): string
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $ext = $ext === 'jpeg' ? 'jpg' : $ext;
        if (! in_array($ext, ['jpg', 'png', 'webp'], true)) {
            return $file->store($dir, 'public');
        }

        $raw = @file_get_contents($file->getRealPath());
        $src = $raw ? @imagecreatefromstring($raw) : false;
        if ($src === false) {
            return $file->store($dir, 'public');
        }

        $width = imagesx($src);
        $height = imagesy($src);
        if ($width > $maxWidth) {
            $height = (int) round($height * $maxWidth / $width);
            $width = $maxWidth;
        }

        $dst = imagecreatetruecolor($width, $height);
        if (in_array($ext, ['png', 'webp'], true)) {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
        }
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, imagesx($src), imagesy($src));

        ob_start();
        match ($ext) {
            'jpg' => imagejpeg($dst, null, 82),
            'png' => imagepng($dst, null, 6),
            'webp' => imagewebp($dst, null, 82),
        };
        $encoded = ob_get_clean();

        imagedestroy($src);
        imagedestroy($dst);

        if (! $encoded) {
            return $file->store($dir, 'public');
        }

        $name = Str::random(40) . '.' . $ext;
        Storage::disk('public')->put($dir . '/' . $name, $encoded);

        return $dir . '/' . $name;
    }
}
