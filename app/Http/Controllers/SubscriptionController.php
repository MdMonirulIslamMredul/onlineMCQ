<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function all_subscription(){
        $datas = DB::table('subscriptions')->orderBy('id', 'desc')->get();
        return view('cms.subscription.all_subscription', compact('datas'));
    }

    // Add Subscription Function
    public function addSubscription(Request $request){
        // dd($request->all());
        $data = array();
        $data['name'] = $request->name;
        $data['yearly_price'] = $request->yearly_price;
        $data['monthly_price'] = $request->monthly_price;
        $data['description'] = $request->description;
        $data['active'] = 1;
        $data['is_popular'] = $request->is_popular ?? 0;
        $data['is_free_trial'] = $request->is_free_trial ?? 0;
        $data['created_at'] = Carbon::now();

        DB::table('subscriptions')->insert($data);

        return Redirect()->back()->with('status', 'Subscription Added Successfully');
    }

    // Deactive Subscription Function
    public function deactiveSubscription($id){
        $data = array();
        $data['active'] = 0;
        $data['updated_at'] = Carbon::now();
        DB::table('subscriptions')-> where('id', $id) ->update($data);

        return redirect()->back()->with('status', 'Deactivated Successfully');
    }

    // Active Subscription Function
    public function activeSubscription($id){
        $data = array();
        $data['active'] = 1;
        $data['updated_at'] = Carbon::now();
        DB::table('subscriptions')-> where('id', $id) ->update($data);

        return redirect()->back()->with('status', 'Activated Successfully');
    }

    // Edit Subscription Function
    public function editSubscription($id){
        $data = DB::table('subscriptions')-> where('id', $id) ->first();
        return view('cms.subscription.edit_subscription', compact('data'));
    }

    // Update Subscription Function
    public function updateSubscription(Request $request, $id){
        $request->validate([
            'name' => 'required|unique:subscriptions,name,'.$id,
            'description' => 'nullable|string',
            'is_popular' => 'boolean',
            'is_free_trial' => 'boolean',
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['yearly_price'] = $request->yearly_price;
        $data['monthly_price'] = $request->monthly_price;
        $data['description'] = $request->description;
        $data['is_popular'] = $request->is_popular ?? 0;
        $data['is_free_trial'] = $request->is_free_trial ?? 0;
        $data['updated_at'] = Carbon::now();

        DB::table('subscriptions')-> where('id', $id) ->update($data);
        return Redirect() -> route('all.subscription')->with('status', 'Updated Successfully');
    }
}
