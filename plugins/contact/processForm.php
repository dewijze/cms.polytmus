<?php

function SendMail()
{
    //If a bot fills in the hidden fake mail field -> exit
    if (isset($_POST["mail"]) && !empty($_POST["mail"])) {
        exit;
    }
    // Clean up the input values
    foreach($_POST as $key => $value) {
        if(ini_get('magic_quotes_gpc')) {
            $_POST[$key] = stripslashes($_POST[$key]); 
        }
        
        $_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
    }

    // Assign the input values to variables for easy reference
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    // Test input values for errors
    $errors = array();
    if(strlen($name) < 2) {
        if(!$name) {
            $errors[] = "You must enter a name.";
        } else {
            $errors[] = "Name must be at least 2 characters.";
        }
    }
    if(!$email) {
        $errors[] = "You must enter an email.";
    } else if(!validEmail($email)) {
        $errors[] = "You must enter a valid email.";
    }
    if(strlen($message) < 10) {
        if(!$message) {
            $errors[] = "You must enter a phone number.";
        } else {
            $errors[] = "Phone numbers are at least 10 characters.";
        }
    }
    if(strlen($message) < 10) {
        if(!$message) {
            $errors[] = "You must enter a message.";
        } else {
            $errors[] = "Message must be at least 10 characters.";
        }
    }

    if($errors) {
        // Output errors and die with a failure message
        $errortext = "";
        foreach($errors as $error) {
            $errortext .= "<li>".$error."</li>";
        }
        die("<span class='failure'>The following errors occured:<ul>". $errortext ."</ul></span>");
    }

    // Gather and sort info

    $to = file_get_contents('../../files/global/global_email');
    if (!$to) {
        $to = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/files/global/global_email');
    }
    if ($to) {
        $to_array = array_map('trim', explode("<br />", preg_replace("/[\n]/","",$to)));
    } else {
        return;
    }

    $subject = "Contact Form: $name";
    $message = "$message \n\nName: $name \n\nPhone: $phone";
    $headers = "From: $email";

    // Send the email
    foreach ($to_array as $to){
        mail($to, $subject, $message, $headers);
    }

    // Die with a success message
    die("<span class='success'>Success! Your message has been sent.</span>");

}

// A function that checks to see if
// an email is valid
function validEmail($email)
{
    $isValid = true;
    $atIndex = strrpos($email, "@");
    if (is_bool($atIndex) && !$atIndex) {
        $isValid = false;
    }
    else
    {
        $domain = substr($email, $atIndex+1);
        $local = substr($email, 0, $atIndex);
        $localLen = strlen($local);
        $domainLen = strlen($domain);
        if ($localLen < 1 || $localLen > 64) {
            // local part length exceeded
            $isValid = false;
        }
        else if ($domainLen < 1 || $domainLen > 255) {
            // domain part length exceeded
            $isValid = false;
        }
        else if ($local[0] == '.' || $local[$localLen-1] == '.') {
            // local part starts or ends with '.'
            $isValid = false;
        }
        else if (preg_match('/\\.\\./', $local)) {
            // local part has two consecutive dots
            $isValid = false;
        }
        else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
            // character not valid in domain part
            $isValid = false;
        }
        else if (preg_match('/\\.\\./', $domain)) {
            // domain part has two consecutive dots
            $isValid = false;
        }
        else if(!preg_match(
            '/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
            str_replace("\\\\", "", $local)
        )) {
            // character not valid in local part unless 
            // local part is quoted
            if (!preg_match(
                '/^"(\\\\"|[^"])+"$/',
                str_replace("\\\\", "", $local)
            )) {
                $isValid = false;
            }
        }
        if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
            // domain not found in DNS
            $isValid = false;
        }
    }
    return $isValid;
}
SendMail();

?>
