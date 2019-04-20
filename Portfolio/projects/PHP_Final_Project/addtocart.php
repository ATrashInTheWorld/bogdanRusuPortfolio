<?php
session_start();
include "Includes.php";
include "Order_Class.php";


function retrieveDiscountIfAny($idOfItem, $oPrice){
    $discounts = openfile();
    $priceFinal = $oPrice;
    if(!empty($discounts)){
        foreach ($discounts as $val){
            $vars = explode("---", $val);
            if($idOfItem == $vars[0]) {
                $priceFinal = $vars[4];
                break;
            }

        }

        return $priceFinal;
    }
    else
        return $oPrice;
}

if (!isset($_GET["id"])) {

   //validate item and get title and price
    $get_iteminfo_sql = "SELECT item_title FROM store_items WHERE id ='".$_GET["sel_item_id"]."'";
    $get_iteminfo_res = $mysqli->query($get_iteminfo_sql) or die("Couldn't connect1");

    if ( $get_iteminfo_res->num_rows < 1) {

   	    //invalid id, send away
   	    header("Location: seestore.php");
   	    exit();
    } else {

   	    //get info
   	    while ($item_info =  $get_iteminfo_res->fetch_array()) {
   	    	$item_title =  stripslashes($item_info["item_title"]);
		}

   	    //add info to cart table
		
		// Cheking if color and size are used, if not setting them
			// a value in order to not have an error
		///*
		if(empty($_GET["sel_item_color"]))
			$_GET["sel_item_color"] = "NA";
		if(empty($_GET["sel_item_size"]))
			$_GET["sel_item_size"] = "NA";
		//*/
		
		$date = date('Y-m-d 00:00:00');


		$data = unserialize($_COOKIE["track"]);
		if(!isset($data)) {
		    $id = "";
		    $item_title = "";
		    $price = "";
		    $originalPrice = 0;
			$getInfos = "SELECT * FROM store_items WHERE id ='".$_GET["sel_item_id"]."'";
			$res = $mysqli->query($getInfos) or die("ERROR AT ADD CART");
			while($tempo = $res->fetch_array()){
			    $id = $tempo["id"];
                $item_title =  stripslashes($tempo["item_title"]);
                $originalPrice = $tempo["item_price"];
            }
            /////////////////////////// SETTING THE PRICE OF THE DISCOUT IF THERE IS////////
            $price = retrieveDiscountIfAny($id,$originalPrice);

            ///////////////////////////////
            $tempObj = new Order($id,$item_title, $_GET["sel_item_color"],$_GET["sel_item_size"],$_GET["sel_item_qty"],$price);
            $add = array($tempObj, $date, 0);
            $res->free();
		}else{
				$idg = 0;
			foreach ($data as $val){
			    if($val[2] == $idg){
                	$idg ++;
                	continue;
			    }
            }
            $id = "";
            $item_title = "";
            $price = "";
            $originalPrice = 0;
            $getInfos = "SELECT * FROM store_items WHERE id ='".$_GET["sel_item_id"]."'";
            $res = $mysqli->query($getInfos) or die("ERROR AT ADD CART");
            while($tempo = $res->fetch_array()){
                $id = $tempo["id"];
                $item_title =  stripslashes($tempo["item_title"]);
                $originalPrice = $tempo["item_price"];
            }

            /////////////////////////// SETTING THE PRICE OF THE DISCOUT IF THERE IS////////
            $price = retrieveDiscountIfAny($id,$originalPrice);

            ///////////////////////////////

            $tempObj = new Order($id,$item_title, $_GET["sel_item_color"],$_GET["sel_item_size"],$_GET["sel_item_qty"],$price);
            $add = array($tempObj, $date, $idg);
            $res->free();
        }
		array_push($data, $add);

		}
		setcookie("track", serialize($data), time()+3600000, "/");
		echo print_r($data);
   	    //redirect to showcart page
   	    header("Location: showcart.php");
  	    exit();
    }


else {
    //send them somewhere else
		//die("HERE3");
    header("Location: seestore.php");
    exit();
}

$mysqli->close();
?>
