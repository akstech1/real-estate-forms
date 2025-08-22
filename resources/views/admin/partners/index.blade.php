@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Our Partners</h1>
                <p class="text-muted small mb-0">Manage your business partners and collaborators</p>
            </div>
            <a href="{{ route('dashboard.partners.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Partner
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="partnersTable">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Title (EN)</th>
                        <th>Title (AR)</th>
                        <th>Description (EN)</th>
                        <th>Description (AR)</th>
                        <th>Website</th>
                        <th>Background</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($partners as $partner)
                    <tr>
                        <td>
                            @if($partner->logo_url)
                                <img src="{{ $partner->logo_url }}" alt="Logo" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ Str::limit($partner->title_en, 30) }}</td>
                        <td>{{ Str::limit($partner->title_ar, 30) }}</td>
                        <td>{{ Str::limit($partner->short_description_en, 50) }}</td>
                        <td>{{ Str::limit($partner->short_description_ar, 50) }}</td>
                        <td>
                            @if($partner->website_link)
                                <a href="{{ $partner->website_link }}" target="_blank" class="text-decoration-none">
                                    <i class="fas fa-external-link-alt me-1"></i>
                                    {{ Str::limit($partner->website_link, 30) }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="color-preview me-2" style="width: 20px; height: 20px; background-color: {{ $partner->background_colour }}; border-radius: 4px; border: 1px solid #ddd;"></div>
                                <small>{{ $partner->background_colour }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('dashboard.partners.show', $partner) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('dashboard.partners.edit', $partner) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dashboard.partners.destroy', $partner) }}" method="POST" class="d-inline delete-partner-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this partner? This action cannot be undone.</p>
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
        $('#partnersTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[1, 'asc']],
            language: {
                search: "Search partners:",
                lengthMenu: "Show _MENU_ partners per page",
                info: "Showing _START_ to _END_ of _TOTAL_ partners",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            columnDefs: [
                { orderable: false, targets: [0, 5, 6] } // Logo, Background, Actions columns are not sortable
            ]
        });
        
        console.log('DataTables initialized successfully');
    } catch (error) {
        console.error('Error initializing DataTables:', error);
    }
    
    // Enhanced delete confirmation
    document.querySelectorAll('.delete-partner-form').forEach(form => {
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
.color-preview {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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

.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
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
