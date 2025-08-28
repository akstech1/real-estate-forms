@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>Homepage Statistics
                    </h5>
                    <div>
                        <span class="badge bg-info">Single Record Management</span>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.homepage-stats.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 10%;">Section</th>
                                        <th style="width: 35%;">English Content</th>
                                        <th style="width: 35%;">Arabic Content</th>
                                        <th style="width: 20%;">Count Display</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Section 1 -->
                                    <tr class="table-light">
                                        <td class="text-center fw-bold">
                                            <span class="badge bg-primary">Section 1</span>
                                        </td>
                                        <td>
                                            <div class="mb-3">
                                                <label for="section_1_heading_en" class="form-label">Heading (English) *</label>
                                                <input type="text" class="form-control @error('section_1_heading_en') is-invalid @enderror"
                                                       id="section_1_heading_en" name="section_1_heading_en"
                                                       value="{{ old('section_1_heading_en', $stats->section_1_heading_en) }}" required>
                                                @error('section_1_heading_en')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-3">
                                                <label for="section_1_heading_ar" class="form-label">Heading (Arabic) *</label>
                                                <input type="text" class="form-control @error('section_1_heading_ar') is-invalid @enderror"
                                                       id="section_1_heading_ar" name="section_1_heading_ar"
                                                       value="{{ old('section_1_heading_ar', $stats->section_1_heading_ar) }}" required>
                                                @error('section_1_heading_ar')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-3">
                                                <label for="section_1_count" class="form-label">Count *</label>
                                                <input type="text" class="form-control @error('section_1_count') is-invalid @enderror"
                                                       id="section_1_count" name="section_1_count"
                                                       value="{{ old('section_1_count', $stats->section_1_count) }}" required>
                                                @error('section_1_count')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Section 2 -->
                                    <tr class="table-light">
                                        <td class="text-center fw-bold">
                                            <span class="badge bg-success">Section 2</span>
                                        </td>
                                        <td>
                                            <div class="mb-3">
                                                <label for="section_2_heading_en" class="form-label">Heading (English) *</label>
                                                <input type="text" class="form-control @error('section_2_heading_en') is-invalid @enderror"
                                                       id="section_2_heading_en" name="section_2_heading_en"
                                                       value="{{ old('section_2_heading_en', $stats->section_2_heading_en) }}" required>
                                                @error('section_2_heading_en')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-3">
                                                <label for="section_2_heading_ar" class="form-label">Heading (Arabic) *</label>
                                                <input type="text" class="form-control @error('section_2_heading_ar') is-invalid @enderror"
                                                       id="section_2_heading_ar" name="section_2_heading_ar"
                                                       value="{{ old('section_2_heading_ar', $stats->section_2_heading_ar) }}" required>
                                                @error('section_2_heading_ar')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-3">
                                                <label for="section_2_count" class="form-label">Count *</label>
                                                <input type="text" class="form-control @error('section_2_count') is-invalid @enderror"
                                                       id="section_2_count" name="section_2_count"
                                                       value="{{ old('section_2_count', $stats->section_2_count) }}" required>
                                                @error('section_2_count')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Section 3 -->
                                    <tr class="table-light">
                                        <td class="text-center fw-bold">
                                            <span class="badge bg-warning">Section 3</span>
                                        </td>
                                        <td>
                                            <div class="mb-3">
                                                <label for="section_3_heading_en" class="form-label">Heading (English) *</label>
                                                <input type="text" class="form-control @error('section_3_heading_en') is-invalid @enderror"
                                                       id="section_3_heading_en" name="section_3_heading_en"
                                                       value="{{ old('section_3_heading_en', $stats->section_3_heading_en) }}" required>
                                                @error('section_3_heading_en')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-3">
                                                <label for="section_3_heading_ar" class="form-label">Heading (Arabic) *</label>
                                                <input type="text" class="form-control @error('section_3_heading_ar') is-invalid @enderror"
                                                       id="section_3_heading_ar" name="section_3_heading_ar"
                                                       value="{{ old('section_3_heading_ar', $stats->section_3_heading_ar) }}" required>
                                                @error('section_3_heading_ar')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-3">
                                                <label for="section_3_count" class="form-label">Count *</label>
                                                <input type="text" class="form-control @error('section_3_count') is-invalid @enderror"
                                                       id="section_3_count" name="section_3_count"
                                                       value="{{ old('section_3_count', $stats->section_3_count) }}" required>
                                                @error('section_3_count')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Section 4 -->
                                    <tr class="table-light">
                                        <td class="text-center fw-bold">
                                            <span class="badge bg-danger">Section 4</span>
                                        </td>
                                        <td>
                                            <div class="mb-3">
                                                <label for="section_4_heading_en" class="form-label">Heading (English) *</label>
                                                <input type="text" class="form-control @error('section_4_heading_en') is-invalid @enderror"
                                                       id="section_4_heading_en" name="section_4_heading_en"
                                                       value="{{ old('section_4_heading_en', $stats->section_4_heading_en) }}" required>
                                                @error('section_4_heading_en')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-3">
                                                <label for="section_4_heading_ar" class="form-label">Heading (Arabic) *</label>
                                                <input type="text" class="form-control @error('section_4_heading_ar') is-invalid @enderror"
                                                       id="section_4_heading_ar" name="section_4_heading_ar"
                                                       value="{{ old('section_4_heading_ar', $stats->section_4_heading_ar) }}" required>
                                                @error('section_4_heading_ar')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-3">
                                                <label for="section_4_count" class="form-label">Count *</label>
                                                <input type="text" class="form-control @error('section_4_count') is-invalid @enderror"
                                                       id="section_4_count" name="section_4_count"
                                                       value="{{ old('section_4_count', $stats->section_4_count) }}" required>
                                                @error('section_4_count')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Homepage Stats
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        vertical-align: middle;
        text-align: center;
    }

    .table td {
        vertical-align: top;
    }

    .badge {
        font-size: 0.8rem;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
    }

    .table-light {
        background-color: #f8f9fa;
    }

    .table-hover tbody tr:hover {
        background-color: #e9ecef;
    }
</style>
@endpush


