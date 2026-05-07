<?php
if(empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || empty($_POST['phone']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  http_response_code(500);
  exit();
}

$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$m_subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));

// Insert into database
$conn = new mysqli("localhost", "root", "", "coffe_shope");
if ($conn->connect_error) {
    http_response_code(500);
    exit();
}

$stmt = $conn->prepare("INSERT INTO contact (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $phone, $m_subject, $message);
$stmt->execute();
$stmt->close();
$conn->close();

$to = "info@example.com"; // Change this email to your //
$subject = "$m_subject:  $name";
$body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\n\nEmail: $email\n\nSubject: $m_subject\n\nMessage: $message";
$header = "From: $email";
$header .= "Reply-To: $email";	

if(!mail($to, $subject, $body, $header))
  http_response_code(500);

// Send SMS using Twilio
$account_sid = 'YOUR_TWILIO_ACCOUNT_SID';
$auth_token = 'YOUR_TWILIO_AUTH_TOKEN';
$twilio_number = 'YOUR_TWILIO_PHONE_NUMBER';

$url = "https://api.twilio.com/2010-04-01/Accounts/$account_sid/Messages.json";
$data = array(
    'From' => $twilio_number,
    'To' => $phone,
    'Body' => "Thank you for contacting us, $name. We have received your message: $message"
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

// Check if SMS was sent successfully
$response_data = json_decode($response, true);
if ($http_code != 201 || !isset($response_data['sid'])) {
    // SMS failed, log error
    file_put_contents('sms_error.log', date('Y-m-d H:i:s') . " - SMS failed for $phone: " . $response . "\n", FILE_APPEND);
} else {
    // SMS sent successfully
    file_put_contents('sms_success.log', date('Y-m-d H:i:s') . " - SMS sent to $phone\n", FILE_APPEND);
}
?>
