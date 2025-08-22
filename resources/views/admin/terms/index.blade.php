@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Manage Terms & Conditions</h1>
                <p class="text-muted small mb-0">Terms and Conditions Management</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.terms.banner.edit') }}" class="btn btn-outline-info btn-sm">
                    <i class="fas fa-image me-2"></i>Banner Image
                </a>
                <a href="{{ route('dashboard.terms.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-2"></i>Add Terms
                </a>
            </div>
        </div>
    </div>
</div>

@if($terms->count() > 0)
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="termsTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th style="width: 60px;">Status</th>
                        <th>Heading (English)</th>
                        <th>Heading (Arabic)</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($terms as $term)
                    <tr data-id="{{ $term->id }}">
                        <td class="align-middle">
                            <span class="badge bg-primary">{{ $term->id }}</span>
                        </td>
                        <td class="align-middle">
                            @if($term->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <div class="fw-semibold">{{ Str::limit($term->heading_en, 60) }}</div>
                            <small class="text-muted">{{ Str::limit($term->description_en, 80) }}</small>
                        </td>
                        <td class="align-middle">
                            <div class="fw-semibold">{{ Str::limit($term->heading_ar, 60) }}</div>
                            <small class="text-muted">{{ Str::limit($term->description_ar, 80) }}</small>
                        </td>
                        <td class="align-middle">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('dashboard.terms.edit', $term) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dashboard.terms.toggle-status', $term) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-warning" title="{{ $term->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas fa-{{ $term->is_active ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('dashboard.terms.destroy', $term) }}" method="POST" class="d-inline delete-term-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@else
<div class="card">
    <div class="card-body text-center py-5">
        <div class="mb-3">
            <i class="fas fa-file-contract fa-3x text-muted opacity-50"></i>
        </div>
        <h5 class="text-muted">No Terms & Conditions Found</h5>
        <p class="text-muted mb-3">Start by adding some terms and conditions.</p>
        <a href="{{ route('dashboard.terms.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Your First Term
        </a>
    </div>
</div>
@endif

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this term? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endpush

@push('scripts')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if jQuery is loaded
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded. DataTables cannot initialize.');
        return;
    }
    
    // Check if DataTables is loaded
    if (typeof $.fn.DataTable === 'undefined') {
        console.error('DataTables is not loaded. Cannot initialize table.');
        return;
    }
    
    try {
        // Initialize DataTable
        $('#termsTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[0, 'desc']], // Sort by ID column (first column) in descending order
            language: {
                search: "Search Terms:",
                lengthMenu: "Show _MENU_ terms per page",
                info: "Showing _START_ to _END_ of _TOTAL_ terms",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            columnDefs: [
                { orderable: false, targets: [4] } // Actions column is not sortable
            ]
        });
        
        console.log('Terms DataTable initialized successfully');
    } catch (error) {
        console.error('Error initializing Terms DataTable:', error);
    }
    
    // Enhanced delete confirmation
    document.querySelectorAll('.delete-term-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const confirmBtn = document.getElementById('confirmDelete');
            
            confirmBtn.onclick = () => {
                form.submit();
                modal.hide();
            };
            
            modal.show();
        });
    });
});
</script>
@endpush

<style>
.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

.btn-group .btn {
    border-radius: 0.375rem !important;
}

.btn-group .btn:first-child {
    border-top-left-radius: 0.375rem !important;
    border-bottom-left-radius: 0.375rem !important;
}

.btn-group .btn:last-child {
    border-top-right-radius: 0.375rem !important;
    border-bottom-right-radius: 0.375rem !important;
}

.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #495057;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.5rem;
}

.badge.bg-primary {
    background-color: #0d6efd !important;
}

.badge.bg-success {
    background-color: #198754 !important;
}

.badge.bg-secondary {
    background-color: #6c757d !important;
}

/* DataTables Length Menu Styling */
.dataTables_length select {
    padding: 0.375rem 2.25rem 0.375rem 0.75rem !important;
    font-size: 0.875rem !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.375rem !important;
    background-color: #fff !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e") !important;
    background-repeat: no-repeat !important;
    background-position: right 0.75rem center !important;
    background-size: 16px 12px !important;
    appearance: none !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    min-width: 80px !important;
    margin: 0 0.5rem !important;
}

.dataTables_length select:focus {
    border-color: #86b7fe !important;
    outline: 0 !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
}

.dataTables_length select:hover {
    border-color: #86b7fe !important;
}

/* DataTables Search Box Styling */
.dataTables_filter input {
    padding: 0.375rem 0.75rem !important;
    font-size: 0.875rem !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.375rem !important;
    background-color: #fff !important;
    min-width: 200px !important;
}

.dataTables_filter input:focus {
    border-color: #86b7fe !important;
    outline: 0 !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
}

.dataTables_filter input:hover {
    border-color: #86b7fe !important;
}

/* DataTables Info and Pagination Styling */
.dataTables_info {
    padding: 0.5rem 0 !important;
    font-size: 0.875rem !important;
    color: #6c757d !important;
}

.dataTables_paginate .paginate_button {
    padding: 0.375rem 0.75rem !important;
    margin: 0 0.125rem !important;
    border: 1px solid #dee2e6 !important;
    background-color: #fff !important;
    color: #0d6efd !important;
    border-radius: 0.375rem !important;
    font-size: 0.875rem !important;
}

.dataTables_paginate .paginate_button:hover {
    background-color: #e9ecef !important;
    border-color: #dee2e6 !important;
    color: #0a58ca !important;
}

.dataTables_paginate .paginate_button.current {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
    color: #fff !important;
}

.dataTables_paginate .paginate_button.disabled {
    color: #6c757d !important;
    pointer-events: none !important;
    background-color: #fff !important;
    border-color: #dee2e6 !important;
}
</style>
