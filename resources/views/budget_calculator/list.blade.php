@extends('layouts.app')

@section('title', 'My Budgets')
@section('page-title', 'My Budgets')
@section('page-description', 'View and manage your saved budgets')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="modern-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-2">My Saved Budgets</h2>
                    <p class="text-muted mb-0">Manage your monthly budgets</p>
                </div>
                <a href="{{ route('budget_calculator.index') }}" class="btn btn-modern btn-modern-primary">
                    <i class="fas fa-plus me-2"></i>Create New Budget
                </a>
            </div>

            @if($budgets->count() > 0)
            <div class="table-responsive">
                <table id="budgetsTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Year</th>
                            <th>Month</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($budgets as $budget)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $budget->year }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $budget->month }}</span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('budget_calculator.show', [$budget->month, $budget->year]) }}" 
                                       class="btn btn-sm btn-modern btn-modern-primary">
                                        <i class="fas fa-eye me-1"></i>View/Edit
                                    </a>
                                    <form action="{{ route('budget_calculator.destroy', $budget->id) }}" 
                                          method="GET" 
                                          onsubmit="return confirm('Are you sure you want to delete this budget?');"
                                          class="d-inline">
                                        <button type="submit" class="btn btn-sm btn-modern" 
                                                style="background: rgba(239,68,68,0.1); color: var(--danger-color); border: 1px solid rgba(239,68,68,0.2);">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-calendar-times" style="font-size: 4rem; color: var(--text-secondary); opacity: 0.5;"></i>
                </div>
                <h4 class="mb-3">No Budgets Found</h4>
                <p class="text-muted mb-4">You haven't created any budgets yet. Start by creating your first budget!</p>
                <a href="{{ route('budget_calculator.index') }}" class="btn btn-modern btn-modern-primary">
                    <i class="fas fa-plus me-2"></i>Create Your First Budget
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
@endpush

@push('scripts')
<!-- DataTables JavaScript -->
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTables only if the table exists
        if ($('#budgetsTable').length) {
            $('#budgetsTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[1, 'desc'], [2, 'desc']], // Sort by year desc, then month desc
                language: {
                    search: "Search budgets:",
                    lengthMenu: "Show _MENU_ budgets per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ budgets",
                    infoEmpty: "No budgets found",
                    infoFiltered: "(filtered from _MAX_ total budgets)",
                    zeroRecords: "No matching budgets found"
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
            });
        }
    });
</script>
@endpush
