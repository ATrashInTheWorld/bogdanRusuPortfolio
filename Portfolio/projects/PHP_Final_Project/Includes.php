
<?php

     $mysqli = new mysqli("localhost", "phpmyadmin", "pokemon123", "store");
     if($mysqli->connect_error) {
         echo "PROBLEM CONNECTING";
        exit();
     }

function openfile()
{
    if (!file("Discounts.txt"))
        return array();
    else{
        $fileContent = file_get_contents("Discounts.txt");
        $arrOfDiscs = explode("\r\n", $fileContent);
        return $arrOfDiscs;
    }

}

?>
