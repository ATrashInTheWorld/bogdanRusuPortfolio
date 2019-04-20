<?php
$message = "";
$a = "";
$b = "";
$c = "";
$d = "";
$e = "";
$f = "";
$g = "";
$h = "";
$i = "";
$j = "";
$k = "";
$l = "";
$m = "";
if(!isset($_GET["opt"]))
    $message .= "Please enter a delivery option <br>";
else
    $a = $_GET["opt"];

if(empty($_GET["na"]))
    $message .="Please enter your full name <br>";
else
    $b = $_GET["na"];

if(empty($_GET["addr"]))
    $message .= "Please enter an address <br>";
else
    $c = $_GET["addr"];

if(empty($_GET["cit"]))
    $message .= "Please enter the city <br>";
else
    $d = $_GET["cit"];

if(empty($_GET["st"]))
    $message .= "Please enter the State <br>";
else
    $e = $_GET["st"];

if(empty($_GET["zip"]))
    $message .= "Please enter the Zip <br>";
else
    $f = $_GET["zip"];

if(empty($_GET["pn"]))
    $message .= "Please enter your phone Number <br>";
else
    $g = $_GET["pn"];

if(empty($_GET["em"]))
    $message .= "Please enter an email address <br>";
else
    $h = $_GET["em"];

if(!isset($_GET["popt"]))
    $message .= "Please select a payment method <br>";
else
    $i = $_GET["popt"];

if(empty($_GET["ch"]))
    $message .= "Please enter the Card Holder name <br>";
else
    $j = $_GET["ch"];

if(empty($_GET["cn"]))
    $message .= "Please enter a card's number <br>";
else
    $k = $_GET["cn"];

if(empty($_GET["ced"]))
    $message .= "Please enter the card's expiration date <br>";
else
    $l = $_GET["ced"];

if(empty($_GET["csc"]))
    $message .= "Please enter the card's security number <br>";
else
    $m = $_GET["csc"];


if($message!="")
    header("Location: Order.php?me=".$message."&a=".$a."&b=".$b."&c=".$c."&d=".$d."&e=".$e."&f=".$f."&g=".$g."&h=".$h."&i=".$i."&j=".$j."&k=".$k."&l=".$l."&m=".$m."");

else
    header("Location: Confirm.php?&a=".$a."&b=".$b."&c=".$c."&d=".$d."&e=".$e."&f=".$f."&g=".$g."&h=".$h."&i=".$i."&j=".$j."&k=".$k."&l=".$l."&m=".$m."&p=".$_GET["prices"]."");

?>