<?php

$u = "none";
if(!isset($_COOKIE["user"]))
    setcookie("user","none",time()+(30),"/");
elseif(isset($_COOKIE['user']))
    $u = $_COOKIE["user"];



include "Includes.php";

if(!isset($_COOKIE["track"])){
    $track = array();
    setcookie("track", serialize($track), time()+3600, "/");
}

$displayDiscounts = "";
$discounts = openfile();
if(!empty($discounts)) {
    $displayDiscounts = "<br><h2>Discounts</h2><br><table style=\"text-align: center; width: 99%; \" border=\"3\">
    <tr><th>Category</th><th>Item</th><th>Original Price</th><th>Discount</th><th>Discounted Price</th></tr>";
    foreach ($discounts as $val) {
        $vars = explode("---", $val);
        $sql_select_category = "SELECT c.cat_title FROM store_categories c WHERE c.id in(SELECT cat_id 
                     FROM store_items WHERE id='".$vars[0]."')";
        $res_get_category = $mysqli->query($sql_select_category) or die($mysqli->error);
        if($res_get_category->num_rows >= 1)
            while($res = $res_get_category->fetch_array())
                $displayDiscounts .= "<tr><td>".$res["cat_title"]."</td><td>$vars[1]</td><td>".$vars[2].
                    "$</td><td>".$vars[3]."</td><td>".$vars[4]."$</td></tr>";

        $res_get_category->free();
    }
    $displayDiscounts .= "</table><br>";
}

$display_block = "<h1 class='text-danger'>My Categories</h1>".$displayDiscounts."
<p>Select a category to see its items.</p>";

//show categories first
$get_cats_sql = "SELECT id, cat_title, cat_desc FROM store_categories ORDER BY cat_title";
$get_cats_res = $mysqli->query($get_cats_sql) or die("PROBLEM IN SEESTORE.PHP");

if ($get_cats_res->num_rows < 1) 
   $display_block = "<p class='text-danger'><em>Sorry, no categories to browse.</em></p>";
else{
   while ($cats = $get_cats_res->fetch_array()) {
	 
        $cat_id  = $cats["id"];
        $cat_title = strtoupper(stripslashes($cats["cat_title"]));
        $cat_desc = stripslashes($cats["cat_desc"]);

        $display_block .= "<p><strong><a href=\"".$_SERVER["PHP_SELF"]."?cat_id=".$cat_id."\">".$cat_title."</a></strong><br/>".$cat_desc."</p>";
		
		
		if(isset($_GET["cat_id"]))	{
			if ($_GET["cat_id"] == $cat_id) {
				
			   //get items
			   $get_items_sql = "SELECT id, item_title, item_price FROM store_items WHERE cat_id = '".$cat_id."' ORDER BY item_title";
			   $get_items_res = $mysqli->query($get_items_sql) or die("Couldn't connect");

			   if ($get_items_res->num_rows < 1) 
					$display_block = "<p class='text-danger'><em>Sorry, no items in this category.</em></p>";
				//else{
					$display_block .= "<ul style='list-style-type: none; '>";

					while ($items = $get_items_res->fetch_array()) {
					
					   $item_id  = $items["id"];
					   $item_title = stripslashes($items["item_title"]);
					   $item_price = $items["item_price"];

					   $display_block .= "<li style='font-size: 20px;'><a href=\"showitem.php?item_id=".$item_id."\">".$item_title."</a></strong> (\$".$item_price.")</li>";
					}

					$display_block .= "</ul>";
				//}

				//free results
				$get_items_res->free();

			}
			
		}
	
	}
}
//free results
$get_cats_res->free();

//close connection to MSSQL
$mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" lang="en">
    <title>Store</title>
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
</body>



<footer id="footerD" class="text-center text-warning">
    What Kind of Shop are we?<br>
    <a href="Index.php"> <img src="Images/logo.png" style="height: 75px; width: 75px;"> </a>
    <p>Phone: 123-456-0987 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email:
        <a href="mailto:wks@hotail.com" class="text-warning">wks@hotmail.com</a></p>
</footer>


</html>