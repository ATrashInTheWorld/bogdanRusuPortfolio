<?php
//connect to database
$mssql = mssql_connect("NEWPC\SQLEXPRESS", "", "");
$db = mssql_select_db("Storefront",$mssql);

$display_block = "<h1>Your Shopping Cart</h1>";

//check for cart items based on user session id
$get_cart_res = mssql_query($get_sql,$mssql) or die("Couldn't connect");
$get_cart_sql = "SELECT st.id, si.item_title, si.item_price, st.sel_item_qty, st.sel_item_size, st.sel_item_color FROM store_shoppertrack AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE session_id = '".$_COOKIE["PHPSESSID"]."'";


if (mssql_num_rows($get_res) < 1) {
    //print message
    $display_block .= "<p>You have no items in your cart.
    Please <a href=\"seestore.php\">continue to shop</a>!</p>";
} else {
    //get info and build cart display
    $display_block .= "
    <table celpadding=\"3\" cellspacing=\"2\" border=\"1\" width=\"98%\">
    <tr>
    <th>Title</th>
    <th>Price</th>
    <th>Total Price</th>
    <th>Quantity</th>
    <th>Size</th>
    <th>Colour</th>
    <th>Action</th>
    </tr>";

    while ($cart_info = mssql_fetch_array($get_cart_res)) {
   	    $id_no = $cart_info['id'];
   	    $item_title = stripslashes($cart_info['title']);
   	    $item_price = $cart_info['price'];
   	    $item_qty = $cart_info['qty'];
   	    $item_color = $cart_info['color'];
   	    $item_size = $cart_info['size'];
	    $total_price = sprintf("%.02f", $price * $qty);

   	    $display_block .= "
   	    <tr>
   	    <td align=\"center\">$title <br></td>
   	    <td align=\"center\">$size <br></td>
   	    <td align=\"center\">$color <br></td>
   	    <td align=\"center\">\$ $price <br></td>
   	    <td align=\"center\">$qty <br>
   	    <td align=\"center\">\$ $total_price</td>
   	    <td align=\"center\"><a href=\"remove.php?id=".$id."\">remove</a></td>
   	    </tr>";
    }

    $display_block .= "</table>";
}
?>
<html>
<head>
<title>My Store</title>
</head>
<body>
<?php echo $display_block; ?>
</body>
</html>
