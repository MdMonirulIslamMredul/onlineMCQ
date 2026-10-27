@extends('cms.cms_master')
@section('admin_content')
@php
    $shop_s = DB::table('company_settings')->first();
    $product_info = DB::table('courses')->where('id', $orders_info->course_id ?? $orders_info->pid)->first();
    $gateway = $gateway ?? ($orders_info->payment_gateway_id ? \App\Models\PaymentGateway::find($orders_info->payment_gateway_id) : null);
@endphp
<section class="section">
    <div class="section-header">
        <h1>Course Enrollment & Payment Verification</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('/cms') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('cms.orders.course') }}">Course Enrollments</a></div>
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
            <!-- Left Column: Order Invoice & Manual Payment Proof -->
            <div class="col-lg-8 col-12">
                <!-- Payment Verification Box -->
                <div class="card border-top border-primary shadow-sm mb-4" style="border-top-width: 4px !important;">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h4 class="text-primary mb-0"><i class="fas fa-shield-alt mr-2"></i> Manual Payment Verification Proof</h4>
                        <div>
                            @if($orders_info->status == 'enrolled')
                                <span class="badge badge-success px-3 py-2"><i class="fas fa-check-circle mr-1"></i> Enrolled & Verified</span>
                            @elseif($orders_info->status == 'pending')
                                <span class="badge badge-warning px-3 py-2 text-dark"><i class="fas fa-clock mr-1"></i> Verification Pending</span>
                            @elseif($orders_info->status == 'rejected')
                                <span class="badge badge-danger px-3 py-2"><i class="fas fa-times-circle mr-1"></i> Payment Rejected</span>
                            @else
                                <span class="badge badge-secondary px-3 py-2">{{ ucfirst($orders_info->status) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <table class="table table-sm table-striped">
                                    <tr>
                                        <th style="width: 40%;">Payment Gateway:</th>
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
                                    @if(($orders_info->payment_type ?? optional($gateway)->type) === 'mfs' || $orders_info->sender_number)
                                    <tr>
                                        <th>Sender Mobile:</th>
                                        <td>
                                            <b class="text-dark font-weight-bold" style="font-size: 15px;">{{ $orders_info->sender_number ?? 'Not provided' }}</b>
                                        </td>
                                    </tr>
                                    @endif
                                    @if(($orders_info->payment_type ?? optional($gateway)->type) === 'bank' || $orders_info->bank_name)
                                    <tr>
                                        <th>Sender Bank:</th>
                                        <td><strong>{{ $orders_info->bank_name ?? 'N/A' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Bank Account No:</th>
                                        <td><code>{{ $orders_info->bank_account_number ?? 'N/A' }}</code></td>
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
                                        <th>Course Tuition Fee:</th>
                                        <td><b class="text-success font-size-16">৳ {{ number_format($orders_info->price, 2) }} BDT</b></td>
                                    </tr>
                                    <tr>
                                        <th>Submission Date:</th>
                                        <td>{{ date("d M, Y h:i A", strtotime($orders_info->date ?? now())) }}</td>
                                    </tr>
                                    @if(!empty($orders_info->admin_note))
                                    <tr>
                                        <th>Admin Note:</th>
                                        <td class="text-danger"><em>{{ $orders_info->admin_note }}</em></td>
                                    </tr>
                                    @endif
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
                                        <p class="mb-0 text-muted small">No screenshot image found for this payment.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice & Student Info Card -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div style="padding: 10px;">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    @if(!empty($shop_s->logo) && file_exists(public_path($shop_s->logo)))
                                        <img id="invoicePageLogo" src="{{ asset($shop_s->logo) }}" alt="" style="max-height: 55px;">
                                    @else
                                        <h3><b>{{ $shop_s->company_name ?? 'Pathjolpona' }}</b></h3>
                                    @endif
                                </div>
                                <div class="col-6 text-right">
                                    <h4 class="mb-1"><b>{{ $shop_s->company_name ?? 'Pathjolpona' }}</b></h4>
                                    <p class="text-muted small mb-0">{{ $shop_s->address ?? '' }}<br>{{ $shop_s->phone_1 ?? '' }} | {{ $shop_s->email ?? '' }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row my-3">
                                <div class="col-sm-6">
                                    <h6 class="text-primary mb-2">Student Information:</h6>
                                    <p class="mb-1"><strong>Name:</strong> {{ $orders_info->name }}</p>
                                    <p class="mb-1"><strong>Phone:</strong> {{ $orders_info->phone }}</p>
                                    <p class="mb-1"><strong>Email:</strong> {{ $orders_info->email }}</p>
                                    <p class="mb-0"><strong>Address:</strong> {{ $orders_info->address ?: 'N/A' }}</p>
                                </div>
                                <div class="col-sm-6 text-sm-right mt-3 mt-sm-0">
                                    <h6 class="text-primary mb-2">Order Information:</h6>
                                    <p class="mb-1"><strong>Order ID:</strong> #{{ $orders_info->orderNum }}</p>
                                    <p class="mb-1"><strong>Order Date:</strong> {{ date("d M, Y", strtotime($orders_info->date)) }}</p>
                                    <p class="mb-1"><strong>Enrollment Status:</strong> <span class="badge badge-info">{{ $orders_info->status }}</span></p>
                                    <p class="mb-0"><strong>Payment Status:</strong> <span class="badge {{ $orders_info->payment_status == 'paid' ? 'badge-success' : 'badge-warning' }}">{{ $orders_info->payment_status ?? 'pending' }}</span></p>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Enrolled Course</th>
                                            <th class="text-center" style="width: 120px;">Qty</th>
                                            <th class="text-right" style="width: 180px;">Tuition Fee</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong>{{ optional($product_info)->name ?? 'Course ID #' . ($orders_info->course_id ?? $orders_info->pid) }}</strong>
                                            </td>
                                            <td class="text-center">1</td>
                                            <td class="text-right">৳ {{ number_format($orders_info->price, 2) }}</td>
                                        </tr>
                                        <tr class="bg-light font-weight-bold">
                                            <td colspan="2" class="text-right">Total Payable Amount:</td>
                                            <td class="text-right text-success" style="font-size: 16px;">৳ {{ number_format($orders_info->price, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Verification Actions -->
            <div class="col-lg-4 col-12">
                <!-- Quick Approval Box -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 text-white"><i class="fas fa-check-double mr-2"></i> Verification Actions</h5>
                    </div>
                    <div class="card-body">
                        @if($orders_info->status != 'enrolled')
                        <!-- One-click Verify & Enroll Form -->
                        <form action="{{ route('cms.admin_courses_order_change') }}" method="post" class="mb-3">
                            @csrf
                            <input type="hidden" name="invID" value="{{ $orders_info->id }}">
                            <input type="hidden" name="order_status" value="enrolled">
                            <button type="submit" class="btn btn-success btn-lg btn-block shadow-sm">
                                <i class="fas fa-check-circle mr-2"></i> Verify & Enroll Student
                            </button>
                        </form>
                        @else
                        <div class="alert alert-success text-center mb-3">
                            <i class="fas fa-check-circle fa-2x mb-2 d-block"></i>
                            <strong>Student is currently Enrolled!</strong>
                            <p class="small mb-0 mt-1">Course lessons are fully accessible for this student.</p>
                        </div>
                        @endif

                        @if($orders_info->status != 'rejected')
                        <!-- Reject Button triggers modal -->
                        <button type="button" class="btn btn-outline-danger btn-block mb-3" data-toggle="modal" data-target="#rejectModal">
                            <i class="fas fa-times-circle mr-1"></i> Reject Payment Proof
                        </button>
                        @endif

                        <!-- General Change Status Button -->
                        <button type="button" class="btn btn-outline-info btn-block" data-toggle="modal" data-target="#exampleModal">
                            <i class="fas fa-edit mr-1"></i> Custom Status Change
                        </button>
                    </div>
                </div>

                <!-- Order Summary Status Card -->
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6>Status Overview</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Enrollment:</strong> 
                            @if($orders_info->status == 'enrolled')
                                <span class="badge badge-success">Enrolled</span>
                            @elseif($orders_info->status == 'pending')
                                <span class="badge badge-warning text-dark">Pending</span>
                            @elseif($orders_info->status == 'rejected')
                                <span class="badge badge-danger">Rejected</span>
                            @else
                                <span class="badge badge-secondary">{{ $orders_info->status }}</span>
                            @endif
                        </p>
                        <p class="mb-2"><strong>Payment:</strong> 
                            <span class="badge {{ $orders_info->payment_status == 'paid' ? 'badge-success' : 'badge-secondary' }}">
                                {{ $orders_info->payment_status ?? 'pending' }}
                            </span>
                        </p>
                        <p class="mb-0"><strong>TrxID:</strong> <code>{{ $orders_info->trx_id ?? $orders_info->transaction_id ?? 'N/A' }}</code></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Screenshot Lightbox Modal -->
@if(!empty($orders_info->screenshot))
<div class="modal fade" id="screenshotModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-file-invoice-dollar mr-2"></i> Payment Proof - Order #{{ $orders_info->orderNum }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center p-2 bg-dark">
                <img src="{{ asset($orders_info->screenshot) }}" alt="Screenshot Proof" class="img-fluid" style="max-height: 80vh; object-fit: contain;">
            </div>
            <div class="modal-footer justify-content-between">
                <div class="text-muted small">
                    TrxID: <strong>{{ $orders_info->trx_id ?? $orders_info->transaction_id }}</strong> | Sender: <strong>{{ $orders_info->sender_number ?? $orders_info->bank_name ?? 'N/A' }}</strong>
                </div>
                <div>
                    <a href="{{ asset($orders_info->screenshot) }}" download class="btn btn-outline-primary btn-sm mr-2">
                        <i class="fas fa-download mr-1"></i> Download
                    </a>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white"><i class="fas fa-times-circle mr-2"></i> Reject Payment</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('cms.admin_courses_order_change') }}" method="post">
                @csrf
                <input type="hidden" name="invID" value="{{ $orders_info->id }}">
                <input type="hidden" name="order_status" value="rejected">
                <div class="modal-body">
                    <p class="text-danger">Are you sure you want to reject this payment? The student will not be granted access to the course.</p>
                    <div class="form-group">
                        <label for="adminNote">Reason for Rejection / Admin Note (Optional)</label>
                        <textarea class="form-control" name="admin_note" id="adminNote" rows="3" placeholder="e.g. Invalid TrxID or deposit amount mismatch. Please contact support."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Rejection</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom Status Change Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Enrollment & Payment Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('cms.admin_courses_order_change') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="invID" value="{{ $orders_info->id }}">
                    <div class="form-group">
                        <label for="orderStatusSelect">Order Status</label>
                        <select class="form-control" id="orderStatusSelect" name="order_status" required>
                            <option @if($orders_info->status == 'pending') selected @endif value="pending">Pending</option>
                            <option @if($orders_info->status == 'enrolled') selected @endif value="enrolled">Enrolled (Grant Course Access)</option>
                            <option @if($orders_info->status == 'rejected') selected @endif value="rejected">Rejected (Deny Access)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="adminNoteChange">Admin Note</label>
                        <textarea class="form-control" name="admin_note" id="adminNoteChange" rows="2">{{ $orders_info->admin_note }}</textarea>
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
