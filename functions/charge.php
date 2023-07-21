<?php
require 'vendor/autoload.php';
// This is your real test secret API key.
\Stripe\Stripe::setApiKey('sk_test_r747hWZh0AjBDSgtLUmQd0vD');
header('Content-Type: application/json');
try {
  // retrieve JSON from POST body
  $json_str = file_get_contents('php://input');
  $json_obj = json_decode($json_str);
  // Look up the available cards stored on your Customer
  $payment_methods = \Stripe\PaymentMethod::all([
    'customer' => $json_obj->customer,
    'type' => 'card'
  ]);
  // Charge the customer and card immediately
  $payment_intent = \Stripe\PaymentIntent::create([
    'amount' => 1099,
    'currency' => 'usd',
    'customer' => $json_obj->customer,
    'payment_method' => $payment_methods->data[0]->id,
    'off_session' => true,
    'confirm' => true
  ]);
  echo json_encode([
    'paymentIntent' => $payment_intent,
  ]);
} catch (Error $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}