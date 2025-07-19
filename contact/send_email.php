<?php

if(isset($_POST['email'])) {

  $email_to = "dominic@lamantiaenterprises.com";
  $email_from = "Website Contact <no-reply@lamantiaenterprises.com>";

  $email_subject = "La Mantia Enterprises Contact Submission";


  function alertAndEnd($alertString) {

    echo '<script language="javascript">';
    echo 'alert("' . $alertString . '");';
    if(strpos($alertString, "**") === false) {
      echo 'window.parent.document.getElementById("contact").reset();';
    }
    echo '</script>';

    die();

  }


  $name = $_POST['name']; // required

  $address = $_POST['address']; // required

  $phone = $_POST['phone']; // required

  $email_reply = $_POST['email']; // required

  $message = $_POST['message']; // required
  

  $error_message = "";

  if (strlen($name) == 0 || strlen($address) == 0 || strlen($email_reply) == 0 || strlen($phone) == 0 || strlen($message) == 0) {
    $error_message .= "**Please fill out all fields of the form**\\n";
  }

  $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
   
  if(!preg_match($email_exp,$email_reply)) {
    $error_message .= "**The email address you entered does not appear to be valid**";
  }

  if(strlen($error_message) > 0) {
    alertAndEnd($error_message);
  }


  $email_message = "Website contact details below.\n\n";


  function clean_string($string) {

    $bad = array("content-type","bcc:","to:","cc:","href");

    return str_replace($bad,"",$string);

  }


  $email_message .= "Name: ".clean_string($name)."\n";

  $email_message .= "Address: ".clean_string($address)."\n";

  $email_message .= "Phone: ".clean_string($phone)."\n";

  $email_message .= "Email: ".clean_string($email_reply)."\n";

  $email_message .= "Message: ".clean_string($message)."\n";


  // create email headers

  $headers = 'From: '.$email_from."\r\n".

  'Reply-To: '.$email_reply."\r\n" .

  'X-Mailer: PHP/' . phpversion();

  @mail($email_to, $email_subject, $email_message, $headers);

  alertAndEnd("Thank you for contacting us. We will be in touch with you very soon.");

}

?>