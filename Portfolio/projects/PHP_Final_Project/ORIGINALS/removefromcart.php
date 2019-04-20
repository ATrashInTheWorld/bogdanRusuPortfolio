<?php
//connect to database
$mssql = mssql_connect("NEWPC\SQLEXPRESS", "", "");
$db = mssql_select_db("Storefront", $mssql);
if (isset($_GET["id"])) {
$delete_item_sql = "DELETE FROM store_shoppertrack WHERE id = '".$_GET["id"]."' and session_id = '".$_COOKIE["PHPSESSID"]."'";
//redirect to showcart page
header("Location: showcart.php");
exit();
//send them somewhere else
header("Location: seestore.php");
exit();

?>