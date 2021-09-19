<?php
if(isset($_GET['action']))
{
$rooting =[
"home" => "home.php",
"inscription" => "inscription.php"
];
if(array_key_exists($_GET['action'],$rooting))
{
    $action=$rooting[$_GET['action']];
    
{
    $action = "404.php"; 
    header("HTTP/1.1 404 Not Found");
}

}else
{
    $action="home.php";
}
include "includes/header.php";
require 'public/'.$action;
include "includes/footer.php";
?>

