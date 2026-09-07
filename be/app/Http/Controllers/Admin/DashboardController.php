<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\Event;
use App\Models\FileDownload;
use App\Models\User;
use App\Models\Faq;
use App\Models\Kontak;
use App\Models\Poll;
use App\Models\Testimonial;
use App\Models\Class\ClassSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        // =========================
        // DASHBOARD STATISTICS
        // =========================

        $jumlahInstruktur = User::role('instruktur')->count();
        $jumlahMembers = User::role('user')->count();

        $totalArticles = Article::count();
        $totalEvents = Event::count();
        $totalDokumen = FileDownload::count();
        $totalFaq = Faq::count();
        $totalPolling = Poll::count();
        $totalPesan = Kontak::count();
        $totalTestimonial = Testimonial::count();


        // =========================
        // UPCOMING EVENTS
        // =========================

        $events = Event::where('status', 'published')
            ->whereDate('tanggal', '>=', now())
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->take(3)
            ->get();


        // =========================
        // TODAY'S SCHEDULE
        // =========================

        $today = strtolower(now()->format('l'));

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
        // STARTING TOMORROW
        // =========================

        $today = strtolower(now()->format('l'));

        $days = [
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday',
        ];

        $currentDayIndex = array_search($today, $days);

        // Hanya hari setelah hari ini
        $upcomingDays = array_slice($days, $currentDayIndex + 1);

        $upcomingClasses = ClassSchedule::with([
            'class.instructor'
        ])
            ->withCount('bookings')
            ->where('status', 'active')
            ->whereIn('day', $upcomingDays)
            ->orderByRaw(
                'FIELD(day, "' . implode('","', $upcomingDays) . '")'
            )
            ->orderBy('start_time')
            ->take(3)
            ->get();

        return view('pages.dashboard.index', compact(
            'user',

            'jumlahInstruktur',
            'jumlahMembers',

            'totalArticles',
            'totalEvents',
            'totalDokumen',
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

        $no_hp = preg_replace('/^0/', '', trim($request->no_hp));

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
