<?php 

include_once('Config/Config.php');
include_once('Helpers/PayPalHelper.php');
include_once('../api/Config/DBconfig.php');


$rand=rand(1432, 9870);

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

// echo generate_string($permitted_chars, 4);
$randalf=generate_string($permitted_chars, 3);
$pass=strtolower($randalf.$rand);

$paypalHelper = new PayPalHelper;
$randNo= (string)strtoupper(rand(1432, 9870).$randalf.$rand);
$orderData = '{
    "intent" : "CAPTURE",
    "application_context" : {
        "return_url" : "",
        "cancel_url" : ""
    },
    "purchase_units" : [ 
        {
            "reference_id" : "PU1",
            "description" : "VSDC 2020",
            "invoice_id" : "INV-L1VDSC2020-'.$randNo.'",
            "custom_id" : "CUST-VDSC",
            "amount" : {
                "currency_code" : "'.$_POST['currency'].'",
                "value" : "'.$_POST['total_amt'].'",
                "breakdown" : {
                    "item_total" : {
                        "currency_code" : "'.$_POST['currency'].'",
                        "value" : "'.$_POST['item_amt'].'"
                    },
                    "shipping" : {
                        "currency_code" : "'.$_POST['currency'].'",
                        "value" : "'.$_POST['shipping_amt'].'"
                    },
                    "tax_total" : {
                        "currency_code" : "'.$_POST['currency'].'",
                        "value" : "'.$_POST['tax_amt'].'"
                    },
                    "handling" : {
                        "currency_code" : "'.$_POST['currency'].'",
                        "value" : "'.$_POST['handling_fee'].'"
                    },
                    "shipping_discount" : {
                        "currency_code" : "'.$_POST['currency'].'",
                        "value" : "'.$_POST['shipping_discount'].'"
                    },
                    "insurance" : {
                        "currency_code" : "'.$_POST['currency'].'",
                        "value" : "'.$_POST['insurance_fee'].'"
                    }
                }
            },
            "items" : [{
                "name" : "Ticket Live",
                "description" : "Ticket Live Event - VDSC2020",
                "sku" : "L1-VSDC2020",
                "unit_amount" : {
                    "currency_code" : "'.$_POST['currency'].'",
                    "value" : "'.$_POST['item_amt'].'"
                },
                "quantity" : "1",
                "category" : "PHYSICAL_GOODS"
            }]
        }
    ]
}';

 
header('Content-Type: application/json');

echo json_encode($paypalHelper->orderCreate($orderData));






