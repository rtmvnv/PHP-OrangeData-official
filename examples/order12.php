<?php

include_once '../orangedata_client.php'; // path to orangedata_client.php

$buyer = null;

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

  $orderId = '1282';

  $order = [
      'ffdVersion' => 4,
      'id' => $orderId,
      'type' => 1,
      'customerContact' => 'example@example.com',
      'taxationSystem' => 1,
      'key' => '999',
      'group' => 'main_2',
      "ignoreItemCodeCheck" => true
  ];

  $position1 = [
      'quantity' => 1.000,
      'price' => 123.45,
      'tax' => 6,
      'text' => "Булка",
      'paymentMethodType' => 4,
      'paymentSubjectType' => 33,
      'agentType' => 127,
      "agentInfo" => [
        "paymentTransferOperatorPhoneNumbers" => ["+79200000001", "+74997870001"],
        "paymentAgentOperation" => "Какая-то операция 1",
        "paymentAgentPhoneNumbers" => ["+79200000003"],
        "paymentOperatorPhoneNumbers" => ["+79200000002", "+74997870002"],
        "paymentOperatorName" => "ООО \"Атлант\"",
        "paymentOperatorAddress" => "Воронеж, ул. Недогонная, д. 84",
        "paymentOperatorINN" => "7727257386"
      ],
      "additionalAttribute" => "Доп. атрибут и все тут",
      "manufacturerCountryCode" => "643",
      "customsDeclarationNumber" => "АД 11/77 от 01.08.2018",
      "excise" => 23.45,
      "unitTaxSum" => 0.23,
      "itemCode" => "010460406000600021N4N57RSCBUZTQ24030040029101612181724010191ffd092tIAF/YVoU4roQS3M/m4z78yFq0fc/WsSmLeX5QkF/YVWwy8IMYAeiQ91Xa2z/fFSJcOkb2N+uUUmfr4n0mOX0Q==",
      "plannedStatus" => 2,
      "fractionalQuantity" => [
          "numerator" => 1,
          "denominator" => 2
      ],
      "industryAttribute" => [
          "foivId" => "012",
          "causeDocumentDate" => "12.08.2021",
          "causeDocumentNumber" => "666",
          "value" => "position industry"
      ]
  ];

  $position2 = [
    "quantity" => 2.000,
    "price" => 4.45,
    "tax" => 4,
    "text" => "Спички",
    "paymentMethodType" => 3,
    "paymentSubjectType" => 13,
    "supplierINN" => "9715225506",
    "supplierInfo" => [
        "phoneNumbers" => ["+79266660011", "+79266660022"],
        "name" => "ПАО \"Адамас\""
    ],
    "quantityMeasurementUnit" => 10
  ];

  $payment1 = [
    "type" => 1,
    "amount" => 123.45
  ];

  $payment2 = [
    "type" => 2,
    "amount" => 8.90000
  ];

  $userAttribute = [
    "name" => "Любимая цитата",
    "value" => "В здоровом теле здоровый дух, этот лозунг еще не потух!"
  ];

  $additional = [
    'additionalAttribute' => 'Доп атрибут чека',
    "senderEmail" => "example@example.com", 
    "customerInfo" => [
          "name"=> "Кузнецов Иван Петрович",
          "inn"=> "828021964975",
          "birthDate"=> "15.09.1988",
          "citizenship"=> "643",
          "identityDocumentCode"=> "01",
          "identityDocumentData"=> "multipassport",
          "address"=> "Басеенная 36"
    ]
  ];

  /** Create client new order **/
  $buyer->create_order($order)
        ->add_position_to_order($position1)
        ->add_position_to_order($position2)
        ->add_payment_to_order($payment1)
        ->add_payment_to_order($payment2)
        ->add_user_attribute($userAttribute)
        ->add_additional_attributes($additional)
  ;

  $result = $buyer->send_order(); // Send order
  var_dump($result); // View response

  /** View status of order **/
  echo "Order status:" . PHP_EOL;
  $order_status = $buyer->get_order_status($orderId);
  var_dump($order_status);

} catch (Exception $ex) {
  echo 'Errors:' . PHP_EOL . $ex->getMessage();
}

