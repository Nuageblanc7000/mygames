<?php
if(!isset($_SESSION['level']) and $_SESSION['level']!=="administrateur"){
    header("LOCATION:../index.php");
}