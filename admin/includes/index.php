<?php
session_start();
if(!isset($_SESSION['level']) and ($_SESSION['level']!=="admin" or $_SESSION['level']!=="batDev")){
    header("LOCATION:../index.php");
}
?>