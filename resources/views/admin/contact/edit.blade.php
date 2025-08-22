@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Contact Us</h1>
                <p class="text-muted small mb-0">Manage your contact information and social media links</p>
            </div>
        </div>
    </div>
</div>


<form action="{{ route('dashboard.contact.update') }}" method="POST" id="contactForm" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Contact Information Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Contact Information
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">English Content</h6>

                    <div class="mb-3">
                        <label for="address_en" class="form-label">Address (English) *</label>
                        <textarea class="form-control @error('address_en') is-invalid @enderror"
                                  id="address_en" name="address_en" rows="3" required
                                  placeholder="Enter your address in English">{{ old('address_en', $contactUs->address_en) }}</textarea>
                        @error('address_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" required
                               value="{{ old('email', $contactUs->email) }}"
                               placeholder="Enter your email address">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number *</label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                               id="phone_number" name="phone_number" required
                               value="{{ old('phone_number', $contactUs->phone_number) }}"
                               placeholder="Enter your phone number">
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">Arabic Content</h6>

                    <div class="mb-3">
                        <label for="address_ar" class="form-label">Address (Arabic) *</label>
                        <textarea class="form-control @error('address_ar') is-invalid @enderror"
                                  id="address_ar" name="address_ar" rows="3" required
                                  placeholder="أدخل عنوانك باللغة العربية">{{ old('address_ar', $contactUs->address_ar) }}</textarea>
                        @error('address_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="latitude" class="form-label">Latitude *</label>
                        <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror"
                               id="latitude" name="latitude" required
                               value="{{ old('latitude', $contactUs->latitude) }}"
                               placeholder="e.g., 24.7136">
                        @error('latitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="longitude" class="form-label">Longitude *</label>
                        <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror"
                               id="longitude" name="longitude" required
                               value="{{ old('longitude', $contactUs->longitude) }}"
                               placeholder="e.g., 46.6753">
                        @error('longitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Media Links Section -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">
                <i class="fas fa-share-alt me-2 text-success"></i>Social Media Links
            </h6>
            <button type="button" class="btn btn-success btn-sm" id="addSocialMediaBtn">
                <i class="fas fa-plus me-2"></i>Add Social Media Link
            </button>
        </div>
        <div class="card-body">
            <div id="socialMediaContainer">
                @if($socialMediaLinks->count() > 0)
                    @foreach($socialMediaLinks as $index => $link)
                    <div class="social-media-item card mb-3" data-index="{{ $index }}">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-link me-2 text-info"></i>Social Media Link #{{ $index + 1 }}
                            </h6>
                            <button type="button" class="btn btn-outline-danger btn-sm remove-social-media-btn"
                                    data-link-id="{{ $link->id }}" title="Remove this link">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Platform Name *</label>
                                        <input type="text" class="form-control"
                                               name="social_media_links[{{ $index }}][name]"
                                               value="{{ $link->name }}" required
                                               placeholder="e.g., Facebook, Twitter, Instagram">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Logo/Icon @if(!$link->logo_url) * @endif</label>
                                        <input type="file" class="form-control"
                                               name="social_media_links[{{ $index }}][logo]"
                                               accept="image/*" @if(!$link->logo_url) required @endif>
                                        <div class="form-text">Max size: 2MB. Accepted: JPEG, PNG, JPG, WebP</div>
                                        @if($link->logo_url)
                                            <div class="mt-2">
                                                <small class="text-muted">Current logo:</small>
                                                <img src="{{ $link->logo_url }}" alt="Current Logo"
                                                     class="img-thumbnail d-block mt-1" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div class="form-text text-info mt-1">Leave empty to keep current logo</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Link URL *</label>
                                        <input type="url" class="form-control"
                                               name="social_media_links[{{ $index }}][link]"
                                               value="{{ $link->link }}" required
                                               placeholder="https://example.com">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>

            <div id="noLinksMessage" class="text-center py-4 {{ $socialMediaLinks->count() > 0 ? 'd-none' : '' }}">
                <div class="mb-3">
                    <i class="fas fa-share-alt fa-3x text-muted opacity-50"></i>
                </div>
                <h6 class="text-muted">No Social Media Links</h6>
                <p class="text-muted mb-0">Click "Add Social Media Link" to get started</p>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <button type="submit" class="btn btn-primary" id="submitBtn">
            <i class="fas fa-save me-2"></i>Update Contact Information
        </button>
    </div>
</form>

<!-- Social Media Link Template (hidden) -->
<template id="socialMediaTemplate">
    <div class="social-media-item card mb-3" data-index="__INDEX__">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">
                <i class="fas fa-link me-2 text-info"></i>Social Media Link #<span class="link-number">__NUMBER__</span>
            </h6>
            <button type="button" class="btn btn-outline-danger btn-sm remove-social-media-btn" title="Remove this link">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Platform Name *</label>
                        <input type="text" class="form-control"
                               name="social_media_links[__INDEX__][name]" required
                               placeholder="e.g., Facebook, Twitter, Instagram">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Logo/Icon *</label>
                        <input type="file" class="form-control"
                               name="social_media_links[__INDEX__][logo]"
                               accept="image/*" required>
                        <div class="form-text">Max size: 2MB. Accepted: JPEG, PNG, JPG, WebP</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Link URL *</label>
                        <input type="url" class="form-control"
                               name="social_media_links[__INDEX__][link]" required
                               placeholder="https://example.com">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('socialMediaContainer');
    const addBtn = document.getElementById('addSocialMediaBtn');
    const template = document.getElementById('socialMediaTemplate');
    const noLinksMessage = document.getElementById('noLinksMessage');

    let socialMediaIndex = {{ $socialMediaLinks->count() }};

    // Function to add new social media link
    function addSocialMediaLink() {
        const linkHtml = template.innerHTML
            .replace(/__INDEX__/g, socialMediaIndex)
            .replace(/__NUMBER__/g, socialMediaIndex + 1);

        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = linkHtml;
        const linkElement = tempDiv.firstElementChild;

        container.appendChild(linkElement);

        // Hide no links message
        noLinksMessage.classList.add('d-none');

        // Update indices
        socialMediaIndex++;
        updateLinkNumbers();

        // Scroll to new link
        linkElement.scrollIntoView({ behavior: 'smooth', block: 'center' });

        // Focus on first input
        setTimeout(() => {
            const firstInput = linkElement.querySelector('input');
            if (firstInput) {
                firstInput.focus();
            }
        }, 300);
    }

    // Function to update link numbers
    function updateLinkNumbers() {
        const linkItems = container.querySelectorAll('.social-media-item');
        linkItems.forEach((item, index) => {
            const numberSpan = item.querySelector('.link-number');
            if (numberSpan) {
                numberSpan.textContent = index + 1;
            }

            // Update form array index
            const inputs = item.querySelectorAll('input');
            inputs.forEach(input => {
                const name = input.name;
                const newName = name.replace(/social_media_links\[\d+\]/, `social_media_links[${index}]`);
                input.name = newName;
            });

            // Update data-index attribute
            item.setAttribute('data-index', index);
        });
    }

    // Function to remove social media link
    function removeSocialMediaLink(element) {
        element.remove();
        updateLinkNumbers();

        // Show no links message if no links remain
        if (container.querySelectorAll('.social-media-item').length === 0) {
            noLinksMessage.classList.remove('d-none');
        }
    }

    // Add event listener for Add More button
    addBtn.addEventListener('click', addSocialMediaLink);

    // Handle remove buttons (for existing and new links)
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-social-media-btn')) {
            const removeBtn = e.target.closest('.remove-social-media-btn');
            const linkItem = removeBtn.closest('.social-media-item');
            const linkId = removeBtn.dataset.linkId;

            if (linkId) {
                // This is an existing link, confirm deletion
                if (confirm('Are you sure you want to delete this social media link? This action cannot be undone.')) {
                    // Send AJAX request to delete
                    fetch(`/dashboard/contact/social-media/${linkId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            removeSocialMediaLink(linkItem);
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting social media link:', error);
                        alert('Error deleting social media link. Please try again.');
                    });
                }
            } else {
                // This is a new link, just remove from DOM
                removeSocialMediaLink(linkItem);
            }
        }
    });

    // Form validation
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (field.type === 'file') {
                // Only validate file inputs that are actually required (new social media links)
                if (field.hasAttribute('required') && !field.files.length) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else if (field.files.length) {
                    // Validate file size (2MB) if file is selected
                    const file = field.files[0];
                    if (file.size > 2 * 1024 * 1024) {
                        field.classList.add('is-invalid');
                        isValid = false;
                        alert('File size must be less than 2MB: ' + file.name);
                    } else {
                        field.classList.remove('is-invalid');
                    }
                } else {
                    field.classList.remove('is-invalid');
                }
            } else {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields and ensure file sizes are under 2MB.');
            return;
        }

        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
    });

    // Real-time validation
    container.addEventListener('input', function(e) {
        if (e.target.tagName === 'INPUT' && e.target.hasAttribute('required')) {
            if (e.target.type === 'file') {
                if (e.target.files.length) {
                    e.target.classList.remove('is-invalid');
                }
            } else {
                if (e.target.value.trim()) {
                    e.target.classList.remove('is-invalid');
                }
            }
        }
    });

    // File preview functionality
    container.addEventListener('change', function(e) {
        if (e.target.type === 'file' && e.target.files.length) {
            const file = e.target.files[0];
            const fileInput = e.target;

            // Validate file size
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB: ' + file.name);
                fileInput.value = '';
                return;
            }

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please select a valid image file (JPEG, PNG, JPG, or WebP): ' + file.name);
                fileInput.value = '';
                return;
            }
        }
    });
});
</script>
@endpush

<style>
.social-media-item {
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.social-media-item:hover {
    border-color: #28a745;
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.1);
}

.social-media-item .card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #dee2e6;
}

.social-media-item .card-header .card-title {
    color: #495057;
    font-weight: 600;
}

.remove-social-media-btn {
    opacity: 0.7;
    transition: all 0.2s ease;
}

.remove-social-media-btn:hover {
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

#addSocialMediaBtn {
    transition: all 0.3s ease;
}

#addSocialMediaBtn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
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
