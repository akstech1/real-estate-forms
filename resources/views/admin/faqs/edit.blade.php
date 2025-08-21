@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Edit FAQ</h1>
                <p class="text-muted small mb-0">Update frequently asked question</p>
            </div>
            <a href="{{ route('dashboard.faqs.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to FAQs
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="fas fa-edit me-2 text-primary"></i>Edit FAQ #{{ $faq->id }}
        </h6>
    </div>
    <div class="card-body">
        <form action="{{ route('dashboard.faqs.update', $faq) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">English Content</h6>
                    
                    <div class="mb-3">
                        <label for="question_en" class="form-label">Question (English) *</label>
                        <textarea class="form-control @error('question_en') is-invalid @enderror" 
                                  id="question_en" name="question_en" rows="3" required 
                                  maxlength="500">{{ old('question_en', $faq->question_en) }}</textarea>
                        <div class="form-text">
                            <span id="charCountEn">0</span> / 500 characters
                        </div>
                        @error('question_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="answer_en" class="form-label">Answer (English) *</label>
                        <textarea class="form-control @error('answer_en') is-invalid @enderror" 
                                  id="answer_en" name="answer_en" rows="4" required>{{ old('answer_en', $faq->answer_en) }}</textarea>
                        @error('answer_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">Arabic Content</h6>
                    
                    <div class="mb-3">
                        <label for="question_ar" class="form-label">Question (Arabic) *</label>
                        <textarea class="form-control @error('question_ar') is-invalid @enderror" 
                                  id="question_ar" name="question_ar" rows="3" required 
                                  maxlength="500">{{ old('question_ar', $faq->question_ar) }}</textarea>
                        <div class="form-text">
                            <span id="charCountAr">0</span> / 500 characters
                        </div>
                        @error('question_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="answer_ar" class="form-label">Answer (Arabic) *</label>
                        <textarea class="form-control @error('answer_ar') is-invalid @enderror" 
                                  id="answer_ar" name="answer_ar" rows="4" required>{{ old('answer_ar', $faq->answer_ar) }}</textarea>
                        @error('answer_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                   {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active (visible to users)
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('dashboard.faqs.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update FAQ
                </button>
            </div>
        </form>
    </div>
</div>

<!-- FAQ Preview -->
<div class="card mt-4">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="fas fa-eye me-2 text-info"></i>Live Preview
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-primary mb-3">English Preview</h6>
                <div class="faq-preview">
                    <h6 class="fw-bold" id="previewQuestionEn">{{ $faq->question_en }}</h6>
                    <p class="text-muted" id="previewAnswerEn">{{ $faq->answer_en }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <h6 class="text-primary mb-3">Arabic Preview</h6>
                <div class="faq-preview">
                    <h6 class="fw-bold" id="previewQuestionAr">{{ $faq->question_ar }}</h6>
                    <p class="text-muted" id="previewAnswerAr">{{ $faq->answer_ar }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const questionEn = document.getElementById('question_en');
    const questionAr = document.getElementById('question_ar');
    const charCountEn = document.getElementById('charCountEn');
    const charCountAr = document.getElementById('charCountAr');
    
    // Character counters
    function updateCharCount(textarea, counter) {
        const length = textarea.value.length;
        counter.textContent = length;
        
        if (length > 450) {
            counter.className = 'text-warning';
        } else if (length > 500) {
            counter.className = 'text-danger';
        } else {
            counter.className = 'text-muted';
        }
    }
    
    // Initialize character counts
    updateCharCount(questionEn, charCountEn);
    updateCharCount(questionAr, charCountAr);
    
    // Update character counts on input
    questionEn.addEventListener('input', () => updateCharCount(questionEn, charCountEn));
    questionAr.addEventListener('input', () => updateCharCount(questionAr, charCountAr));
    
    // Live preview updates
    function updatePreview() {
        document.getElementById('previewQuestionEn').textContent = questionEn.value;
        document.getElementById('previewAnswerEn').textContent = document.getElementById('answer_en').value;
        document.getElementById('previewQuestionAr').textContent = questionAr.value;
        document.getElementById('previewAnswerAr').textContent = document.getElementById('answer_ar').value;
    }
    
    // Update preview on input
    questionEn.addEventListener('input', updatePreview);
    questionAr.addEventListener('input', updatePreview);
    document.getElementById('answer_en').addEventListener('input', updatePreview);
    document.getElementById('answer_ar').addEventListener('input', updatePreview);
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
});
</script>
@endpush

<style>
.faq-preview {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
    border-left: 4px solid #007bff;
}

.faq-preview h6 {
    color: #495057;
    margin-bottom: 0.5rem;
}

.faq-preview p {
    margin-bottom: 0;
    line-height: 1.6;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #dee2e6;
}

.card-header .card-title {
    color: #495057;
    font-weight: 600;
}
</style>
