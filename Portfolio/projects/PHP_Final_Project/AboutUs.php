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
    <title>AboutUs</title>
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
        #infos{
            padding: 25px;
        }
        #imgtean{
            height: 175px;
            width: 300px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        @media screen and (min-width: 450px){
            #imgtean{
                height: auto;
                width: auto;
            }
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
    <a href="ContactUs.php" class="text-warning navFont col-sm-12">Contact Us</a>
</div>

<div id="infos">
    <p style="font-size: 17px;">What Kind of Shop are we? Is a college project that imitates an online shopping. In less scientific words, we are a kind of Amazon that
        only sell books, hats, and shirts for now. We definitely plan to develop the company (on the PHP side of the meaning).
    </p>

    <p style="font-size: 17px;">The company/project was created on February 25th, 2018.
        It is presently located at the creator’s house, which we will keep secret in order to keep his privacy.
    </p>
    <br>
    <p style="font-size: 18px;">The team is composed of 4 people:
    <ul>
        <li class="text-primary">The CEO: <strong>Bogdan Rusu</strong></li>
        <li class="text-success">The Web Designer: <strong>Me</strong> </li>
        <li class="text-warning">The Web Developer: <strong>Myself</strong></li>
        <li class="text-danger">The Database Administrator: <strong>I</strong></li>
    </ul>
    </p>
    <img src="Images/team.png" alt="Bog's Team!" class="text-center" id="imgtean">
    <br>
    <p class="text-center text-warning" style="font-size: 25px;">Our goal is, with the help of this project, to pass the PHP class with a 90%.</p>
<br>
    <p style="font-size: 20px; color: #000000;" class="text-center">How does buying our products going to help us?</p>

        <p style="font-size: 18px;" class="text-center">Well, like a lot of businesses, money strongly motivates us to improve this
    project and make it the best we can in order to offer you, the customer, an amazing
        online shopping experience.</p>
<br>
    <p class="text-center" style="font-size: 20px; color: #48a70b;">We strongly hope that enjoy the website and your online shopping session.
        Feel free to contact us at the email located in the footer or the about us page.
    </p>
    <p class="text-center" style="font-size: 20px; color: #00ff45;">Happy Shopping!</p>

</div>

</body>



<footer id="footerD" class="text-center text-warning">
    What Kind of Shop are we?<br>
    <a href="Index.php"> <img src="Images/logo.png" style="height: 75px; width: 75px;"> </a>
    <p>Phone: 123-456-0987 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email:
        <a href="mailto:wks@hotail.com" class="text-warning">wks@hotmail.com</a></p>
</footer>

</html>