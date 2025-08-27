@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Manage Testimonials</h1>
                <p class="text-muted small mb-0">Customer testimonials and reviews</p>
            </div>
            <a href="{{ route('dashboard.testimonials.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-2"></i>Add Testimonial
            </a>
        </div>
    </div>
</div>

@if($testimonials->count() > 0)
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="testimonialsTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th style="width: 60px;">Image</th>
                            <th>Name (EN)</th>
                            <th>Name (AR)</th>
                            <th style="width: 100px;">Rating</th>
                            <th style="width: 80px;">Status</th>
                            <th style="width: 100px;">Created</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($testimonials as $testimonial)
                            <tr data-id="{{ $testimonial->id }}">
                                <td class="align-middle">
                                    <span class="badge bg-primary">{{ $testimonial->id }}</span>
                                </td>
                                <td class="align-middle">
                                    @if($testimonial->getFirstMedia('image'))
                                        <img src="{{ $testimonial->getFirstMediaUrl('image') }}"
                                             alt="{{ $testimonial->name_en }}"
                                             class="rounded-circle"
                                             width="40"
                                             height="40"
                                             style="object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="fw-semibold">{{ Str::limit($testimonial->name_en, 30) }}</div>
                                </td>
                                <td class="align-middle">
                                    <div class="fw-semibold">{{ Str::limit($testimonial->name_ar, 30) }}</div>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <span class="text-warning me-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $testimonial->rating)
                                                    <i class="fas fa-star fa-sm"></i>
                                                @else
                                                    <i class="far fa-star fa-sm"></i>
                                                @endif
                                            @endfor
                                        </span>
                                        <span class="badge bg-primary">{{ $testimonial->rating }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    @if($testimonial->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <small class="text-muted">
                                        {{ $testimonial->created_at->format('M d, Y') }}
                                    </small>
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('dashboard.testimonials.show', $testimonial) }}"
                                           class="btn btn-outline-info"
                                           title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dashboard.testimonials.edit', $testimonial) }}"
                                           class="btn btn-outline-primary"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('dashboard.testimonials.toggle-status', $testimonial) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="btn btn-outline-warning"
                                                    title="{{ $testimonial->is_active ? 'Deactivate' : 'Activate' }}">
                                                <i class="fas fa-{{ $testimonial->is_active ? 'eye-slash' : 'eye' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('dashboard.testimonials.destroy', $testimonial) }}"
                                              method="POST"
                                              class="d-inline delete-testimonial-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-outline-danger"
                                                    title="Delete">
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
                <i class="fas fa-comments fa-3x text-muted opacity-50"></i>
            </div>
            <h5 class="text-muted">No Testimonials Found</h5>
            <p class="text-muted mb-3">Start by adding some testimonials.</p>
            <a href="{{ route('dashboard.testimonials.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Your First Testimonial
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
                <p>Are you sure you want to delete this testimonial? This action cannot be undone.</p>
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
        $('#testimonialsTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[0, 'desc']], // Sort by ID column (first column) in descending order
            language: {
                search: "Search Testimonials:",
                lengthMenu: "Show _MENU_ testimonials per page",
                info: "Showing _START_ to _END_ of _TOTAL_ testimonials",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            columnDefs: [
                { orderable: false, targets: [7] } // Actions column is not sortable
            ]
        });

        console.log('Testimonials DataTable initialized successfully');
    } catch (error) {
        console.error('Error initializing Testimonials DataTable:', error);
    }

    // Enhanced delete confirmation
    document.querySelectorAll('.delete-testimonial-form').forEach(form => {
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
    margin-left: 2px !important;
    border: 1px solid #dee2e6 !important;
    background-color: #fff !important;
    color: #495057 !important;
    border-radius: 0.375rem !important;
    transition: all 0.15s ease-in-out !important;
}

.dataTables_paginate .paginate_button:hover {
    background-color: #e9ecef !important;
    border-color: #dee2e6 !important;
    color: #495057 !important;
}

.dataTables_paginate .paginate_button.current {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
    color: #fff !important;
}

.dataTables_paginate .paginate_button.disabled {
    color: #6c757d !important;
    pointer-events: none !important;
    background-color: #e9ecef !important;
    border-color: #dee2e6 !important;
}

/* Table Styling */
.table th {
    background-color: #f8f9fa !important;
    border-bottom: 2px solid #dee2e6 !important;
    font-weight: 600 !important;
    color: #495057 !important;
}

.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05) !important;
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
</style>
