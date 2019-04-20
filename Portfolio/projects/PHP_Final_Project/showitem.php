<?php
session_start();
include "Includes.php";


$u = "none";
if(!isset($_COOKIE["user"]))
    setcookie("user","none",time()+(30),"/");
elseif(isset($_COOKIE['user']))
    $u = $_COOKIE["user"];





$arrayOfDiscoutsAndIds = array();
$discounts = openfile();
if(!empty($discounts)){
    foreach ($discounts as $val){
        $vars = explode("---", $val);
        array_push($arrayOfDiscoutsAndIds, array($vars[0]=> array($vars[2],$vars[4])));
    }
}


if(isset($_POST["submit"])){
    $col = "NA";
     $si = "NA";
     if(!empty($_POST["sel_item_color"]))
         $col = $_POST["sel_item_color"];
     if(!empty($_POST["sel_item_size"]))
         $si = $_POST["sel_item_size"];

     $sql = "SELECT InStockQty FROM inventory WHERE ItemID='".$_POST["sel_item_id"]."' 
                        AND Color='".$col."' AND Size='".$si."'";
     $query = $mysqli->query($sql) or die("ERROR ON SHOW ITEM BEFORE ADDING TO CART");

     if($query->num_rows != 0){
         $qty = 0;
         while ($x = $query->fetch_array())
             $qty = $x["InStockQty"];

         $query->free();
         $mysqli->close();
         if($qty==0)
             header("Location: showitem.php?m=Sorry, we no longer have this product in our inventory&item_id=".$_POST["sel_item_id"]."");
         elseif ($qty < $_POST["sel_item_qty"])
             header("Location: showitem.php?m=Sorry, we no longer have the quantity requested in our inventory&item_id=".$_POST["sel_item_id"]."");
         else
             header("Location: addtocart.php?sel_item_id=".$_POST["sel_item_id"]."&sel_item_color=".$_POST["sel_item_color"]."&sel_item_size=".$_POST["sel_item_size"]."&sel_item_qty=".$_POST["sel_item_qty"]."");


     }
}



$display_block = "<h1>My Store - Item Detail</h1>";

if(!isset($_GET["item_id"]) || empty($_GET["item_id"]))
    $_GET["item_id"] = $_POST["sel_item_id"];

//validate item
$get_item_sql = "SELECT c.id as cat_id, c.cat_title, si.item_title, si.item_price, si.item_desc, si.item_image 
			FROM store_items AS si LEFT JOIN store_categories AS c on c.id = si.cat_id 
			WHERE si.id = '".$_GET["item_id"]."'";
$get_item_res = $mysqli->query($get_item_sql) or die(mysqli_error($mysqli));

if ($get_item_res->num_rows < 1) {
   //invalid item
   $display_block .= "<p><em>Invalid item selection.</em></p>";
}
else{
    $item_price = 0;
   //valid item, get info
   while ($item_info = $get_item_res->fetch_array()) {
	   $cat_id = $item_info["cat_id"];
	   $cat_title = strtoupper(stripslashes($item_info["cat_title"]));
	   $item_title = stripslashes($item_info["item_title"]);
	   $item_price = number_format($item_info["item_price"],2);
	   $item_desc = stripslashes($item_info["item_desc"]);
	   $item_image = $item_info["item_image"];
   }

   $item_price_print = "<strong>Price:</strong>$".$item_price;
   foreach ($arrayOfDiscoutsAndIds as $val){
        foreach ($val as $k=>$val2) {
       if($_GET["item_id"] == $k)
           $item_price_print = "<strong>Actual Price: </strong>$".$val[$k][1]."&nbsp;&nbsp;&nbsp;
                                    <strong>Original Price: </strong>$".$val[$k][0];

        }
    }

   //make breadcrumb trail
   $display_block .= "<p><strong><em>You are viewing:</em><br/>
   <a href=\"seestore.php?cat_id='".$cat_id."'\">".$cat_title."</a> &gt; ".$item_title."</strong></p>
   <table cellpadding=\"3\" cellspacing=\"3\" class=''>
   <tr>
   <td valign=\"middle\" align=\"center\"><img src=\"".$item_image."\"/></td>
   <td valign=\"middle\" ><p><strong>Description:</strong><br/>".$item_desc."</p>
   <p>".$item_price_print."</p>
   <form method=\"post\" action=\"showitem.php\">";

   //free result
   $get_item_res->free();

   //get colors
   $get_colors_sql = "SELECT item_color FROM store_item_color WHERE item_id = '".$_GET["item_id"]."' ORDER BY item_color";
   $get_colors_res = $mysqli->query($get_colors_sql) or die("Couldn't connect2");

   if ($get_colors_res->num_rows != 0) {
        $display_block .= "<p><strong>Available Colors:</strong><br/>
        <select name=\"sel_item_color\">";

        while ($colors = $get_colors_res->fetch_array()) {
           $item_color = $colors["item_color"];
           $display_block .= "<option value=\"".$item_color."\">".$item_color."</option>";
       }
       $display_block .= "</select>";
   }
 

   //free result
   $get_colors_res->free();

   //get sizes
   $get_sizes_sql = "SELECT item_size FROM store_item_size WHERE item_id = ".$_GET["item_id"]." ORDER BY item_size";
   $get_sizes_res = $mysqli->query($get_sizes_sql) or die("Couldn't connect3");

   if ($get_sizes_res->num_rows > 0) {
       $display_block .= "<p><strong>Available Sizes:</strong><br/>
       <select name=\"sel_item_size\">";

       while ($sizes = $get_sizes_res->fetch_array()) {
          $item_size = $sizes["item_size"];
          $display_block .= "<option value=\"".$item_size."\">".$item_size."</option>";
       }
   }


   $display_block .= "</select>";

   //free result
   $get_sizes_res->free();

   $display_block .= "
   <p><strong>Select Quantity:</strong>
   <select name=\"sel_item_qty\">";

   for($i=1; $i<11; $i++) {
       $display_block .= "<option value=\"".$i."\">".$i."</option>";
   }

   $display_block .= "
   </select>
   <input type=\"hidden\" name=\"sel_item_id\" value=\"".$_GET["item_id"]."\"/>
   <p><input type=\"submit\" name=\"submit\" value=\"Add to Cart\"/></p>
   </form>
   </td>
   </tr>
   </table>";
}


///////////////////////////// XML PART //////////////////////
$displayComments = "<br><h1>Comments</h1><br>";
$comments = simplexml_load_file("Products.xml");
foreach ($comments->prod as $val){
        if($val->attributes()->id == $_GET["item_id"]){
            foreach ($val->comment as $comm){
                if($comm->attributes()->status == "good"){
                    $displayComments .= "<p style='border: 1px dashed red; margin-right: 13%; margin-left: 13%;'>Rate:<strong>".$comm->rate."</strong>/5
                                            <br><strong>Comment:</strong><br>".
                                            $comm->com."</p>";
                }
            }
        }
}



//close connection to MSSQL
$mysqli->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" lang="en">
    <title>Item</title>
    <link href="CSS/css/bootstrap.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="Images/logo.png"/>
    <style>

        #titleFont{
            color: #ff870f;
            font-size: 55px;
            font-style: italic;
            font-family: "Comic Sans MS";
            margin-top: 50px;
        }

        .navFont{
            font-size: 30px;
        }

        #footerD{
            margin-top: 25px;
            background:linear-gradient(cornflowerblue,darkblue);
            font-size: 15px;
        }
        .underlinedstuff{
            text-decoration: underline;
            font-weight: bolder;
            font-size: 18px;
            color: mediumblue;
        }

    </style>

</head>
<body style="background: #d7ffd5">

<div class="row"
     style="background:linear-gradient(grey, blue); padding-top: 25px; padding-bottom: 25px; ">
    <a href="Index.php"> <img src="Images/logo.png" alt="What Kind of Shop are we?" style="margin-left: 125px;" > </a>
    <p class="text-center" id="titleFont">What Kind of Shop are we?</p>
</div>



<div style="padding-right: 35px;">
    <?php
    if($u == "none") {
        ?>
        <br>
        <form action="loginProcess.php" method="post" style="text-align: right;">
            Username:<input type="text" name="username">&nbsp;&nbsp;&nbsp;
            Password:<input type="password" name="password">&nbsp;&nbsp;&nbsp;
            <input type="submit" name="login" value="Login">
            <a href="signUpPage.php">Sign up</a>
        </form>
        <br>
        <?php
    }
    else{
        ?>
        <p style='text-align: right; font-size: 35px;'>Welcome <?php echo $_COOKIE["user"]; ?>
            <br>
        <form style='text-align: right;' action="loginProcess.php" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>
        </p>
        <?php
    }
    ?>

</div>




<div class="bg-success text-center" style="padding-bottom: 15px; padding-top: 15px;">
    <a href="Index.php" class="text-warning navFont col-sm-12">Home</a>
    <a href="seestore.php" class="text-warning navFont col-sm-12">See the Store</a>
    <a href="AboutUs.html" class="text-warning navFont col-sm-12">About Us</a>
</div>
<div class="text-center bg-info" style="font-size: 20px;">
    <a href="seestore.php" style="color: yellow;">Store</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="showcart.php" style="color: yellow;">Your Cart</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="RateProduct.php" style="color: yellow;">Rate a product</a>
    <?php
    if($u == "admin") {

        ?>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="CommentsEvaluation.php" style="color: yellow;">Evaluate Comments</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="AdminDiscounts.php" style="color: yellow;">Set Discounts</a>
        <?php
    }
    ?>
</div>
<p class="text-danger text-center" style="font-size: 28px;"><?php if(isset($_GET["m"])) echo $_GET["m"]; ?></p>
<div class="text-center">
    <?php echo $display_block;
           echo  $displayComments;?>
</div>
</body>



<footer id="footerD" class="text-center text-warning">
    What Kind of Shop are we?<br>
    <a href="Index.php"> <img src="Images/logo.png" style="height: 75px; width: 75px;"> </a>
    <p>Phone: 123-456-0987 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email:
        <a href="mailto:wks@hotail.com" class="text-warning">wks@hotmail.com</a></p>
</footer>

</html>