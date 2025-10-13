<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Models\Exam;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\UserSubscriptionDetails;
use App\Notifications\CandidateNotification;
use App\Library\SslCommerz\SslCommerzNotification;

class SslCommerzPaymentController extends Controller
{
    public function payNow($bookingData)
    {
        // dd($bookingData);
        $candidate = auth('candidate')->user();
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = $bookingData->total_payable; # You cant not pay less than 10
        // dd($post_data['total_amount']);
        $post_data['currency'] = "BDT";
        if($bookingData->title == 'subscription'){
            $post_data['tran_id'] = $bookingData->tran_id;
            $post_data['title'] = 'subscription';
        }
        else if($bookingData->title == 'renewal'){
            $post_data['tran_id'] = $bookingData->tran_id; // tran_id must be unique
            $post_data['title'] = 'renewal';
        }
        else{
            $post_data['tran_id'] = $bookingData->id; // tran_id must be unique
            $post_data['title'] = 'booking';
        }
        // $post_data['tran_id'] = $bookingData->id; // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $candidate->full_name;
        $post_data['cus_email'] = $candidate->email;
        $post_data['cus_add1'] = $candidate->address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $candidate->phone_number;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Kaicom Solution Limited";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1230";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = 'JPT Exam Registration';
        $post_data['product_category'] = "Booking";
        $post_data['product_profile'] = "Digital Product";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";
        // dd($post_data);
 

        $sslc = new SslCommerzNotification;
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {

            $response = json_decode($payment_options, true);
            $response['url'] = $response['data'];
            unset($response['data']);

            return $response;
        }
    }


    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id'); // booking id
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $title = $request->input('title');

        $sslc = new SslCommerzNotification();

        $subscriptionData = UserSubscription::where('tran_id', $tran_id)->firstOrFail();



        // if($title == 'subscription'){
        //     $subscriptionData = UserSubscription::where('tran_id', $tran_id)->firstOrFail();
        //     // dd($bookingData);
        //     dd("1");
        //     //  dd($bookingData->id);
        // }
        // else if($title == 'renewal'){
        //     $subscriptionData = UserSubscription::where('tran_id', $tran_id)->firstOrFail();
        //     dd("2");
        // }
        // else{
        //     // $bookingData = UserSubscription::find($tran_id);
        //     $subscriptionData = UserSubscription::where('tran_id', $tran_id)->firstOrFail();
        //     dd("3");
        //     // dd($bookingData);
        // }
        

        // $successPath = str_replace('{booking_id}', $bookingData->id, config('app.frontend.payment_success') );
        $successPath = config('app.frontend.payment_success') . '?subscription_id=' . $subscriptionData->id . '&amount=' . $subscriptionData->total_payable . '&tran_id=' . $subscriptionData->tran_id;
        // dd($successPath);
        $failedPath  = str_replace('{booking_id}', $subscriptionData->id, config('app.frontend.payment_failed'));
        $baseUrl     = config('app.frontend.url');

        $this->paymentTrack($subscriptionData, $request->all());

        if ($subscriptionData->payment_status == 'pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $subscriptionData->update(
                    [
                        'payment_status' => 'success',
                        'status' => 'confirmed'
                    ]
                );
                $package = Package::with('package_details.exam')->find($subscriptionData->package_id);
                foreach ($package->package_details as $detail) {
                    UserSubscriptionDetails::create([
                        'package_details_id'   => $detail->id,
                        'user_subscription_id' => $subscriptionData->id,
                        'exam_id'              => $detail->exam_id,
                        'max_exam_attempt'     => $detail->max_exam_attempt,
                    ]);
                }

                //notify candidate
                $data=[
                    'title'=>"Subscription Successful!",
                    // 'message'=>"Your booking for exam: ". $bookingData->exam->title ." has been successful. Please Check your profile. ",
                    'message'=>"Your payment has been successful. Please Check your profile. ",
                    'url'=>'',

                ];
                // dd($data);
                $subscriptionData->candidate->notify(new CandidateNotification($data));
                // dd($successPath);
                return redirect()->away($successPath);
            } else {
                #That means something wrong happened. You can redirect customer to your product page.
                return redirect()->away($baseUrl . $failedPath);
            }
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            return redirect()->away($baseUrl . $failedPath);
        }
        // $bookingData->candidate->notify(new CandidateNotification($data));
     
        return redirect()->away($successPath);
    }

    public function paymentTrack($bookingData, $requestData)
    {
        Payment::create([
            // ($requestData['title'] ?? '') == "subscription" ? 'package_id' : 'booking_id' => $bookingData->id,
            'subscription_id'      => $bookingData->id, // existing bookings.id
            'type'            => 'booking',
            'amount'          => $bookingData->total_payable,
            'payment_method'  => $requestData['card_type'] ?? 'unknown',
            'status'          => $bookingData['status'],
            // 'reference'       => 
            'additionals'     => json_encode($requestData),
        ]);
    }

    public function fail(Request $request)
    {
        // $successPath = config('app.frontend.payment_success') . '?subscription_id=' . $subscriptionData->id . '&amount=' . $subscriptionData->total_payable . '&tran_id=' . $subscriptionData->tran_id;
        // // dd($successPath);
        // $failedPath  = str_replace('{booking_id}', $subscriptionData->id, config('app.frontend.payment_failed'));
        // $baseUrl     = config('app.frontend.url');
        $tran_id = $request->input('tran_id');

        $subscriptionData = UserSubscription::where('tran_id', $tran_id)->firstOrFail();

        $failedPath = config('app.frontend.payment_failed') . '?subscription_id=' . $request->input('subscription_id');
        $baseUrl     = config('app.frontend.url');
        
        $subscriptionData->update([
            'payment_status' => UserSubscription::FAILED,
            'status' => UserSubscription::CANCELLED,
        ]);
        
        $this->paymentTrack($subscriptionData, $request->all());

        return redirect()->away($failedPath);

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        
        $subscriptionData = UserSubscription::where('tran_id', $tran_id)->firstOrFail();

        $failedPath = config('app.frontend.payment_cancel') . '?subscription_id=' . $request->input('subscription_id');
        
        $subscriptionData->update([
            'payment_status' => UserSubscription::FAILED,
            'status' => UserSubscription::CANCELLED,
        ]);
        
        $this->paymentTrack($subscriptionData, $request->all());

        return redirect()->away($failedPath);
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
