<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PaidMessage;
use App\Models\Expedition;
use App\Models\Paiement;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $app_name = "La Poste";
        $page_title = "Les Paiements";
        $transaction = "side-menu--active";
        $transaction_sub = "side-menu__sub-open";
        $transaction1 = "side-menu--active";

        $payments = Paiement::orderBy('id', 'DESC')->paginate(10);

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        return view('admin.adminPaiement', compact(
            'page_title',
            'app_name',
            'payments',
            'transaction',
            'transaction_sub',
            'transaction1'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchPaiement(Request $request)
    {

        $app_name = "La Poste";
        $page_title = "Les Paiements";
        $transaction = "side-menu--active";
        $transaction_sub = "side-menu__sub-open";
        $transaction1 = "side-menu--active";

        $admin = Auth::user();
        $admin_id = Auth::user()->id;

        $q = $request->input('q');

        $payments = Paiement::where('reference', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('amount', 'LIKE', '%' . $request->input('q') . '%')
            ->orWhere('description', 'LIKE', '%' . $request->input('q') . '%')
            ->paginate(10);

        return view('admin.adminPaiement', compact(
            'page_title',
            'app_name',
            'payments',
            'transaction',
            'transaction_sub',
            'transaction1'
        ));
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
        $payment = Paiement::where('reference', $data['reference'])->first();
        if ($payment) {
            $payment->reference = $data['reference'];
            return $payment->save();
        } else {
            $payment = new Paiement();
            $payment->expedition_id = $data['expedition'];
            $payment->description = $data['description'];
            $payment->reference = $data['reference'];
            $payment->amount = $data['amount'];
            $payment->status = $data['status'];
            $payment->ebilling_id = $data['billing_id'];
            return $payment->save();
        }
    }

    public function update(Request $request, Paiement $payment)
    {
        $payment->status = STATUT_PAID;
        $payment->transaction_id = $request->transaction_id;
        $payment->operator = $request->operator;
        $payment->amount = $request->amount;
        $payment->paid_at = $request->paid_at;
        if ($payment->save()) {
            $payment->load(['expedition']);
            $entity = $payment->expedition;
            if ($entity->status != 5) {
                $entity->status = STATUT_PAID;
                $entity->updated_at = $payment->paid_at;
                $entity->created_at = $payment->paid_at;
                $entity->save();
            }
            return back()->with('success', "Le paiement a bien été mis à jour !");
        } else {
            return back()->with('error', "Une erreur s'est produite.");
        }
    }

    static function ebilling($data)
    {
        $payment = Paiement::where('expedition_id', $data->id)->first();

        $eb_name = $data->name_exp;
        $eb_amount = $data->amount * 1.025;
        $eb_shortdescription = "Paiment de l'expéditon N°" . $data->code;
        $eb_reference = PaymentController::str_reference(10);
        $eb_email = $data->email_exp;
        $eb_msisdn = $data->phone_exp;

        $expiry_period = 60; // 60 minutes timeout

        // Creating invoice for a merchant
        $merchant_name = config('app.name');

        $ref_pay = Paiement::where('reference', $eb_reference)->first();

        if ($ref_pay) {
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


        $username =  env('USER_NAME');
        $shared_key = env('SHARED_KEY');

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
        //dd($status);
        // Check status <> 200
        if ($status < 200  || $status > 299) {
            //die("Error: call to URL failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
            return back()->with('error', "Une erreur $status s'est produite lors du paiement, Veuillez réessayer !");
        }

        curl_close($curl);

        // Get response in JSON format
        $response = json_decode($json_response, true);

        // Get unique transaction id
        $bill_id = $response['e_bill']['bill_id'];

        if ($payment == null) {
            // Fetch all data (including those not optional) from session
            $data = [
                'expedition' => $data->id,
                'amount' => $eb_amount,
                'description' => $eb_shortdescription,
                'reference' => $eb_reference,
                'status' => STATUT_PENDING,
                'time_out' => $expiry_period,
                'description' => $eb_shortdescription,
                'billing_id' => $bill_id,
            ];

            PaymentController::create($data);
        } else {
            $payment->reference = PaymentController::str_reference(10);
            $payment->ebilling_id = $bill_id;
            $payment->save();
        }

        return $bill_id;
    }

    public function callback_ebilling($entity)
    {
        $expedition = Expedition::find($entity);
        $payment = Paiement::where('expedition', $expedition->id)->first();
        if ($payment->status == STATUT_PAID) {
            $expedition->load(['payment']);
            return view(
                'payment.callback',
                [
                    'expedition' => $expedition,
                    'payment' => $payment,
                    'user' => Auth::user(),
                ]
            )->with('succes', 'Votre paiment a bien été reçu.');
        } else {
            $expedition->status = STATUT_PENDING;
            $expedition->save();
            return redirect('/list-refills')->with('warning', "Votre paiement n'a pas été reçu.");;
        }
    }

    public function notify_ebilling()
    {
        if (isset($_POST['reference'])) {
            $payment = Paiement::where('reference', $_POST['reference'])->first();
            if ($payment) {
                $payment->status = STATUT_PAID;
                $payment->transaction_id = $_POST['transactionid'];
                $payment->operator = $_POST['paymentsystem'];
                $payment->amount = $_POST['amount'];
                $payment->paid_at = date('Y-m-d H:i');
                $payment->save();

                $expedition = Paiement::where('expedition_id', $payment->expedition_id)->first();
                $expedition->status = STATUT_PAID;
                $expedition->updated_at = date('Y-m-d H:i');
                $expedition->created_at = date('Y-m-d H:i');
                $expedition->save();

                try {
                    Mail::to($expedition->email_exp)->send(new PaidMessage($payment));
                } catch (Exception $e) {
                    return http_response_code(201);
                }
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
