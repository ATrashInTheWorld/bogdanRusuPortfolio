<?php
$lastUrl = $_SERVER['HTTP_REFERER'];

if(isset($_POST["login"])) {
    $user = $_POST["username"];
    $pass = $_POST["password"];

    if(strpos($lastUrl,"loginForm.php")>0)
        $lastUrl = "index.php";


    if (!empty($user) & !empty($pass)) {
        $b = false;
        $file = file_get_contents("users.json");
        $json = json_decode($file, true);
        foreach ($json["users"] as $val) {
            foreach ($val as $userL) {
                if ($user == $userL["name"]) {
                    if ($pass == $userL["pass"]) {
                        $b = true;
                        setcookie("user", $user, time() + 300, "/");
                        header("Location: $lastUrl");
                    }

                }
            }
        }
        if(!$b)
            header("Location: loginForm.php?m=Username or Password was wrong!!!");
    } else
        header("Location: loginForm.php?m=Please do not let any field empty!");
}

if(isset($_POST["logout"])){
    setcookie("user", "none", time() + 300, "/");

    if(strpos($lastUrl,"AdminDiscounts.php")>0
        || strpos($lastUrl, "CommentsEvaluation.php")>0
        || strpos($lastUrl, "Order.php")>0
        || strpos($lastUrl, "Confirm.php")>0
        || strpos($lastUrl, "tkx.php")>0)
        $lastUrl = "index.php";

    header("Location: $lastUrl");
}
?>