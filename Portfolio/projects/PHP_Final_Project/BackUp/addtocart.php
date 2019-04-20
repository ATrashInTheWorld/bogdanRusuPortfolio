<?php
session_start();
include "Includes.php";

if (!isset($_POST["id"])) {
	//die("HERE");
   //validate item and get title and price
    $get_iteminfo_sql = "SELECT item_title FROM store_items WHERE id ='".$_POST["sel_item_id"]."'";
    $get_iteminfo_res = $mysqli->query($get_iteminfo_sql) or die("Couldn't connect1");

    if ( $get_iteminfo_res->num_rows < 1) {
		//die("HERE1");
   	    //invalid id, send away
   	    header("Location: seestore.php");
   	    exit();
    } else {
		//die("HERE2");
   	    //get info
   	    while ($item_info =  $get_iteminfo_res->fetch_array()) {
   	    	$item_title =  stripslashes($item_info["item_title"]);
		}

   	    //add info to cart table
		
		// Cheking if color and size are used, if not setting them
			// a value in order to not have an error
		///*
		if(empty($_POST["sel_item_color"]))
			$_POST["sel_item_color"] = "NIO";
		if(empty($_POST["sel_item_size"]))
			$_POST["sel_item_size"] = "NIO";
		//*/
		
		$date = date('Y-m-d 00:00:00');
   	    $addtocart_sql = "INSERT INTO store_shoppertrack (session_id, sel_item_id, 
			sel_item_qty, sel_item_size, sel_item_color, date_added) VALUES ('".$_COOKIE["PHPSESSID"]."', 
			'".$_POST["sel_item_id"]."', '".$_POST["sel_item_qty"]."', '".$_POST["sel_item_size"]."', 
			'".$_POST["sel_item_color"]."','".$date."')";
		//	echo $addtocart_sql;
  	    $addtocart_res = $mysqli->query($addtocart_sql) or die($mysqli->error);
		//mysqli_errno($addtocart_res);
	
   	    //redirect to showcart page
   	    header("Location: showcart.php");
  	    exit();
    }

} else {
    //send them somewhere else
		//die("HERE3");
    header("Location: seestore.php");
    exit();
}

$mysqli->close();
?>
