@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Manage FAQs</h1>
                <p class="text-muted small mb-0">Frequently Asked Questions</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.faqs.banner.edit') }}" class="btn btn-outline-info btn-sm">
                    <i class="fas fa-image me-2"></i>Banner Image
                </a>
                <a href="{{ route('dashboard.faqs.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-2"></i>Add FAQs
                </a>
            </div>
        </div>
    </div>
</div>

@if($faqs->count() > 0)
<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>All FAQs ({{ $faqs->count() }})
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th style="width: 60px;">Status</th>
                        <th>Question (English)</th>
                        <th>Question (Arabic)</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="faqTableBody">
                    @foreach($faqs as $faq)
                    <tr data-id="{{ $faq->id }}">
                        <td class="align-middle">
                            <span class="badge bg-primary">{{ $faq->id }}</span>
                        </td>
                        <td class="align-middle">
                            @if($faq->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <div class="fw-semibold">{{ Str::limit($faq->question_en, 60) }}</div>
                            <small class="text-muted">{{ Str::limit($faq->answer_en, 80) }}</small>
                        </td>
                        <td class="align-middle">
                            <div class="fw-semibold">{{ Str::limit($faq->question_ar, 60) }}</div>
                            <small class="text-muted">{{ Str::limit($faq->answer_ar, 80) }}</small>
                        </td>
                        <td class="align-middle">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('dashboard.faqs.edit', $faq) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dashboard.faqs.toggle-status', $faq) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-warning" title="{{ $faq->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas fa-{{ $faq->is_active ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('dashboard.faqs.destroy', $faq) }}" method="POST" class="d-inline delete-faq-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this FAQ?')">
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
            <i class="fas fa-question-circle fa-3x text-muted opacity-50"></i>
        </div>
        <h5 class="text-muted">No FAQs Found</h5>
        <p class="text-muted mb-3">Start by adding some frequently asked questions.</p>
        <a href="{{ route('dashboard.faqs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Your First FAQ
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
                <p>Are you sure you want to delete this FAQ? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced delete confirmation
    document.querySelectorAll('.delete-faq-form').forEach(form => {
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
</style>
