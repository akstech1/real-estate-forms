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
                                <form action="{{ route('dashboard.partners.destroy', $partner) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this partner?')">
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

<!-- DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
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
        }
    });
});
</script>
@endsection
