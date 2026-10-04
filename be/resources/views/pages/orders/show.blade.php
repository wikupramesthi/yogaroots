@extends('layouts.app')

@section('title', 'Payment Receipt')

@section('content')

<div class="receipt-page">
    <div class="receipt-wrapper">

        {{-- Top Navigation --}}
        <div class="receipt-topbar">

            <a
                href="{{ route('orders.index') }}"
                class="back-link">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Billing</span>
            </a>

            <button
                type="button"
                onclick="window.print()"
                class="print-button">
                <i class="bi bi-printer"></i>
                <span>Print Receipt</span>
            </button>

        </div>


        {{-- Admin verification (manual transfer) --}}
        @if ($isAdmin && $order->status === 'pending')
            <div class="card border-warning mb-4">
                <div class="card-header bg-warning bg-opacity-10 fw-bold">
                    <i class="bi bi-shield-check me-1"></i> Admin Verification
                </div>
                <div class="card-body">
                    <p class="text-muted small">
                        Verify the manual bank transfer for <strong>{{ $order->order_number }}</strong>.
                        Approving marks the order as paid and activates the membership automatically.
                    </p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <form action="{{ route('orders.approve', $order->uuid) }}" method="POST">
                                @csrf
                                <label class="form-label small fw-semibold" for="approveNote">Note (optional)</label>
                                <textarea name="admin_note" id="approveNote" rows="2" class="form-control mb-2"
                                    placeholder="e.g. Transfer verified, BCA ...1234"></textarea>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-check-lg me-1"></i> Approve — Mark as Paid
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('orders.reject', $order->uuid) }}" method="POST">
                                @csrf
                                <label class="form-label small fw-semibold" for="rejectNote">Rejection reason</label>
                                <textarea name="admin_note" id="rejectNote" rows="2" class="form-control mb-2"
                                    placeholder="e.g. No transfer received"></textarea>
                                <button type="submit" class="btn btn-outline-danger w-100"
                                    onclick="return confirm('Reject this order?')">
                                    <i class="bi bi-x-lg me-1"></i> Reject Order
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($isAdmin && $order->admin_note)
            <div class="alert alert-info">
                <strong>Admin note:</strong> {{ $order->admin_note }}
            </div>
        @endif

        @if ($userPackage)
            <div class="alert alert-success d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill"></i>
                <div>
                    Membership active
                    @if ($userPackage->quota === null)
                        (Unlimited)
                    @else
                        ({{ $userPackage->quota }} classes left)
                    @endif
                    until {{ $userPackage->expired_at?->format('d M Y') ?? '-' }}.
                </div>
            </div>
        @endif


        @if ($order->status === 'pending')
            @php
                $isOwner = $order->user_uuid === auth()->user()->uuid;
                $bankName = config('manual_payment.bank_name');
                $bankAccount = config('manual_payment.bank_account');
                $bankHolder = config('manual_payment.bank_holder');
                $waNumber = preg_replace('/\D/', '', (string) config('manual_payment.admin_whatsapp'));
                $waText = 'Hello YogaRoots Admin, I have transferred Rp ' . number_format($order->amount, 0, ',', '.') . ' for order ' . $order->order_number . ' (' . ($order->user?->name ?? '') . '). Thank you.';
            @endphp
            <div class="card border-primary mb-4">
                <div class="card-header bg-primary bg-opacity-10 fw-bold">
                    <i class="bi bi-bank me-1"></i> Complete Your Payment — Manual Transfer
                </div>
                <div class="card-body">
                    <ol class="small mb-3 ps-3">
                        <li>Transfer the exact amount below to our bank account.</li>
                        <li>Upload your transfer proof (or confirm via WhatsApp).</li>
                        <li>Admin verifies it — your membership activates automatically.</li>
                    </ol>

                    @if ($bankAccount)
                        <div class="p-3 rounded-3 bg-light mb-3">
                            <div class="small text-muted">BANK</div>
                            <div class="fw-bold fs-5">{{ $bankName }}</div>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <span class="font-monospace fs-5 fw-bold" id="bankAccountNumber">{{ $bankAccount }}</span>
                            </div>
                            @if ($bankHolder)
                                <div class="small text-muted">Account holder: {{ $bankHolder }}</div>
                            @endif
                            <div class="d-flex flex-wrap gap-3 mt-2">
                                <span>Amount: <strong>Rp {{ number_format($order->amount, 0, ',', '.') }}</strong></span>
                                <span>Order: <strong>{{ $order->order_number }}</strong></span>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @if ($waNumber)
                            <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($waText) }}" target="_blank"
                                rel="noopener" class="btn btn-success">
                                <i class="bi bi-whatsapp me-1"></i> Confirm via WhatsApp
                            </a>
                        @endif
                    </div>

                    @if ($order->proof_image_path)
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light mb-3">
                            <a href="{{ $order->proofUrl() }}" target="_blank" rel="noopener">
                                <img src="{{ $order->proofUrl() }}" alt="Transfer proof"
                                    class="rounded-3 border" style="height:110px;width:auto;object-fit:cover;">
                            </a>
                            <div class="small">
                                <div class="fw-bold text-success">
                                    <i class="bi bi-check-circle me-1"></i>Proof uploaded
                                </div>
                                <div class="text-muted">
                                    {{ $order->proof_uploaded_at?->format('d M Y H:i') ?? '' }} — waiting for admin verification.
                                </div>
                                @if ($isOwner)
                                    <div class="text-muted">Upload again below to replace it.</div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($isOwner)
                        <form action="{{ route('orders.proof', $order->uuid) }}" method="POST"
                            enctype="multipart/form-data" class="d-flex flex-wrap align-items-end gap-2">
                            @csrf
                            <div class="flex-fill" style="min-width: 220px;">
                                <label class="form-label small fw-semibold" for="proofInput">
                                    Upload transfer proof (JPG/PNG/WebP, max {{ number_format(config('manual_payment.proof_max_kb', 3072) / 1024, 1) }} MB)
                                </label>
                                <input type="file" name="proof" id="proofInput" class="form-control"
                                    accept="image/jpeg,image/png,image/webp" required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload me-1"></i>
                                {{ $order->proof_image_path ? 'Replace Proof' : 'Upload Proof' }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endif


        {{-- Receipt --}}
        <div class="receipt-card">

            {{-- Header --}}
            <div class="receipt-header">

                <div class="receipt-brand">
                    Yogaroots
                </div>

                <div class="receipt-heading">
                    Payment Receipt
                </div>

                <div class="receipt-order-number">
                    {{ $order->order_number }}
                </div>

                <div class="receipt-date">
                    {{ $order->created_at?->format('d F Y, H:i') ?? '-' }}
                </div>

            </div>


            {{-- Status --}}
            <div class="receipt-status-section">

                @if ($order->status === 'paid')

                <div class="status-circle paid">
                    <i class="bi bi-check-lg"></i>
                </div>

                <h3>
                    Payment Successful
                </h3>

                <p>
                    Your payment has been successfully processed.
                </p>

                @elseif ($order->status === 'pending')

                <div class="status-circle pending">
                    <i class="bi bi-clock"></i>
                </div>

                <h3>
                    Payment Pending
                </h3>

                <p>
                    This payment has not been completed yet.
                </p>

                @elseif ($order->status === 'failed')

                <div class="status-circle failed">
                    <i class="bi bi-x-lg"></i>
                </div>

                <h3>
                    Payment Failed
                </h3>

                <p>
                    We could not complete this payment.
                </p>

                @elseif ($order->status === 'expired')

                <div class="status-circle expired">
                    <i class="bi bi-hourglass-bottom"></i>
                </div>

                <h3>
                    Payment Expired
                </h3>

                <p>
                    This payment session has expired.
                </p>

                @elseif ($order->status === 'cancelled')

                <div class="status-circle cancelled">
                    <i class="bi bi-x-lg"></i>
                </div>

                <h3>
                    Order Cancelled
                </h3>

                <p>
                    This order has been cancelled.
                </p>

                @endif

            </div>


            {{-- Main Content --}}
            <div class="receipt-content">

                {{-- Membership --}}
                <div class="receipt-block">

                    <div class="receipt-label">
                        MEMBERSHIP
                    </div>

                    <div class="membership-row">

                        <div class="membership-info">

                            <h4>
                                {{ $order->package?->name ?? '-' }}
                            </h4>

                            @if ($order->packageOption)

                            <div class="membership-meta">

                                <span>
                                    {{ $order->packageOption->name }}
                                </span>

                                <span class="dot"></span>

                                <span>
                                    {{ $order->packageOption->duration }}
                                    {{ ucfirst($order->packageOption->duration_unit) }}
                                </span>

                                <span class="dot"></span>

                                <span>
                                    @if ($order->packageOption->quota === null)
                                    Unlimited Classes
                                    @else
                                    {{ $order->packageOption->quota }} Classes
                                    @endif
                                </span>

                            </div>

                            @endif

                        </div>


                        <div class="membership-price">
                            Rp {{ number_format($order->amount, 0, ',', '.') }}
                        </div>

                    </div>

                </div>


                {{-- Divider --}}
                <div class="receipt-divider"></div>


                {{-- Customer --}}
                <div class="receipt-block">

                    <div class="receipt-label">
                        CUSTOMER
                    </div>

                    <div class="customer-name">
                        {{ $order->user?->name ?? '-' }}
                    </div>

                    <div class="customer-email">
                        {{ $order->user?->email ?? '-' }}
                    </div>

                </div>


                {{-- Payment --}}
                <div class="receipt-payment-grid">

                    <div>

                        <div class="receipt-label">
                            PAYMENT STATUS
                        </div>

                        <div class="payment-value">

                            @if ($order->status === 'paid')
                            <span class="mini-status paid">
                                Paid
                            </span>
                            @elseif ($order->status === 'pending')
                            <span class="mini-status pending">
                                Pending
                            </span>
                            @elseif ($order->status === 'failed')
                            <span class="mini-status failed">
                                Failed
                            </span>
                            @elseif ($order->status === 'expired')
                            <span class="mini-status expired">
                                Expired
                            </span>
                            @else
                            <span class="mini-status cancelled">
                                Cancelled
                            </span>
                            @endif

                        </div>

                    </div>


                    <div>

                        <div class="receipt-label">
                            PAYMENT DATE
                        </div>

                        <div class="payment-value">
                            {{ $order->paid_at?->format('d M Y, H:i') ?? '-' }}
                        </div>

                    </div>


                    <div>

                        <div class="receipt-label">
                            PAYMENT METHOD
                        </div>

                        <div class="payment-value">
                            {{ $order->payment?->payment_type ?? 'Manual Transfer' }}
                        </div>

                    </div>

                </div>


                {{-- Total --}}
                <div class="receipt-total">

                    <div>
                        <span>
                            Total Paid
                        </span>

                        <small>
                            {{ strtoupper($order->type) }} ORDER
                        </small>
                    </div>

                    <strong>
                        Rp {{ number_format($order->amount, 0, ',', '.') }}
                    </strong>

                </div>


                {{-- Paid Message --}}
                @if ($order->status === 'paid')

                <div class="receipt-message">

                    <i class="bi bi-heart"></i>

                    <span>
                        Thank you for choosing Yogaroots.
                        Your membership is ready to enjoy.
                    </span>

                </div>

                @elseif ($order->status === 'pending')

                <div class="receipt-message pending">

                    <i class="bi bi-info-circle"></i>

                    <span>
                        Payment is still pending. Please complete your payment to activate your membership.
                    </span>

                </div>

                @endif

            </div>


            {{-- Footer --}}
            <div class="receipt-footer">

                <div class="footer-brand">
                    Yogaroots
                </div>

                <div>
                    Yoga, movement, and mindful living.
                </div>

            </div>

        </div>

    </div>
    ```

</div>

<style>
    /* =========================================================
       PAGE
    ========================================================= */

    .receipt-page {
        min-height: calc(100vh - 100px);
        padding: 30px 20px 60px;
        background: var(--bs-body-bg);
    }

    .receipt-wrapper {
        width: 100%;
        max-width: 850px;
        margin: 0 auto;
    }


    /* =========================================================
       TOPBAR
    ========================================================= */

    .receipt-topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--bs-secondary-color);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: color .2s ease;
    }

    .back-link:hover {
        color: var(--bs-primary);
    }

    .print-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 14px;
        border: 1px solid var(--bs-border-color);
        border-radius: 9px;
        background: var(--bs-body-bg);
        color: var(--bs-body-color);
        font-size: 12px;
        font-weight: 600;
        transition: all .2s ease;
    }

    .print-button:hover {
        border-color: var(--bs-primary);
        color: var(--bs-primary);
    }


    /* =========================================================
       RECEIPT CARD
    ========================================================= */

    .receipt-card {
        overflow: hidden;
        background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 18px;
        box-shadow: 0 15px 45px rgba(49, 57, 47, .07);
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .receipt-header {
        padding: 34px 42px 28px;
        text-align: center;
        border-bottom: 1px solid var(--bs-border-color);
    }

    .receipt-brand {
        color: var(--bs-primary);
        font-size: 23px;
        font-weight: 800;
        letter-spacing: -.03em;
    }

    .receipt-heading {
        margin-top: 7px;
        color: var(--bs-body-color);
        font-size: 14px;
        font-weight: 600;
    }

    .receipt-order-number {
        margin-top: 14px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .04em;
    }

    .receipt-date {
        margin-top: 3px;
        color: var(--bs-secondary-color);
        font-size: 11px;
    }


    /* =========================================================
       STATUS
    ========================================================= */

    .receipt-status-section {
        padding: 34px 30px 32px;
        text-align: center;
    }

    .status-circle {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 13px;
        border-radius: 50%;
        font-size: 22px;
    }

    .status-circle.paid {
        background: rgba(75, 107, 82, .10);
        color: var(--bs-primary);
    }

    .status-circle.pending {
        background: rgba(234, 179, 8, .10);
        color: #a16207;
    }

    .status-circle.failed,
    .status-circle.cancelled {
        background: rgba(239, 68, 68, .10);
        color: #b91c1c;
    }

    .status-circle.expired {
        background: rgba(107, 114, 128, .10);
        color: #4b5563;
    }

    .receipt-status-section h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 750;
        letter-spacing: -.02em;
    }

    .receipt-status-section p {
        margin: 6px 0 0;
        color: var(--bs-secondary-color);
        font-size: 12px;
    }


    /* =========================================================
       CONTENT
    ========================================================= */

    .receipt-content {
        padding: 0 42px 38px;
    }

    .receipt-block {
        padding: 3px 0;
    }

    .receipt-label {
        margin-bottom: 9px;
        color: var(--bs-secondary-color);
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .11em;
    }


    /* =========================================================
       MEMBERSHIP
    ========================================================= */

    .membership-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 30px;
    }

    .membership-info h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 750;
        letter-spacing: -.02em;
    }

    .membership-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin-top: 7px;
        color: var(--bs-secondary-color);
        font-size: 11px;
    }

    .membership-meta .dot {
        width: 3px;
        height: 3px;
        border-radius: 50%;
        background: var(--bs-secondary-color);
        opacity: .5;
    }

    .membership-price {
        color: var(--bs-primary);
        font-size: 17px;
        font-weight: 800;
        white-space: nowrap;
    }


    /* =========================================================
       DIVIDER
    ========================================================= */

    .receipt-divider {
        height: 1px;
        margin: 26px 0;
        background: var(--bs-border-color);
    }


    /* =========================================================
       CUSTOMER
    ========================================================= */

    .customer-name {
        font-size: 14px;
        font-weight: 700;
    }

    .customer-email {
        margin-top: 3px;
        color: var(--bs-secondary-color);
        font-size: 12px;
    }


    /* =========================================================
       PAYMENT GRID
    ========================================================= */

    .receipt-payment-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 28px;
        padding-top: 25px;
        border-top: 1px solid var(--bs-border-color);
    }

    .payment-value {
        font-size: 12px;
        font-weight: 650;
    }

    .mini-status {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 750;
    }

    .mini-status.paid {
        background: rgba(75, 107, 82, .10);
        color: var(--bs-primary);
    }

    .mini-status.pending {
        background: rgba(234, 179, 8, .10);
        color: #a16207;
    }

    .mini-status.failed,
    .mini-status.cancelled {
        background: rgba(239, 68, 68, .10);
        color: #b91c1c;
    }

    .mini-status.expired {
        background: rgba(107, 114, 128, .10);
        color: #4b5563;
    }


    /* =========================================================
       TOTAL
    ========================================================= */

    .receipt-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-top: 30px;
        padding: 20px 0;
        border-top: 2px solid var(--bs-primary);
        border-bottom: 1px solid var(--bs-border-color);
    }

    .receipt-total span {
        display: block;
        font-size: 13px;
        font-weight: 700;
    }

    .receipt-total small {
        display: block;
        margin-top: 3px;
        color: var(--bs-secondary-color);
        font-size: 8px;
        letter-spacing: .1em;
    }

    .receipt-total strong {
        color: var(--bs-primary);
        font-size: 24px;
        font-weight: 800;
        white-space: nowrap;
    }


    /* =========================================================
       MESSAGE
    ========================================================= */

    .receipt-message {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 20px;
        padding: 12px 15px;
        border-radius: 9px;
        background: rgba(75, 107, 82, .06);
        color: var(--bs-secondary-color);
        font-size: 11px;
        text-align: center;
    }

    .receipt-message i {
        color: var(--bs-primary);
    }

    .receipt-message.pending {
        background: rgba(234, 179, 8, .07);
    }

    .receipt-message.pending i {
        color: #a16207;
    }


    /* =========================================================
       FOOTER
    ========================================================= */

    .receipt-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        padding: 20px 42px;
        background: var(--bs-tertiary-bg);
        color: var(--bs-secondary-color);
        font-size: 10px;
    }

    .footer-brand {
        color: var(--bs-body-color);
        font-size: 12px;
        font-weight: 750;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 767.98px) {

        .receipt-page {
            padding: 20px 12px 40px;
        }

        .receipt-topbar {
            margin-bottom: 14px;
        }

        .print-button span,
        .back-link span {
            display: none;
        }

        .print-button,
        .back-link {
            width: 38px;
            height: 38px;
            justify-content: center;
            padding: 0;
        }

        .receipt-header {
            padding: 28px 20px 24px;
        }

        .receipt-content {
            padding: 0 20px 30px;
        }

        .receipt-status-section {
            padding: 28px 20px;
        }

        .membership-row {
            flex-direction: column;
            gap: 10px;
        }

        .membership-price {
            font-size: 16px;
        }

        .receipt-payment-grid {
            grid-template-columns: 1fr;
            gap: 18px;
        }

        .receipt-total strong {
            font-size: 19px;
        }

        .receipt-footer {
            flex-direction: column;
            align-items: flex-start;
            padding: 18px 20px;
        }

    }


    /* =========================================================
       PRINT
    ========================================================= */

    @media print {

        @page {
            margin: 15mm;
        }

        body {
            background: #fff !important;
        }

        .receipt-page {
            min-height: auto;
            padding: 0;
        }

        .receipt-topbar {
            display: none !important;
        }

        .receipt-wrapper {
            max-width: none;
        }

        .receipt-card {
            border: 0;
            border-radius: 0;
            box-shadow: none;
        }

        .receipt-header,
        .receipt-content {
            padding-left: 0;
            padding-right: 0;
        }

        .receipt-footer {
            padding-left: 0;
            padding-right: 0;
        }

    }
</style>

@endsection