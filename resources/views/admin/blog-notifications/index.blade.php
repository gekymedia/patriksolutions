<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="section-title" style="margin-bottom: 0.5rem;">
                    Blog Notification <span class="text-gradient">Subscribers</span>
                </h2>
                <p class="text-muted mb-0">View all users subscribed to blog notifications</p>
            </div>
        </div>
    </x-slot>

    <section class="modern-section" style="background: var(--bg-light); padding-top: 2rem;">
        <div class="container">
            <div class="modern-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">
                        <i class="fas fa-bell me-2" style="color: var(--primary-color);"></i>
                        Total Subscribers: <span class="badge rounded-pill" style="background: var(--gradient-primary); color: white; padding: 0.5rem 1rem;">{{ $subscriptions->total() }}</span>
                    </h4>
                </div>

                @if($subscriptions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead style="background: var(--bg-light);">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Browser</th>
                                <th>Device</th>
                                <th>IP Address</th>
                                <th>Subscribed</th>
                                <th>Last Notified</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subscriptions as $subscription)
                            <tr>
                                <td>{{ $loop->iteration + ($subscriptions->currentPage() - 1) * $subscriptions->perPage() }}</td>
                                <td>
                                    @if($subscription->user)
                                        <div>
                                            <strong>{{ $subscription->user->name }}</strong><br>
                                            <small class="text-muted">{{ $subscription->user->email }}</small>
                                        </div>
                                    @else
                                        <span class="text-muted">Guest User</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge rounded-pill" style="background: rgba(102,126,234,0.1); color: var(--primary-color);">
                                        <i class="fas fa-globe me-1"></i>{{ $subscription->browser ?? 'Unknown' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill" style="background: rgba(16,185,129,0.1); color: var(--success-color);">
                                        <i class="fas fa-mobile-alt me-1"></i>{{ $subscription->device ?? 'Unknown' }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $subscription->ip_address ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $subscription->subscribed_at->format('M d, Y') }}<br>
                                        <span style="font-size: 0.75rem;">{{ $subscription->subscribed_at->format('h:i A') }}</span>
                                    </small>
                                </td>
                                <td>
                                    @if($subscription->last_notified_at)
                                    <small class="text-muted">
                                        <i class="fas fa-bell me-1"></i>
                                        {{ $subscription->last_notified_at->format('M d, Y') }}<br>
                                        <span style="font-size: 0.75rem;">{{ $subscription->last_notified_at->format('h:i A') }}</span>
                                    </small>
                                    @else
                                    <small class="text-muted">Never</small>
                                    @endif
                                </td>
                                <td>
                                    @if($subscription->is_active)
                                    <span class="badge rounded-pill" style="background: var(--gradient-success); color: white;">
                                        <i class="fas fa-check-circle me-1"></i>Active
                                    </span>
                                    @else
                                    <span class="badge rounded-pill" style="background: rgba(239,68,68,0.1); color: var(--danger-color);">
                                        <i class="fas fa-times-circle me-1"></i>Inactive
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $subscriptions->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-bell-slash" style="font-size: 4rem; color: var(--text-secondary); opacity: 0.3; margin-bottom: 1rem;"></i>
                    <h4 class="text-secondary">No subscribers yet</h4>
                    <p class="text-muted">Users will appear here once they subscribe to blog notifications.</p>
                </div>
                @endif
            </div>
        </div>
    </section>
</x-app-layout>

