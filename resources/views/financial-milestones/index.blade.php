@extends('layouts.user-dashboard')

@section('title', 'Financial Milestones')
@section('page-title', 'My Financial Milestones')
@section('page-description', 'Track your progress toward financial goals')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <button type="button" class="btn btn-modern btn-modern-primary" data-bs-toggle="modal" data-bs-target="#createMilestoneModal">
        <i class="fas fa-plus me-2"></i>New Milestone
    </button>
</div>
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($milestones->isEmpty())
            <div class="modern-card text-center py-5">
                <i class="fas fa-flag-checkered" style="font-size: 4rem; color: var(--text-secondary); opacity: 0.3; margin-bottom: 1rem;"></i>
                <h4 class="text-secondary">No milestones yet</h4>
                <p class="text-muted mb-4">Create your first financial milestone to start tracking your progress!</p>
                <button type="button" class="btn btn-modern btn-modern-primary" data-bs-toggle="modal" data-bs-target="#createMilestoneModal">
                    <i class="fas fa-plus me-2"></i>Create Your First Milestone
                </button>
            </div>
            @else
            <div class="row g-4">
                @foreach($milestones as $milestone)
                <div class="col-md-6 col-lg-4">
                    <div class="modern-card {{ $milestone->is_completed ? 'border-success' : '' }}" style="{{ $milestone->is_completed ? 'border: 2px solid var(--success-color);' : '' }}">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h4 class="mb-1">
                                    @if($milestone->is_completed)
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    @else
                                    <i class="fas fa-flag me-2" style="color: var(--primary-color);"></i>
                                    @endif
                                    {{ $milestone->title }}
                                </h4>
                                <span class="badge rounded-pill" style="background: rgba(102,126,234,0.1); color: var(--primary-color);">
                                    {{ ucfirst(str_replace('_', ' ', $milestone->milestone_type)) }}
                                </span>
                            </div>
                        </div>

                        @if($milestone->description)
                        <p class="text-muted mb-3">{{ $milestone->description }}</p>
                        @endif

                        @if($milestone->target_amount)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Progress</small>
                                <small class="text-muted">
                                    ${{ number_format($milestone->current_amount, 0) }} / ${{ number_format($milestone->target_amount, 0) }}
                                </small>
                            </div>
                            <div class="progress" style="height: 8px; border-radius: 4px;">
                                @php
                                    $progress = $milestone->target_amount > 0 
                                        ? min(100, ($milestone->current_amount / $milestone->target_amount) * 100) 
                                        : 0;
                                @endphp
                                <div class="progress-bar" role="progressbar" 
                                     style="width: {{ $progress }}%; background: var(--gradient-primary);"
                                     aria-valuenow="{{ $progress }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($milestone->target_date)
                        <p class="mb-3">
                            <i class="fas fa-calendar-alt me-2 text-muted"></i>
                            <small class="text-muted">Target: {{ $milestone->target_date->format('M d, Y') }}</small>
                        </p>
                        @endif

                        @if($milestone->completed_at)
                        <p class="mb-3 text-success">
                            <i class="fas fa-check-circle me-2"></i>
                            <small>Completed: {{ $milestone->completed_at->format('M d, Y') }}</small>
                        </p>
                        @endif

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-modern btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editMilestoneModal{{ $milestone->id }}"
                                    style="flex: 1;">
                                <i class="fas fa-edit me-1"></i>Edit
                            </button>
                            @if(!$milestone->is_completed)
                            <form action="{{ route('financial-milestones.update', $milestone->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="is_completed" value="1">
                                <button type="submit" class="btn btn-modern btn-modern-success btn-sm w-100">
                                    <i class="fas fa-check me-1"></i>Complete
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

    <!-- Create Milestone Modal -->
    <div class="modal fade" id="createMilestoneModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Create New Milestone
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('financial-milestones.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Milestone Type *</label>
                            <select name="milestone_type" class="form-control" required>
                                <option value="emergency_fund">Emergency Fund</option>
                                <option value="debt_free">Debt Free</option>
                                <option value="first_investment">First Investment</option>
                                <option value="retirement_savings">Retirement Savings</option>
                                <option value="home_purchase">Home Purchase</option>
                                <option value="wealth_building">Wealth Building</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g., Build $10,000 Emergency Fund">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Optional description..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Target Amount ($)</label>
                            <input type="number" name="target_amount" class="form-control" step="0.01" placeholder="0.00">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Target Date</label>
                            <input type="date" name="target_date" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-modern btn-modern-primary">
                            <i class="fas fa-save me-2"></i>Create Milestone
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Milestone Modals -->
    @foreach($milestones as $milestone)
    <div class="modal fade" id="editMilestoneModal{{ $milestone->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Milestone
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('financial-milestones.update', $milestone->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" class="form-control" value="{{ $milestone->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ $milestone->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Target Amount ($)</label>
                            <input type="number" name="target_amount" class="form-control" step="0.01" value="{{ $milestone->target_amount }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Current Amount ($)</label>
                            <input type="number" name="current_amount" class="form-control" step="0.01" value="{{ $milestone->current_amount }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Target Date</label>
                            <input type="date" name="target_date" class="form-control" value="{{ $milestone->target_date ? $milestone->target_date->format('Y-m-d') : '' }}">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_completed" class="form-check-input" value="1" {{ $milestone->is_completed ? 'checked' : '' }}>
                                <label class="form-check-label">Mark as completed</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-modern btn-modern-primary">
                            <i class="fas fa-save me-2"></i>Update Milestone
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endsection

