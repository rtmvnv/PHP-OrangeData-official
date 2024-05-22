<?php

include_once '../orangedata_client.php'; // path to orangedata_client.php

try {
  $client = [
    'inn' => '7725327863',
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

  $correctionId = '1285';

  $correction = [
      'id' => $correctionId,
      "group" => "main_2",
      "key" => "999",
      "ffdVersion" => 4,
      "ignoreItemCodeCheck" => true,
      "type" => 1,
      "correctionType" => 0,
      "causeDocumentDate" => new \DateTime(),
      "causeDocumentNumber" => "12312",
      "taxationSystem" => 0,
      "customerContact" => 'example@example.com'
  ];

  $correctionPosition1 = [
    "tax" => 1,
    "paymentMethodType" => 1,
    "paymentSubjectType" => 1,
    "quantity" => 1,
    "quantityMeasurementUnit" => 0,
    "text" => "вввввв",
    "price" => "1000"
  ];

  $correctionPayment1 = [
    "type" => 2,
    "amount" => 1000
  ];

  $userAttribute = [
    "value" => "2132",
    "name" => "21212"
  ];

  $correctionAdditional = [
    "additionalAttribute" => "ыыа",
    "senderEmail" => "example@example.com",
    "vat1Sum" => 1,
    "vat2Sum" => 2,
    "vat3Sum" => 3,
    "vat4Sum" => 4,
    "vat5Sum" => 5,
    "vat6Sum" => 6,
    "customerInfo" => [
        "address" => "ввввввввв",
        "citizenship" => 48,
        "identityDocumentData" => "1236 1231231",
        "identityDocumentCode" => 21,
        "inn" => "7727401209",
        "name" => "яяяяяяяяяяя",
        "birthDate" => "11.04.2024"
    ],
    "operationalAttribute" => [
        "value" => "9999",
        "date" => new \DateTime(),
        "id" => null
    ],
    "industryAttribute" => [
        "foivId" => "012",
        "causeDocumentDate" => "03.04.2024",
        "causeDocumentNumber" => "666",
        "value" => "11111111"
    ]
  ];

  $buyer->create_correction12($correction) // Create correction
    ->add_position_to_correction12($correctionPosition1)
    ->add_payment_to_correction12($correctionPayment1)
    ->add_user_attribute_to_correction12($userAttribute)
    ->add_additional_attributes_to_correction12($correctionAdditional)
;


$result = $buyer->post_correction12(); // Send correction
var_dump($result); // View response
} catch (Exception $ex) {
echo 'Errors:' . PHP_EOL . $ex->getMessage();
}

/** View status of correction **/
try {
$cor_status = $buyer->get_correction_status12($correctionId);
var_dump($cor_status);
} catch (Exception $ex) {
echo 'Ошибка:' . PHP_EOL . $ex->getMessage();
}

