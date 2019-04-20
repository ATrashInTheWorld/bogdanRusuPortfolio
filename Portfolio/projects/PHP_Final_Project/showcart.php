<?php

$u = "none";
if(!isset($_COOKIE["user"]))
    setcookie("user","none",time()+(30),"/");
elseif(isset($_COOKIE['user']))
    $u = $_COOKIE["user"];



session_start();
include "Includes.php";
include "Order_Class.php";

if(isset($_GET["rem"])){
    $track = array();
    setcookie("track", serialize($track),time()+360000, "/");
    header("Location: showcart.php");
}
if(isset($_GET["order"])){
    if($u == "none")
        header("Location: loginForm.php?m=You must be logged in in order to order");
    else
    header("Location: Order.php");
}


$tot = 0;
$display_block = "<h1>Your Shopping Cart</h1>";


if (!isset($_COOKIE["track"])) {
    //print message
    $display_block .= "<p>You have no items in your cart.
    Please <a href=\"seestore.php\">continue to shop</a>!</p>";
} 
else {
    $data = unserialize($_COOKIE["track"]);
    if (!empty($data)) {
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

        foreach ($data as $i => $val) {
            //echo print_r($val)."<br>";


            $id_no = $val[0]->getItemID();
            $item_qty = $val[0]->getQty();
            $item_size = $val[0]->getSize();
            $item_color = $val[0]->getColor();
                $item_title = stripslashes($val[0]->getTitle());
                $item_price = $val[0]->getPrice();
                $total_price = sprintf("%.02f", $val[0]->calculateTotalPrice());

                $tot += $total_price;

                $display_block .= "
                        <tr>
                        <td align=\"center\">" . $item_title . "<br></td>
                        <td align=\"center\">\$" . $item_price . " <br></td>
                        <td align=\"center\">\$" . $total_price . " <br></td>
                        <td align=\"center\"> " . $item_qty . " <br></td>
                        <td align=\"center\">" . $item_size . " <br>
                        <td align=\"center\"> " . $item_color . "</td>
                        <td align=\"center\"><a href=\"removefromcart.php?idL=" . $val[2] . "\">remove</a></td>
                        </tr>";


        }
        $display_block .= "</table>";
    }
    else{
        $display_block .= "<p>You have no items in your cart.
    Please <a href=\"seestore.php\">continue to shop</a>!</p>";
    }
}
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
    <a href="AboutUs.php" class="text-warning navFont col-sm-12">About Us</a>
</div>
<div class="text-center bg-info" style="font-size: 20px;">
    <a href="seestore.php" style="color: yellow;">Store</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="showcart.php" style="color: yellow;">Your Cart</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="RateProduct.php" style="color: yellow;">Rate a product</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
<div class="text-center">
    <?php echo $display_block; ?>
</div>

<div style="text-align: right; padding-right: 45px; margin-top: 35px;">
    <form action="showcart.php" method="get">
    <p>Sub Total: <?php echo number_format($tot,2)."$";?></p>
    <p>Taxes: <?php echo number_format($tot*0.15,2)."$";?></p>
    <p><strong>Total: <?php echo number_format($tot*1.15,2);?>$ </strong></p>
    <input type="submit" name="rem" value="Remove everything from cart">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="seestore.php">Continue Shopping</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="order" value="Order">
    </form>
</div>
</body>
<footer id="footerD" class="text-center text-warning">
    What Kind of Shop are we?<br>
    <a href="Index.php"> <img src="Images/logo.png" style="height: 75px; width: 75px;"> </a>
    <p>Phone: 123-456-0987 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email:
        <a href="mailto:wks@hotail.com" class="text-warning">wks@hotmail.com</a></p>
</footer>


</html>
