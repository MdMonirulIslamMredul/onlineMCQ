<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        $gateways = PaymentGateway::orderBy('id', 'desc')->get();
        return view('cms.payment_gateways.index', compact('gateways'));
    }

    public function create()
    {
        return view('cms.payment_gateways.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:mfs,bank',
            'account_number' => 'required|string|max:255',
            'account_type' => 'nullable|string|max:100',
            'bank_name' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'routing_number' => 'nullable|string|max:100',
            'logo' => 'nullable|file|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'instruction' => 'nullable|string',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'gateway_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/gateways'), $filename);
            $logoPath = 'uploads/gateways/' . $filename;
        }

        PaymentGateway::create([
            'name' => $request->name,
            'type' => $request->type,
            'account_number' => $request->account_number,
            'account_type' => $request->account_type,
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'routing_number' => $request->routing_number,
            'logo' => $logoPath,
            'instruction' => $request->instruction,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('cms.payment_gateways.index')->with('status', 'Payment Gateway added successfully.');
    }

    public function edit($id)
    {
        $gateway = PaymentGateway::findOrFail($id);
        return view('cms.payment_gateways.edit', compact('gateway'));
    }

    public function update(Request $request, $id)
    {
        $gateway = PaymentGateway::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:mfs,bank',
            'account_number' => 'required|string|max:255',
            'account_type' => 'nullable|string|max:100',
            'bank_name' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'routing_number' => 'nullable|string|max:100',
            'logo' => 'nullable|file|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'instruction' => 'nullable|string',
        ]);

        $logoPath = $gateway->logo;
        if ($request->hasFile('logo')) {
            if ($gateway->logo && File::exists(public_path($gateway->logo))) {
                File::delete(public_path($gateway->logo));
            }
            $file = $request->file('logo');
            $filename = 'gateway_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/gateways'), $filename);
            $logoPath = 'uploads/gateways/' . $filename;
        }

        $gateway->update([
            'name' => $request->name,
            'type' => $request->type,
            'account_number' => $request->account_number,
            'account_type' => $request->account_type,
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'routing_number' => $request->routing_number,
            'logo' => $logoPath,
            'instruction' => $request->instruction,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('cms.payment_gateways.index')->with('status', 'Payment Gateway updated successfully.');
    }

    public function toggleStatus($id)
    {
        $gateway = PaymentGateway::findOrFail($id);
        $gateway->status = !$gateway->status;
        $gateway->save();

        return redirect()->back()->with('status', 'Gateway status updated successfully.');
    }

    public function destroy($id)
    {
        $gateway = PaymentGateway::findOrFail($id);
        if ($gateway->logo && File::exists(public_path($gateway->logo))) {
            File::delete(public_path($gateway->logo));
        }
        $gateway->delete();

        return redirect()->route('cms.payment_gateways.index')->with('status', 'Payment Gateway deleted successfully.');
    }
}
