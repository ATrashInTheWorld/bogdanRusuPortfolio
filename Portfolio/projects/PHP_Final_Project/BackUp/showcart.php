<?php
session_start();
include "Includes.php";

$tot = 0;
$display_block = "<h1>Your Shopping Cart</h1>";

//check for cart items based on user session id
$get_cart_sql = "SELECT st.id, si.item_title, si.item_price, st.sel_item_qty, st.sel_item_size, st.sel_item_color FROM store_shoppertrack AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE session_id = '".$_COOKIE["PHPSESSID"]."'";
$get_cart_res = $mysqli->query($get_cart_sql) or die("Couldn't connect");
//$get_cart_sql = "SELECT st.id, si.item_title, si.item_price, st.sel_item_qty, st.sel_item_size, st.sel_item_color FROM store_shoppertrack AS st LEFT JOIN store_items AS si ON si.id = st.sel_item_id WHERE session_id = '".$_COOKIE["PHPSESSID"]."'";


if ($get_cart_res->num_rows < 1) {
    //print message
    $display_block .= "<p>You have no items in your cart.
    Please <a href=\"seestore.php\">continue to shop</a>!</p>";
} 
else {
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

    while ($cart_info = $get_cart_res->fetch_array()) {
   	    $id_no = $cart_info['id'];
   	    $item_title = stripslashes($cart_info["item_title"]);
   	    $item_price = $cart_info['item_price'];
   	    $item_qty = $cart_info['sel_item_qty'];
   	    $item_color = $cart_info['sel_item_color'];
   	    $item_size = $cart_info['sel_item_size'];
	    $total_price = sprintf("%.02f", $item_price * $item_qty);

	    $tot += $total_price;

   	    $display_block .= "
   	    <tr>
   	    <td align=\"center\">".$item_title."<br></td>
   	    <td align=\"center\">\$".$item_price." <br></td>
   	    <td align=\"center\">\$".$total_price." <br></td>
   	    <td align=\"center\"> ".$item_qty." <br></td>
   	    <td align=\"center\">".$item_size." <br>
   	    <td align=\"center\"> ".$item_color."</td>
   	    <td align=\"center\"><a href=\"removefromcart.php?idL=".$id_no."\">remove</a></td>
   	    </tr>";
    }

    $display_block .= "</table>";
}
$get_cart_res->free();
$mysqli->close();
?>
<html>
<head>
<title>My Store</title>
</head>
<body>
<?php echo $display_block; ?>
<div style="text-align: right; padding-right: 45px; margin-top: 35px;">
    <p>Sub Total: <?php echo number_format($tot,2)."$";?></p>
    <p>Taxes: <?php echo number_format($tot*0.15,2)."$";?></p>
    <p><strong>Total: <?php echo number_format($tot*1.15,2)."$";?> </strong></p>
    <button>Remove Everything from Cart</button>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="seestore.php">Continue Shopping</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <button>Order</button>
</div>
</body>
</html>
