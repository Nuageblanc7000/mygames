<?php
session_start();
if(!isset($_SESSION['level']) and $_SESSION['level']!=="admin"){
    header("LOCATION:index.php");
    }

    if(isset($_GET['id']) and !empty($_GET['id'])){
        require "../connection.php";
        $idGames=htmlspecialchars($_GET['id']);
        //verification de l'id reçu en get
        $verifIds = ('SELECT * from game where PK_game=?');
        $verifIdRequests = $bd -> prepare($verifIds);
        $verifIdRequests -> execute([$idGames]);
        if(!$donGames = $verifIdRequests -> fetch()){
            $err=2;
        }$verifIdRequests -> closeCursor();
    }else{
        $err=1;
    }

$genre = $_POST['genres'];
var_dump($genre);
?>