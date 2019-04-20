<?php

$ToEmail = 'naborus@yahoo.ca';
$EmailSubject = 'Portfolio Contact Me '.$_POST["name"];
$MESSAGE_BODY = "Name: ".$_POST["name"]."\n".
                "Email: ".$_POST["email"]."\n\n".
                $_POST["message"];
$header = "From: ".$_POST["email"];

mail($ToEmail, $EmailSubject, $MESSAGE_BODY, $header) or die("NOP");

?>