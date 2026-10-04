<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment\Order;
use App\Models\UserPackage;
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
use App\Models\Class\ClassBooking;
use App\Models\Class\ClassSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $applyPeriod = function ($query, string $column = 'created_at') use ($startDate, $endDate) {
            if ($startDate) {
                $query->whereDate($column, '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate($column, '<=', $endDate);
            }
            return $query;
        };

        // =========================
        // DASHBOARD STATISTICS
        // =========================

        $jumlahInstruktur = $applyPeriod(User::role('instruktur'))->count();
        $jumlahMembers = $applyPeriod(User::role('user'))->count();

        $totalClasses = $applyPeriod(ClassModel::query())->count();
        $totalPackages = $applyPeriod(Package::query())->count();
        $totalArticles = $applyPeriod(Article::query())->count();
        $totalEvents = $applyPeriod(Event::query())->count();
        $totalFaq = $applyPeriod(Faq::query())->count();
        $totalPolling = $applyPeriod(Poll::query())->count();
        $totalPesan = $applyPeriod(Kontak::query())->count();
        $totalTestimonial = $applyPeriod(Testimonial::query())->count();

        // =========================
        // ORDERS & MEMBERSHIP & REVENUE
        // =========================

        $newOrdersCount = $applyPeriod(Order::where('status', 'pending'))->count();
        $newMembershipCount = $applyPeriod(UserPackage::where('status', 'active'), 'started_at')->count();

        $revenuePaid = $applyPeriod(Order::where('status', 'paid'), 'paid_at');
        $revenueMonth = (clone $revenuePaid)->sum('amount');
        $revenueTotal = Order::where('status', 'paid')->sum('amount');

        $orderPaidByDay = Order::where('status', 'paid')
            ->whereNotNull('paid_at')
            ->selectRaw('DATE(paid_at) as day_date, SUM(amount) as total')
            ->groupBy('day_date')
            ->orderBy('day_date')
            ->pluck('total', 'day_date');

        $days = collect(range(0, 6))->map(fn ($i) => now()->subDays(6 - $i)->format('Y-m-d'));
        $revenueDailyLabels = $days->map(fn ($d) => \Carbon\Carbon::parse($d)->format('d M'))->all();
        $revenueDaily = $days->map(fn ($d) => (float) ($orderPaidByDay[$d] ?? 0))->all();

        $monthStart = now()->startOfMonth();
        $monthDays = collect(range(0, now()->daysInMonth - 1))->map(fn ($i) => $monthStart->copy()->addDays($i)->format('Y-m-d'));
        $revenueMonthLabels = $monthDays->map(fn ($d) => \Carbon\Carbon::parse($d)->format('d'))->all();
        $revenueMonthDaily = $monthDays->map(fn ($d) => (float) ($orderPaidByDay[$d] ?? 0))->all();

        $orderPaidByMonth = Order::where('status', 'paid')
            ->whereNotNull('paid_at')
            ->whereYear('paid_at', now()->year)
            ->selectRaw('MONTH(paid_at) as m, SUM(amount) as total')
            ->groupBy('m')
            ->pluck('total', 'm');
        $revenueYearLabels = [];
        $revenueYear = [];
        for ($m = 1; $m <= 12; $m++) {
            $revenueYearLabels[] = now()->startOfYear()->addMonths($m - 1)->format('M');
            $revenueYear[] = (float) ($orderPaidByMonth[$m] ?? 0);
        }

        $revenueAllDaily = $orderPaidByDay->mapWithKeys(fn ($total, $day) => [$day => (float) $total]);

        $recentOrders = $applyPeriod(Order::with('user', 'package')->latest())
            ->take(5)
            ->get();

        $recentMemberships = $applyPeriod(UserPackage::with('user', 'package')->latest(), 'started_at')
            ->take(5)
            ->get();

        // =========================
        // ACTIVE MEMBERSHIP
        // =========================

        $activePackage = $user->userPackages()
            ->with('package')
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>=', now());
            })
            ->latest('started_at')
            ->first();

        // =========================
        // ACTIVE BANNER
        // =========================

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
        // DAY CONFIGURATION
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
        $nextDay = $days[($currentDayIndex + 1) % count($days)];

        // =========================
        // TODAY'S SCHEDULE
        // =========================

        $todaySchedules = ClassSchedule::with([
            'class.instructor'
        ])
            ->withCount([
                'bookings as bookings_count' => function ($q) {
                    $q->whereIn('status', ['confirmed', 'attended']);
                },
            ])
            ->where('status', 'active')
            ->where('day', $today)
            ->orderBy('start_time')
            ->take(5)
            ->get();


        // =========================
        // NEXT DAY SCHEDULE
        // =========================

        $upcomingClasses = ClassSchedule::with([
            'class.instructor'
        ])
            ->where('status', 'active')
            ->where('day', $nextDay)
            ->orderBy('start_time')
            ->take(3)
            ->get();


        // =========================
        // ART OF LIVING COURSES API
        // =========================

        // =========================
        // ART OF LIVING COURSES API
        // =========================

        $courses = [];

        try {

            $response = Http::timeout(30)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'User-Agent' => 'Mozilla/5.0',
                ])
                ->get('https://unity.artofliving.org/csapi/courses', [
                    'type' => 'country',
                    'limit' => 100,
                    'distance' => 50,
                    'language' => 'id-id',
                    'country' => 'id',
                    'order_by' => 'start_date',
                ]);

            if ($response->successful()) {

                $courses = $response->json('courses', []);

                Log::info('Art of Living Courses', [
                    'total' => count($courses),
                    'courses' => $courses,
                ]);
            } else {

                Log::warning('Art of Living API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {

            Log::error('Art of Living API Exception', [
                'message' => $e->getMessage(),
            ]);
        }


        // =========================
        // DETECT MOBILE
        // =========================

        $isMobile = preg_match(
            '/Mobile|Android|iPhone|iPad|iPod/i',
            request()->userAgent()
        );


        // =========================
        // MOBILE USER
        // =========================

        if ($user->hasRole('user') && $isMobile) {

            $todayDate = now()->format('Y-m-d');
            $tomorrowDate = now()->addDay()->format('Y-m-d');
            $scheduleUuids = $todaySchedules->pluck('uuid')->merge($upcomingClasses->pluck('uuid'));

            $myBookings = ClassBooking::where('user_uuid', $user->uuid)
                ->whereIn('class_schedule_uuid', $scheduleUuids)
                ->where('status', '!=', 'cancelled')
                ->get()
                ->keyBy(fn ($b) => $b->class_schedule_uuid . '|' . $b->booking_date?->format('Y-m-d'));

            return view('pages.mobile.home', compact(
                'user',

                // Statistics
                'jumlahInstruktur',
                'jumlahMembers',
                'totalClasses',
                'totalPackages',
                'totalArticles',
                'totalEvents',

                // Banner
                'banner',

                // Events & Schedule
                'events',
                'todaySchedules',
                'upcomingClasses',

                // Membership & bookings
                'activePackage',
                'myBookings',
                'todayDate',
                'tomorrowDate',

                // API Courses
                'courses'
            ));
        }


        // =========================
        // DESKTOP / ADMIN
        // =========================

        return view('pages.dashboard.index', compact(
            'user',

            // Statistics
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

            // Events & Schedule
            'events',
            'todaySchedules',
            'upcomingClasses',

            // API Courses
            'courses',

            // Membership
            'activePackage',

            // Orders, Membership, Revenue
            'newOrdersCount',
            'newMembershipCount',
            'revenueMonth',
            'revenueTotal',
            'recentOrders',
            'recentMemberships',

            // Revenue chart
            'revenueDailyLabels',
            'revenueDaily',
            'revenueMonthLabels',
            'revenueMonthDaily',
            'revenueYearLabels',
            'revenueYear',
            'revenueAllDaily',
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
