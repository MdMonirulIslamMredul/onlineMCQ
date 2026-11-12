<?php

namespace App\Http\Controllers;

//use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Cookie;
class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {


        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = $request->amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->customer_name;
        $post_data['cus_email'] = $request->customer_email;
        $post_data['cus_add1'] = $request->address;
        $post_data['examID'] = $request->examID;
        $post_data['userID'] = $request->userID;

        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $request->customer_mobile;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'examID' => $post_data['examID'],
                'userID' => $post_data['userID'],
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();

        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }
    public function buybookpay(Request $request)
    {
        $bookType = $request->book_type ?: 'hardcopy';
        $paymentMethodType = $request->payment_method_type ?? ($request->radio ?? 'gateway');

        // Common validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => $bookType === 'hardcopy' ? 'required|string|max:255' : 'nullable|string|max:255',
            'pid' => 'required|numeric',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:1',
        ];

        // 1. Cash on Delivery (COD) - only for Hardcopy physical delivery
        if ($paymentMethodType === 'cash' || $request->radio === 'cash') {
            $request->validate($rules);

            $total_order = DB::table('books_order')->count('id');
            $current_order = $total_order + 1;
            $order_num = 'COD' . date("dmy") . $current_order;

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address ?? '',
                'pid' => $request->pid,
                'user_id' => Cookie::get('user_id'),
                'book_type' => $bookType,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'amount' => $request->price * $request->quantity,
                'currency' => 'BDT',
                'orderNum' => $order_num,
                'transaction_id' => 'COD_' . uniqid(),
                'payment_method' => 'Cash on Delivery',
                'payment_type' => 'cod',
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'date' => Carbon::now(),
            ];

            DB::table('books_order')->insert($data);

            return redirect('/orders-info/' . $order_num)->with('userSuccess', 'Cash on Delivery order placed successfully! Our team will process your book shipment.');
        }

        // 2. Manual Payment Gateway (bKash / Nagad / Rocket / Bank Transfer)
        if ($request->has('payment_gateway_id')) {
            $rules['payment_gateway_id'] = 'required|exists:payment_gateways,id';
            $rules['trx_id'] = 'required|string|max:255';
            $rules['screenshot'] = 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120';

            $gateway = \App\Models\PaymentGateway::findOrFail($request->payment_gateway_id);

            if ($gateway->type === 'mfs') {
                $rules['sender_number'] = 'required|string|max:50';
            } else {
                $rules['bank_name'] = 'required|string|max:255';
                $rules['bank_account_number'] = 'required|string|max:100';
            }

            $request->validate($rules);

            $screenshotPath = null;
            if ($request->hasFile('screenshot')) {
                $file = $request->file('screenshot');
                $filename = 'book_pay_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                if (!file_exists(public_path('uploads/payments'))) {
                    mkdir(public_path('uploads/payments'), 0777, true);
                }
                $file->move(public_path('uploads/payments'), $filename);
                $screenshotPath = 'uploads/payments/' . $filename;
            }

            $total_order = DB::table('books_order')->count('id');
            $current_order = $total_order + 1;
            $order_num = 'BOD' . date("dmy") . $current_order;

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address ?? '',
                'pid' => $request->pid,
                'user_id' => Cookie::get('user_id'),
                'book_type' => $bookType,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'amount' => $request->price * $request->quantity,
                'currency' => 'BDT',
                'orderNum' => $order_num,
                'transaction_id' => $request->trx_id,
                'trx_id' => $request->trx_id,
                'payment_gateway_id' => $gateway->id,
                'payment_method' => $gateway->name,
                'payment_type' => $gateway->type,
                'sender_number' => $request->sender_number ?? null,
                'bank_name' => $request->bank_name ?? ($gateway->type === 'bank' ? $gateway->bank_name : null),
                'bank_account_number' => $request->bank_account_number ?? null,
                'screenshot' => $screenshotPath,
                'status' => 'pending',
                'payment_status' => 'pending',
                'date' => Carbon::now(),
            ];

            DB::table('books_order')->insert($data);

            return redirect('/orders-info/' . $order_num)->with('userSuccess', 'Payment submitted successfully! Your payment proof is under manual verification by our team.');
        }

        // 3. Fallback to SSLCommerz
        $post_data = array();
        $post_data['total_amount'] = $request->price * $request->quantity; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->name;
        $post_data['cus_email'] = $request->email;
        $post_data['cus_add1'] = $request->address;
        // $post_data['examID'] = $request->examID;
        $post_data['userID'] = $request->userID;

        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $request->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.

        $total_order = DB::table('books_order')->count('id');
        $current_order = $total_order + 1;
        $order_num = 'EOD'.date("dmy").$current_order;

        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['pid'] = $request->pid;
        $data['user_id'] = Cookie::get('user_id');
        $data['book_type'] = $request->book_type ?: 'hardcopy';
        $data['price'] = $request->price;
        $data['amount'] =  $post_data['total_amount'];
        $data['quantity'] = $request->quantity;
        $data['orderNum'] = $order_num;
        $data['transaction_id'] = $post_data['tran_id'];

        $data['status'] = 'pending';
        $data['date'] = Carbon::now();

    // if ($request->order=="cash") {

    // }

        DB::table('books_order')->where('transaction_id', $post_data['tran_id'])->insert($data);



        $sslc = new SslCommerzNotification();

        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    // public function payViaAjax(Request $request)
    // {

    //     //dd($request->all());
    //     # Here you have to receive all the order data to initate the payment.
    //     # Lets your oder trnsaction informations are saving in a table called "orders"
    //     # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

    //     $post_data = array();
    //     $post_data['total_amount'] = '10'; # You cant not pay less than 10
    //     $post_data['currency'] = "BDT";
    //     $post_data['tran_id'] = uniqid(); // tran_id must be unique

    //     # CUSTOMER INFORMATION
    //     $post_data['cus_name'] = $request->customer_name;
    //     $post_data['cus_email'] = 'customer@mail.com';
    //     $post_data['cus_add1'] = 'Customer Address';
    //     $post_data['cus_add2'] = "";
    //     $post_data['cus_city'] = "";
    //     $post_data['cus_state'] = "";
    //     $post_data['cus_postcode'] = "";
    //     $post_data['cus_country'] = "Bangladesh";
    //     $post_data['cus_phone'] = '8801XXXXXXXXX';
    //     $post_data['cus_fax'] = "";

    //     # SHIPMENT INFORMATION
    //     $post_data['ship_name'] = "Store Test";
    //     $post_data['ship_add1'] = "Dhaka";
    //     $post_data['ship_add2'] = "Dhaka";
    //     $post_data['ship_city'] = "Dhaka";
    //     $post_data['ship_state'] = "Dhaka";
    //     $post_data['ship_postcode'] = "1000";
    //     $post_data['ship_phone'] = "";
    //     $post_data['ship_country'] = "Bangladesh";

    //     $post_data['shipping_method'] = "NO";
    //     $post_data['product_name'] = "Computer";
    //     $post_data['product_category'] = "Goods";
    //     $post_data['product_profile'] = "physical-goods";

    //     # OPTIONAL PARAMETERS
    //     $post_data['value_a'] = "ref001";
    //     $post_data['value_b'] = "ref002";
    //     $post_data['value_c'] = "ref003";
    //     $post_data['value_d'] = "ref004";


    //     #Before  going to initiate the payment order status need to update as Pending.
    //     $update_product = DB::table('orders')
    //         ->where('transaction_id', $post_data['tran_id'])
    //         ->updateOrInsert([
    //             'name' => $post_data['cus_name'],
    //             'email' => $post_data['cus_email'],
    //             'phone' => $post_data['cus_phone'],
    //             'amount' => $post_data['total_amount'],
    //             'status' => 'Pending',
    //             'address' => $post_data['cus_add1'],
    //             'transaction_id' => $post_data['tran_id'],
    //             'currency' => $post_data['currency']
    //         ]);

    //     $sslc = new SslCommerzNotification();
    //     # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
    //     $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

    //     if (!is_array($payment_options)) {
    //         print_r($payment_options);
    //         $payment_options = array();
    //     }

    // }
    public function buycoursepay(Request $request)
    {

//
            $user = Cookie::get('user_id');
           if($user){
                $post_data = array();
        $post_data['total_amount'] = $request->price; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->name;
        $post_data['cus_email'] = $request->email;
        $post_data['cus_add1'] = $request->address;
        // $post_data['examID'] = $request->examID;
        $post_data['userID'] = $request->userID;

        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $request->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.

        $total_order = DB::table('courses_order')->count('id');
        $current_order = $total_order + 1;
        $order_num = 'EOD'.date("dmy").$current_order;

        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['pid'] = $request->pid;
        $data['price'] = $request->price;
        $data['amount'] =  $post_data['total_amount'];
        $data['orderNum'] = $order_num;
        $data['transaction_id'] = $post_data['tran_id'];

        $data['status'] = 'enrolled';
        $data['date'] = Carbon::now();

        DB::table('courses_order')->where('transaction_id', $post_data['tran_id'])->insert($data);



        $sslc = new SslCommerzNotification();

        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
           }else{

                  return redirect('/')->with('userSuccess', 'Please sing in first');
           }



    }




    public function success(Request $request)
    {

        echo "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

            $books_order = DB::table('books_order')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

            $courses_order = DB::table('courses_order')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();



     if ($order_detials !=Null) {
        $ordersInfo = DB::table('orders')->where('transaction_id', $request->tran_id)->where('amount', $request->amount* $request->quantity)->first();
        if ($order_detials->status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);

                $category = DB::table('categories')->where('id', $ordersInfo->examID)->first();
                $Eurl = str_replace(" ","-", $category->name);
                $key = rand(10000, 199999);
                return redirect('/category/'.$category->id.'/'.$Eurl)->with('userSuccess', 'Payment Received Successfully');

            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Failed']);
                echo "validation Fail";
            }
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }
     }

     if ($books_order !=null) {

        $ordersInfo = DB::table('books_order')->where('transaction_id', $request->tran_id)->first();
       $order_num= $ordersInfo->orderNum;

        if ($books_order->status == 'pending') {

            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $targetStatus = (optional($books_order)->book_type == 'softcopy') ? 'delivered' : 'processing';
                $update_product = DB::table('books_order')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => $targetStatus, 'payment_status' => 'paid']);



                return redirect('/ordres-info/'.$order_num)->with('user Success', 'Payment Received Successfully');

            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table('books_order')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Failed']);
                echo "validation Fail";
            }
        }  else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }
     }
     if ($courses_order !=null) {

        $ordersInfo = DB::table('courses_order')->where('transaction_id', $request->tran_id)->first();
       $order_num= $ordersInfo->orderNum;

        if ($courses_order->status == 'pending') {

            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('courses_order')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'pending','payment_status' => 'paid']);



                return redirect('/')->with('user Success', 'Payment Received Successfully');

            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table('courses_order')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Failed']);
                echo "validation Fail";
            }
        }
        else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }
     }


    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        $ordersInfo = DB::table('orders')->where('transaction_id', $request->tran_id)->where('amount', $request->amount)->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);

            $category = DB::table('categories')->where('id', $ordersInfo->examID)->first();
            $Eurl = str_replace(" ","-", $category->name);
            $key = rand(10000, 199999);
            return redirect('/user/unlock-category/'.$category->id.'/'.$Eurl)->with('notAllow', 'Transaction is Falied!, Please Try Again');


            //echo "Transaction is Falied";
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        $ordersInfo = DB::table('orders')->where('transaction_id', $request->tran_id)->where('amount', $request->amount)->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);


            $category = DB::table('categories')->where('id', $ordersInfo->examID)->first();
            $Eurl = str_replace(" ","-", $category->name);
            $key = rand(10000, 199999);
            return redirect('/user/unlock-category/'.$category->id.'/'.$Eurl)->with('notAllow', 'Transaction is Cancel');


           // echo "Transaction is Cancel";
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Failed']);

                    echo "validation Fail";
                }

            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}
