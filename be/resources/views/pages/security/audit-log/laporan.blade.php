<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Audit Log Report</title>
    <style>
        @page { margin: 22px 28px 42px 28px; }
        * { box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; color: #1f2937; line-height: 1.45; }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-logo { width: 90px; text-align: center; vertical-align: middle; }
        .kop-text { text-align: center; vertical-align: middle; }
        .kop-text .instansi { font-size: 14px; font-weight: bold; color: #1B3A5F; letter-spacing: 0.5px; }
        .kop-text .sub { font-size: 9px; color: #4b5563; }
        .kop-rule { border: none; border-top: 3px solid #1B3A5F; margin: 6px 0 1px 0; }
        .kop-rule2 { border: none; border-top: 1px solid #C9A227; margin: 0 0 12px 0; }
        .judul { text-align: center; margin-bottom: 6px; }
        .judul h1 { font-size: 15px; color: #1B3A5F; margin: 0 0 2px 0; letter-spacing: 1px; }
        .judul .periode { font-size: 10px; font-weight: bold; }
        .meta { width: 100%; border-collapse: collapse; margin: 8px 0 12px 0; font-size: 8px; color: #4b5563; }
        .meta td { padding: 2px 4px; }
        .section-title { font-size: 11px; font-weight: bold; color: #1B3A5F; border-left: 4px solid #C9A227; padding-left: 8px; margin: 12px 0 8px 0; }
        .data-table { width: 100%; border-collapse: collapse; font-size: 8px; }
        .data-table th { background: #1B3A5F; color: #ffffff; padding: 5px 4px; text-align: left; }
        .data-table td { padding: 4px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
        .data-table tr:nth-child(even) td { background: #f3f4f6; }
        .badge { display: inline-block; padding: 1px 6px; border-radius: 8px; font-size: 7px; font-weight: bold; color: #fff; }
        .badge-created { background: #198754; } .badge-updated { background: #0d99c7; } .badge-deleted { background: #dc3545; } .badge-restored { background: #6c757d; }
        .ttd-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .ttd-table td { width: 50%; vertical-align: top; }
        .ttd-box { text-align: center; font-size: 9px; }
        .footer { position: fixed; bottom: -28px; left: 0; right: 0; font-size: 7px; color: #6b7280; border-top: 1px solid #d1d5db; padding-top: 4px; }
        .pagenum:before { content: counter(page); }
        .filter-box { background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 6px; padding: 6px 10px; margin-bottom: 10px; font-size: 8px; }
        .esign { margin-top: 8px; border: 1px dashed #C9A227; border-radius: 6px; padding: 8px; background: #fffbeb; font-size: 7px; color: #92400e; }
    </style>
</head>
<body>
<div class="footer">
    <table style="width:100%; border-collapse:collapse;"><tr><td>Audit Log Report — YogaRoots</td><td style="text-align:right;">Page <span class="pagenum"></span></td></tr></table>
</div>

<table class="kop-table">
    <tr>
        <td class="kop-logo"><img src="{{ public_path('img/logo-yogaroots.png') }}" style="height:60px;" alt="Logo"></td>
        <td class="kop-text">
            <div class="instansi">YOGAROOTS</div>
            <div class="instansi">STUDIO WELLNESS, YOGA &amp; MINDFULNESS</div>
            <div class="sub">Jakarta, Indonesia</div>
        </td>
        <td class="kop-logo"></td>
    </tr>
</table>
<hr class="kop-rule"><hr class="kop-rule2">

<div class="judul">
    <h1>AUDIT TRAIL REPORT</h1>
    <div class="periode">Period: {{ $periode }}</div>
</div>

<table class="meta">
    <tr><td style="width:22%;">User Filter</td><td style="width:35%;">: {{ $filterUser }}</td><td style="width:18%;">Printed by</td><td>: {{ $dicetakOleh }}</td></tr>
    <tr><td>Activity Filter</td><td>: {{ $filterEvent }}</td><td>Print time</td><td>: {{ $waktuCetak }} WIB</td></tr>
    <tr><td>Module Filter</td><td>: {{ $filterModel }}</td><td>Total records</td><td>: {{ number_format($total) }} records</td></tr>
    @if(!empty($search))<tr><td>Search</td><td colspan="3">: {{ $search }}</td></tr>@endif
</table>

<div class="filter-box">
    <strong>Note:</strong> This report was automatically generated from <em>Audit Log</em> YogaRoots. Each data change (created/updated/deleted/restored) is recorded with user, IP, and time for audit purposes.
</div>

<div class="section-title">ACTIVITY LIST ({{ number_format($total) }})</div>
<table class="data-table">
    <thead>
        <tr>
            <th style="width:4%;">No</th>
            <th style="width:13%;">Time</th>
            <th style="width:14%;">User</th>
            <th style="width:8%;">Activity</th>
            <th style="width:12%;">Module</th>
            <th style="width:20%;">Data</th>
            <th style="width:14%;">IP Address</th>
            <th style="width:15%;">Changes</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($logs as $i => $log)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $log->created_at?->format('d/m/Y H:i') ?? '-' }}<br><small style="color:#6b7280;">{{ $log->created_at?->diffForHumans() }}</small></td>
            <td>{{ $log->user_name ?? 'Sistem' }}<br><small style="color:#6b7280;">{{ $log->user_email ?? '-' }}</small></td>
            <td><span class="badge badge-{{ $log->event }}">{{ ucfirst($log->event) }}</span></td>
            <td>{{ class_basename($log->auditable_type) }}</td>
            <td>{{ $log->auditable_label ?? '-' }}<br><small style="color:#6b7280;">#{{ $log->auditable_id }}</small></td>
            <td style="font-family: monospace;">{{ $log->ip_address ?? '-' }}</td>
            <td>
                @php $changes = $log->changes(); @endphp
                @if(empty($changes))
                    <small style="color:#9ca3af;">-</small>
                @else
                    @foreach(array_slice($changes, 0, 3) as $field => $vals)
                        <div><strong>{{ $field }}:</strong> {{ is_scalar($vals['old'] ?? null) ? \Illuminate\Support\Str::limit((string)($vals['old'] ?? '-'), 20) : '-' }} → {{ is_scalar($vals['new'] ?? null) ? \Illuminate\Support\Str::limit((string)($vals['new'] ?? '-'), 20) : '-' }}</div>
                    @endforeach
                    @if(count($changes) > 3)<small style="color:#6b7280;">+{{ count($changes)-3 }} field lain</small>@endif
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center; padding:12px;">Tidak ada data pada periode/filter ini.</td></tr>
        @endforelse
    </tbody>
</table>

<table class="ttd-table">
    <tr>
        <td>
            <div class="esign">
                <strong>E-Sign / Verifikasi:</strong><br>
                Dokumen ini dicetak otomatis dari sistem YogaRoots. Keaslian dapat diverifikasi dengan mencocokkan waktu cetak &amp; filter di atas dengan data di menu <em>Keamanan &gt; Audit Log</em>.<br>
                Hash: {{ md5($waktuCetak . $total . $periode) }}
            </div>
        </td>
        <td>
            <div class="ttd-box">
                Jakarta, {{ now()->translatedFormat('d F Y') }}<br>
                Management YogaRoots<br><br><br><br>
                <strong><u>( ........................................ )</u></strong>..
            </div>
        </td>
    </tr>
</table>

</body>
</html>
