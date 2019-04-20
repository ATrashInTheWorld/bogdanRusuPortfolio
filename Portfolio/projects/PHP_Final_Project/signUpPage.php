<?php

if(isset($_POST["create"])){
    if(!empty($_POST["use"]) & !empty($_POST["papa"]) & !empty($_POST["emm"])){
        $file = file_get_contents("users.json");
        $json = json_decode($file, true);
        $bUserOK = false;
        $bPassOK = false;
        foreach ($json["users"] as $val){
            foreach ($val as $user){
                if($_POST["use"] == $user["name"] || $_POST["use"] == "none"){
                    header("Location: signUpPage.php?m=Username already in use, please restart");
                    break(2);
                }
                else
                    $bUserOK = true;

                if($_POST["papa"] == $user["pass"]){
                    header("Location: signUpPage.php?m=Password already in use, please restart");
                    break(2);
                }
                else
                    $bPassOK = true;

            }

        }
        if($bPassOK & $bUserOK) {
            $json["users"][] = array("user" => array("name" => $_POST["use"], "pass" => $_POST["papa"], "type" => "normal"));
            file_put_contents("users.json", json_encode($json));
            header("Location: signUpPage.php?m=Yo have been signed up, feel free to log in");
        }

    }
    else
        header("Location: signUpPage.php?m=All the fields must be filled, please restart!");
}
?>

<!DOCTYPE html>
<html>





<head>
    <meta charset="UTF-8" lang="en">
    <title>Index</title>
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

        #toprod{
            font-size: 45px;
            font-weight: bold;
        }

        .displayImages{
            margin-top: 5px;
            border: 5px solid darkblue;
            margin-left: 10px;
            height: 20em;
            width:21.5em;
        }

        @media screen and (min-width : 450px){
            .displayImages {
                height: 30em;
                width: 55em;
                margin-left: 225px;
            }
        }



        #footerD{
            margin-top: 25px;
            background:linear-gradient(cornflowerblue,darkblue);
            font-size: 15px;
        }
    </style>

</head>
<body style="background: #d7ffd5">

<div class="row"
     style="background:linear-gradient(grey, blue); padding-top: 25px; padding-bottom: 25px; ">
    <a href="Index.php"> <img src="Images/logo.png" alt="What Kind of Shop are we?" style="margin-left: 125px;" > </a>
<p class="text-center" id="titleFont">What Kind of Shop are we?</p>
</div>



<div class="bg-success text-center" style="padding-bottom: 15px; padding-top: 15px;">
    <a href="AboutUs.php" class="text-warning navFont col-sm-12">About Us</a>
    <a href="seestore.php" class="text-warning navFont col-sm-12">See the Store</a>
    <a href="ContactUs.php" class="text-warning navFont col-sm-12">Contact Us</a>
</div>

<div class="text-center">
    <?php
    if(isset($_GET["m"]))
        echo "<p class='text-danger'>".$_GET["m"]." </p>";
    ?>
    <h1>Sign Up</h1>
    <form action="signUpPage.php" method="post">
        Username:<input type="text" name="use"><br><br>
        Password: <input type="password" name="papa"><br><br>
        Email:<input type="text" name="emm"><br><br>
        <input type="submit" name="create" value="Sign Up">
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