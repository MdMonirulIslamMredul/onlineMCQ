@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>All Orders</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                        </div>
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
                                            <td>{{ $order->orderNum }}</td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->quantity*$order->price }}</td>
                                                @if($order->status == 'pending')
                                                    <td class="text-info"> <h3><b>{{ $order->status }}</b></h3></td>
                                                @elseif($order->status == 'processing')
                                                    <td class="text-secondary"> <h3><b>{{ $order->status }}</b></h3></td>
                                                @elseif($order->status == 'shipped')
                                                    <td class="text-dark"> <h3><b>{{ $order->status }}</b></h3></td>
                                                @elseif($order->status == 'delivered')
                                                    <td class="text-success"> <h3><b>{{ $order->status }}</b></h3></td>
                                                @elseif($order->status == 'canceled')
                                                    <td class="text-danger"> 
                                                        <h3><b>{{ $order->status }}</b></h3> 
                                                    </td>
                                                @endif
                                            <td>
                                                <a href="{{ url('/cms/orderDetails/'.$order->id) }}" class="btn btn-info btn-sm">View Details</a>
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
