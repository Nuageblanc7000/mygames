<?php
session_start();
if(!isset($_SESSION['level']) and $_SESSION['level']!=="admin"){
header("LOCATION:index.php");
}
if(isset($_GET['id'])){
    $id=htmlspecialchars($_GET['id']);
    require "../connection.php";
    $sqlVerifId = ("SELECT * from game where PK_game=?");
    $reqVerifId = $bd ->prepare($sqlVerifId);
    $reqVerifId -> execute([$id]);
    if(!$donVerifId = $reqVerifId ->fetch()){
        header("LOCATION:index.php");
    }
    $reqVerifId ->closeCursor();
}
if(isset($_POST['picker']) and !empty($_POST['picker'])){
    $picker = htmlspecialchars($_POST['picker']);

    $sqlInsertColor = ("UPDATE  game SET theme=:theme where PK_game=:id");
    $reqInsertColor = $bd -> prepare($sqlInsertColor);
    $reqInsertColor -> execute([":theme" => $picker, ":id" => $id]);
    $reqInsertColor -> closeCursor();
    header("LOCATION:dashboard.php?successModif");
}

?>