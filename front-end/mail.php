<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log errors to a file
ini_set('log_errors', 1);
ini_set('error_log', 'errors.log');

// Trim and sanitize input data
$name = trim($_POST['contact-name']);
$phone = trim($_POST['contact-phone']);
$email = trim($_POST['contact-email']);
$subject = trim($_POST['subject']);
$message = trim($_POST['contact-message']);

$msg = [];

// Check if the message is empty
if ($message == "") {
    $msg['err'] = "Message cannot be empty!";
    $msg['field'] = "contact-message";
    $msg['code'] = FALSE;
} else {
    // Set default values if name or email is not provided
    if ($name == "") {
        $name = "Anonymous";
    }

    if ($email == "") {
        $email = "anonymous@example.com";
    }

    // Email details
    $to = 'emmanuel.k.makau.jr.26@dartmouth.edu';
    $email_subject = 'inbio Contact Query: ' . ($subject != "" ? $subject : "No Subject");

    // Email content
    $_message = '<html><head></head><body>';
    $_message .= '<p><strong>Name:</strong> ' . htmlspecialchars($name) . '</p>';
    $_message .= '<p><strong>Phone:</strong> ' . htmlspecialchars($phone) . '</p>';
    $_message .= '<p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>';
    $_message .= '<p><strong>Message:</strong> ' . nl2br(htmlspecialchars($message)) . '</p>';
    $_message .= '</body></html>';

    // Email headers
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: inbio <contact@example.com>' . "\r\n";
    $headers .= 'Cc: emmanuel.k.makau.jr.26@dartmouth.edu' . "\r\n";
    $headers .= 'Bcc: emmanuel.k.makau.jr.26@dartmouth.edu' . "\r\n";

    // Send the email
    if (mail($to, $email_subject, $_message, $headers)) {
        $msg['success'] = "Email has been sent successfully.";
        $msg['code'] = TRUE;
    } else {
        $msg['err'] = "Failed to send email. Please try again later.";
        $msg['code'] = FALSE;

        // Log the error
        error_log("Mail function failed. Name: $name, Email: $email, Phone: $phone, Subject: $subject, Message: $message");
    }
}

echo json_encode($msg);
?>