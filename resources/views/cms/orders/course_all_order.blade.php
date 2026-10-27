@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Course Enrollments & Manual Payment Verification</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('/cms') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Course Enrollments</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">All Course Enrollment Orders</h4>
                        <div>
                            <span class="badge badge-warning text-dark mr-2">Pending: {{ $orders->where('status', 'pending')->count() }}</span>
                            <span class="badge badge-success">Enrolled: {{ $orders->where('status', 'enrolled')->count() }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle" id="example1" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Date</th>
                                        <th>Order #</th>
                                        <th>Student</th>
                                        <th>Course</th>
                                        <th>Payment Gateway</th>
                                        <th>TrxID</th>
                                        <th>Amount</th>
                                        <th>Proof</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    @php
                                        $courseItem = DB::table('courses')->where('id', $order->course_id ?? $order->pid)->first();
                                    @endphp
                                        <tr>
                                            <th>{{ $loop->iteration }}</th>
                                            <td><small class="text-muted">{{ date("d M, Y", strtotime($order->date)) }}</small></td>
                                            <td><strong>#{{ $order->orderNum }}</strong></td>
                                            <td>
                                                <strong>{{ $order->name }}</strong><br>
                                                <small class="text-muted">{{ $order->phone }}</small>
                                            </td>
                                            <td>
                                                <span class="badge badge-light border text-truncate" style="max-width: 170px;" title="{{ optional($courseItem)->name }}">
                                                    {{ optional($courseItem)->name ?? 'Course #' . ($order->course_id ?? $order->pid) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge {{ ($order->payment_type ?? '') === 'bank' ? 'badge-info' : 'badge-primary' }}">
                                                    {{ $order->payment_method ?? 'Manual' }}
                                                </span>
                                                @if(!empty($order->sender_number))
                                                    <br><small class="text-muted">{{ $order->sender_number }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <code style="font-size: 13px;">{{ $order->trx_id ?? $order->transaction_id ?? 'N/A' }}</code>
                                            </td>
                                            <td><strong>৳ {{ number_format($order->price, 0) }}</strong></td>
                                            <td class="text-center">
                                                @if(!empty($order->screenshot) && file_exists(public_path($order->screenshot)))
                                                    <a href="{{ asset($order->screenshot) }}" target="_blank" title="View Screenshot">
                                                        <img src="{{ asset($order->screenshot) }}" alt="" style="width: 38px; height: 38px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                                    </a>
                                                @else
                                                    <span class="text-muted small">None</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->status == 'pending')
                                                    <span class="badge badge-warning text-dark"><i class="fas fa-clock mr-1"></i> Pending</span>
                                                @elseif($order->status == 'enrolled' || $order->status == 'delivered')
                                                    <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> Enrolled</span>
                                                @elseif($order->status == 'rejected' || $order->status == 'canceled')
                                                    <span class="badge badge-danger"><i class="fas fa-times-circle mr-1"></i> Rejected</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ ucfirst($order->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('/cms/course/orderDetails/'.$order->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-search mr-1"></i> Verify / View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
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
