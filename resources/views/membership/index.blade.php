@extends('layouts.app')

@section('title', 'Membership Plans')
@section('page-title', 'Choose Your Plan')
@section('page-description', 'Unlock AI tax help, calculators, courses, and expert guidance')

@push('head')
@if($stripeConfigured)
<script src="https://js.stripe.com/v3/"></script>
@endif
@endpush

@push('styles')
<style>
    .membership-plan-card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .membership-plan-card.is-current {
        border: 2px solid var(--primary-color);
        box-shadow: 0 12px 24px rgba(102, 126, 234, 0.15);
    }

    .membership-plan-card.is-featured {
        border: 2px solid var(--primary-color);
        position: relative;
    }

    .membership-price {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1;
        color: var(--text-primary);
        letter-spacing: -0.03em;
    }

    .membership-price span {
        font-size: 1rem;
        font-weight: 500;
        color: var(--text-secondary);
    }

    .membership-features {
        list-style: none;
        padding: 0;
        margin: 0 0 1.5rem;
        flex-grow: 1;
    }

    .membership-features li {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.5rem 0;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    .membership-features li.included {
        color: var(--text-primary);
    }

    .membership-features li i {
        margin-top: 0.2rem;
        width: 1rem;
        text-align: center;
    }

    #membership-card-errors {
        color: var(--danger-color);
        font-size: 0.9rem;
        min-height: 1.25rem;
    }

    #membership-card-element {
        padding: 0.875rem;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        background: #fff;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<section class="modern-section" style="background: var(--bg-light); padding: 2rem 0 3rem;">
    <div class="container">
        @if(session('upgrade_message'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-lock me-2"></i>{{ session('upgrade_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @unless($stripeConfigured)
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                Online checkout is not active yet. Plan details are shown below; payment setup is still in progress.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endunless

        <div class="text-center mb-5">
            <h2 class="mb-3">Membership Plans</h2>
            <p class="text-muted mb-0 mx-auto" style="max-width: 640px;">
                Pick the plan that fits your goals. Upgrade anytime to unlock more calculators, courses, and AI-powered tax guidance.
            </p>
        </div>

        <div class="row g-4 align-items-stretch">
            {{-- Free --}}
            <div class="col-lg-4">
                <div class="modern-card membership-plan-card {{ $currentPlan === 'free' ? 'is-current' : '' }}">
                    <div class="text-center mb-4">
                        <div class="feature-icon mx-auto mb-3" style="width: 56px; height: 56px; font-size: 1.5rem; background: var(--gradient-info);">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3 class="modern-card-title mb-2">Free</h3>
                        <div class="membership-price">$0<span>/mo</span></div>
                    </div>

                    <ul class="membership-features">
                        <li class="included"><i class="fas fa-check text-success"></i> Basic budget calculator</li>
                        <li class="included"><i class="fas fa-check text-success"></i> 3 AI questions per day</li>
                        <li class="included"><i class="fas fa-check text-success"></i> Blog access</li>
                        <li><i class="fas fa-times text-muted"></i> Full calculator suite</li>
                        <li><i class="fas fa-times text-muted"></i> Courses</li>
                        <li><i class="fas fa-times text-muted"></i> AI Tax Assistant</li>
                        <li><i class="fas fa-times text-muted"></i> 1-on-1 consultation</li>
                    </ul>

                    @if($currentPlan === 'free')
                        <button class="btn btn-modern btn-modern-outline w-100" disabled>Current plan</button>
                    @endif
                </div>
            </div>

            {{-- Pro --}}
            <div class="col-lg-4">
                <div class="modern-card membership-plan-card is-featured {{ $currentPlan === 'pro' ? 'is-current' : '' }}">
                    <div class="text-center mb-2">
                        <span class="badge rounded-pill mb-3" style="background: var(--gradient-primary);">Most popular</span>
                    </div>
                    <div class="text-center mb-4">
                        <div class="feature-icon mx-auto mb-3" style="width: 56px; height: 56px; font-size: 1.5rem;">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3 class="modern-card-title mb-2">Pro</h3>
                        <div class="membership-price">$19<span>/mo</span></div>
                    </div>

                    <ul class="membership-features">
                        <li class="included"><i class="fas fa-check text-success"></i> All 8 calculators</li>
                        <li class="included"><i class="fas fa-check text-success"></i> Unlimited AI chatbot</li>
                        <li class="included"><i class="fas fa-check text-success"></i> AI Tax/Finance Assistant</li>
                        <li class="included"><i class="fas fa-check text-success"></i> All literacy courses</li>
                        <li class="included"><i class="fas fa-check text-success"></i> Monthly Zoom Q&amp;A</li>
                        <li><i class="fas fa-times text-muted"></i> 1-on-1 tax consultation</li>
                        <li><i class="fas fa-times text-muted"></i> Direct WhatsApp access</li>
                    </ul>

                    @if($currentPlan === 'pro')
                        <button class="btn btn-modern btn-modern-outline w-100" disabled>Current plan</button>
                    @elseif($currentPlan !== 'elite')
                        @if($stripeConfigured)
                            <button type="button" class="btn btn-modern btn-modern-primary w-100"
                                onclick="startCheckout('pro', '{{ config('cashier.key') }}', '{{ $intent->client_secret }}')">
                                <i class="fas fa-arrow-up me-2"></i>Upgrade to Pro
                            </button>
                        @else
                            <button class="btn btn-modern btn-modern-primary w-100" disabled>Coming soon</button>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Elite --}}
            <div class="col-lg-4">
                <div class="modern-card membership-plan-card {{ $currentPlan === 'elite' ? 'is-current' : '' }}">
                    <div class="text-center mb-4">
                        <div class="feature-icon mx-auto mb-3" style="width: 56px; height: 56px; font-size: 1.5rem; background: var(--gradient-warm);">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h3 class="modern-card-title mb-2">Elite</h3>
                        <div class="membership-price">$49<span>/mo</span></div>
                    </div>

                    <ul class="membership-features">
                        <li class="included"><i class="fas fa-check text-success"></i> Everything in Pro</li>
                        <li class="included"><i class="fas fa-check text-success"></i> Monthly 1-on-1 tax consult</li>
                        <li class="included"><i class="fas fa-check text-success"></i> Personalized financial plan</li>
                        <li class="included"><i class="fas fa-check text-success"></i> Priority AI responses</li>
                        <li class="included"><i class="fas fa-check text-success"></i> Direct WhatsApp access</li>
                        <li class="included"><i class="fas fa-check text-success"></i> Tax return filing included</li>
                    </ul>

                    @if($currentPlan === 'elite')
                        <button class="btn btn-modern btn-modern-outline w-100" disabled>Current plan</button>
                    @else
                        @if($stripeConfigured)
                            <button type="button" class="btn btn-modern btn-modern-secondary w-100"
                                onclick="startCheckout('elite', '{{ config('cashier.key') }}', '{{ $intent->client_secret }}')">
                                <i class="fas fa-crown me-2"></i>Upgrade to Elite
                            </button>
                        @else
                            <button class="btn btn-modern btn-modern-secondary w-100" disabled>Coming soon</button>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        @if($currentPlan !== 'free')
            <div class="modern-card mt-4">
                <h4 class="modern-card-title mb-3">
                    <i class="fas fa-cog me-2" style="color: var(--primary-color);"></i>
                    Manage Subscription
                </h4>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('membership.billing') }}" class="btn btn-modern btn-modern-outline">
                        <i class="fas fa-credit-card me-2"></i>Manage billing &amp; invoices
                    </a>

                    @if(auth()->user()->subscription('default') && !auth()->user()->subscription('default')->cancelled())
                        <button type="button" onclick="cancelSubscription()" class="btn btn-modern"
                            style="background: rgba(239,68,68,0.1); color: var(--danger-color); border: 1px solid rgba(239,68,68,0.2);">
                            <i class="fas fa-times me-2"></i>Cancel subscription
                        </button>
                    @elseif(auth()->user()->subscription('default') && auth()->user()->subscription('default')->onGracePeriod())
                        <button type="button" onclick="resumeSubscription()" class="btn btn-modern btn-modern-success">
                            <i class="fas fa-redo me-2"></i>Resume subscription
                        </button>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>

@if($stripeConfigured)
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">
                    <i class="fas fa-credit-card me-2"></i>Upgrade your plan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">Enter your card details to start your subscription.</p>
                <div id="membership-card-element"></div>
                <div id="membership-card-errors" class="mb-2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="membership-pay-btn" class="btn btn-modern btn-modern-primary" onclick="confirmPayment()">
                    <span id="membership-pay-label">Confirm &amp; Subscribe</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
@if($stripeConfigured)
<script>
let stripe, cardElement, selectedPlan, setupClientSecret, paymentModal;

document.addEventListener('DOMContentLoaded', function () {
    paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
});

function startCheckout(plan, stripeKey, clientSecret) {
    selectedPlan = plan;
    setupClientSecret = clientSecret;
    stripe = Stripe(stripeKey);

    document.getElementById('paymentModalLabel').innerHTML =
        plan === 'pro'
            ? '<i class="fas fa-star me-2"></i>Upgrade to Pro — $19/mo'
            : '<i class="fas fa-crown me-2"></i>Upgrade to Elite — $49/mo';

    document.getElementById('membership-card-errors').textContent = '';

    if (cardElement) {
        cardElement.unmount();
        cardElement = null;
    }

    const elements = stripe.elements();
    cardElement = elements.create('card', {
        style: {
            base: { fontSize: '16px', color: '#111827', '::placeholder': { color: '#9ca3af' } }
        }
    });
    cardElement.mount('#membership-card-element');
    cardElement.on('change', ({ error }) => {
        document.getElementById('membership-card-errors').textContent = error ? error.message : '';
    });

    paymentModal.show();
}

async function confirmPayment() {
    const btn = document.getElementById('membership-pay-btn');
    const label = document.getElementById('membership-pay-label');
    btn.disabled = true;
    label.textContent = 'Processing...';

    const { setupIntent, error } = await stripe.confirmCardSetup(setupClientSecret, {
        payment_method: { card: cardElement }
    });

    if (error) {
        document.getElementById('membership-card-errors').textContent = error.message;
        btn.disabled = false;
        label.textContent = 'Confirm & Subscribe';
        return;
    }

    const res = await fetch('{{ route("membership.subscribe") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            plan: selectedPlan,
            payment_method: setupIntent.payment_method
        })
    });

    const data = await res.json();
    if (data.success) {
        window.location.reload();
    } else {
        document.getElementById('membership-card-errors').textContent = data.message || 'Payment failed. Please try again.';
        btn.disabled = false;
        label.textContent = 'Confirm & Subscribe';
    }
}

async function cancelSubscription() {
    if (!confirm('Cancel your subscription? You keep access until the end of the billing period.')) return;

    const res = await fetch('{{ route("membership.cancel") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });
    const data = await res.json();
    if (data.success) window.location.reload();
}

async function resumeSubscription() {
    const res = await fetch('{{ route("membership.resume") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });
    const data = await res.json();
    if (data.success) window.location.reload();
}
</script>
@endif
@endpush
