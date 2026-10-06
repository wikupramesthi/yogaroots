@extends('layouts.mobile')
@section('title', 'Scan Check-in')
@section('content')

<section class="screen active" id="scan">
    <div class="px-4 pt-4">
        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('dashboard.index') }}"
                class="text-dark text-decoration-none d-inline-flex align-items-center"
                onclick="if (window.history.length > 1) { window.history.back(); return false; }">
                <i class="bi bi-arrow-left fs-5"></i>
                <span class="ms-2 small fw-semibold">{{ __('mobile.back') }}</span>
            </a>
            <div class="ms-2">
                <p class="eyebrow mb-0">Front Desk</p>
                <h1 class="fw-semibold mb-0" style="font-size: 24px;">Scan Check-in</h1>
            </div>
        </div>

        {{-- CAMERA --}}
        <div class="app-card overflow-hidden">
            <div id="qr-reader" style="width:100%;"></div>
        </div>
        <p id="scan-error" class="text-danger m-meta mt-2 mb-0 d-none"></p>

        {{-- MANUAL --}}
        <div class="app-card p-3 mt-3">
            <label for="manual-uuid" class="m-meta fw-semibold">Kode manual</label>
            <div class="d-flex gap-2 mt-1">
                <input type="text" id="manual-uuid" class="form-control"
                    placeholder="BOOKING:uuid" autocomplete="off">
                <button type="button" id="manual-btn" class="btn btn-sage text-nowrap">Cek</button>
            </div>
        </div>

        {{-- RESULT --}}
        <div id="booking-result" class="d-none">
            <div class="app-card p-4 mt-3 text-center">
                <span class="chip bg-sage-soft text-sage text-uppercase m-micro">Booking</span>
                <h5 class="fw-bold mt-2 mb-0" id="b-member">-</h5>
                <p class="text-muted2 m-meta mb-0" id="b-email">-</p>
                <div class="text-start mt-3">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted2 text-small">Kelas</span>
                        <span class="small fw-semibold text-end" id="b-class">-</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted2 text-small">Jadwal</span>
                        <span class="small fw-semibold" id="b-schedule">-</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted2 text-small">Tanggal</span>
                        <span class="small fw-semibold" id="b-date">-</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted2 text-small">Status</span>
                        <span class="small fw-semibold" id="b-status">-</span>
                    </div>
                </div>
                <form id="checkin-form" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" id="checkin-btn" class="btn btn-warm w-100 py-2" disabled>
                        Menunggu QR...
                    </button>
                </form>
            </div>
        </div>

        <div style="height: 24px"></div>
    </div>
</section>

@endsection

@push('after-script')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    (function () {
        var errBox = document.getElementById('scan-error');
        var resultBox = document.getElementById('booking-result');
        var lastCode = '';
        var submitted = {};

        function autoCheckin(form) {
            setTimeout(function () { form.submit(); }, 900);
        }

        function showError(msg) {
            errBox.textContent = msg;
            errBox.classList.remove('d-none');
        }

        function clearError() {
            errBox.textContent = '';
            errBox.classList.add('d-none');
        }

        function parseCode(raw) {
            var code = (raw || '').trim();
            if (code.indexOf('BOOKING:') === 0) code = code.slice(8).trim();
            var uuidRe = /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i;
            return uuidRe.test(code) ? code : null;
        }

        function lookup(uuid, raw) {
            clearError();
            fetch("{{ route('class-bookings.lookup') }}?uuid=" + encodeURIComponent(uuid), {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            })
                .then(function (r) {
                    if (r.status === 401 || r.status === 419) {
                        throw new Error('SESSION');
                    }
                    if (!r.ok) {
                        throw new Error('HTTP ' + r.status);
                    }
                    return r.json();
                })
                .then(function (data) {
                    if (!data || !data.found) {
                        showError('Data tidak ditemukan untuk kode ini [' + uuid + ']. Pastikan QR dari halaman My Bookings yang masih aktif.');
                        return;
                    }
                    resultBox.classList.remove('d-none');
                    document.getElementById('b-member').textContent = data.member;
                    document.getElementById('b-email').textContent = data.email;
                    document.getElementById('b-class').textContent = data.class;
                    document.getElementById('b-schedule').textContent = data.day + ' ' + data.time;
                    document.getElementById('b-date').textContent = data.date;
                    document.getElementById('b-status').textContent = data.status;
                    var form = document.getElementById('checkin-form');
                    var btn = document.getElementById('checkin-btn');
                    form.action = data.checkin_url;
                    if (data.status === 'attended') {
                        btn.disabled = true;
                        btn.textContent = 'Sudah check-in';
                    } else if (data.status === 'confirmed') {
                        // Otomatis check-in: admin tidak perlu tap lagi.
                        btn.disabled = true;
                        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Check-in ' + data.member + '...';
                        submitted[lastCode || document.getElementById('manual-uuid').value] = true;
                        autoCheckin(form);
                    } else {
                        btn.disabled = true;
                        btn.textContent = 'Tidak bisa check-in (' + data.status + ')';
                    }
                    resultBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                })
                .catch(function (err) {
                    if (err && err.message === 'SESSION') {
                        showError('Sesi habis. Login ulang sebagai admin lalu scan lagi.');
                    } else if (err && /^HTTP /.test(err.message || '')) {
                        showError('Server: ' + err.message + ' untuk [' + uuid + '].');
                    } else {
                        showError('Lookup gagal. Periksa koneksi.');
                    }
                });
        }

        function onScan(raw) {
            if (raw === lastCode || submitted[raw]) return;
            var uuid = parseCode(raw);
            if (!uuid) return;
            lastCode = raw;
            lookup(uuid);
            setTimeout(function () { lastCode = ''; }, 5000);
        }

        document.getElementById('manual-btn').addEventListener('click', function () {
            var uuid = parseCode(document.getElementById('manual-uuid').value);
            if (!uuid) { showError('Kode tidak valid (BOOKING:uuid).'); return; }
            lookup(uuid);
        });

        try {
            var scanner = new Html5Qrcode('qr-reader');
            scanner.start(
                { facingMode: 'environment' },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                onScan,
                function () {}
            ).catch(function () {
                showError('Kamera tidak tersedia. Pakai kode manual.');
            });
        } catch (e) {
            showError('Kamera tidak tersedia. Pakai kode manual.');
        }
    })();
</script>
@endpush
