<?php
session_start();


if (isset($_GET["idL"])) {
	


    $data = unserialize($_COOKIE["track"]);
//    echo print_r($data);
    if(sizeof($data) == 1){
        $track = array();
        setcookie("track", serialize($track),time()-1, "/");
    }
    else
    foreach ($data as $i=>$val){
        if($val[2] == $_GET["idL"]){
            unset($data[$i]);
            setcookie("track", serialize($data), time()+3600000, "/");
        }
    }



//redirect to showcart page
header("Location: showcart.php");
}
else{
//send them somewhere else
header("Location: seestore.php");
$mysqli->close();
exit();
}

?>