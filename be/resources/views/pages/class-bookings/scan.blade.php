@extends('layouts.app')

@section('title', 'Scan Check-in')

@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Scan Check-in" page="Memberships" active="Scan"
        route="{{ route('class-bookings.scan') }}" />
@endsection

<section class="section">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible mb-3 fade show" role="alert">
            <span class="alert-text text-white">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible mb-3 fade show" role="alert">
            <span class="alert-text text-white">{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Scan Member QR</h5>
                    <small class="text-muted">Member shows the QR from My Bookings → Check-in QR</small>
                </div>
                <div class="card-body">
                    <div id="qr-reader" style="width:100%;"></div>
                    <p id="scan-error" class="text-danger small mt-2 mb-0 d-none"></p>
                    <hr>
                    <label for="manual-uuid" class="form-label small fw-semibold">Or enter code manually</label>
                    <div class="input-group">
                        <input type="text" id="manual-uuid" class="form-control"
                            placeholder="BOOKING:uuid or uuid">
                        <button type="button" id="manual-btn" class="btn btn-primary">Lookup</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Booking</h5>
                </div>
                <div class="card-body">
                    <div id="booking-empty" class="text-muted">
                        Scan a QR or enter the code to load the booking.
                    </div>
                    <div id="booking-result" class="d-none">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Member</dt>
                            <dd class="col-sm-8 fw-semibold" id="b-member">-</dd>
                            <dt class="col-sm-4">Class</dt>
                            <dd class="col-sm-8" id="b-class">-</dd>
                            <dt class="col-sm-4">Schedule</dt>
                            <dd class="col-sm-8" id="b-schedule">-</dd>
                            <dt class="col-sm-4">Date</dt>
                            <dd class="col-sm-8" id="b-date">-</dd>
                            <dt class="col-sm-4">Status</dt>
                            <dd class="col-sm-8" id="b-status">-</dd>
                        </dl>
                        <form id="checkin-form" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" id="checkin-btn" class="btn btn-success w-100">
                                Check In
                            </button>
                        </form>
                        <p class="text-muted small mt-2 mb-0">Admin can check in confirmed bookings for any date. Members can only self check-in on the class day.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('after-script')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    (function () {
        var scanError = document.getElementById('scan-error');
        var emptyBox = document.getElementById('booking-empty');
        var resultBox = document.getElementById('booking-result');
        var lastCode = '';

        function showError(msg) {
            scanError.textContent = msg;
            scanError.classList.remove('d-none');
        }

        function clearError() {
            scanError.textContent = '';
            scanError.classList.add('d-none');
        }

        function parseCode(raw) {
            var code = (raw || '').trim();
            if (code.indexOf('BOOKING:') === 0) code = code.slice(8).trim();
            var uuidRe = /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i;
            return uuidRe.test(code) ? code : null;
        }

        function lookup(uuid) {
            clearError();
            fetch("{{ route('class-bookings.lookup') }}?uuid=" + encodeURIComponent(uuid), {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (!data.found) { showError('Booking not found.'); return; }
                    emptyBox.classList.add('d-none');
                    resultBox.classList.remove('d-none');
                    document.getElementById('b-member').textContent = data.member + ' (' + data.email + ')';
                    document.getElementById('b-class').textContent = data.class;
                    document.getElementById('b-schedule').textContent = data.day + ' ' + data.time;
                    document.getElementById('b-date').textContent = data.date;
                    document.getElementById('b-status').textContent = data.status;
                    var form = document.getElementById('checkin-form');
                    var btn = document.getElementById('checkin-btn');
                    form.action = data.checkin_url;
                    var ok = data.status === 'confirmed';
                    btn.disabled = !ok;
                    btn.textContent = data.status === 'attended'
                        ? 'Already checked in'
                        : (!data.is_today ? 'Check In (' + data.date + ')' : (ok ? 'Check In' : 'Cannot check in (' + data.status + ')'));
                })
                .catch(function () { showError('Lookup failed. Check connection.'); });
        }

        function onScan(raw) {
            if (raw === lastCode) return;
            var uuid = parseCode(raw);
            if (!uuid) { showError('QR code not recognized.'); return; }
            lastCode = raw;
            lookup(uuid);
            setTimeout(function () { lastCode = ''; }, 5000);
        }

        document.getElementById('manual-btn').addEventListener('click', function () {
            var uuid = parseCode(document.getElementById('manual-uuid').value);
            if (!uuid) { showError('Invalid code. Expected BOOKING:uuid.'); return; }
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
                showError('Camera unavailable. Use manual entry.');
            });
        } catch (e) {
            showError('Camera unavailable. Use manual entry.');
        }
    })();
</script>
@endpush
