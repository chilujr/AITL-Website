<?php
require_once '../PHPFormBuilder/PhpFormBuilder.php';
require_once '../PHPMailer/PHPMailer.php';
require_once '../PHPMailer/SMTP.php';

// Create a new form instance
$form = new PhpFormBuilder();

// Define your form fields
$form->add_input('Your Name', ['required' => true], 'name');
$form->add_input('Email', ['required' => true], 'email');
$form->add_input('Subject', ['required' => true], 'subject');
$form->add_input('Message', ['required' => true], 'message');

// Process the form
// Assuming there's no built-in `isValid()` method, you might need to handle validation manually
// For example, check if required fields are set in the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isValid = true;

    foreach (['name', 'email', 'subject', 'message'] as $field) {
        if (empty($_POST[$field])) {
            $isValid = false;
            break;
        }
    }

    if ($isValid) {
        // Form is valid, continue with email sending logic

        $mailer = new PHPMailer\PHPMailer\PHPMailer();
        $mailer->isSMTP();
        $mailer->Host = 'localhost'; // Update with your SMTP host
        $mailer->SMTPAuth = true;
        $mailer->Username = ''; // The business email address
        $mailer->Password = '';
        $mailer->SMTPSecure = 'tls';
        $mailer->Port = 80;

        $mailer->setFrom('your_email@example.com', 'Chilu');
        $mailer->addAddress('recipient@example.com', 'Recipient Name');
        $mailer->Subject = 'Contact Form Submission';
        $mailer->Body = "Name: {$_POST['name']}\nEmail: {$_POST['email']}\nMessage: {$_POST['message']}";

        if ($mailer->send()) {
            echo 'Email sent successfully!';
        } else {
            echo 'Error sending email: ' . $mailer->ErrorInfo;
        }
    } else {
        // Form has validation errors
        echo 'Form validation errors: Some fields are required.';
    }
} else {
    // Display the form or redirect to the form page
    // You might want to redirect to the form page or show the form HTML here
    echo 'Form not submitted.';
}
?>
