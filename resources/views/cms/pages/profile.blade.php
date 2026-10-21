@extends('cms.cms_master')
@section('admin_content')

<section class="section">
    <div class="section-header">
        <h1>Admin Profile Settings</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Profile Information</h4>
                </div>
                <div class="card-body">
                    {{-- <p><strong>Name:</strong> {{ $admin_info->name }}</p>
                    <p><strong>Email:</strong> {{ $admin_info->email }}</p> --}}
                    <!-- Add more fields as needed -->
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $admin_info->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $admin_info->email }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($admin_info->active == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection