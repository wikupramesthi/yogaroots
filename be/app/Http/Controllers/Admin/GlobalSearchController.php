<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Class\ClassModel;
use App\Models\Event;
use App\Models\Faq;
use App\Models\Package\Package;
use App\Models\Page;
use App\Models\Studio;
use App\Models\User;
use Illuminate\Http\Request;

class GlobalSearchController extends Controller
{
    /** Maksimal hasil per grup modul. */
    private const PER_GROUP = 4;

    /**
     * Pencarian global lintas modul untuk command palette (Ctrl+K).
     * GET /backend/search?q=...&nbsp;→ JSON { results: [...] }
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        if (mb_strlen($q) < 2 || mb_strlen($q) > 60) {
            return response()->json(['results' => []]);
        }

        $like = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $q) . '%';
        $results = [];

        $push = function (string $type, string $title, ?string $subtitle, string $url) use (&$results) {
            $results[] = [
                'type' => $type,
                'title' => $title,
                'subtitle' => $subtitle,
                'url' => $url,
            ];
        };

        foreach (Article::where('title', 'like', $like)->orWhere('excerpt', 'like', $like)->limit(self::PER_GROUP)->get(['uuid', 'title', 'excerpt']) as $a) {
            $push('Artikel', $a->title, $a->excerpt ? mb_strimwidth(strip_tags($a->excerpt), 0, 80, '…') : null, route('articles.edit', $a->uuid));
        }

        foreach (Event::where('judul', 'like', $like)->limit(self::PER_GROUP)->get(['uuid', 'judul', 'tanggal']) as $e) {
            $push('Event', $e->judul, $e->tanggal, route('events.edit', $e->uuid));
        }

        foreach (ClassModel::where('name', 'like', $like)->limit(self::PER_GROUP)->get(['uuid', 'name']) as $c) {
            $push('Kelas', $c->name, null, route('classes.edit', $c->uuid));
        }

        foreach (Package::where('name', 'like', $like)->limit(self::PER_GROUP)->get(['uuid', 'name']) as $p) {
            $push('Paket', $p->name, null, route('packages.edit', $p->uuid));
        }

        foreach (Studio::where('name', 'like', $like)->limit(self::PER_GROUP)->get(['uuid', 'name']) as $s) {
            $push('Studio', $s->name, null, route('studios.edit', $s->uuid));
        }

        foreach (Page::where('title', 'like', $like)->limit(self::PER_GROUP)->get(['uuid', 'title']) as $pg) {
            $push('Halaman', $pg->title, null, route('pages.edit', $pg->uuid));
        }

        foreach (Faq::where('pertanyaan', 'like', $like)->limit(self::PER_GROUP)->get(['uuid', 'pertanyaan']) as $f) {
            $push('FAQ', $f->pertanyaan, null, route('faq.index'));
        }

        foreach (User::where('name', 'like', $like)->orWhere('email', 'like', $like)->limit(self::PER_GROUP)->get(['uuid', 'name', 'email']) as $u) {
            $push('Pengguna', $u->name, $u->email, route('pengguna.index'));
        }

        if (mb_stripos('website identity', $q) !== false || mb_stripos('site identity', $q) !== false) {
            $push('Settings', 'Website Identity', 'Name, logo, contact & socials', route('website-identity.index'));
        }

        return response()->json(['results' => $results]);
    }
}
