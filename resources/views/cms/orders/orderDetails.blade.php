@extends('cms.cms_master')
@section('admin_content')
@php
    $shop_s = DB::table('company_settings')->first();
    $product_info = DB::table('books')->where('id', $orders_info->pid)->first();
    $gateway = $gateway ?? ($orders_info->payment_gateway_id ? \App\Models\PaymentGateway::find($orders_info->payment_gateway_id) : null);
@endphp
<section class="section">
    <div class="section-header">
        <h1>Book Order & Payment Details</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('/cms') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('cms.orders.books') }}">Book Orders</a></div>
            <div class="breadcrumb-item">Order #{{ $orders_info->orderNum }}</div>
        </div>
    </div>

    @if(session('status'))
    <div class="alert alert-success alert-dismissible show fade">
        <div class="alert-body">
            <button class="close" data-dismiss="alert"><span>&times;</span></button>
            <i class="fas fa-check-circle mr-2"></i> {{ session('status') }}
        </div>
    </div>
    @endif

    <div class="section-body">
        <div class="row">
            <div class="col-md-9">

                @if(!empty($orders_info->payment_gateway_id) || !empty($orders_info->screenshot) || !empty($orders_info->trx_id) || (!empty($orders_info->payment_method) && $orders_info->payment_method !== 'Cash on Delivery'))
                <!-- Payment Verification Box (Manual Gateways: bKash / Nagad / Bank) -->
                <div class="card border-top border-primary shadow-sm mb-4" style="border-top-width: 4px !important;">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h4 class="text-primary mb-0"><i class="fas fa-shield-alt mr-2"></i> Manual Payment Verification Proof</h4>
                        <div>
                            @if($orders_info->payment_status == 'paid')
                                <span class="badge badge-success px-3 py-2"><i class="fas fa-check-circle mr-1"></i> Payment Verified & Paid</span>
                            @elseif($orders_info->payment_status == 'pending')
                                <span class="badge badge-warning px-3 py-2 text-dark"><i class="fas fa-clock mr-1"></i> Verification Pending</span>
                            @elseif($orders_info->payment_status == 'unpaid')
                                <span class="badge badge-danger px-3 py-2"><i class="fas fa-times-circle mr-1"></i> Unpaid</span>
                            @else
                                <span class="badge badge-secondary px-3 py-2">{{ ucfirst($orders_info->payment_status) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <table class="table table-sm table-striped">
                                    <tr>
                                        <th style="width: 40%;">Payment Method:</th>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($gateway && $gateway->logo && file_exists(public_path($gateway->logo)))
                                                    <img src="{{ asset($gateway->logo) }}" alt="" style="max-height: 28px; max-width: 70px; margin-right: 8px;">
                                                @endif
                                                <strong>{{ $orders_info->payment_method ?? ($gateway ? $gateway->name : 'Manual Gateway') }}</strong>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Gateway Type:</th>
                                        <td>
                                            <span class="badge {{ ($orders_info->payment_type ?? optional($gateway)->type) === 'bank' ? 'badge-info' : 'badge-primary' }}">
                                                {{ strtoupper($orders_info->payment_type ?? optional($gateway)->type ?? 'MFS') }}
                                            </span>
                                        </td>
                                    </tr>
                                    @if($orders_info->sender_number)
                                    <tr>
                                        <th>Sender Mobile:</th>
                                        <td>
                                            <b class="text-dark font-weight-bold" style="font-size: 15px;">{{ $orders_info->sender_number }}</b>
                                        </td>
                                    </tr>
                                    @endif
                                    @if($orders_info->bank_name)
                                    <tr>
                                        <th>Sender Bank:</th>
                                        <td><strong>{{ $orders_info->bank_name }}</strong></td>
                                    </tr>
                                    @endif
                                    @if($orders_info->bank_account_number)
                                    <tr>
                                        <th>Bank Account No:</th>
                                        <td><code>{{ $orders_info->bank_account_number }}</code></td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>Transaction ID (TrxID):</th>
                                        <td>
                                            <span class="badge badge-dark px-2 py-1" style="font-size: 14px; font-family: monospace; letter-spacing: 0.05em;">
                                                {{ $orders_info->trx_id ?? $orders_info->transaction_id ?? 'N/A' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payable Amount:</th>
                                        <td><b class="text-success font-size-16">৳ {{ number_format($orders_info->amount ?: ($orders_info->price * $orders_info->quantity), 2) }} BDT</b></td>
                                    </tr>
                                    <tr>
                                        <th>Submission Date:</th>
                                        <td>{{ date("d M, Y h:i A", strtotime($orders_info->date ?? now())) }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Screenshot Proof Box -->
                            <div class="col-md-5 text-center">
                                <label class="font-weight-bold text-dark d-block mb-2">Payment Proof Screenshot</label>
                                @if(!empty($orders_info->screenshot) && file_exists(public_path($orders_info->screenshot)))
                                    <div class="border rounded p-2 bg-light shadow-sm" style="display: inline-block;">
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#screenshotModal">
                                            <img src="{{ asset($orders_info->screenshot) }}" alt="Payment Proof" style="max-height: 220px; max-width: 100%; object-fit: contain; border-radius: 6px; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                                        </a>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#screenshotModal">
                                                <i class="fas fa-search-plus mr-1"></i> Zoom Screenshot
                                            </button>
                                            <a href="{{ asset($orders_info->screenshot) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-secondary py-4">
                                        <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                        <p class="mb-0 text-muted small">No screenshot image uploaded.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Invoice & Book Info Card -->
                <div class="card shadow-sm">
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
                                        <b class="text-info">Address: </b>{{$orders_info->address ?: 'N/A'}}<br>
                                        <b class="text-info">Phone: </b>{{$orders_info->phone}}<br>
                                        <b class="text-info">Email: </b>{{$orders_info->email}}
                                    </p>
                                </div>
                                <div class="col-md-6 col-6" style="text-align: right;">
                                    <p class="font_size_small">
                                        <b class="text-info">Order Date: </b>{{date("d M, Y", strtotime($orders_info->date))}}<br>
                                        <b class="text-info">Order Number: </b>{{$orders_info->orderNum}}<br>
                                        <b class="text-danger">Order Status: </b>{{$orders_info->status}}<br>
                                        <b class="text-primary">Payment: </b>{{$orders_info->payment_method ?? ($orders_info->payment_type === 'cod' ? 'Cash on Delivery' : 'Online / Manual')}}<br>
                                        @if ($orders_info->transaction_id != null)
                                        <b class="text-secondary">Trx ID: </b><code>{{$orders_info->transaction_id}}</code>
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
                                                <th class="text-center">Format</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <strong>{{$product_info->name ?? 'Book #' . $orders_info->pid}}</strong>
                                                    @if(($orders_info->book_type ?? 'hardcopy') == 'softcopy' && !empty($product_info->pdf_file))
                                                        <div class="mt-1">
                                                            <a href="{{ route('cms.book.preview_pdf', $orders_info->pid) }}" target="_blank" class="btn btn-xs btn-outline-info" style="font-size: 11px;">
                                                                <i class="fas fa-file-pdf"></i> Preview Book PDF
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if(($orders_info->book_type ?? 'hardcopy') == 'softcopy')
                                                        <span class="badge badge-info"><i class="fas fa-file-pdf"></i> Softcopy (E-Book)</span>
                                                    @else
                                                        <span class="badge badge-success"><i class="fas fa-book"></i> Hardcopy</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{$orders_info->quantity}}</td>
                                                <td class="text-center">৳ {{ number_format($orders_info->price, 2)}}</td>
                                                <td class="text-center font-weight-bold text-success">৳
                                                    {{ number_format(($orders_info->amount ?: ($orders_info->price*$orders_info->quantity)), 2)}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-sm table-bordered">
                                        <tbody style="text-align: right;">
                                            <tr style="text-align: right;">
                                                <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;">
                                                    <b>Total Payable</b>
                                                </td>
                                                <td style="text-align:right; width:120px !important;"><b>৳ {{ number_format($orders_info->amount ?: ($orders_info->price*$orders_info->quantity), 2)}}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column Status Management -->
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0 text-dark">Order Status</h5>
                    </div>
                    <div class="card-body">
                        <p style="font-size: 15px;">Current Status: <b class="text-info text-capitalize">{{$orders_info->status}}</b></p>
                        <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#exampleModal">
                            <i class="fas fa-edit mr-1"></i> Update Status
                        </button>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0 text-dark">Payment Info</h5>
                    </div>
                    <div class="card-body">
                        <p style="font-size: 14px; margin-bottom: 8px;">Payment Status: 
                            @if($orders_info->payment_status === 'paid')
                                <span class="badge badge-success">PAID</span>
                            @elseif($orders_info->payment_status === 'pending')
                                <span class="badge badge-warning text-dark">PENDING</span>
                            @else
                                <span class="badge badge-secondary">{{ strtoupper($orders_info->payment_status ?? 'UNPAID') }}</span>
                            @endif
                        </p>
                        <p style="font-size: 14px; margin-bottom: 8px;">Method: <b>{{ $orders_info->payment_method ?? ($orders_info->payment_type === 'cod' ? 'Cash on Delivery' : 'N/A') }}</b></p>
                        @if ($orders_info->trx_id || $orders_info->transaction_id)
                        <p style="font-size: 13px; margin-bottom: 0;">TrxID: <code>{{ $orders_info->trx_id ?? $orders_info->transaction_id }}</code></p>
                        @endif
                    </div>
                </div>

                @if(($orders_info->book_type ?? 'hardcopy') === 'softcopy')
                <div class="card shadow-sm border-info">
                    <div class="card-body">
                        <h6 class="text-info"><i class="fas fa-info-circle mr-1"></i> Softcopy Access</h6>
                        <small class="text-muted">Setting status to <b>Delivered</b> automatically grants the student online reading access in their <code>/my-books</code> portal.</small>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Modal for Order Status -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Order Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('cms.admin_order_change')}}" method="post">
          @csrf
          <div class="modal-body">
                <input type="hidden" name="invID" value="{{$orders_info->id}}">
                <div class="form-group">
                    <label>Order Status</label>
                    <select class="form-control" name="order_status" required>
                        <option @if($orders_info->status == 'pending') selected @endif value="pending">Pending</option>
                        <option @if($orders_info->status == 'processing') selected @endif value="processing">Processing</option>
                        <option @if($orders_info->status == 'dispatched') selected @endif value="dispatched">Dispatched</option>
                        <option @if($orders_info->status == 'delivered') selected @endif value="delivered">Delivered / Paid</option>
                        <option @if($orders_info->status == 'canceled') selected @endif value="canceled">Canceled</option>
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

@if(!empty($orders_info->screenshot))
<!-- Screenshot Zoom Modal -->
<div class="modal fade" id="screenshotModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-file-invoice mr-2"></i> Payment Proof Screenshot - Order #{{ $orders_info->orderNum }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center p-2 bg-dark">
                <img src="{{ asset($orders_info->screenshot) }}" class="img-fluid rounded" alt="Payment Proof" style="max-height: 80vh;">
            </div>
            <div class="modal-footer justify-content-between">
                <span class="text-muted small">TrxID: <strong>{{ $orders_info->trx_id ?? $orders_info->transaction_id ?? 'N/A' }}</strong></span>
                <div>
                    <a href="{{ asset($orders_info->screenshot) }}" target="_blank" download class="btn btn-primary btn-sm">
                        <i class="fas fa-download mr-1"></i> Download
                    </a>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
