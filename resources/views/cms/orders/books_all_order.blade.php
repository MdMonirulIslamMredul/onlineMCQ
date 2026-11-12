@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>All Book Orders</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Book Purchase History (Hardcopy & Softcopy)</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example1" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Date</th>
                                        <th>Order Num</th>
                                        <th>Customer Name</th>
                                        <th>Customer Phone</th>
                                        <th>Format</th>
                                        <th>Subtotal</th>
                                        <th>Order Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php( $i = 0 )
                                    @foreach($orders as $order)
                                        <tr>
                                            <th>{{ $i += 1}}</th>
                                            <td>{{ date("d M, Y", strtotime($order->date)) }}</td>
                                            <td><strong>#{{ $order->orderNum }}</strong></td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>
                                                @if(($order->book_type ?? 'hardcopy') == 'softcopy')
                                                    <span class="badge badge-info" style="font-size: 11.5px;">
                                                        <i class="fas fa-file-pdf"></i> Softcopy (E-Book)
                                                    </span>
                                                @else
                                                    <span class="badge badge-success" style="font-size: 11.5px;">
                                                        <i class="fas fa-book"></i> Hardcopy
                                                    </span>
                                                @endif
                                            </td>
                                            <td><strong>৳ {{ number_format($order->amount ?: ($order->quantity * $order->price), 0) }}</strong></td>
                                            <td>
                                                @if($order->status == 'pending')
                                                    <span class="badge badge-warning text-dark">Pending</span>
                                                @elseif($order->status == 'processing')
                                                    <span class="badge badge-primary">Processing</span>
                                                @elseif($order->status == 'shipped')
                                                    <span class="badge badge-info">Shipped</span>
                                                @elseif($order->status == 'delivered' || $order->status == 'approved' || $order->status == 'completed')
                                                    <span class="badge badge-success">Delivered / Active</span>
                                                @elseif($order->status == 'canceled')
                                                    <span class="badge badge-danger">Canceled</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ ucfirst($order->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('/cms/orderDetails/'.$order->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Details
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
