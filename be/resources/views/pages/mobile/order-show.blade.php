@extends('layouts.mobile')
@section('title', 'Order Detail')
@section('content')

<section class="screen active" id="order-detail">
    <div class="px-4 pt-4">

        {{-- BACK --}}
        <a href="{{ route('orders.index') }}"
            class="text-dark text-decoration-none d-inline-flex align-items-center mb-3">
            <i class="bi bi-arrow-left fs-5"></i>
        </a>

        @php
            $isOwner = $order->user_uuid === auth()->user()->uuid;
            $bankName = config('manual_payment.bank_name');
            $bankAccount = config('manual_payment.bank_account');
            $bankHolder = config('manual_payment.bank_holder');
            $waNumber = preg_replace('/\D/', '', (string) config('manual_payment.admin_whatsapp'));
            $waText = 'Hello YogaRoots Admin, I have transferred Rp ' . number_format($order->amount, 0, ',', '.') . ' for order ' . $order->order_number . ' (' . ($order->user?->name ?? '') . '). Thank you.';
        @endphp

        {{-- STATUS --}}
        <div class="app-card p-4 text-center mt-2">
            @if ($order->status === 'paid')
                <div class="status-circle paid d-inline-flex align-items-center justify-content-center mx-auto"
                    style="width:56px;height:56px;border-radius:50%;background:#e8f3ea;">
                    <i class="bi bi-check-lg text-success fs-4"></i>
                </div>
                <h2 class="h5 fw-semibold mt-3 mb-1">Payment Successful</h2>
                <p class="mb-0 text-muted2 text-small">Your membership is active.</p>
            @elseif ($order->status === 'pending')
                <div class="d-inline-flex align-items-center justify-content-center mx-auto"
                    style="width:56px;height:56px;border-radius:50%;background:#fff4e5;">
                    <i class="bi bi-clock text-warning fs-4"></i>
                </div>
                <h2 class="h5 fw-semibold mt-3 mb-1">Payment Pending</h2>
                <p class="mb-0 text-muted2 text-small">Complete the transfer below.</p>
            @elseif ($order->status === 'failed')
                <div class="d-inline-flex align-items-center justify-content-center mx-auto"
                    style="width:56px;height:56px;border-radius:50%;background:#fdecea;">
                    <i class="bi bi-x-lg text-danger fs-4"></i>
                </div>
                <h2 class="h5 fw-semibold mt-3 mb-1">Payment Failed</h2>
                <p class="mb-0 text-muted2 text-small">We could not complete this payment.</p>
            @else
                <div class="d-inline-flex align-items-center justify-content-center mx-auto"
                    style="width:56px;height:56px;border-radius:50%;background:#ededed;">
                    <i class="bi bi-hourglass-bottom text-secondary fs-4"></i>
                </div>
                <h2 class="h5 fw-semibold mt-3 mb-1">{{ ucfirst($order->status) }}</h2>
                <p class="mb-0 text-muted2 text-small">Order #{{ $order->order_number }}</p>
            @endif
        </div>

        {{-- MEMBERSHIP ACTIVE --}}
        @if ($userPackage)
            <div class="alert alert-success d-flex align-items-center gap-2 mt-3">
                <i class="bi bi-check-circle-fill"></i>
                <div style="font-size:13px;">
                    Membership active
                    @if ($userPackage->quota === null) (Unlimited) @else ({{ $userPackage->quota }} classes left) @endif
                    until {{ $userPackage->expired_at?->format('d M Y') ?? '-' }}.
                </div>
            </div>
        @endif

        {{-- SUMMARY --}}
        <div class="app-card p-3 mt-3">
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <span class="text-muted2 text-small">Order</span>
                <span class="small fw-semibold">#{{ $order->order_number }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <span class="text-muted2 text-small">Package</span>
                <span class="small fw-semibold text-end" style="max-width:60%;">
                    {{ $order->package?->name ?? 'Single Class' }}
                    @if ($order->packageOption?->name)
                        <small class="d-block text-muted2 fw-normal">{{ $order->packageOption->name }}</small>
                    @endif
                </span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <span class="text-muted2 text-small">Date</span>
                <span class="small fw-semibold">{{ $order->created_at?->format('d M Y') ?? '-' }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2">
                <span class="text-muted2 text-small">Amount</span>
                <span class="small fw-semibold">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- PAYMENT INSTRUCTIONS --}}
        @if ($order->status === 'pending')
            <div class="app-card p-3 mt-3">
                <h3 class="h6 fw-semibold mb-2">Complete Your Payment</h3>
                <ol class="small text-muted2 mb-3 ps-3 text-small" style="line-height:1.6;">
                    <li>Transfer the exact amount below to our bank account.</li>
                    <li>Upload your transfer proof (or confirm via WhatsApp).</li>
                    <li>Admin verifies it — your membership activates automatically.</li>
                </ol>

                @if ($bankAccount)
                    <div class="p-3 rounded-3 bg-sage-soft mb-3">
                        <div class="m-micro text-uppercase text-muted2">Bank</div>
                        <div class="fw-bold">{{ $bankName }}</div>
                        <div class="m-micro fw-semibold">{{ $bankAccount }}</div>
                        @if ($bankHolder)
                            <div class="m-micro text-muted2">Account holder: {{ $bankHolder }}</div>
                        @endif
                        <div class="mt-2 m-meta">
                            Amount: <strong>Rp {{ number_format($order->amount, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                @endif

                @if ($waNumber)
                    <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($waText) }}" target="_blank"
                        rel="noopener" class="btn btn-success w-100 mb-3">
                        <i class="bi bi-whatsapp me-1"></i> Confirm via WhatsApp
                    </a>
                @endif

                @if ($order->proof_image_path)
                    <div class="p-3 rounded-3 bg-sage-soft mb-3">
                        <a href="{{ $order->proofUrl() }}" target="_blank" rel="noopener" class="text-decoration-none d-block mb-2">
                            <img src="{{ $order->proofUrl() }}" alt="Transfer proof"
                                class="rounded-3 border w-100" style="max-height:200px;object-fit:cover;">
                        </a>
                        <div class="m-meta text-success fw-semibold">
                            <i class="bi bi-check-circle me-1"></i>Proof uploaded
                        </div>
                        <div class="m-micro text-muted2">
                            {{ $order->proof_uploaded_at?->format('d M Y H:i') ?? '' }} — waiting for admin verification.
                        </div>
                    </div>
                @endif

                @if ($isOwner)
                    <form action="{{ route('orders.proof', $order->uuid) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <label class="m-meta fw-semibold" for="proofInput">
                            Upload transfer proof (JPG/PNG/WebP, max {{ number_format(config('manual_payment.proof_max_kb', 3072) / 1024, 1) }} MB)
                        </label>
                        <input type="file" name="proof" id="proofInput" class="form-control mt-1"
                            accept="image/jpeg,image/png,image/webp" required>
                        <button type="submit" class="btn btn-sage w-100 mt-2">
                            <i class="bi bi-upload me-1"></i>
                            {{ $order->proof_image_path ? 'Replace Proof' : 'Upload Proof' }}
                        </button>
                    </form>
                @endif
            </div>
        @endif

        <div style="height: 24px"></div>
    </div>
</section>

@endsection
