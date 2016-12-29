<?php
require 'vendor/autoload.php';
if (isset($_POST['email'])) {



    // ADD YOUR EMAIL WHERE YOU WANT TO RECIEVE THE MESSAGES

    $email_to = "piotr@geosystem3d.pl";

    $email_subject = "GEOSYSTEM3D - Formularz kontaktowy";

    function died($error) {

        // your error code can go here

        echo '<div class="alert alert-danger alert-dismissible wow fadeInUp" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Something is wrong:</strong><br>';

        echo $error . "<br />";

        echo '</div>';

        die();
    }

    // validation expected data exists

    if (!isset($_POST['name']) ||
            !isset($_POST['email']) ||
            // !isset($_POST['phone']) || // un-commet for required
            !isset($_POST['message'])) {

        died('We are sorry, but there appears to be a problem with the form you submitted.');
    }



    $name = $_POST['name']; // required

    $email_from = $_POST['email']; // required

    $telephone = $_POST['phone']; // not required

    $message = $_POST['message']; // required



    $error_message = "";

    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email_from)) {

        $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $name)) {

        $error_message .= 'The First Name you entered does not appear to be valid.<br />';
    }

    if (strlen($message) < 2) {

        $error_message .= 'The message you entered do not appear to be valid.<br />';
    }

    if (strlen($error_message) > 0) {

        died($error_message);
    }

    $email_message = "Form details below.\n\n";

    function clean_string($string) {

        $bad = array("content-type", "bcc:", "to:", "cc:", "href");

        return str_replace($bad, "", $string);
    }

    $email_message .= "Name: " . clean_string($name) . "\n";

    $email_message .= "Email: " . clean_string($email_from) . "\n";

    $email_message .= "Telephone: " . clean_string($telephone) . "\n";

    $email_message .= "Message: " . clean_string($message) . "\n";



// create email

    $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'ssl0.ovh.net';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'piotr@geosystem3d.pl';                 // SMTP username
    $mail->Password = 'password';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    $mail->setFrom($email_from, $name);
    $mail->addAddress('piotr@geosystem3d.pl', 'Piotr');     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo($email_from, $name);
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
    print_r($_FILES);
    if (!empty($_FILES)) {
        print_r($_FILES);

        $fileName = $_FILES['files']['name'];

        print_r($fileName);
    }



//$mail->AddAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name


    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'GEOSYSTEM3D Contact form';
    $mail->Body = $email_message;
//    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        ?>
        <div class="alert alert-success alert-dismissible wow fadeInUp" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Your message has been sent.
        </div>

    <?php } ?>


<?php } ?>