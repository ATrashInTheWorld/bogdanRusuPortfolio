<?php

$u = "none";
if(!isset($_COOKIE["user"]))
    setcookie("user","none",time()+(30),"/");
elseif(isset($_COOKIE['user']))
    $u = $_COOKIE["user"];



include "Order_Class.php";
include "Includes.php";
$shippingOptions = array("day"=>0.27, "week"=>0.125, "month"=>0.065);
$shippingTotal = 0;
$total = 0;
$display = "";

if (isset($_COOKIE['track']))
    $prods = unserialize($_COOKIE["track"]);

if(isset($_GET["notGood"])){
    header("Location: Order.php?a=".$_GET["a"]."&b=".$_GET["b"]."&c=".$_GET["c"]."&d=".$_GET["d"]."&e=".$_GET["e"]."&f=".$_GET["f"]."&g=".$_GET["g"]."&h=".$_GET["h"]."&i=".$_GET["i"]."&j=".$_GET["j"]."&k=".$_GET["k"]."&l=".$_GET["l"]."&m=".$_GET["m"]."");
}
if(isset($_GET["good"])){
    foreach ($prods as $val){
        $sql = "SELECT InStockQty FROM inventory WHERE ItemID='".$val[0]->getItemId()."'
        AND Color='".$val[0]->getColor()."' AND Size='".$val[0]->getSize()."'";
     $query = $mysqli->query($sql) or die("ERROR ON CONFIRMATION NO ITEM FOUND FOR QUERY");

     if($query->num_rows != 0){
         $tres = 0;
         while ($res = $query->fetch_array())
         $tres = $res["InStockQty"];


         $tres -= $val[0]->getQty();
         $sql2 = "UPDATE inventory SET InStockQty='".$tres."' WHERE ItemID='".$val[0]->getItemId()."'
                AND Color='".$val[0]->getColor()."' AND Size='".$val[0]->getSize()."'";
         $query2 = $mysqli->query($sql2) or die("HERE CALCL");

     }
         $query->free();

    }
    $mysqli->close();
    $track = array();
    setcookie("track", serialize($track),time()+360000, "/");
    header("Location: tkx.php");
   // exit();
}


if(empty($prods))
$display = "<h1>NO PRODUCTS IN YOUR CART</h1><br><a href='seestore.php'>Continue Shopping</a> ";
else {
    $display = "<table celpadding='3' cellspacing='2' border='1' width='98%'>
    <tr>
    <th>Title</th>
    <th>Price</th>
    <th>Total Price</th>
    <th>Quantity</th>
    <th>Size</th>
    <th>Colour</th>
    <th>Date Added</th>
    </tr>";

    foreach ($prods as $val) {
        $id_no = $val[0]->getItemID();
        $item_qty = $val[0]->getQty();
        $item_size = $val[0]->getSize();
        $item_color = $val[0]->getColor();
        $item_title = stripslashes($val[0]->getTitle());
        $item_price = $val[0]->getPrice();
        $total_price = sprintf("%.02f", $val[0]->calculateTotalPrice());

        $total += $total_price;

        $display .= "
                        <tr>
                        <td align=\"center\">" . $item_title . "<br></td>
                        <td align=\"center\">\$" . $item_price . " <br></td>
                        <td align=\"center\">\$" . $total_price . " <br></td>
                        <td align=\"center\"> " . $item_qty . " <br></td>
                        <td align=\"center\">" . $item_size . " <br>
                        <td align=\"center\"> " . $item_color . "</td>
                        <td align=\"center\"> " . $val[1] . "</td>
                        </tr>";
    }

    if ($_GET["a"]=="1-3 days")
        $shippingTotal = $total*$shippingOptions["day"];
    elseif ($_GET["a"]=="1-2 weeks")
        $shippingTotal = $total*$shippingOptions["week"];
    elseif ($_GET["a"]=="1 month")
        $shippingTotal = $total*$shippingOptions["month"];

    $display .= "</table><br>";
}



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
            <a href="">Sign up</a>
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
<div class="text-center" style="font-size: 18px;">
   <h1>Confirmation:</h1>
    <h3>Please confirm the following information</h3>
    <h5>Product(s)</h5>
    <?php echo $display; ?>
    <h5>About you</h5>
    Name: <strong><?php echo $_GET['b'] ?> </strong><br>
    Address:<strong> <?php echo $_GET['c'] ?> </strong><br>
    City: <strong><?php echo $_GET['d'] ?> </strong><br>
    State: <strong><?php echo $_GET['e'] ?> </strong><br>
    Zip: <strong><?php echo $_GET['f'] ?> </strong><br>
    Phone Number:<strong> <?php echo $_GET['g'] ?> </strong><br>
    Email Address: <strong><?php echo $_GET['h'] ?></strong> <br><br>


    <h5>Payment Method</h5>
    Type: <strong><?php echo $_GET['i'] ?> </strong><br>
    Card number:<strong> <?php echo $_GET['k'] ?> </strong><br>
    Security Code: <strong><?php echo $_GET['m'] ?> </strong><br>
    Card Expiration date: <strong><?php echo $_GET['l'] ?> </strong><br>
    Card Holder: <strong><?php echo $_GET['j'] ?> </strong><br><br>


    <h5>Delivery Specifications</h5>
    Delivery delay: <strong><?php echo $_GET['a'] ?> </strong><br>
    Delivery price: <strong><?php echo sprintf("%.02f",$shippingTotal) ?>$</strong><br>
    Total tax included: <strong><?php echo sprintf("%.02f",($shippingTotal+$total)*1.15) ?>$</strong><br>
<br>
<form action="Confirm.php" method="get">

    <input type="hidden" name="a" value="<?php echo $_GET["a"]; ?>">
    <input type="hidden" name="b" value="<?php echo $_GET["b"]; ?>">
    <input type="hidden" name="c" value="<?php echo $_GET["c"]; ?>">
    <input type="hidden" name="d" value="<?php echo $_GET["d"]; ?>">
    <input type="hidden" name="e" value="<?php echo $_GET["e"]; ?>">
    <input type="hidden" name="f" value="<?php echo $_GET["f"]; ?>">
    <input type="hidden" name="g" value="<?php echo $_GET["g"]; ?>">
    <input type="hidden" name="h" value="<?php echo $_GET["h"]; ?>">
    <input type="hidden" name="i" value="<?php echo $_GET["i"]; ?>">
    <input type="hidden" name="j" value="<?php echo $_GET["j"]; ?>">
    <input type="hidden" name="k" value="<?php echo $_GET["k"]; ?>">
    <input type="hidden" name="l" value="<?php echo $_GET["l"]; ?>">
    <input type="hidden" name="m" value="<?php echo $_GET["m"]; ?>">

        <input type="submit" name="notGood" value="Modify the information">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="good" value="Order">
</form>

</div>
<br>
</body>

<footer id="footerD" class="text-center text-warning">
    What Kind of Shop are we?<br>
    <a href="Index.php"> <img src="Images/logo.png" style="height: 75px; width: 75px;"> </a>
    <p>Phone: 123-456-0987 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email:
        <a href="mailto:wks@hotail.com" class="text-warning">wks@hotmail.com</a></p>
</footer>


</html>