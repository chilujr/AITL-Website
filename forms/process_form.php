<?php
require_once '../PHPFormBuilder/PhpFormBuilder.php';
require_once '../PHPMailer/PHPMailer.php';
require_once '../PHPMailer/SMTP.php';

// Create a new form instance
$new_form = new PhpFormBuilder();

// Define your form fields
$form->add('text', 'name', 'Name')->required();
$form->add('email', 'email', 'Email')->required();
$form->add('text', 'subject', 'Subject')->required();
$form->add('textarea', 'message', 'Message')->required();

// Process the form
if ($form->isValid()) {
    // Form is valid, send email
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
    $mailer->Body = "Name: {$form->getValue('name')}\nEmail: {$form->getValue('email')}\nMessage: {$form->getValue('message')}";

    if ($mailer->send()) {
        echo 'Email sent successfully!';
    } else {
        echo 'Error sending email: ' . $mailer->ErrorInfo;
    }
} else {
    // Form has validation errors
    echo 'Form validation errors:';
    print_r($form->getValidationErrors());
}
?>
