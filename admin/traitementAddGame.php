<?php
session_start();
if(!isset($_SESSION['level']) and ($_SESSION['level']!=="admin" or $_SESSION['level']!=="batDev") ){
header("LOCATION:index.php");
}

if(isset($_POST['name_game'])){
$err=0;
if(empty($_POST['name_game'])){
    
    $err=1;
}else{
    $name_game = htmlspecialchars($_POST['name_game']);
}
if(empty($_POST['date_game'])){
    $err=2;
}else{
    $name_game = htmlspecialchars($_POST['date_game']);
}
if(empty($_POST['describe_game'])){
    $err=3;
}else{
    $name_game = htmlspecialchars($_POST['describe_game']);
}

if(empty($_POST['genres'])){
    $err=4;
}else{
    $name_game = $_POST['genres'];
}
if(empty($_POST['consoles'])){
    $err=5;
}else{
    $name_game = $_POST['consoles'];
}

if($err==0){

}else{
    header("LOCATION:addGame?error=$err");
}

}else{
    header("LOCATION:dashboard.php");
}