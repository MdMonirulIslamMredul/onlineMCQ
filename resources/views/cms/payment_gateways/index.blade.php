@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Payment Gateways</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('/cms') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Payment Gateways</div>
        </div>
    </div>

    <div class="section-body">
        @if(session('status'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Configured Payment Methods (MFS & Bank)</h4>
                        <a href="{{ route('cms.payment_gateways.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Payment Gateway
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example1" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Logo</th>
                                        <th>Gateway Name</th>
                                        <th>Type</th>
                                        <th>Account Number / Info</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($gateways as $index => $gateway)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($gateway->logo)
                                                <img src="{{ asset($gateway->logo) }}" alt="{{ $gateway->name }}" style="height: 38px; width: 68px; object-fit: contain; border-radius: 6px; background: #fff; padding: 2px; border: 1px solid #e2e8f0;">
                                            @else
                                                <span class="badge badge-secondary"><i class="fas fa-wallet"></i></span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $gateway->name }}</strong>
                                            @if($gateway->account_type)
                                                <span class="badge badge-light text-dark ml-1 font-weight-normal">({{ $gateway->account_type }})</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($gateway->type == 'mfs')
                                                <span class="badge badge-info"><i class="fas fa-mobile-alt mr-1"></i> MFS (Mobile)</span>
                                            @else
                                                <span class="badge badge-primary"><i class="fas fa-university mr-1"></i> Bank Transfer</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="font-weight-bold text-dark">{{ $gateway->account_number }}</div>
                                            @if($gateway->type == 'bank')
                                                <small class="text-muted d-block">
                                                    {{ $gateway->bank_name ?? '' }} 
                                                    {{ $gateway->branch_name ? '• ' . $gateway->branch_name : '' }}
                                                    {{ $gateway->routing_number ? '• Routing: ' . $gateway->routing_number : '' }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($gateway->status)
                                                <a href="{{ route('cms.payment_gateways.toggle', $gateway->id) }}" class="badge badge-success text-white" title="Click to disable">Active</a>
                                            @else
                                                <a href="{{ route('cms.payment_gateways.toggle', $gateway->id) }}" class="badge badge-danger text-white" title="Click to enable">Inactive</a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('cms.payment_gateways.edit', $gateway->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('cms.payment_gateways.destroy', $gateway->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment gateway?');" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm ml-1" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            No payment gateways configured yet. Click "Add Payment Gateway" to get started.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
