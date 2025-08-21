@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Add New FAQs</h1>
                <p class="text-muted small mb-0">Create multiple frequently asked questions at once</p>
            </div>
            <a href="{{ route('dashboard.faqs.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to FAQs
            </a>
        </div>
    </div>
</div>

<form action="{{ route('dashboard.faqs.store') }}" method="POST" id="faqForm">
    @csrf
    
    <div id="faqContainer">
        <!-- FAQ items will be added here -->
    </div>
    
    <div class="d-flex justify-content-between align-items-center mt-4">
        <button type="button" class="btn btn-success" id="addMoreBtn">
            <i class="fas fa-plus me-2"></i>Add More FAQ
        </button>
        
        <div class="d-flex gap-2">
            <a href="{{ route('dashboard.faqs.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-save me-2"></i>Create All FAQs
            </button>
        </div>
    </div>
</form>

<!-- FAQ Template (hidden) -->
<template id="faqTemplate">
    <div class="faq-item card mb-4" data-index="__INDEX__">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">
                <i class="fas fa-question-circle me-2 text-primary"></i>FAQ #<span class="faq-number">__NUMBER__</span>
            </h6>
            <button type="button" class="btn btn-outline-danger btn-sm remove-faq-btn" title="Remove this FAQ">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">English Content</h6>
                    <div class="mb-3">
                        <label class="form-label">Question (English) *</label>
                        <textarea class="form-control" name="faqs[__INDEX__][question_en]" rows="3" required 
                                  placeholder="Enter your question in English"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Answer (English) *</label>
                        <textarea class="form-control" name="faqs[__INDEX__][answer_en]" rows="4" required 
                                  placeholder="Enter your answer in English"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">Arabic Content</h6>
                    <div class="mb-3">
                        <label class="form-label">Question (Arabic) *</label>
                        <textarea class="form-control" name="faqs[__INDEX__][question_ar]" rows="3" required 
                                  placeholder="أدخل سؤالك باللغة العربية"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Answer (Arabic) *</label>
                        <textarea class="form-control" name="faqs[__INDEX__][answer_ar]" rows="4" required 
                                  placeholder="أدخل إجابتك باللغة العربية"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
console.log('FAQ Script loaded!');

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing FAQ form...');
    
    // Get DOM elements
    const container = document.getElementById('faqContainer');
    const addMoreBtn = document.getElementById('addMoreBtn');
    const template = document.getElementById('faqTemplate');
    
    console.log('Container:', container);
    console.log('Add More Button:', addMoreBtn);
    console.log('Template:', template);
    
    // Check if elements exist
    if (!container) {
        console.error('Container not found!');
        return;
    }
    if (!addMoreBtn) {
        console.error('Add More Button not found!');
        return;
    }
    if (!template) {
        console.error('Template not found!');
        return;
    }
    
    let faqIndex = 0;
    
    // Function to add a new FAQ
    function addFAQ() {
        console.log('Adding FAQ, current index:', faqIndex);
        
        // Create new FAQ HTML
        const faqHtml = template.innerHTML
            .replace(/__INDEX__/g, faqIndex)
            .replace(/__NUMBER__/g, faqIndex + 1);
        
        console.log('Generated HTML:', faqHtml);
        
        // Create DOM element
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = faqHtml;
        const faqElement = tempDiv.firstElementChild;
        
        console.log('FAQ Element:', faqElement);
        
        // Add to container
        container.appendChild(faqElement);
        
        // Add remove functionality (only if not the first FAQ)
        if (faqIndex > 0) {
            const removeBtn = faqElement.querySelector('.remove-faq-btn');
            removeBtn.addEventListener('click', function() {
                faqElement.remove();
                updateFAQNumbers();
            });
        } else {
            // Hide remove button for first FAQ
            const removeBtn = faqElement.querySelector('.remove-faq-btn');
            removeBtn.style.display = 'none';
        }
        
        // Update indices
        faqIndex++;
        updateFAQNumbers();
        
        // Scroll to new FAQ
        faqElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Focus on first input
        setTimeout(() => {
            const firstTextarea = faqElement.querySelector('textarea');
            if (firstTextarea) {
                firstTextarea.focus();
            }
        }, 300);
        
        console.log('FAQ added successfully, new index:', faqIndex);
    }
    
    // Function to update FAQ numbers and form indices
    function updateFAQNumbers() {
        const faqItems = container.querySelectorAll('.faq-item');
        faqItems.forEach((item, index) => {
            // Update display number
            const numberSpan = item.querySelector('.faq-number');
            if (numberSpan) {
                numberSpan.textContent = index + 1;
            }
            
            // Update form array index
            const textareas = item.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                const name = textarea.name;
                const newName = name.replace(/faqs\[\d+\]/, `faqs[${index}]`);
                textarea.name = newName;
            });
            
            // Update data-index attribute
            item.setAttribute('data-index', index);
        });
    }
    
    // Add first FAQ automatically
    console.log('Adding first FAQ...');
    addFAQ();
    
    // Add event listener for Add More button
    addMoreBtn.addEventListener('click', function() {
        console.log('Add More button clicked');
        addFAQ();
    });
    
    // Form submission
    document.getElementById('faqForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const faqItems = container.querySelectorAll('.faq-item');
        if (faqItems.length === 0) {
            alert('Please add at least one FAQ before submitting.');
            return;
        }
        
        // Validate all FAQs
        let isValid = true;
        const requiredFields = container.querySelectorAll('textarea[required]');
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            alert('Please fill in all required fields.');
            return;
        }
        
        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating FAQs...';
        
        // Submit form
        this.submit();
    });
    
    // Real-time validation
    container.addEventListener('input', function(e) {
        if (e.target.tagName === 'TEXTAREA') {
            if (e.target.hasAttribute('required') && e.target.value.trim()) {
                e.target.classList.remove('is-invalid');
            }
        }
    });
    
    console.log('FAQ form initialization complete!');
});

// Fallback: if DOMContentLoaded already fired
if (document.readyState === 'loading') {
    console.log('DOM still loading, waiting...');
} else {
    console.log('DOM already loaded, initializing immediately...');
    // Trigger the initialization manually
    document.dispatchEvent(new Event('DOMContentLoaded'));
}
</script>
@endpush

<style>
.faq-item {
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.faq-item:hover {
    border-color: #007bff;
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.1);
}

.faq-item .card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #dee2e6;
}

.faq-item .card-header .card-title {
    color: #495057;
    font-weight: 600;
}

.remove-faq-btn {
    opacity: 0.7;
    transition: all 0.2s ease;
}

.remove-faq-btn:hover {
    opacity: 1;
    transform: scale(1.1);
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

#addMoreBtn {
    transition: all 0.3s ease;
}

#addMoreBtn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
}
</style>
