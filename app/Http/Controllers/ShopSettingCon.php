<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ShopSettingCon extends Controller
{
    //Begin::Shop Setting Added
    public function addSetting(Request $request){
        $request->validate([
            'company_name' => 'required',
            'logo' => 'required',
            'address' => 'required',
            'phone_1' => 'required',
            'email' => 'required',

        ]);

        $logo = $request->file('logo');
        $name_gen = hexdec(uniqid()).".".$logo->getClientOriginalExtension();
        Image::make($logo)->resize(210, 66)->save('images/'.$name_gen);
        $last_img = 'images/'.$name_gen;

        $data = array();
        $data['company_name'] = $request->company_name;
        $data['logo'] = $last_img;
        $data['address'] = $request->address;
        $data['phone_1'] = $request->phone_1;
        $data['phone_2'] = $request->phone_2;
        $data['email'] = $request->email;
        $data['facebook'] = $request->facebook;
        $data['youtube'] = $request->youtube;
        $data['instagram'] = $request->instagram;
        $data['twitter'] = $request->twitter;
        $data['linkden'] = 'null';
        $data['privacy_policy'] = $request->editor1;
        $data['mission_and_vission'] = $request->editor2;
        $data['trams_and_condition'] = $request->editor3;
        $data['created_at'] = Carbon::now();

        DB::table('company_settings')->insert($data);
        return Redirect()->back()->with('status', 'Setting Added Successfully');

    }
    //Begin::Shop Setting Added

    // Shop Setting Edit
    public function EditShopSetting($id){
        $company_setting = DB::table('company_settings')-> where('id', $id) ->first();
        return view('cms.setting.edit_shop_setting', compact('company_setting'));
    }

    // Update Shop Settings
    public function UpdateShopSetting(Request $request, $id){

        $old_image = $request->old_image;
        $logo = $request->file('logo');

        if($logo){

            $name_gen = hexdec(uniqid()).".".$logo->getClientOriginalExtension();
            Image::make($logo)->resize(100, 100)->save('images/'.$name_gen);
            $last_img = 'images/'.$name_gen;

            if (isset($old_image) && file_exists($old_image)) {
                unlink($old_image);
            }

            $data = array();
            $data['company_name'] = $request->company_name;
            $data['logo'] = $last_img;
            $data['address'] = $request->address;
            $data['phone_1'] = $request->phone_1;
            $data['phone_2'] = $request->phone_2;
            $data['email'] = $request->email;
            $data['facebook'] = $request->facebook;
            $data['youtube'] = $request->youtube;
            $data['instagram'] = $request->instagram;
            $data['twitter'] = $request->twitter;
            $data['linkden'] = 'null';
            $data['count1'] = $request->count1;
            $data['count2'] = $request->count2;
            $data['count3'] = $request->count3;
            $data['count4'] = $request->count4;
            $data['privacy_policy'] = $request->editor1;
            $data['mission_and_vission'] = $request->editor2;
            $data['trams_and_condition'] = $request->editor3;
            $data['footer_des'] = $request->footer_des;
            $data['footer_credit'] = $request->footer_credit;
            $data['updated_at'] = Carbon::now();

            DB::table('company_settings')-> where('id', $id) ->update($data);
            return Redirect() -> route('admin_setting')->with('status', 'Company Setting Update Successfully');
        }
        else {
            $data = array();
            $data['company_name'] = $request->company_name;
            $data['address'] = $request->address;
            $data['phone_1'] = $request->phone_1;
            $data['phone_2'] = $request->phone_2;
            $data['email'] = $request->email;
            $data['facebook'] = $request->facebook;
            $data['youtube'] = $request->youtube;
            $data['instagram'] = $request->instagram;
            $data['twitter'] = $request->twitter;
            $data['linkden'] = 'null';
            $data['count1'] = $request->count1;
            $data['count2'] = $request->count2;
            $data['count3'] = $request->count3;
            $data['count4'] = $request->count4;
            $data['privacy_policy'] = $request->editor1;
            $data['mission_and_vission'] = $request->editor2;
            $data['trams_and_condition'] = $request->editor3;
            $data['footer_des'] = $request->footer_des;
            $data['footer_credit'] = $request->footer_credit;
            $data['updated_at'] = Carbon::now();

            DB::table('company_settings')-> where('id', $id) ->update($data);
            return Redirect()-> route('admin_setting')->with('status', 'Company Setting Update Successfully');
        }
    }



}
