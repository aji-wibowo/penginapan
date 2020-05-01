<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.irvankede-smm.co.id/services/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => array('api_id' => '2997','api_key' => '36b69a-6d6772-0a14d4-117bd7-2acaeb'),
));

$response = curl_exec($curl);

curl_close($curl);

$array = json_decode($response);



echo '<pre>';
var_dump($array);

print_r($array->data);

foreach ($array->data as $row) {
	$row->name;
}