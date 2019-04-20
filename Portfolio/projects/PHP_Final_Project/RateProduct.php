<?php

$u = "none";
if(!isset($_COOKIE["user"]))
    setcookie("user","none",time()+(30),"/");
elseif(isset($_COOKIE['user']))
    $u = $_COOKIE["user"];



include "Includes.php";

if(isset($_GET["comment"])) {
    if ($u == "none")
        header("Location: loginForm.php?m=You must be logged in in order to comment");
    else {
        if (!empty($_GET["rate"]) & !empty($_GET["com"])) {

            $newComment;
            $data = simplexml_load_file("Products.xml");
            // $fileXml = $data->asXML();
            foreach ($data->prod as $val) {
                if ($val->attributes()->id == $_GET["item"]) {
                    $newComment = new SimpleXMLElement($data->asXML());
                    $commentID = 1;

                    foreach ($val->comment as $val2)
                        if ($commentID == $val2->attributes()->id)
                            $commentID++;

                    $test2 = $val->addChild("comment", $newComment);
                    $test2->addAttribute("id", $commentID);
                    $test2->addAttribute("status", "pending");
                    $test2->addChild("rate", $_GET["rate"]);
                    $test2->addChild("com", $_GET["com"]);
                }

            }
            file_put_contents("Products.xml", $data->asXML());
            header("Location: RateProduct.php?t=g&m=Thank you! We will review your comment for now.");

        } else
            header("Location: RateProduct.php?t=b&m=Do not let any field empty please.");
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
<?php
    if($u == "none") {

        ?>
        <p class="text-danger">You must be LOGGED IN in order to comment, else your comment won't register.</p>
        <?php
    }
    ?>
    <?php if(isset($_GET["m"]))
    if($_GET["t"]=="b")
        echo "<br><p class='text-danger'>".$_GET["m"]."</p>";
    elseif ($_GET["t"]=="g")
        echo "<br><p class='text-success'>".$_GET["m"]."</p>"
?>
    <h1>Comment us</h1>

<form action="RateProduct.php" method="get">
    Select a product:<select name="item">
        <?php
            $sql = "SELECT id, item_title FROM store_items";
            $sql_query = $mysqli->query($sql) or die("ERROR DISCOUNTS MAKER PAGE 1");
            if($sql_query->num_rows >=1 ){
                while($res = $sql_query->fetch_array()){
                    echo "<option value='".$res["id"]."'>".$res["item_title"]."</option>";
                }
            }

            $sql_query->free();
        ?>
    </select><br><br>
    Rate:<input type="number" min="0" max="5" name="rate" style="width: 35px;">/5
    <br>
    <h3>Comment</h3>
    <textarea style="width: 45%;" name="com"></textarea>
    <br>
    <input type="submit" name="comment" value="Submit Comment">
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