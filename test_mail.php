<?php
$to = "your-email@example.com"; // Replace with your email
$subject = "SMTP Test Email";
$message = "This is a test email to check if PHP mail() is working.";
$headers = "From: no-reply@example.com"; // Replace with a valid sender email

if (mail($to, $subject, $message, $headers)) {
    echo "Mail function is working. Check your inbox.";
} else {
    echo "Mail function failed. SMTP might not be configured.";
}
?>
