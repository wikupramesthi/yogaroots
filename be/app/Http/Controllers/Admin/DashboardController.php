<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\Banner;
use App\Models\FileDownload;
use App\Models\User;
use App\Models\Faq;
use App\Models\Kontak;
use App\Models\Poll;
use App\Models\Testimonial;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $jumlahUser       = User::role('guru')->count();
        $totalArticles    = Article::count();
        $totalBanner      = Banner::count();
        $totalDokumen     = FileDownload::count();
        $totalFaq         = Faq::count();
        $totalPolling     = Poll::count();
        $totalPesan       = Kontak::count();
        $totalTestimonial = Testimonial::count();

        $categories       = Category::withCount('articles')->get();
        $categoryLabels   = $categories->pluck('name');
        $categoryCounts   = $categories->pluck('articles_count');

        return view('pages.dashboard.index', compact(
            'user',
            'jumlahUser',
            'totalArticles',
            'totalBanner',
            'totalDokumen',
            'totalFaq',
            'totalPolling',
            'totalPesan',
            'totalTestimonial',
            'categoryLabels',
            'categoryCounts'
        ));
    }

    public function submitSumber(Request $request)
    {
        $request->validate([
            'no_hp' => [
                'required',
                'regex:/^[0-9]{8,15}$/',
                'unique:users,no_hp,' . Auth::user()->uuid . ',uuid',
            ],
        ], [
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex'    => 'Format nomor HP tidak valid.',
            'no_hp.unique'   => 'No. HP ini sudah digunakan.',
        ]);

        $user = Auth::user();

        $no_hp = preg_replace('/^0/', '', trim($request->no_hp));

        $user->update([
            'no_hp' => $no_hp,
        ]);

        Auth::setUser($user->fresh());

        return redirect()
            ->route('dashboard.index')
            ->with('success', 'Terima kasih! No. Whatsapp Anda berhasil disimpan.');
    }
}
