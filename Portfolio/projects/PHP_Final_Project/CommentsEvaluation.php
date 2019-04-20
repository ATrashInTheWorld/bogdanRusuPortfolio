<?php

$u = "none";
if(!isset($_COOKIE["user"]))
    setcookie("user","none",time()+(30),"/");
elseif(isset($_COOKIE['user']))
    $u = $_COOKIE["user"];



include "Includes.php";
$displayBlock = "";
$xmlDoc = simplexml_load_file("Products.xml");
foreach ($xmlDoc->prod as $item){
    $ids = (int)$item->attributes()->id;
    $sql = "SELECT item_title FROM store_items WHERE id='".$ids."'";
    $query = $mysqli->query($sql) or die("ERROR RETRIEVE ITEM TITLE on COMMENT EVALUATION");

    $title = "";
    while ($res = $query->fetch_array())
        $title = $res["item_title"];

    $displayBlock .= "<br><h3>$title</h3>";

    foreach ($item->comment as $comm){
        if($comm->attributes()->status == "pending")
        $displayBlock .= "<form action='SetCommentStatus.php' method='get'>Comment ID: <strong>".
                            intval($comm->attributes()->id)."</strong><br>Rate: <strong>".$comm->rate."
                            </strong>/5<br><strong>Comment</strong><br>".$comm->com."
                            <br><input type='hidden' name='comid' value='".$comm->attributes()->id."'>
                            <br><input type='hidden' name='prodid' value='".$ids."'>
                            <input type='submit' name='y' value='Accept'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type='submit' name='n' value='Reject'></form><br>";

    }

    $query->free();
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
    <h1>Comments Evaluation</h1>
    <?php echo $displayBlock ?>
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