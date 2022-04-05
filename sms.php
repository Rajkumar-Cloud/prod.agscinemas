<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"614d7ca85b09c4350137435a\",\n  \"sender\": \"AGSETK\",\n  \"mobiles\": \"6374434847\",\n  \"VAR1\": \"Dear AGS Customer, your OTP for Completion of Account Registration is 0000 This will expire in 30 Minutes.\"}",
  CURLOPT_HTTPHEADER => array(
    "authkey: ",
    "content-type: application/JSON"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
?>