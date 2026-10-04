{{-- Admin dashboard (dilibatkan oleh pages.dashboard.index saat bukan role user) --}}
<div class="d-grid gap-4">

    {{-- HERO --}}
    <div class="dash-hero">
        <div class="hero-content d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="hero-date"><i class="bi bi-calendar3"></i> {{ now()->translatedFormat('l, j F Y') }}</span>
                <h3>Welcome back, {{ auth()->user()->name }} 🌿</h3>
                <p>A quick overview of studio activities and performance.</p>
            </div>
            <div class="hero-action d-flex gap-2">
                <a href="{{ route('orders.report') }}" class="btn btn-light"><i class="bi bi-bar-chart me-1"></i> Reports</a>
                <a href="{{ route('class-schedules.index') }}" class="btn btn-light"><i class="bi bi-calendar-week me-1"></i> Schedule</a>
            </div>
        </div>
    </div>

    {{-- FILTER TANGGAL --}}
    <div class="card mb-2">
        <div class="card-body">
            <form action="{{ route('dashboard.index') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-auto col-12">
                    <label class="form-label small fw-semibold mb-1">From Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-auto col-12">
                    <label class="form-label small fw-semibold mb-1">To Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-auto col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-funnel"></i> Filter</button>
                    <a href="{{ route('dashboard.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- STAT CARDS --}}
    @php
        $stats = [
            ['label' => 'Active Members', 'value' => $jumlahMembers, 'icon' => 'bi bi-people', 'class' => 'purple', 'route' => route('pengguna.index')],
            ['label' => 'Instructors', 'value' => $jumlahInstruktur, 'icon' => 'bi bi-person-badge', 'class' => 'blue', 'route' => route('instruktur.index')],
            ['label' => 'Packages', 'value' => $totalPackages, 'icon' => 'bi bi-box-seam', 'class' => 'green', 'route' => route('packages.index')],
            ['label' => 'Classes', 'value' => $totalClasses, 'icon' => 'bi bi-book', 'class' => 'red', 'route' => route('classes.index')],
            ['label' => 'Events', 'value' => $totalEvents, 'icon' => 'bi bi-calendar-event', 'class' => 'cyan', 'route' => route('events.index')],
            ['label' => 'Articles', 'value' => $totalArticles, 'icon' => 'bi bi-file-earmark-text', 'class' => 'yellow', 'route' => route('articles.index')],
            ['label' => 'FAQ', 'value' => $totalFaq, 'icon' => 'bi bi-question-circle', 'class' => 'pink', 'route' => route('faq.index')],
            ['label' => 'Incoming Messages', 'value' => $totalPesan, 'icon' => 'bi bi-envelope', 'class' => 'turquoise', 'route' => route('layanan.kontak')],
        ];
    @endphp

    <div class="row g-4">
        @foreach ($stats as $s)
            <div class="col-6 col-md-4 col-xl-3">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stats-icon {{ $s['class'] }}">
                            <i class="{{ $s['icon'] }}"></i>
                        </div>
                        <div class="min-w-0">
                            <h6 class="text-muted font-semibold mb-0 text-truncate">{{ $s['label'] }}</h6>
                            <a href="{{ $s['route'] }}" class="text-decoration-none">
                                <h4 class="font-extrabold mb-0">{{ $s['value'] }}</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ORDER, MEMBERSHIP & REVENUE --}}
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stats-icon yellow"><i class="bi bi-bag-plus"></i></div>
                    <div class="min-w-0">
                        <h6 class="text-muted font-semibold mb-0">New Orders (Pending)</h6>
                        <a href="{{ route('orders.index') }}" class="text-decoration-none">
                            <h4 class="font-extrabold mb-0">{{ $newOrdersCount }}</h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stats-icon green"><i class="bi bi-person-plus"></i></div>
                    <div class="min-w-0">
                        <h6 class="text-muted font-semibold mb-0">New Memberships</h6>
                        <a href="{{ route('memberships.index') }}" class="text-decoration-none">
                            <h4 class="font-extrabold mb-0">{{ $newMembershipCount }}</h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stats-icon blue"><i class="bi bi-cash-stack"></i></div>
                    <div class="min-w-0">
                        <h6 class="text-muted font-semibold mb-0">Revenue</h6>
                        <h4 class="font-extrabold mb-0 text-success">Rp {{ number_format($revenueMonth, 0, ',', '.') }}</h4>
                        <small class="text-muted">Total: Rp {{ number_format($revenueTotal, 0, ',', '.') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- REVENUE CHART --}}
    <div class="row g-4">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Revenue</h5>
                    <div class="d-flex align-items-center gap-2 flex-wrap justify-content-end">
                        <input type="date" id="revenueFrom" class="form-control form-control-sm" style="width:auto" value="{{ now()->subDays(6)->format('Y-m-d') }}">
                        <input type="date" id="revenueTo" class="form-control form-control-sm" style="width:auto" value="{{ now()->format('Y-m-d') }}">
                        <select id="revenueChartRange" class="form-select form-select-sm" style="width:auto">
                            <option value="daily">Per Day</option>
                            <option value="monthly">This Month</option>
                            <option value="yearly">This Year</option>
                        </select>
                        <button id="revenueApply" class="btn btn-sm btn-primary"><i class="bi bi-funnel"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div style="position:relative;height:300px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ORDER & MEMBERSHIP TERBARU --}}
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Orders</h5>
                    <a href="{{ route('orders.index') }}" class="small text-decoration-none text-primary fw-semibold">View All</a>
                </div>
                <div class="card-body table-responsive">
                    @if ($recentOrders->count())
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Order No.</th>
                                    <th>Member</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentOrders as $order)
                                    <tr>
                                        <td class="fw-semibold">{{ $order->order_number }}</td>
                                        <td>{{ $order->user->name ?? '-' }}</td>
                                        <td>Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                                        <td>
                                            @php
                                                $badge = match ($order->status) {
                                                    'paid' => 'bg-light-success',
                                                    'pending' => 'bg-light-warning',
                                                    default => 'bg-light-danger',
                                                };
                                            @endphp
                                            <span class="badge {{ $badge }}">{{ ucfirst($order->status) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center text-muted py-4">No orders yet.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Memberships</h5>
                    <a href="{{ route('memberships.index') }}" class="small text-decoration-none text-primary fw-semibold">View All</a>
                </div>
                <div class="card-body">
                    @forelse ($recentMemberships as $membership)
                        <div class="d-flex align-items-center gap-3 {{ $loop->last ? '' : 'border-bottom pb-3 mb-3' }}">
                            <div class="avatar avatar-md2">
                                <div class="avatar-content bg-light-success">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold small text-truncate">{{ $membership->user->name ?? '-' }}</div>
                                <div class="small text-muted text-truncate">{{ $membership->package->name ?? '-' }} · {{ \Carbon\Carbon::parse($membership->started_at)->format('d M Y') }}</div>
                            </div>
                            <span class="badge {{ $membership->status === 'active' ? 'bg-light-success' : 'bg-light-secondary' }}">{{ ucfirst($membership->status) }}</span>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">No memberships yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- JADWAL HARI INI & EVENT --}}
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Today's Schedule</h5>
                    <a href="{{ route('class-schedules.index') }}" class="small text-decoration-none text-primary fw-semibold">View All</a>
                </div>
                <div class="card-body table-responsive">
                    @if ($todaySchedules->count())
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Time</th>
                                    <th>Instructor</th>
                                    <th>Level</th>
                                    <th>Attendees</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($todaySchedules as $schedule)
                                    <tr>
                                        <td class="fw-semibold">{{ $schedule->class->name ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                                        <td>{{ $schedule->class->instructor->name ?? '-' }}</td>
                                        <td><span class="badge bg-light-secondary">{{ $schedule->class->level ?? '-' }}</span></td>
                                        <td>
                                            @if (($schedule->bookings_count ?? 0) >= ($schedule->capacity ?? PHP_INT_MAX))
                                                <span class="badge bg-light-danger">Full</span>
                                            @else
                                                <span class="badge bg-light-success">{{ $schedule->bookings_count ?? 0 }} / {{ $schedule->capacity ?? '∞' }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                            No classes scheduled today.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">Upcoming Events</h5>
                </div>
                <div class="card-body">
                    @forelse ($events as $event)
                        <div class="d-flex gap-3 {{ $loop->last ? '' : 'border-bottom pb-3 mb-3' }}">
                            <div class="text-center" style="min-width:52px;">
                                <div class="fw-extrabold fs-4 lh-1">{{ \Carbon\Carbon::parse($event->tanggal)->format('d') }}</div>
                                <div class="small text-muted text-uppercase">{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('M') }}</div>
                            </div>
                            <div class="min-w-0">
                                <div class="fw-semibold small text-truncate">{{ $event->judul ?? $event->title ?? '-' }}</div>
                                <div class="small text-muted">{{ $event->waktu_mulai ?? '' }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">No upcoming events.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- KELAS BERIKUTNYA & AKSES CEPAT --}}
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">Upcoming Classes</h5>
                </div>
                <div class="card-body">
                    @forelse ($upcomingClasses as $kelas)
                        <div class="d-flex align-items-center gap-3 {{ $loop->last ? '' : 'border-bottom pb-3 mb-3' }}">
                            <div class="avatar avatar-md2">
                                <div class="avatar-content bg-light-primary">
                                    <i class="bi bi-activity"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold small text-truncate">{{ $kelas->class->name ?? '-' }}</div>
                                <div class="small text-muted">{{ ucfirst($kelas->day) }} · {{ \Carbon\Carbon::parse($kelas->start_time)->format('H:i') }}</div>
                            </div>
                            <span class="badge bg-light-primary">{{ $kelas->class->level ?? '-' }}</span>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">No upcoming classes.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">Quick Access</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <a href="{{ route('class-bookings.index') }}" class="text-decoration-none">
                                <div class="border rounded-3 p-3 text-center h-100">
                                    <i class="bi bi-journal-check fs-4 text-primary"></i>
                                    <div class="small fw-semibold mt-2">Bookings</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('orders.index') }}" class="text-decoration-none">
                                <div class="border rounded-3 p-3 text-center h-100">
                                    <i class="bi bi-credit-card fs-4 text-success"></i>
                                    <div class="small fw-semibold mt-2">Orders</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('banner.index') }}" class="text-decoration-none">
                                <div class="border rounded-3 p-3 text-center h-100">
                                    <i class="bi bi-images fs-4 text-warning"></i>
                                    <div class="small fw-semibold mt-2">Banners</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('testimonial.index') }}" class="text-decoration-none">
                                <div class="border rounded-3 p-3 text-center h-100">
                                    <i class="bi bi-chat-quote fs-4 text-info"></i>
                                    <div class="small fw-semibold mt-2">Testimonials</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('website-identity.index') }}" class="text-decoration-none">
                                <div class="border rounded-3 p-3 text-center h-100">
                                    <i class="bi bi-globe fs-4 text-danger"></i>
                                    <div class="small fw-semibold mt-2">Website</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('security.audit-log.index') }}" class="text-decoration-none">
                                <div class="border rounded-3 p-3 text-center h-100">
                                    <i class="bi bi-shield-check fs-4 text-secondary"></i>
                                    <div class="small fw-semibold mt-2">Audit Log</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('after-script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function () {
    const dailyLabels = @json($revenueDailyLabels);
    const daily = @json($revenueDaily);
    const monthLabels = @json($revenueMonthLabels);
    const monthDaily = @json($revenueMonthDaily);
    const yearLabels = @json($revenueYearLabels);
    const year = @json($revenueYear);
    const allDaily = @json($revenueAllDaily);

    function dailyRangeSeries(from, to) {
        const keys = Object.keys(allDaily).sort().filter(d => d >= from && d <= to);
        if (keys.length === 0) return { labels: [], data: [] };
        const start = new Date(from);
        const end = new Date(to);
        const labels = [];
        const data = [];
        for (let d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
            const key = d.toISOString().slice(0, 10);
            labels.push(d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' }));
            data.push(Number(allDaily[key] || 0));
        }
        return { labels, data };
    }

    function currentSet() {
        const mode = document.getElementById('revenueChartRange').value;
        if (mode === 'monthly') return { labels: monthLabels, data: monthDaily };
        if (mode === 'yearly') return { labels: yearLabels, data: year };
        const from = document.getElementById('revenueFrom').value;
        const to = document.getElementById('revenueTo').value;
        if (from && to) return dailyRangeSeries(from, to);
        return { labels: dailyLabels, data: daily };
    }

    const ctx = document.getElementById('revenueChart');
    if (!ctx || typeof Chart === 'undefined') return;

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Revenue (Rp)',
                data: daily,
                borderColor: '#2f7d4f',
                backgroundColor: 'rgba(47,125,79,0.12)',
                fill: true,
                tension: 0.3,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    ticks: {
                        callback: (v) => 'Rp ' + Number(v).toLocaleString('id-ID'),
                    },
                },
            },
        },
    });

    function refresh() {
        const set = currentSet();
        chart.data.labels = set.labels;
        chart.data.datasets[0].data = set.data;
        chart.update();
    }

    document.getElementById('revenueChartRange').addEventListener('change', refresh);
    document.getElementById('revenueApply').addEventListener('click', refresh);
})();
</script>
@endpush

