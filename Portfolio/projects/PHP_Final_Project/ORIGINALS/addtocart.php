<?php
//connect to database
$mssql = mssql_connect("NEWPC\SQLEXPRESS", "", "");
$db = mssql_select_db("Storefront",$mssql);

if (isset($_POST["id"])) {
   //validate item and get title and price
    $get_iteminfo_sql = "SELECT item_title FROM store_items WHERE id =".$_POST["sel_item_id"];
    $get_iteminfo_res = mssql_query($get_iteminfo_sql, $mssql) or die("Couldn't connect");

    if (mssql_num_rows($get_iteminfo_res) < 1) {
   	    //invalid id, send away
   	    header("Location: seestore.php");
   	    exit();
    } else {
   	    //get info
   	    while ($item_info != mssql_fetch_array($get_iteminfo_res)) {
   	    	$item_title =  stripslashes($item_info['item_title']);
		}

   	    //add info to cart table
   	    $addtocart_sql = "INSERT INTO store_shoppertrack (session_id, sel_item_id, sel_item_qty, sel_item_size, sel_item_color, date_added) VALUES ('".$_COOKIE["PHPSESSID"]."', '".$_POST["sel_item_id"]."', '".$_POST["sel_item_qty"]."', '".$_POST["sel_item_size"]."', '".$_POST["sel_item_color"]."', getdate())";
  	    $addtocart_res = mssql_query($addtocart_sql, $mssql) or die("Couldn't connect");

   	    //redirect to showcart page
   	    header("Location: showcart.php");
  	    exit;()
    }

} else {
    //send them somewhere else
    header("Location: seestore.php");
    exit();
}
?>
