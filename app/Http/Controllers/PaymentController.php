<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;


class PaymentController extends Controller
{
    public function checkout(Course $course) {
        return view('payment.checkout', compact('course'));
    }

    public function pay(Course $course){
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('services.paypal.client_id'),     // ClientID
                config('services.paypal.client_secret')     // ClientSecret
            )
        );

        // After Step 2
$payer = new \PayPal\Api\Payer();
$payer->setPaymentMethod('paypal');

$amount = new \PayPal\Api\Amount();
$amount->setTotal($course->price->value);
$amount->setCurrency('USD');

$transaction = new \PayPal\Api\Transaction();
$transaction->setAmount($amount);

$redirectUrls = new \PayPal\Api\RedirectUrls();
$redirectUrls->setReturnUrl(route('payment.approved', $course))
    ->setCancelUrl(route('payment.checkout', $course));

$payment = new \PayPal\Api\Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setTransactions(array($transaction))
    ->setRedirectUrls($redirectUrls);


    // After Step 3
try {
    $payment->create($apiContext);
    // url de paypal
    return redirect()->away($payment->getApprovalLink());
}
catch (\PayPal\Exception\PayPalConnectionException $ex) {
    // This will print the detailed information on the exception.
    //REALLY HELPFUL FOR DEBUGGING
    echo $ex->getData();
}
    }


    public function approved(Request $request, Course $course){
        
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('services.paypal.client_id'),     // ClientID
                config('services.paypal.client_secret')     // ClientSecret
            )
        );

        $paymentId = $_GET['paymentId'];
        $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);

        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);
        
        $payment->execute($execution, $apiContext);
        // las lineas de arriba son para procesar el pagp

        // matricular despues de pagar
        $course->students()->attach(auth()->user()->id);
        // auth()->user() - recuperamos el id de usuario actualmente autentificado
        // aqui recuperamos la relacion muchos a muchos de students
        // Attach sirve para agregar relaciones muchos a muchos - from google

        return redirect()->route('courses.status', $course);
    }
}
