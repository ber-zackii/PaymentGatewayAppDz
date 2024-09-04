<?php 

use Chargily\ePay\Chargily;

require 'path-to-vendor/vendor/autoload.php';

$epay_config = require 'epay_config.php';

$chargily = new Chargily([
    //credentials
    'api_key' => $epay_config['key'],
    'api_secret' => $epay_config['secret'],
]);

if ($chargily->checkResponse()) {
    $response = $chargily->getResponseDetails();
   echo $response;
    exit('OK');
}

 

?>