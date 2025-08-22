@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Add New Terms & Conditions</h1>
                <p class="text-muted small mb-0">Create multiple terms and conditions at once</p>
            </div>
            <a href="{{ route('dashboard.terms.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Terms
            </a>
        </div>
    </div>
</div>

<form action="{{ route('dashboard.terms.store') }}" method="POST" id="termForm">
    @csrf
    
    <div id="termContainer">
        <!-- Term items will be added here -->
    </div>
    
    <div class="d-flex justify-content-between align-items-center mt-4">
        <button type="button" class="btn btn-success" id="addMoreBtn">
            <i class="fas fa-plus me-2"></i>Add More Term
        </button>
        
        <div class="d-flex gap-2">
            <a href="{{ route('dashboard.terms.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-save me-2"></i>Create All Terms
            </button>
        </div>
    </div>
</form>

<!-- Term Template (hidden) -->
<template id="termTemplate">
    <div class="term-item card mb-4" data-index="__INDEX__">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">
                <i class="fas fa-file-contract me-2 text-primary"></i>Term #<span class="term-number">__NUMBER__</span>
            </h6>
            <button type="button" class="btn btn-outline-danger btn-sm remove-term-btn" title="Remove this Term">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">English Content</h6>
                    <div class="mb-3">
                        <label class="form-label">Heading (English) *</label>
                        <textarea class="form-control" name="terms[__INDEX__][heading_en]" rows="3" required 
                                  placeholder="Enter your heading in English"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description (English) *</label>
                        <textarea class="form-control" name="terms[__INDEX__][description_en]" rows="4" required 
                                  placeholder="Enter your description in English"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">Arabic Content</h6>
                    <div class="mb-3">
                        <label class="form-label">Heading (Arabic) *</label>
                        <textarea class="form-control" name="terms[__INDEX__][heading_ar]" rows="3" required 
                                  placeholder="أدخل العنوان باللغة العربية"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description (Arabic) *</label>
                        <textarea class="form-control" name="terms[__INDEX__][description_ar]" rows="4" required 
                                  placeholder="أدخل الوصف باللغة العربية"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
console.log('Terms Script loaded!');

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing Terms form...');
    
    // Get DOM elements
    const container = document.getElementById('termContainer');
    const addMoreBtn = document.getElementById('addMoreBtn');
    const template = document.getElementById('termTemplate');
    
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
    
    let termIndex = 0;
    
    // Function to add a new Term
    function addTerm() {
        console.log('Adding Term, current index:', termIndex);
        
        // Create new Term HTML
        const termHtml = template.innerHTML
            .replace(/__INDEX__/g, termIndex)
            .replace(/__NUMBER__/g, termIndex + 1);
        
        console.log('Generated HTML:', termHtml);
        
        // Create DOM element
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = termHtml;
        const termElement = tempDiv.firstElementChild;
        
        console.log('Term Element:', termElement);
        
        // Add to container
        container.appendChild(termElement);
        
        // Add remove functionality (only if not the first Term)
        if (termIndex > 0) {
            const removeBtn = termElement.querySelector('.remove-term-btn');
            removeBtn.addEventListener('click', function() {
                termElement.remove();
                updateTermNumbers();
            });
        } else {
            // Hide remove button for first Term
            const removeBtn = termElement.querySelector('.remove-term-btn');
            removeBtn.style.display = 'none';
        }
        
        // Update indices
        termIndex++;
        updateTermNumbers();
        
        // Scroll to new Term
        termElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Focus on first input
        setTimeout(() => {
            const firstTextarea = termElement.querySelector('textarea');
            if (firstTextarea) {
                firstTextarea.focus();
            }
        }, 300);
        
        console.log('Term added successfully, new index:', termIndex);
    }
    
    // Function to update Term numbers and form indices
    function updateTermNumbers() {
        const termItems = container.querySelectorAll('.term-item');
        termItems.forEach((item, index) => {
            // Update display number
            const numberSpan = item.querySelector('.term-number');
            if (numberSpan) {
                numberSpan.textContent = index + 1;
            }
            
            // Update form array index
            const textareas = item.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                const name = textarea.name;
                const newName = name.replace(/terms\[\d+\]/, `terms[${index}]`);
                textarea.name = newName;
            });
            
            // Update data-index attribute
            item.setAttribute('data-index', index);
        });
    }
    
    // Add first Term automatically
    console.log('Adding first Term...');
    addTerm();
    
    // Add event listener for Add More button
    addMoreBtn.addEventListener('click', function() {
        console.log('Add More button clicked');
        addTerm();
    });
    
    // Form submission
    document.getElementById('termForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const termItems = container.querySelectorAll('.term-item');
        if (termItems.length === 0) {
            alert('Please add at least one term before submitting.');
            return;
        }
        
        // Validate all Terms
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
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating Terms...';
        
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
    
    console.log('Terms form initialization complete!');
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
.term-item {
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.term-item:hover {
    border-color: #007bff;
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.1);
}

.term-item .card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #dee2e6;
}

.term-item .card-header .card-title {
    color: #495057;
    font-weight: 600;
}

.remove-term-btn {
    opacity: 0.7;
    transition: all 0.2s ease;
}

.remove-term-btn:hover {
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
