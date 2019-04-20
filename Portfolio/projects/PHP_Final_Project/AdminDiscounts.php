<?php

$u = "none";
if(!isset($_COOKIE["user"]))
    setcookie("user","none",time()+(30),"/");
elseif(isset($_COOKIE['user']))
    $u = $_COOKIE["user"];



include "Includes.php";

$discounts = openfile();

if(isset($_GET["setDiscount"])){
    if(!empty($_GET["item"]) & !empty($_GET["discount"])){
        $discount = $_GET["discount"]/100;
        $sql = "SELECT item_title,item_price FROM store_items WHERE id='".$_GET["item"]."'";
        $query = $mysqli->query($sql) or die("ERROR WRITING SQL");

        if($query->num_rows != 0){
            while ($res = $query->fetch_array()) {
                $noDoubleD = false;
                foreach ($discounts as $val)
                    if ($val[0] == $_GET["item"])
                        $noDoubleD = true;

                if (!$noDoubleD) {
                    $discountedPrice = $res["item_price"]-($res["item_price"] * $discount);
                    $data = "";
                    if (file_get_contents("Discounts.txt") == "")
                        $data = $_GET['item'] . "---" . $res["item_title"] . "---" . number_format($res["item_price"], 2) . "---" .
                            $_GET['discount'] . "%---" . number_format($discountedPrice, 2) ;
                    else
                        $data = "\r\n" . $_GET['item'] . "---" . $res["item_title"] . "---" . number_format($res["item_price"], 2) . "---" .
                            $_GET['discount'] . "%---" . number_format($discountedPrice, 2);

                    file_put_contents("Discounts.txt", $data, FILE_APPEND);
                    header("Location: AdminDiscounts.php");
                }
                else {
                    header("Location: AdminDiscounts.php?m=This Item already has a discount");
                    break;
                }
            }
        }
        $query->free();
    }
    else
        header("Location: AdminDiscounts.php?m=Enter a value to all th fields");
}

if(isset($_GET["deleteAll"])){
   $file = @fopen("Discounts.txt", "w");
    fclose($file);
    header("Location: AdminDiscounts.php");
}

$displayDisc = "";
if(!empty($discounts)) {
    foreach ($discounts as $val) {
        $vars = explode("---", $val);
        $displayDisc .= "<tr><td>$vars[0]</td><td>$vars[1]</td><td>$vars[2]$</td><td>$vars[3]</td><td>$vars[4]$</td>
            <td><a href='removeDiscount.php?id=$vars[0]'> Remove Discount</a></td></tr>";
    }
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
    <a href="CommentsEvaluation.php" style="color: yellow;">Evaluate Comments</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="AdminDiscounts.php" style="color: yellow;">Set Discounts</a>
</div>
<div class="text-center">
    <h1>Discounts Maker</h1>

    <br>
    <h2>Already existed Discounts</h2>
    <table style="text-align: center; width: 99%; " border="3">
        <tr><th>Item ID</th><th>Item Title</th><th>Original Price</th><th>Discount</th><th>Discounted Price</th><th>Action</th></tr>
        <?php echo $displayDisc; ?>
    </table>
    <form action="AdminDiscounts.php" method="get">
        <br>
        <input type="submit" name="deleteAll" value="Erase the file">
    </form><br>
    <?php
    if(isset($_GET["m"]))
        echo "<p class='text-danger'>".$_GET["m"]."</p>" ;
    ?>
    <h2>Create a new one</h2>
<form action="AdminDiscounts.php" method="get">
    Select a product:<select name="item">
        <?php
            $sql = "SELECT id, item_title FROM store_items";
            $sql_query = $mysqli->query($sql) or die("ERROE DICOUNTS MAKER PAGE 1");
            if($sql_query->num_rows >=1 ){
                while($res = $sql_query->fetch_array()){
                    echo "<option value='".$res["id"]."'>".$res["item_title"]."</option>";
                }
            }

            $sql_query->free();
        ?>
    </select><br><br>
    Set Discount: <input type="number" max="100" min="1" name="discount">%<br><br>
    <input type="submit" name="setDiscount" value="Create Discount">
</form><br>

</div>

</body>



<footer id="footerD" class="text-center text-warning">
    What Kind of Shop are we?<br>
    <a href="Index.php"> <img src="Images/logo.png" style="height: 75px; width: 75px;"> </a>
    <p>Phone: 123-456-0987 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email:
        <a href="mailto:wks@hotail.com" class="text-warning">wks@hotmail.com</a></p>
</footer>
<?php
$mysqli->close();
?>
</html>