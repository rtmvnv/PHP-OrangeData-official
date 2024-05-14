<?php

include_once '../orangedata_client.php'; // path to orangedata_client.php

try {
  $client = [
    'inn' => '0123456789',
    'api_url' => '2443',
    // 'api_url' => 'https://apip.orangedata.ru:2443', // link access
    'sign_pkey' => dirname(__DIR__) . '/secure_path/private_key.pem',
    'ssl_client_key' => dirname(__DIR__) . '/secure_path/client.key',
    'ssl_client_crt' => dirname(__DIR__) . '/secure_path/client.crt',
    'ssl_ca_cert' => dirname(__DIR__) . '/secure_path/cacert.pem',
    'ssl_client_crt_pass' => 1234,
  ];

  $buyer = new orangedata\orangedata_client($client); // create new client

  // $buyer->is_debug(); // for write curl.log file

  $correctionId = 1281;

  $correction = [
    "id" => $correctionId,
    "description" => "Описание",
    "group" => "Main",
    "key" => "999",
    "ignoreItemCodeCheck" => true,
    "type" => 1,
    "taxationSystem" => 0,
    "correctionType" => 0,
    "causeDocumentDate" => new \DateTime(),
    "causeDocumentNumber" => "1",
    "totalSum" => "100.00",
    "cashSum" => 0,
    "eCashSum" => "100",
    "prepaymentSum" => 0,
    "postpaymentSum" => 0,
    "otherPaymentTypeSum" => 0,
    "tax1Sum" => 0,
    "tax2Sum" => 0,
    "tax3Sum" => 0,
    "tax4Sum" => 0,
    "tax5Sum" => 0,
    "tax6Sum" => 0,
    "checkClose" => false
  ];

/*   $correctionVending = [
    'automatNumber' => '21321321123',
    'settlementAddress' => 'Address',
    'settlementPlace' => 'Place',
  ]; */

  $buyer
  ->create_correction($correction)
/*   ->add_vending_to_correction($correctionVending); // Create correction */
  ;
  $result = $buyer->post_correction(); // Send correction
  var_dump($result); // View response
} catch (Exception $ex) {
  echo 'Errors:' . PHP_EOL . $ex->getMessage();
}

/** View status of correction **/
try {
  $cor_status = $buyer->get_correction_status($correctionId);
  var_dump($cor_status);
} catch (Exception $ex) {
  echo 'Ошибка:' . PHP_EOL . $ex->getMessage();
}

?>
