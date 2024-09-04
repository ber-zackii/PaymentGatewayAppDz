<?php

require 'path-to-vendor/vendor/autoload.php';

use Chargily\ePay\Chargily;

$epay_config = require 'epay_config.php';

$chargily = new Chargily([
    'api_key' => $epay_config['key'],
    'api_secret' => $epay_config['secret'],
]);

// Get the raw POST data
$input = file_get_contents('php://input');

// Parse the JSON data
$data = json_decode($input, true);

if (isset($data['transaction_id']) && isset($data['status'])) {
    // Process the payment
    $transactionId = $data['transaction_id'];
    $status = $data['status'];
    
    // Verify the payment using Chargily's API
    $paymentDetails = $chargily->verifyPayment($transactionId);
    
    if ($paymentDetails && $paymentDetails['status'] == 'success') {
        // Update your system with payment information
        // For example, mark the order as paid in your database
        
        // Your database update logic here
        // Example:
        // $orderId = $paymentDetails['order_number'];
        // updateOrderStatus($orderId, 'paid');
        
        echo "Payment processed successfully";
    } else {
        echo "Payment verification failed";
    }
} else {
    echo "Invalid webhook data";
}

?>
