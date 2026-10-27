@extends('cms.cms_master')
@section('admin_content')
<section class="section">
    <div class="section-header">
        <h1>Add Payment Gateway</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('/cms') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('cms.payment_gateways.index') }}">Payment Gateways</a></div>
            <div class="breadcrumb-item">Add Gateway</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>New Payment Information</h4>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('cms.payment_gateways.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Gateway Type <span class="text-danger">*</span></label>
                                    <select name="type" id="gatewayTypeSelect" class="form-control" required>
                                        <option value="mfs" {{ old('type') == 'mfs' ? 'selected' : '' }}>MFS (Mobile Financial Services - bKash, Nagad, Rocket, Upay)</option>
                                        <option value="bank" {{ old('type') == 'bank' ? 'selected' : '' }}>Bank Account (Bank Transfer / Deposit)</option>
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Gateway Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="e.g. bKash Personal, Dutch-Bangla Bank" value="{{ old('name') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Account Number <span class="text-danger">*</span></label>
                                    <input type="text" name="account_number" class="form-control" placeholder="e.g. 01712345678 or 154.120.34567" value="{{ old('account_number') }}" required>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Account Type</label>
                                    <input type="text" name="account_type" class="form-control" placeholder="e.g. Personal, Merchant, Agent, Current, Savings" value="{{ old('account_type') }}">
                                </div>
                            </div>

                            <!-- Bank specific fields -->
                            <div id="bankFieldsSection" style="display: {{ old('type') == 'bank' ? 'block' : 'none' }}; background: #f8fafc; padding: 18px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
                                <h6 class="text-primary mb-3"><i class="fas fa-university"></i> Bank Account Specifics</h6>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Bank Name</label>
                                        <input type="text" name="bank_name" class="form-control" placeholder="e.g. Dutch-Bangla Bank Ltd, City Bank" value="{{ old('bank_name') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Branch Name</label>
                                        <input type="text" name="branch_name" class="form-control" placeholder="e.g. Dhanmondi Branch, Dhaka" value="{{ old('branch_name') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group mb-0">
                                        <label>Routing Number</label>
                                        <input type="text" name="routing_number" class="form-control" placeholder="e.g. 090261145" value="{{ old('routing_number') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Logo upload -->
                            <div class="form-group">
                                <label>Gateway Logo / Icon</label>
                                <input type="file" name="logo" class="form-control" accept="image/*,.svg" onchange="previewLogo(event)">
                                <small class="text-muted">Accepts PNG, JPG, WebP, SVG. Recommended square or horizontal logo.</small>
                                <div id="logoPreviewWrap" class="mt-2" style="display: none;">
                                    <img id="logoPreview" src="#" alt="Logo Preview" style="height: 48px; border-radius: 8px; border: 1px solid #ddd; padding: 4px; background: #fff;">
                                </div>
                            </div>

                            <!-- Payment Instruction -->
                            <div class="form-group">
                                <label>Payment Instructions for Students</label>
                                <textarea name="instruction" rows="3" class="form-control" style="height: 100px;" placeholder="Instructions displayed to student when this gateway is selected (e.g. Send Money to this personal number, then submit your transaction ID and receipt screenshot below).">{{ old('instruction') }}</textarea>
                            </div>

                            <!-- Status switch -->
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="status" class="custom-control-input" id="statusCheckbox" value="1" {{ old('status', '1') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="statusCheckbox">Active (Display this payment gateway on course checkout page)</label>
                                </div>
                            </div>

                            <div class="text-right">
                                <a href="{{ route('cms.payment_gateways.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-check mr-1"></i> Save Payment Gateway
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('gatewayTypeSelect');
    const bankFields = document.getElementById('bankFieldsSection');

    typeSelect.addEventListener('change', function () {
        if (this.value === 'bank') {
            bankFields.style.display = 'block';
        } else {
            bankFields.style.display = 'none';
        }
    });
});

function previewLogo(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('logoPreview').src = e.target.result;
            document.getElementById('logoPreviewWrap').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
