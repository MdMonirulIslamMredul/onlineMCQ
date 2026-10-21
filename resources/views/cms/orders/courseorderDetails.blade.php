@extends('cms.cms_master')
@section('admin_content')
@php
    $shop_s = DB::table('company_settings')->first();
    $product_info = DB::table('courses')->where('id', $orders_info->course_id)->first();
@endphp
<section class="section">
    <div class="section-header">
        <h1>Order Details</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div style="padding: 5px;">
                            <div class="row">
                                <div class="col-md-6 col-4 text-left">
                                    <img id="invoicePageLogo" src="{{asset($shop_s->logo)}}" alt="">
                                </div>
                                <div class="col-md-6 col-8" style="text-align: right;">
                                    <h2><b>{{$shop_s->company_name}}</b></h2>
                                    <p class="font_size_small"><b>{{$shop_s->address}}</b><br><b>{{$shop_s->phone_1}}, {{$shop_s->phone_2}}<br>{{$shop_s->email}}</b></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 col-6" style="text-align: left;">
                                    <p>
                                        <b class="text-info">Customer Name: </b>{{$orders_info->name}}<br>
                                        <b class="text-info">Adderss: </b>{{$orders_info->address}}<br>
                                        <b class="text-info">Phone: </b>{{$orders_info->phone}}<br>
                                        <b class="text-info">Email: </b>{{$orders_info->email}}
                                    </p>
                                </div>
                                <div class="col-md-6 col-6" style="text-align: right;">
                                    <p class="font_size_small">
                                        <b class="text-info">Order Date: </b>{{date("d M, Y", strtotime($orders_info->date))}}<br>
                                        <b class="text-info">Order Number: </b>{{$orders_info->orderNum}}<br>
                                        <b class="text-danger">Order Status: </b>{{$orders_info->status}}<br>
                                       
                                        @if ($orders_info->transaction_id != null)
                                        <b class="text-danger">transaction_id: </b>{{$orders_info->transaction_id}}
                                        @endif
                                      
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12" style="padding: 10px;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Product Title</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$product_info->name}}</td>
                                              
                                                <td class="text-center">{{ number_format($orders_info->price, 2)}}</td>
                                                <td class="text-center">৳
                                                    {{ number_format($orders_info->price, 2)}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-sm table-bordered">
                                        <tbody style="text-align: right;">
                                            <tr style="text-align: right;">
                                                <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;">
                                                    <b>Total Payable</b>
                                                </td>
                                                <td style="text-align:right; width:100px !important;">{{ number_format($orders_info->price, 2)}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-12">
                                <p style="font-size: 15px;">Order Status: <b class="text-info">{{$orders_info->status}}</b></p>
                            </div>
                            <div class="col-md-12 mt-2">
                                <button type="button" class="btn btn-info btn-sm btn-block" data-toggle="modal" data-target="#exampleModal">Change Status</button>
                            </div>
                        </div>
                    </div>
                </div>
                
           
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-12">
                            <p style="font-size: 15px;">Payment Status:<b class="text-info">{{$orders_info->payment_status}}</b></p>
                            </div>
                        <div class="col-md-12">
                          
                            @if ($orders_info->transaction_id != null)
                            <p style="font-size: 15px;">transaction_id:<b class="text-info">{{$orders_info->transaction_id}}</b></p>
                            @endif
                            </div>
                           
                        </div>
                    </div>
                </div>
                
            
            </div>
            
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Order Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('cms.admin_courses_order_change')}}" method="post">
            @csrf
            <div class="form-group">
                <input type="hidden" name="invID" value="{{$orders_info->id}}">
                <label for="">Order Status</label>
                <select class="form-control" id="" name="order_status" required>
                    <option @if($orders_info->status == 'pending') selected @endif value="pending">Pending</option>
                    <option @if($orders_info->status == 'enrolled') selected @endif value="enrolled">Enrolled</option>
                    {{-- <option @if($orders_info->status == 'processing') selected @endif value="processing">processing</option>
                    <option @if($orders_info->status == 'dispatched') selected @endif value="dispatched">dispatched</option>
                    <option @if($orders_info->status == 'delivered') selected @endif value="delivered">delivered</option>
                    <option @if($orders_info->status == 'canceled') selected @endif value="canceled">canceled</option> --}}
                </select>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
