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

  $orderId = '1280';

  $order = [
    'id' => $orderId,
    'customerContact' => 'test@aqsi.ru',
    'key' => '999',
    'ignoreItemCodeCheck' => false,
    "type" => 1,
    "ffdVersion" => 2,
    'group' => 'main',
    "taxationSystem" => 0,
  ];

  $position1 = [
    "quantity" => 1,
    "price" => "100",
    "tax" => 1,
    "text" => "Товар 1",
    "paymentMethodType" => 1,
    "paymentSubjectType" => 1
  ];

  $position2 = [
    "quantity" => 1,
    "price" => "200",
    "tax" => 6,
    "text" => "Товар 2",
    "paymentMethodType" => 4,
    "paymentSubjectType" => 1
  ];

  $position3 = [
    "quantity" => 1,
    "price" => "300",
    "tax" => 6,
    "text" => "Товар 3",
    "paymentMethodType" => 3,
    "paymentSubjectType" => 1,
    "supplierINN" => "7727401209",
    "supplierInfo" => [
        "name" => "ооо поставщик"
    ],
    "agentType" => 32
  ];

  $payment = [
    "type" => 2,
    "amount" => 600
  ];

  $agent = [
    "agentType" => 64
  ];

  $userAttribute = [
    "name" => "Номер заказа",
    "value" => "1"
  ];

  $additional = [
    "customer" => "Иван",
    "customerINN" => "7727401209",
    "additionalAttribute" => "2"
  ];

/*   $vending = [
    'automatNumber' => '21321321123',
    'settlementAddress' => 'Address',
    'settlementPlace' => 'Place',
  ]; */

  /** Create client new order **/
  $buyer->create_order($order)
        ->add_position_to_order($position1)
        ->add_position_to_order($position2)
        ->add_position_to_order($position3)
        ->add_payment_to_order($payment)
        ->add_agent_to_order($agent)
        ->add_user_attribute($userAttribute)
        ->add_additional_attributes($additional)
/*         ->add_vending_to_order($vending) */
  ;
  $result = $buyer->send_order(); // Send order
  var_dump($result); // View response
} catch (Exception $ex) {
  echo 'Errors:' . PHP_EOL . $ex->getMessage();
}

/** View status of order **/
try {
  $order_status = $buyer->get_order_status($orderId);
  var_dump($order_status);
} catch (Exception $ex) {
  echo 'Ошибка:' . PHP_EOL . $ex->getMessage();
}

?>
