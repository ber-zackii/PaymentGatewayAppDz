<?php

$webLink=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://$_SERVER[HTTP_HOST]";


use Chargily\ePay\Chargily;
require './vendor/autoload.php';

$epay_config = require 'epay-config.php';



if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $amount = $_POST['amount'];
    $message = $_POST['message'];

    $chargily = new Chargily([
        'api_key' => $epay_config['key'],
        'api_secret' => $epay_config['secret'],
        'urls' => [
            'back_url' => "$webLink/support-app/success.php", 
            'webhook_url' => "$webLink/support-app/process.php", 
        ],
        //mode
        'mode' => 'EDAHABIA', //OR CIB
        'payment' => [
            'number' => '5487821', // Payment or order number
            'client_name' => $name, // Client name
            'client_email' =>$email, // This is where client receive payment receipt after confirmation
            'amount' => $amount, //this the amount must be greater than or equal 75 
            'discount' => 0, //this is discount percentage between 0 and 99
            'description' => $message, // this is the payment description
    
        ]
    ]);
    
    
        $redirectUrl = $chargily->getRedirectUrl();
        if ($redirectUrl) {
            header('Location: ' . $redirectUrl);
        } else {
            echo "We can't redirect to your payment now";
        }
   
    


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* لون الخلفية العام */
        }
        .card {
            background-color: #ffffff; 
            border-radius: 8px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        }
        h2 {
            color: #007bff; 
        }
        .btn-outline-primary {
            color: #007bff;
            border-color: #007bff;
        }
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #ffffff;
        }
        .btn-primary {
            background-color: #28a745; 
            border-color: #28a745;
        }
        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Support & Send Money</h2>
    
    <div class="card p-4">
        <form  method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="mb-3">
                <div class="btn-group w-100" role="group" aria-label="Select Amount">
                    <button type="button" class="btn btn-outline-primary" onclick="setAmount(100)">100 D.A</button>
                    <button type="button" class="btn btn-outline-primary" onclick="setAmount(200)">200 D.A</button>
                    <button type="button" class="btn btn-outline-primary" onclick="setAmount(500)">500 D.A</button>
                    <button type="button" class="btn btn-outline-primary" onclick="setAmount(1000)">1000 D.A</button>
                    <button type="button" class="btn btn-outline-primary" onclick="setAmount(2000)">2000 D.A</button>
                    <button type="button" class="btn btn-outline-primary" onclick="setAmount(5000)">5000 D.A</button>
                </div>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message (Optional)</label>
                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Support</button>
        </form>
    </div>
</div>

<script>
    function setAmount(value) {
        document.getElementById('amount').value = value;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
