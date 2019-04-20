<?php

$u = "none";
if(!isset($_COOKIE["user"]))
    setcookie("user","none",time()+(30),"/");
elseif(isset($_COOKIE['user']))
    $u = $_COOKIE["user"];



include "Order_Class.php";
$shippingOptions = array("day"=>0.27, "week"=>0.125, "month"=>0.065);
$prods = "";
$prices = array();
$message = "";
    if(isset($_GET["me"]))
        $message = "<br><div class='text-danger'>".$_GET["me"]."</div><br>";

if (isset($_COOKIE['track']))
    $prods = unserialize($_COOKIE["track"]);

$display = "";

if(empty($prods))
    $display = "<h1>NO PRODUCTS IN YOUR CART</h1><br><a href='seestore.php'>Continue Shopping</a> ";
else{


    $total = 0;
    $display = "<table celpadding='3' cellspacing='2' border='1' width='98%'>
    <tr>
    <th>Title</th>
    <th>Price</th>
    <th>Total Price</th>
    <th>Quantity</th>
    <th>Size</th>
    <th>Colour</th>
    </tr>";

    foreach ($prods as $val){
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
                        </tr>";
    }
    $display .= "<tr><td><strong>Total: ". sprintf("%.02f",$total)."$</strong></td></tr></table>";
    $opt1 = sprintf("%.02f",$total*$shippingOptions["day"]);
    $opt2 = sprintf("%.02f",$total*$shippingOptions["week"]);
    $opt3 = sprintf("%.02f",$total*$shippingOptions["month"]);
    $prices[0] = $opt1;
    $prices[1] = $opt2;
    $prices[2] = $opt3;

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
    <h1>Items Ordered:</h1>

 <?php echo $message; echo $display;
 if(!empty($prods)){?>
    <div class="text-center" style='line-height: 60px%;'>
        <h3>Select the delivery option</h3>
        <form action='Order_Verificator.php' method='get'>
            <input type="radio" name="opt" value='1-3 days' <?php if(isset($_GET["a"])) if($_GET["a"] == '1-3 days') echo "checked"; ?>>Within 1-3 days: <strong><?php echo $opt1; ?>$</strong>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="opt" value='1-2 weeks' <?php if(isset($_GET["a"])) if($_GET["a"] == '1-2 weeks') echo "checked"; ?>>Within 1-2 weeks: <strong><?php echo $opt2; ?>$</strong>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="opt" value='1 month' <?php if(isset($_GET["a"])) if($_GET["a"] == '1 month') echo "checked"; ?>>Within 1 month: <strong><?php echo $opt3; ?>$</strong>

            <br><br>
            <h3>Customer Information</h3>
            Name and Family name: <input type='text' name='na' value="<?php if(isset($_GET["b"])) echo $_GET["b"]; ?>" ><br>
            Address: <input type='text' name='addr' value="<?php if(isset($_GET["c"])) echo $_GET["c"]; ?>"><br>
            City: <input type='text' name='cit' value="<?php if(isset($_GET["d"])) echo $_GET["d"]; ?>"><br>
            State or province(Full or abbreviation): <input type='text' name='st' value="<?php if(isset($_GET["e"])) echo $_GET["e"]; ?>"><br>
            Zip code: <input type='text' name='zip' value="<?php if(isset($_GET["f"])) echo $_GET["f"]; ?>"><br>
            Phone Number: <input type='text' name='pn' value="<?php if(isset($_GET["g"])) echo $_GET["g"]; ?>"><br>
            Email address: <input type='text' name='em' value="<?php if(isset($_GET["h"])) echo $_GET["h"]; ?>"><br>
            <br>
            <h3>Payment Information</h3>
            <input type='radio' name='popt' value='Visa' <?php if(isset($_GET["i"])) if($_GET["i"] == 'Visa') echo "checked"; ?>>Visa
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type='radio' name='popt' value='Mastercard' <?php if(isset($_GET["i"])) if($_GET["i"] == 'Mastercard') echo "checked"; ?>>MasterCard
            <br>
            Card holder: <input type='text' name='ch' value="<?php if(isset($_GET["j"])) echo $_GET["j"]; ?>"><br>
            Card Number <input type='text' name='cn' value="<?php if(isset($_GET["k"])) echo $_GET["k"]; ?>"><br>
            Expiration Date <input type='text' name='ced' value="<?php if(isset($_GET["l"])) echo $_GET["l"]; ?>"><br>
            Security Code<input type='text' name='csc' value="<?php if(isset($_GET["m"])) echo $_GET["m"]; ?>"><br>
            <input type="submit" name="Order">


        </form>

    </div>
</div>
<br>
<?php } ?>



</body>
<footer id="footerD" class="text-center text-warning">
    What Kind of Shop are we?<br>
    <a href="Index.php"> <img src="Images/logo.png" style="height: 75px; width: 75px;"> </a>
    <p>Phone: 123-456-0987 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email:
        <a href="mailto:wks@hotail.com" class="text-warning">wks@hotmail.com</a></p>
</footer>


</html>
