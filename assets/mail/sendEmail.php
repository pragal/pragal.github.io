<?php
$siteOwnersEmail = 'prspraga@gmail.com';

if($_POST) {

$name = trim(stripslashes($_POST['name']));
$email = trim(stripslashes($_POST['email']));
$subject = trim(stripslashes($_POST['subject']));
$contact_message = trim(stripslashes($_POST['comments']));
$error = array();

// Check Name
if (strlen($name) < 2) {
    $error['name'] = "Please enter your name.";
}
// Check Email
if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
    $error['email'] = "Please enter a valid email address.";
}
// Check Message
if (strlen($contact_message) < 15) {
    $error['message'] = "Your message should have at least 15 characters.";
}
// Subject
if ($subject == '') {
    $subject = "Contact Form Submission";
}


// Set Message
$message = "<b>Name: </b>" . $name . "<br />";
$message .= "<b>Email Address: </b>" . $email . "<br /><br />";
$message .= "<b>Message: </b><br />";
$message .= $contact_message;
$message .= "<br /><br />----- <br /><br /> This email was sent from your site's <b> <a href='www.pragal.in'>Pragalathan Marimuthu</a></b> contact form. <br />";

// Set From: header
$from =  $name . " <" . $email . ">";

// Email Headers
$headers = "From: " . $from . "\r\n";
$headers .= "Reply-To: ". $email . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


if ( empty($error) ) {

    ini_set("sendmail_from", $siteOwnersEmail); // for windows server
    $mail = mail($siteOwnersEmail, $subject, $message, $headers);

    if ($mail) {
        $error['status'] = "Congratulation";
        $error['message'] = "Your message has been sent successfully!";
        echo json_encode($error);
    } else {
        $error['status'] = "Error";
        $error['message'] = "Oops...! Something went wrong, Try again later!";
        echo json_encode($error);
    }

} # end if - no validation error

else {
    $error['status'] = "Error";
    $error['message'] = "Unable to send! Looks like your message is incomplete.";
    echo json_encode($error);

} # end else - there was a validation error

}
?>
