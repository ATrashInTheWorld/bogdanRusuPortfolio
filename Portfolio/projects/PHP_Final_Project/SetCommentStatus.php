<?php
$file = simplexml_load_file("Products.xml");
foreach ($file->prod as $val){
    if($val->attributes()->id == $_GET["prodid"])
        foreach ($val->comment as $val2){
            if($val2->attributes()->id == $_GET["comid"]){
                if(isset($_GET["y"]))
                $val2->attributes()->status = "good";
                elseif (isset($_GET["n"]))
                    $val2->attributes()->status = "rejected";
                break(2);
            }
        }
}
file_put_contents("Products.xml", $file->asXML());

header("Location: CommentsEvaluation.php");





?>