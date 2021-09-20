<?php
$nameDb='mygames';
$user='root';
$pass='';
try {

    $bd = new PDO('mysql:host=localhost;dbname='.$nameDb.';charset=utf8',$user,$pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur: ' . $e->getMessage());
}