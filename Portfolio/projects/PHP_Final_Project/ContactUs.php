<?php
$u = "none";
if(!isset($_COOKIE["user"]))
    setcookie("user","none",time()+(30),"/");
elseif(isset($_COOKIE['user']))
    $u = $_COOKIE["user"];

?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" lang="en">
    <title>ContactUs</title>
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

<div class="text-center" style="padding: 15px;">
    <h1 class="text-warning">We are here for you - Contact Us</h1>
    <h2 class="text-danger">Feel free to contact us for any reason. That it is a complaint, information about a delivery or a simple
    questions, we will always try to answer you as quickly as possible.
    </h2>
    <br>
        <p style="font-size: 20px; color:yellowgreen;">Email: <a href="mailto:wks@hotail.com" class="text-warning">wks@hotmail.com</a></p>
    <p> <spam style="font-size: 20px; color:darkgreen">Phone Number: 123-456-0987</spam>
        <br>
        <spam class="underlinedstuff">Phone Availabilities:</spam>
        <br>
        <spam class="text-success">Monday to Friday: 8:00 to 22:00
            <br>Weekend: 8:00 to 20:00</spam>
    </p>


    <p><spam style="font-size: 20px; color:darkgreen">
        Office Location: 123 Nowhere street Createdcity Quebec Canada</spam><br>
        <spam class="underlinedstuff">Office Availabilities:</spam><br>
       <spam class="text-success">Monday to Friday: 8:00 to 16:00 <br>
           Weekend: 8:00 to 14:00</spam>
    </p>
        <br>
    <p style="color: #e7e100; font-size: 25px;">Thank you for shopping with What Kind of Store are we?</p>

</div>

</body>



<footer id="footerD" class="text-center text-warning">
    What Kind of Shop are we?<br>
    <a href="Index.php"> <img src="Images/logo.png" style="height: 75px; width: 75px;"> </a>
    <p>Phone: 123-456-0987 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email:
        <a href="mailto:wks@hotail.com" class="text-warning">wks@hotmail.com</a></p>
</footer>

</html>