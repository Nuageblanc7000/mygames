<?php
session_start();
if(!isset($_SESSION['level']) and $_SESSION['level']!=="admin"){
header("LOCATION:../index.php");
}
?>