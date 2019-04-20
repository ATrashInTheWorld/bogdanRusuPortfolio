<?php
include "Includes.php";

$discounts = openfile();
$tempolist = array();
foreach ($discounts as $val){
    if($val[0]!=$_GET["id"])
        array_push($tempolist, $val);
    else
        continue;
}

file_put_contents("Discounts.txt",$tempolist);
header("Location: AdminDiscounts.php");
?>