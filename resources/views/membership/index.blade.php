{{-- resources/views/membership/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Upgrade Your Plan — Patrik Solutions')

@push('head')
<script src="https://js.stripe.com/v3/"></script>
@endpush

@section('content')
<div class="ps-membership">

  @if(session('upgrade_message'))
    <div class="ps-alert ps-alert-warning">
      <i class="ti ti-lock"></i> {{ session('upgrade_message') }}
    </div>
  @endif

  <div class="ps-membership-header">
    <h1>Choose your plan</h1>
    <p>Unlock the full power of Patrik Solutions — AI tax help, all calculators, and expert guidance.</p>
  </div>

  <div class="ps-plans-grid">

    {{-- FREE --}}
    <div class="ps-plan {{ $currentPlan === 'free' ? 'ps-plan--current' : '' }}">
      <div class="ps-plan-name">Free</div>
      <div class="ps-plan-price">$0<span>/mo</span></div>
      <ul class="ps-plan-features">
        <li class="yes"><i class="ti ti-check"></i> Basic budget calculator</li>
        <li class="yes"><i class="ti ti-check"></i> 3 AI questions per day</li>
        <li class="yes"><i class="ti ti-check"></i> Blog access</li>
        <li class="no"><i class="ti ti-x"></i> Full calculator suite</li>
        <li class="no"><i class="ti ti-x"></i> Courses</li>
        <li class="no"><i class="ti ti-x"></i> AI Tax Assistant</li>
        <li class="no"><i class="ti ti-x"></i> 1-on-1 consultation</li>
      </ul>
      @if($currentPlan === 'free')
        <button class="ps-btn ps-btn--current" disabled>Current plan</button>
      @endif
    </div>

    {{-- PRO --}}
    <div class="ps-plan ps-plan--featured {{ $currentPlan === 'pro' ? 'ps-plan--current' : '' }}">
      <div class="ps-plan-badge">Most popular</div>
      <div class="ps-plan-name">Pro</div>
      <div class="ps-plan-price">$19<span>/mo</span></div>
      <ul class="ps-plan-features">
        <li class="yes"><i class="ti ti-check"></i> All 8 calculators</li>
        <li class="yes"><i class="ti ti-check"></i> Unlimited AI chatbot</li>
        <li class="yes"><i class="ti ti-check"></i> AI Tax/Finance Assistant</li>
        <li class="yes"><i class="ti ti-check"></i> All literacy courses</li>
        <li class="yes"><i class="ti ti-check"></i> Monthly Zoom Q&A</li>
        <li class="no"><i class="ti ti-x"></i> 1-on-1 tax consultation</li>
        <li class="no"><i class="ti ti-x"></i> Direct WhatsApp access</li>
      </ul>
      @if($currentPlan === 'pro')
        <button class="ps-btn ps-btn--current" disabled>Current plan</button>
      @elseif($currentPlan !== 'elite')
        <button class="ps-btn ps-btn--primary" onclick="startCheckout('pro', '{{ config('services.stripe.key') }}', '{{ $intent->client_secret }}')">
          Upgrade to Pro
        </button>
      @endif
    </div>

    {{-- ELITE --}}
    <div class="ps-plan {{ $currentPlan === 'elite' ? 'ps-plan--current' : '' }}">
      <div class="ps-plan-name">Elite</div>
      <div class="ps-plan-price">$49<span>/mo</span></div>
      <ul class="ps-plan-features">
        <li class="yes"><i class="ti ti-check"></i> Everything in Pro</li>
        <li class="yes"><i class="ti ti-check"></i> Monthly 1-on-1 tax consult</li>
        <li class="yes"><i class="ti ti-check"></i> Personalized financial plan</li>
        <li class="yes"><i class="ti ti-check"></i> Priority AI responses</li>
        <li class="yes"><i class="ti ti-check"></i> Direct WhatsApp access</li>
        <li class="yes"><i class="ti ti-check"></i> Tax return filing included</li>
      </ul>
      @if($currentPlan === 'elite')
        <button class="ps-btn ps-btn--current" disabled>Current plan</button>
      @else
        <button class="ps-btn ps-btn--secondary" onclick="startCheckout('elite', '{{ config('services.stripe.key') }}', '{{ $intent->client_secret }}')">
          Upgrade to Elite
        </button>
      @endif
    </div>

  </div>

  {{-- Manage existing subscription --}}
  @if($currentPlan !== 'free')
    <div class="ps-manage">
      <a href="{{ route('membership.billing') }}" class="ps-link">
        <i class="ti ti-credit-card"></i> Manage billing & invoices
      </a>
      @if(auth()->user()->subscription('default') && !auth()->user()->subscription('default')->cancelled())
        <button onclick="cancelSubscription()" class="ps-link ps-link--danger">
          <i class="ti ti-x"></i> Cancel subscription
        </button>
      @elseif(auth()->user()->subscription('default') && auth()->user()->subscription('default')->onGracePeriod())
        <button onclick="resumeSubscription()" class="ps-link ps-link--success">
          <i class="ti ti-refresh"></i> Resume subscription
        </button>
      @endif
    </div>
  @endif

  {{-- Payment modal --}}
  <div id="ps-payment-modal" style="display:none;">
    <div class="ps-modal-overlay" onclick="closeModal()"></div>
    <div class="ps-modal">
      <div class="ps-modal-header">
        <h3 id="ps-modal-title">Upgrade your plan</h3>
        <button onclick="closeModal()"><i class="ti ti-x"></i></button>
      </div>
      <div id="ps-card-element" class="ps-card-element"></div>
      <div id="ps-card-errors" class="ps-card-errors"></div>
      <button id="ps-pay-btn" class="ps-btn ps-btn--primary ps-btn--full" onclick="confirmPayment()">
        <span id="ps-pay-label">Confirm & Subscribe</span>
      </button>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
let stripe, cardElement, selectedPlan, setupClientSecret;

function startCheckout(plan, stripeKey, clientSecret) {
  selectedPlan = plan;
  setupClientSecret = clientSecret;
  stripe = Stripe(stripeKey);

  document.getElementById('ps-payment-modal').style.display = 'flex';
  document.getElementById('ps-modal-title').textContent =
    plan === 'pro' ? 'Upgrade to Pro — $19/mo' : 'Upgrade to Elite — $49/mo';

  const elements = stripe.elements();
  cardElement = elements.create('card', {
    style: {
      base: { fontSize: '16px', color: '#1a2e27', '::placeholder': { color: '#9ab' } }
    }
  });
  cardElement.mount('#ps-card-element');
  cardElement.on('change', ({ error }) => {
    document.getElementById('ps-card-errors').textContent = error ? error.message : '';
  });
}

async function confirmPayment() {
  const btn = document.getElementById('ps-pay-btn');
  const label = document.getElementById('ps-pay-label');
  btn.disabled = true;
  label.textContent = 'Processing...';

  const { setupIntent, error } = await stripe.confirmCardSetup(setupClientSecret, {
    payment_method: { card: cardElement }
  });

  if (error) {
    document.getElementById('ps-card-errors').textContent = error.message;
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
    document.getElementById('ps-card-errors').textContent = data.message;
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

function closeModal() {
  document.getElementById('ps-payment-modal').style.display = 'none';
}
</script>
@endpush
