<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\Event;
use App\Models\Class\ClassModel;
use App\Models\Package\Package;
use App\Models\User;
use App\Models\Faq;
use App\Models\Kontak;
use App\Models\Poll;
use App\Models\Testimonial;
use App\Models\Banner;
use App\Models\Class\ClassSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $jumlahInstruktur = User::role('instruktur')->count();
        $jumlahMembers = User::role('user')->count();
        $totalClasses = ClassModel::count();
        $totalPackages = Package::count();
        $totalArticles = Article::count();
        $totalEvents = Event::count();
        $totalFaq = Faq::count();
        $totalPolling = Poll::count();
        $totalPesan = Kontak::count();
        $totalTestimonial = Testimonial::count();

        $banner = Banner::where('status', 'active')
            ->where('posisi', 'slider')
            ->first();


        // =========================
        // UPCOMING EVENTS
        // =========================

        $events = Event::where('status', 'published')
            ->whereDate('tanggal', '>=', now())
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->take(5)
            ->get();

        // =========================
        // TODAY'S SCHEDULE
        // =========================

        $days = [
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday',
        ];

        $today = strtolower(now()->format('l'));

        $currentDayIndex = array_search($today, $days);

        $todaySchedules = ClassSchedule::with([
            'class.instructor'
        ])
            ->withCount('bookings')
            ->where('status', 'active')
            ->where('day', $today)
            ->orderBy('start_time')
            ->take(5)
            ->get();

        // =========================
        // UPCOMING CLASSES
        // NEXT DAY ONLY
        // =========================

        $nextDay = $days[($currentDayIndex + 1) % 7];

        $upcomingClasses = ClassSchedule::with([
            'class.instructor'
        ])
            ->where('status', 'active')
            ->where('day', $nextDay)
            ->orderBy('start_time')
            ->take(3)
            ->get();

        // =========================
        // DETECT MOBILE
        // =========================

        $isMobile = preg_match(
            '/Mobile|Android|iPhone|iPad|iPod/i',
            request()->header('User-Agent')
        );

        // =========================
        // RETURN VIEW
        // =========================

        $isMobile = preg_match(
            '/Mobile|Android|iPhone|iPad|iPod/i',
            request()->header('User-Agent')
        );

        if ($user->hasRole('user') && $isMobile) {
            return view('pages.mobile.home', compact(
                'user',
                'jumlahInstruktur',
                'jumlahMembers',
                'totalClasses',
                'totalPackages',
                'totalArticles',
                'totalEvents',
                'banner',
                'events',
                'todaySchedules',
                'upcomingClasses'
            ));
        }

        return view('pages.dashboard.index', compact(
            'user',
            'jumlahInstruktur',
            'jumlahMembers',
            'totalClasses',
            'totalPackages',
            'totalArticles',
            'totalEvents',
            'totalFaq',
            'totalPolling',
            'totalPesan',
            'totalTestimonial',
            'events',
            'todaySchedules',
            'upcomingClasses'
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
            'sumber_informasi' => [
                'required',
                'string',
                'max:255',
            ],
        ], [
            'no_hp.required' => 'Phone number is required.',
            'no_hp.regex'    => 'Invalid phone number format.',
            'no_hp.unique'   => 'This phone number is already in use.',

            'sumber_informasi.required' => 'Please select how you heard about us.',
            'sumber_informasi.string'   => 'Invalid information source.',
            'sumber_informasi.max'      => 'Information source is too long.',
        ]);

        $user = Auth::user();

        $no_hp = trim($request->no_hp);

        $user->update([
            'no_hp'             => $no_hp,
            'sumber_informasi'  => $request->sumber_informasi,
        ]);

        Auth::setUser($user->fresh());

        return redirect()
            ->route('dashboard.index')
            ->with(
                'success',
                'Thank you! Your WhatsApp number and information source have been successfully saved.'
            );
    }
}
