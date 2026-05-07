<?php
// Test SMS sending
$account_sid = 'YOUR_TWILIO_ACCOUNT_SID';
$auth_token = 'YOUR_TWILIO_AUTH_TOKEN';
$twilio_number = 'YOUR_TWILIO_PHONE_NUMBER';
$to_phone = '+91xxxxxxxxxx'; // Replace with your phone number for testing

$url = "https://api.twilio.com/2010-04-01/Accounts/$account_sid/Messages.json";
$data = array(
    'From' => $twilio_number,
    'To' => $to_phone,
    'Body' => 'Test SMS from your website'
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_USERPWD, $account_sid . ':' . $auth_token);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $http_code<br>";
echo "Response: $response<br>";

$response_data = json_decode($response, true);
if ($http_code == 201 && isset($response_data['sid'])) {
    echo "SMS sent successfully!";
} else {
    echo "SMS failed. Error: " . ($response_data['message'] ?? 'Unknown');
}
?>