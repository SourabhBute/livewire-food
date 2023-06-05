<?php
namespace App\Http\Controllers;

use App\Constants\OrderPaymentStatus;
use App\Models\Order\Transaction;
use Hyperpay\Payment\Controllers\MainController;
use Illuminate\Support\Facades\Http;

class PaymentController extends MainController
{


    // for success
    protected const success_pattren = '/^(000.000.|000.100.1|000.[36]|000.400.[1][12]0)/';
    protected const successManualReviewCodePattern = '/^(000.400.0[^3]|000.400.100)/';

    //pending
    protected const pending_pattren = '/^(000\.200)/';

    // failure response
    protected const failure_pattren =  [
        '/^(800\.[17]00|800\.800\.[123])/',
        '/^(900\.[1234]00|000\.400\.030)/',
        '/^(800\.[56]|999\.|600\.1|800\.800\.[84])/',
        '/^(100\.400\.[0-3]|100\.380\.100|100\.380\.11|100\.380\.4|100\.380\.5)/',
        '/^(800\.1[123456]0)/',
        '/^(600\.[23]|500\.[12]|800\.121)/',
        '/^(800\.[32])/',
        '/^(800\.400\.2|100\.390)/',
        '/^(800\.400\.1)/',
        '/^(100\.[13]50)/',
        '/^(300\.100\.100)/',
        '/^(100\.39[765])/',
        '/^(100\.39[765])/',
        '/^(100\.250|100\.360)/',
        '/^(700\.[1345][05]0)/',
        '/^(200\.[123]|100\.[53][07]|800\.900|100\.[69]00\.500)/',
        '/^(100\.800)/',
        '/^(100\.700|100\.900\.[123467890][00-99])/',
        '/^(100\.100|100.2[01])/',
        '/^(100\.55)/',
        '/^(100\.380\.[23]|100\.380\.101)/',
        '/^(000\.100\.2)/',
        '/^(000\.400\.[1][0-9][1-9]|000\.400\.2)/'
    ];


    public function success($response)
    {
        $result = self::ResponseValidate($response);
        switch ($result['status']) {
            case OrderPaymentStatus::SUCCESS:
                    return $this->SuccessHyperpay($result);
                break;
            case OrderPaymentStatus::PENDING:
                    return $this->PendingHyperpay($result);
                break;
            case OrderPaymentStatus::FAILED:
                    return $this->FailedHyperpay($result);                
                break;
        }

    }


    public function failed($response)
    {
        $result = self::ResponseValidate($response);
        switch ($result['status']) {
            case OrderPaymentStatus::SUCCESS:
                    return $this->SuccessHyperpay($result);
                break;
            case OrderPaymentStatus::PENDING:
                    return $this->PendingHyperpay($result);
                break;
            case OrderPaymentStatus::FAILED:
                    return $this->FailedHyperpay($result);                
                break;
        }
    }



     /**
     * To send success status response
     *
     * @param [type] $result
     * @return void
     */
    public function SuccessHyperpay($result)
    {

        $transaction = Transaction::where('transaction_id',$result['merchantTransactionId'])->first();
        if ($transaction) {
            OrderTransactionHistory($transaction->id ,OrderPaymentStatus::COMPLETED);
            Transaction::where('transaction_id',$result['merchantTransactionId'])->update([
                'refrence_id' => $result['id'],
                'status' => OrderPaymentStatus::COMPLETED,
                'content' => isset($result['result']['description']) ? $result['result']['description'] : $transaction->content,
                'gatway_response' => @json_encode($result,true),
            ]);
            Http::patch(config('app_settings.app_api_url.value').'/payment/status/'.$transaction->order_id.'/'.OrderPaymentStatus::SUCCESS.'/'.base64_encode($transaction->user_id));
        }
        return redirect()->route('payment.status', [
            'refrence_id' => $result['id'],
            'status' => OrderPaymentStatus::SUCCESS,
            'txnid' => $result['merchantTransactionId'],
            'content' => isset($result['result']['description']) ? $result['result']['description'] : $transaction->content,
        ]);
    }

    /**
     * To send pending status response
     *
     * @param [type] $result
     * @return void
     */
    public function PendingHyperpay($result)
    {
        $transaction = Transaction::where('transaction_id',$result['merchantTransactionId'])->first();
        if ($transaction) {
            OrderTransactionHistory($transaction->id ,OrderPaymentStatus::HOLD);
            Transaction::where('transaction_id',$result['merchantTransactionId'])->update([
                'refrence_id' => $result['id'],
                'status' => OrderPaymentStatus::HOLD,
                'content' => isset($result['result']['description']) ? $result['result']['description'] : $transaction->content,
                'gatway_response' => @json_encode($result,true),
            ]);
            Http::patch(config('app_settings.app_api_url.value').'/payment/status/'.$transaction->order_id.'/'.OrderPaymentStatus::PENDING.'/'.base64_encode($transaction->user_id));
        }
        return redirect()->route('payment.status', [
            'refrence_id' => $result['id'],
            'status' => OrderPaymentStatus::PENDING,
            'txnid' => $result['merchantTransactionId'],
            'content' => isset($result['result']['description']) ? $result['result']['description'] : $transaction->content,
        ]);
    }

     /**
     * To send failure status response
     *
     * @param [type] $result
     * @return void
     */
    public function FailedHyperpay($result)
    {
        if (!isset($result['merchantTransactionId'])) {
            return redirect()->route('payment.status', [
                'status' => OrderPaymentStatus::FAILED,
                'content' => isset($result['result']['description']) ? $result['result']['description'] : OrderPaymentStatus::FAILED,
            ]);
        }
        $transaction = Transaction::where('transaction_id',$result['merchantTransactionId'])->first();
        if ($transaction) {
            OrderTransactionHistory($transaction->id ,OrderPaymentStatus::CANCELLED);
            Transaction::where('transaction_id',$result['merchantTransactionId'])->update([
                'refrence_id' => $result['id'],
                'status' => OrderPaymentStatus::CANCELLED,
                'content' => isset($result['result']['description']) ? $result['result']['description'] : $transaction->content,
                'gatway_response' => @json_encode($result,true),
            ]);
            Http::patch(config('app_settings.app_api_url.value').'/payment/status/'.$transaction->order_id.'/'.OrderPaymentStatus::FAILED.'/'.base64_encode($transaction->user_id));
        }
        return redirect()->route('payment.status', [
            'status' => OrderPaymentStatus::CANCELLED,
            'txnid' => $result['merchantTransactionId'],
            'content' => isset($result['result']['description']) ? $result['result']['description'] : $transaction->content,
        ]);
    }



    /**
    * validate http response
    *
    * @param [json]  $response
    * @return $response
    */
   public static function ResponseValidate($response)
   {
       $code =  ($response['result']['code'] ?? '');
       $success = preg_match(self::success_pattren , $code) || preg_match(self::successManualReviewCodePattern , $code) ;
       $pending = preg_match(self::pending_pattren , $code);
       $failure = self::PregGrep($code);
        if ($success) {
            $response['status'] = OrderPaymentStatus::SUCCESS;
        }else if ($pending) {
            $response['status'] = OrderPaymentStatus::PENDING;
        }else if($failure){
            $response['status'] = OrderPaymentStatus::FAILED;
        }else{
            $response['status'] = OrderPaymentStatus::PENDING;
        }
       return $response;
   }
    /**
    * validate failure response code
    *
    * @param [type] $code
    * @return true/false
    */
   public static function PregGrep($code = null)
   {
       if ($code) {
           $pattern =  self::failure_pattren;
           foreach ($pattern as $key => $value) {
               if (preg_match($value, $code)) {
                   return true;
               }
           }
       }
       return false;
   }
}
