<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- IMPORTANT: Change this to your email address ---
    $recipient_email = "your-email@example.com"; 

    // Sanitize input data to prevent security issues
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);

    // Basic validation
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // If validation fails, send an error response
        http_response_code(400);
        echo "Please fill out all fields and provide a valid email address.";
        exit;
    }

    // Email subject
    $subject = "New Contact from Rick's Website: $name";

    // Email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $email_headers = "From: $name <$email>";

    // Send the email
    if (mail($recipient_email, $subject, $email_content, $email_headers)) {
        // If the email is sent successfully, redirect to a thank you page
        // Create a 'thankyou.html' page with a success message
        header("Location: thankyou.html"); 
    } else {
        // If it fails, send an error response
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }

} else {
    // Not a POST request, send a 403 forbidden error
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>