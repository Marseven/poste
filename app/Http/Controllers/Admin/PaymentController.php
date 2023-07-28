<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expedition;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $payments = Paiement::where('customer_id', Auth::user()->id);
        $payments;
        return view(
            'payment.list',
            [
                'payments' => $payments,
            ]
        );
    }

    public function payments()
    {
        $this->add_visite(Auth::user());
        $user = User::find(Auth::user()->id);
        $user->load(['payments']);
        return view(
            'payment.list',
            [
                'payments' => $user->payments,
            ]
        );
    }

    static function create($data)
    {
        $payment = Paiement::where('reference_refill', $data['reference_refill'])->first();
        if ($payment) {
            $payment->reference = $data['reference'];
            return $payment->save();
        } else {
            $payment = new Paiement();
            $payment->refill_id = $data['refill'];
            $payment->bank = $data['bank'];
            $payment->reference_refill = $data['reference_refill'];
            $payment->description = $data['description'];
            $payment->reference = $data['reference'];
            $payment->amount = $data['amount'];
            $payment->status = $data['status'];
            $payment->time_out = $data['time_out'];
            $payment->customer_id = $data['customer_id'];
            $payment->billing_id = $data['billing_id'];
            return $payment->save();
        }
    }

    public function update(Request $request, Paiement $payment)
    {
        $payment->status = "Paid";
        $payment->transaction_id = $request->transaction_id;
        $payment->operator = $request->operator;
        $payment->amount = $request->amount;
        $payment->paid_at = $request->paid_at;
        if ($payment->save()) {
            $payment->load(['expedition']);
            $entity = $payment->expedition;
            if ($entity->status != 5 || $entity->status != 6) {
                $entity->status = "Paid";
                $entity->updated_at = $payment->paid_at;
                $entity->created_at = $payment->paid_at;
                $entity->save();
            }
            return back()->with('success', "Le paiement a bien été mis à jour !");
        } else {
            return back()->with('error', "Une erreur s'est produite.");
        }
    }

    static function ebilling($bank = null, $type, $data, $try = false)
    {

        $pay = PaymentController::check_payment($type, $data->reference);
        $invoice = false;
        if ($pay != null) {
            $invoice = PaymentController::check_invoice($pay);
        }
        if ($pay != null && $invoice != false) {
            $bill_id = $invoice->billing_id;
            $eb_callbackurl = url('/callback/ebilling/' . $bank . '/' . $type . '/' . $data->id);
            if ($try) $eb_callbackurl = url('/callback/ebilling/try/' . $bank . '/' . $type . '/' . $data->id);
        } else {

            // Fetch all data (including those not optional) from session
            $eb_name = $data->name_card;
            $eb_amount = $data->amount_ora + $data->fees_ora + $data->fees_eb;
            $eb_shortdescription = 'Recharge de la Carte prépayé Orabank **** **** **** ' . substr($data->number_card, -4, 4);
            $eb_reference = PaymentController::str_reference(10);
            $eb_email = auth()->user()->email;
            $eb_msisdn = '074808000';
            $eb_callbackurl = url('/callback/ebilling/' . $bank . '/refill/' . $data->id);

            $expiry_period = 60; // 60 minutes timeout

            // Creating invoice for a merchant
            $merchant_name = config('app.name');

            $payment = Paiement::where('reference', $eb_reference)->first();

            if ($payment) {
                $eb_reference = PaymentController::str_reference(10);
            }

            // =============================================================
            // ============== E-Billing server invocation ==================
            // =============================================================

            $global_array =
                [
                    'payer_email' => $eb_email,
                    'payer_msisdn' => $eb_msisdn,
                    'amount' => $eb_amount,
                    'short_description' => $eb_shortdescription,
                    'external_reference' => $eb_reference,
                    'payer_name' => $eb_name,
                    'expiry_period' => $expiry_period
                ];

            if ($type == "transfert") {
                $username =  env('USER_NAME_TR');
                $shared_key = env('SHARED_KEY_TR');
            } else {
                $username =  env('USER_NAME');
                $shared_key = env('SHARED_KEY');
            }

            $content = json_encode($global_array);
            $curl = curl_init(env('SERVER_URL'));
            curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $shared_key);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
            $json_response = curl_exec($curl);

            // Get status code
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            // Check status <> 200
            if ($status < 200  || $status > 299) {
                //die("Error: call to URL failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
                return back()->with('error', "Une erreur $status s'est produite lors du paiement, Veuillez réessayer !")->withInput();
            }

            curl_close($curl);

            // Get response in JSON format
            $response = json_decode($json_response, true);

            // Get unique transaction id
            $bill_id = $response['e_bill']['bill_id'];


            $data = [
                'refill' => $data->id,
                'bank' => $bank,
                'amount' => $eb_amount,
                'description' => $eb_shortdescription,
                'reference' => $eb_reference,
                'reference_refill' => $data->reference,
                'status' => STATUT_PENDING,
                'time_out' => $expiry_period,
                'customer_id' => Auth::user()->id,
                'description' => $eb_shortdescription,
                'billing_id' => $bill_id,
            ];


            PaymentController::create($type, $data);
        }

        // Redirect to E-Billing portal
        echo "<form action='" . env('POST_URL') . "' method='post' name='frm'>";
        echo "<input type='hidden' name='invoice_number' value='" . $bill_id . "'>";
        echo "<input type='hidden' name='eb_callbackurl' value='" . $eb_callbackurl . "'>";
        echo "</form>";
        echo "<script language='JavaScript'>";
        echo "document.frm.submit();";
        echo "</script>";

        exit();
    }

    public function callback_ebilling($entity)
    {
        $refill = Expedition::find($entity);
        $payment = Paiement::where('reference_refill', $refill->reference)->first();
        if ($payment->status == "Paid") {
            $refill->load(['payment']);
            return view(
                'payment.callback',
                [
                    'refill' => $refill,
                    'payment' => $payment,
                    'user' => Auth::user(),
                ]
            )->with('succes', 'Votre paiment a bien été reçu.');
        } else {
            $refill->status = "Failed";
            $refill->save();
            return redirect('/list-refills')->with('warning', "Votre paiement n'a pas été reçu.");;
        }
    }

    public function notify_ebilling()
    {
        if (isset($_POST['reference'])) {
            $payment = Paiement::where('reference', $_POST['reference'])->first();
            if ($payment) {
                $payment->status = "Paid";
                $payment->transaction_id = $_POST['transactionid'];
                $payment->operator = $_POST['paymentsystem'];
                $payment->amount = $_POST['amount'];
                $payment->paid_at = date('Y-m-d H:i');
                $payment->save();

                $expedition = Paiement::where('reference', $payment->reference_refill)->first();
                $expedition->status = "Paid";
                $expedition->updated_at = date('Y-m-d H:i');
                $expedition->created_at = date('Y-m-d H:i');
                $expedition->save();
                $expedition->load(['user']);

                return http_response_code(200);
            } else {
                return http_response_code(402);
            }
        } else {
            return http_response_code(401);
        }
    }

    static function str_reference($length)
    {
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
    }


    static function check_invoice(Paiement $payment)
    {
        $auth = env('USER_NAME') . ':' . env('SHARED_KEY');
        $base64 = base64_encode($auth);

        $response = Http::withHeaders([
            "Authorization" => "Basic " . $base64
        ])->get(env('SERVER_URL') . $payment->bill_id);

        $response = json_decode($response->body());

        if ($response != null && $response->state == 'ready') {
            return $response;
        } else {
            return false;
        }
    }

    static function check_payment($reference)
    {
        $payment = Paiement::where('reference', $reference)->get();
        if ($payment->first() != null) {
            return $payment->first();
        } else {
            return null;
        }
    }
}
