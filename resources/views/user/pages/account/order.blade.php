@extends('user.pages.test_master')
@section('content')

@php
$userID = Cookie::get('user_id');
$userName = Cookie::get('user_name');
$userQ = DB::table('users')->where('id', $userID)->first();

$courseOrders = DB::table('courses_order')
    ->leftJoin('courses', function($join) {
        $join->on('courses_order.course_id', '=', 'courses.id')
             ->orOn('courses_order.pid', '=', 'courses.id');
    })
    ->leftJoin('payment_gateways', 'courses_order.payment_gateway_id', '=', 'payment_gateways.id')
    ->select(
        'courses_order.*',
        'courses.name as course_name',
        'courses.image as course_image',
        'payment_gateways.logo as gateway_logo',
        'payment_gateways.type as gw_type'
    )
    ->where(function($q) use ($userQ, $userID) {
        if ($userID) {
            $q->where('courses_order.user_id', $userID);
        }
        if ($userQ) {
            $q->orWhere('courses_order.phone', $userQ->phone)
              ->orWhere('courses_order.email', $userQ->email);
        }
    })
    ->orderBy('courses_order.id', 'desc')
    ->get();

$bookOrders = DB::table('books_order')
    ->where(function($q) use ($userQ) {
        if ($userQ) {
            $q->where('phone', $userQ->phone)->orWhere('email', $userQ->email);
        }
    })
    ->orderBy('id', 'desc')
    ->get();

$enrolledCount = $courseOrders->whereIn('status', ['enrolled', 'delivered'])->count();
@endphp

<style>
.order-tab-nav {
    display: flex;
    gap: 10px;
    border-bottom: 2px solid #e2e8f0;
    margin-bottom: 24px;
}

.order-tab-btn {
    padding: 10px 20px;
    font-size: 15px;
    font-weight: 700;
    color: #64748b;
    background: transparent;
    border: none;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.order-tab-btn:hover {
    color: #03c6bb;
}

.order-tab-btn.active {
    color: #03c6bb;
    border-bottom-color: #03c6bb;
}

.order-tab-badge {
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 700;
    background: #f1f5f9;
    color: #475569;
}

.order-tab-btn.active .order-tab-badge {
    background: rgba(3, 198, 187, 0.15);
    color: #009e95;
}

.course-thumb-tiny {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid #e2e8f0;
    flex-shrink: 0;
}

.gateway-pill-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 3px 10px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    color: #334155;
}

.gateway-pill-tag img {
    height: 16px;
    max-width: 40px;
    object-fit: contain;
}

/* Status Badges */
.status-badge-custom {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
}

.status-enrolled {
    background: rgba(16, 185, 129, 0.12);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.25);
}

.status-pending {
    background: rgba(245, 158, 11, 0.12);
    color: #d97706;
    border: 1px solid rgba(245, 158, 11, 0.25);
}

.status-rejected {
    background: rgba(239, 68, 68, 0.12);
    color: #dc2626;
    border: 1px solid rgba(239, 68, 68, 0.25);
}
</style>

<!-- ============================ Dashboard: My Order Start ================================== -->
<div class="rbt-page-banner-wrapper">
    <div class="rbt-banner-image"></div>
</div>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Dashboard Top Profile Header -->
                <div class="rbt-dashboard-content-wrapper">
                    <div class="tutor-bg-photo bg-gradient-7 height-350"></div>
                    <div class="rbt-tutor-information">
                        <div class="rbt-tutor-information-left">
                            <div class="thumbnail rbt-avatars size-lg">
                                <img src="{{ asset('/') }}frontend/assets/images/user-student.png" alt="Student">
                            </div>
                            <div class="tutor-content">
                                <h5 class="title">{{ $userName }}</h5>
                                <ul class="rbt-meta rbt-meta-white mt--5">
                                    <li><i class="feather-book"></i>{{ $enrolledCount }} Courses Enrolled</li>
                                    <li><i class="feather-clock"></i>{{ $courseOrders->where('status', 'pending')->count() }} Pending Verification</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-5">
                    <!-- Left Sidebar -->
                    <div class="col-lg-3">
                        @include('user.pages.account.sidebar')
                    </div>

                    <!-- Right Content: Payment & Order History -->
                    <div class="col-lg-9">
                        @if(session('userSuccess'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px;">
                            <i class="feather-check-circle me-2"></i> {{ session('userSuccess') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                            <div class="content">
                                <div class="section-title d-flex justify-content-between align-items-center mb--20">
                                    <h4 class="rbt-title-style-3 mb-0">Payment & Order History</h4>
                                    <a href="{{ route('course') }}" class="rbt-btn btn-xs btn-gradient radius-round">
                                        <i class="feather-plus me-1"></i> Browse Courses
                                    </a>
                                </div>

                                <!-- Tabs: Course Enrollments vs Book Orders -->
                                <div class="order-tab-nav">
                                    <button type="button" class="order-tab-btn active" onclick="switchOrderTab('coursesTab', this)">
                                        <i class="feather-book-open"></i>
                                        <span>Course Payments</span>
                                        <span class="order-tab-badge">{{ $courseOrders->count() }}</span>
                                    </button>
                                    <button type="button" class="order-tab-btn" onclick="switchOrderTab('booksTab', this)">
                                        <i class="feather-shopping-bag"></i>
                                        <span>Book Orders</span>
                                        <span class="order-tab-badge">{{ $bookOrders->count() }}</span>
                                    </button>
                                </div>

                                <!-- Course Payments Tab Pane -->
                                <div id="coursesTab" class="order-tab-pane">
                                    @if($courseOrders->count() > 0)
                                    <div class="rbt-dashboard-table table-responsive mobile-table-750">
                                        <table class="rbt-table table table-borderless align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Order #</th>
                                                    <th>Course Name</th>
                                                    <th>Payment Method</th>
                                                    <th>TrxID</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($courseOrders as $order)
                                                <tr>
                                                    <th><strong>#{{ $order->orderNum }}</strong></th>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            @if(!empty($order->course_image))
                                                                <img src="{{ asset($order->course_image) }}" alt="" class="course-thumb-tiny">
                                                            @endif
                                                            <div>
                                                                <div class="fw-bold" style="font-size: 14px; max-width: 180px; line-height: 1.3;">
                                                                    {{ $order->course_name ?? 'Course #' . ($order->course_id ?? $order->pid) }}
                                                                </div>
                                                                @if($order->status == 'enrolled')
                                                                    <small class="text-success fw-semibold"><i class="feather-unlock me-1"></i>Access Active</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="gateway-pill-tag">
                                                            @if(!empty($order->gateway_logo) && file_exists(public_path($order->gateway_logo)))
                                                                <img src="{{ asset($order->gateway_logo) }}" alt="">
                                                            @endif
                                                            <span>{{ $order->payment_method ?? 'Manual Gateway' }}</span>
                                                        </div>
                                                        @if(!empty($order->sender_number))
                                                            <div class="small text-muted mt-1">{{ $order->sender_number }}</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <code style="font-size: 12.5px; background: #f1f5f9; padding: 2px 6px; border-radius: 4px;">
                                                            {{ $order->trx_id ?? $order->transaction_id ?? 'N/A' }}
                                                        </code>
                                                    </td>
                                                    <td>
                                                        <strong style="color: #0f172a;">৳ {{ number_format($order->price, 0) }}</strong>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">{{ date("d M, Y", strtotime($order->date)) }}</small>
                                                    </td>
                                                    <td>
                                                        @if($order->status == 'enrolled' || $order->status == 'delivered')
                                                            <span class="status-badge-custom status-enrolled">
                                                                <i class="feather-check-circle"></i> Enrolled
                                                            </span>
                                                        @elseif($order->status == 'pending')
                                                            <span class="status-badge-custom status-pending">
                                                                <i class="feather-clock"></i> Verification Pending
                                                            </span>
                                                        @elseif($order->status == 'rejected' || $order->status == 'canceled')
                                                            <span class="status-badge-custom status-rejected">
                                                                <i class="feather-x-circle"></i> Rejected
                                                            </span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-1">
                                                            <button type="button" class="rbt-btn btn-xs bg-primary-opacity radius-round" 
                                                                    onclick="openReceiptModal({{ json_encode($order) }})">
                                                                <i class="feather-file-text me-1"></i> Receipt
                                                            </button>
                                                            @if($order->status == 'enrolled')
                                                            <a href="{{ url('/course/' . ($order->course_id ?? $order->pid)) }}" class="rbt-btn btn-xs btn-gradient radius-round">
                                                                <i class="feather-play"></i>
                                                            </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="text-center py-5">
                                        <i class="feather-credit-card text-muted" style="font-size: 42px;"></i>
                                        <h5 class="mt-3 mb-1">No Course Payments Yet</h5>
                                        <p class="text-muted small">When you purchase a course using manual bank or MFS gateway, your payment history will appear here.</p>
                                        <a href="{{ route('course') }}" class="rbt-btn btn-sm btn-gradient radius-round mt-2">Explore Courses</a>
                                    </div>
                                    @endif
                                </div>

                                <!-- Book Orders Tab Pane -->
                                <div id="booksTab" class="order-tab-pane" style="display: none;">
                                    @if($bookOrders->count() > 0)
                                    <div class="rbt-dashboard-table table-responsive mobile-table-750">
                                        <table class="rbt-table table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Product Info</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bookOrders as $bo)
                                                <tr>
                                                    <th>#{{ $bo->orderNum }}</th>
                                                    <td>Book Purchase</td>
                                                    <td>{{ date("F d, Y", strtotime($bo->date)) }}</td>
                                                    <td><span class="rbt-badge-5 bg-color-success-opacity color-success">{{ $bo->status }}</span></td>
                                                    <td>
                                                        <a target="_blank" href="{{ url('/ordres-info/'.$bo->orderNum) }}" class="rbt-btn btn-xs bg-primary-opacity radius-round">View details</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="text-center py-5">
                                        <i class="feather-shopping-bag text-muted" style="font-size: 42px;"></i>
                                        <h5 class="mt-3 mb-1">No Book Orders Found</h5>
                                        <p class="text-muted small">You haven't ordered any books yet.</p>
                                        <a href="{{ route('shop') }}" class="rbt-btn btn-sm btn-gradient radius-round mt-2">Visit Shop</a>
                                    </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Student Payment Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: linear-gradient(135deg, #03c6bb 0%, #009e95 100%); color: #ffffff;">
                <h5 class="modal-title text-white" id="receiptModalLabel">
                    <i class="feather-file-text me-2"></i> Payment Receipt & Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center pb-3 border-bottom mb-3">
                    <div class="text-muted small text-uppercase fw-bold">Order Number</div>
                    <div class="fs-4 fw-bold text-dark" id="modalOrderNum">#EOD0000</div>
                    <div class="mt-1" id="modalStatusBadge"></div>
                </div>

                <div class="d-flex flex-column gap-2 mb-3" style="font-size: 14px;">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Course:</span>
                        <strong class="text-dark text-end" id="modalCourseName">--</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Amount Paid:</span>
                        <strong class="text-success" id="modalAmount">৳ 0</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Payment Method:</span>
                        <strong class="text-dark" id="modalGateway">--</strong>
                    </div>
                    <div class="d-flex justify-content-between" id="modalSenderRow">
                        <span class="text-muted">Sender Number:</span>
                        <strong class="text-dark" id="modalSender">--</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Transaction ID:</span>
                        <code id="modalTrxId" style="font-size: 13px;">--</code>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Submission Date:</span>
                        <span class="text-dark" id="modalDate">--</span>
                    </div>
                    <div id="modalAdminNoteBox" class="p-2 rounded mt-2" style="background: #fef2f2; border: 1px solid #fecaca; display: none;">
                        <small class="text-danger fw-bold d-block"><i class="feather-info me-1"></i> Admin Note:</small>
                        <span class="text-danger small" id="modalAdminNote"></span>
                    </div>
                </div>

                <!-- Proof Screenshot Section -->
                <div id="modalScreenshotBox" class="border-top pt-3 text-center" style="display: none;">
                    <label class="small text-muted fw-bold d-block mb-2">Uploaded Payment Proof Screenshot</label>
                    <a id="modalScreenshotLink" href="" target="_blank">
                        <img id="modalScreenshotImg" src="" alt="Proof Screenshot" style="max-height: 180px; max-width: 100%; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </a>
                    <div class="small text-muted mt-1">Click image to view full size</div>
                </div>
            </div>
            <div class="modal-footer justify-content-between bg-light">
                <button type="button" class="rbt-btn btn-xs btn-border radius-round" data-bs-dismiss="modal">Close</button>
                <div id="modalActionBtn"></div>
            </div>
        </div>
    </div>
</div>

<script>
function switchOrderTab(tabId, btn) {
    document.querySelectorAll('.order-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.order-tab-pane').forEach(p => p.style.display = 'none');
    
    btn.classList.add('active');
    const target = document.getElementById(tabId);
    if (target) target.style.display = 'block';
}

function openReceiptModal(order) {
    document.getElementById('modalOrderNum').innerText = '#' + order.orderNum;
    document.getElementById('modalCourseName').innerText = order.course_name || ('Course #' + (order.course_id || order.pid));
    document.getElementById('modalAmount').innerText = '৳ ' + Number(order.price).toLocaleString();
    document.getElementById('modalGateway').innerText = order.payment_method || 'Manual Gateway';
    document.getElementById('modalTrxId').innerText = order.trx_id || order.transaction_id || 'N/A';
    document.getElementById('modalDate').innerText = order.date ? new Date(order.date).toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' }) : '--';

    // Sender details
    const senderRow = document.getElementById('modalSenderRow');
    if (order.sender_number) {
        senderRow.style.display = 'flex';
        document.getElementById('modalSender').innerText = order.sender_number;
    } else if (order.bank_name) {
        senderRow.style.display = 'flex';
        document.getElementById('modalSender').innerText = order.bank_name + ' (' + (order.bank_account_number || '') + ')';
    } else {
        senderRow.style.display = 'none';
    }

    // Status Badge
    const statusBox = document.getElementById('modalStatusBadge');
    const actionBtnBox = document.getElementById('modalActionBtn');
    actionBtnBox.innerHTML = '';

    if (order.status === 'enrolled' || order.status === 'delivered') {
        statusBox.innerHTML = '<span class="status-badge-custom status-enrolled"><i class="feather-check-circle"></i> Enrolled & Verified</span>';
        actionBtnBox.innerHTML = '<a href="/course/' + (order.course_id || order.pid) + '" class="rbt-btn btn-xs btn-gradient radius-round"><i class="feather-play me-1"></i> Go to Lessons</a>';
    } else if (order.status === 'pending') {
        statusBox.innerHTML = '<span class="status-badge-custom status-pending"><i class="feather-clock"></i> Verification in Progress</span>';
    } else if (order.status === 'rejected' || order.status === 'canceled') {
        statusBox.innerHTML = '<span class="status-badge-custom status-rejected"><i class="feather-x-circle"></i> Payment Rejected</span>';
    } else {
        statusBox.innerHTML = '<span class="badge bg-secondary">' + order.status + '</span>';
    }

    // Admin note
    const noteBox = document.getElementById('modalAdminNoteBox');
    if (order.admin_note) {
        noteBox.style.display = 'block';
        document.getElementById('modalAdminNote').innerText = order.admin_note;
    } else {
        noteBox.style.display = 'none';
    }

    // Screenshot
    const screenshotBox = document.getElementById('modalScreenshotBox');
    if (order.screenshot) {
        screenshotBox.style.display = 'block';
        const imgUrl = '/' + order.screenshot;
        document.getElementById('modalScreenshotImg').src = imgUrl;
        document.getElementById('modalScreenshotLink').href = imgUrl;
    } else {
        screenshotBox.style.display = 'none';
    }

    // Show modal via Bootstrap, jQuery, or Vanilla CSS
    const modalEl = document.getElementById('receiptModal');
    if (window.bootstrap && bootstrap.Modal) {
        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.show();
    } else if (window.$ && typeof $('#receiptModal').modal === 'function') {
        $('#receiptModal').modal('show');
    } else {
        modalEl.classList.add('show');
        modalEl.style.display = 'block';
        document.body.classList.add('modal-open');
    }

    // Attach close button listeners
    modalEl.querySelectorAll('[data-bs-dismiss="modal"], [data-dismiss="modal"]').forEach(btn => {
        btn.onclick = function() {
            if (window.bootstrap && bootstrap.Modal) {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            } else if (window.$ && typeof $('#receiptModal').modal === 'function') {
                $('#receiptModal').modal('hide');
            }
            modalEl.classList.remove('show');
            modalEl.style.display = 'none';
            document.body.classList.remove('modal-open');
        };
    });
}
</script>

@endsection
