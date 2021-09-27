<?php
session_start();
if(!isset($_SESSION['level']) and $_SESSION['level']!=="admin"){
    header("LOCATION:index.php");
    }
if(isset($_GET['id']) and  !empty($_GET['id'])){
    $idUpdateGame = htmlspecialchars($_GET['id']);
}else{ 
    header("LOCATION:dashboard.php");
}
require '../connection.php';
$sqlIdGame = ("SELECT * FROM game where PK_game=?");
$reqVerifIdGame = $bd ->prepare($sqlIdGame);
$reqVerifIdGame -> execute([$idUpdateGame]);
if(!$donGames = $reqVerifIdGame ->fetch()){
   $reqVerifIdGame -> closeCursor();
    header("LOCATION:dashboard.php");
}
$reqVerifIdGame -> closeCursor();
//à partir d'ici on va vérifier si le formulaire existe puis on va vérifier erreur par erreur
if(isset($_POST['name_game'])){
$err=0;
if(empty($_POST['name_game'])){
    $err=1;
}else{
    $gameName = htmlspecialchars($_POST['name_game']);
}
if(empty($_POST['date_game'])){
    $err=2;
}else{
    $gameDate = htmlspecialchars($_POST['date_game']);
}
if(empty($_POST['describe_game'])){
    $err=3;
}else{
    $gameDescribe = htmlspecialchars($_POST['describe_game']);
}
if(empty($_POST['genres'])){
    $err=4;
}else{
    $genres=$_POST['genres'];
}
if($err==0){
    //on crée aussi les genre à partir d'ici comme ça si avant il y a eu un problème avec le jeu les gens ne sont pas envoyé seul
    
    $sqlDeleteGenre =("DELETE  FROM game_genre where FK_game=:FkGame");
    $reqDeleteeGenre = $bd -> prepare($sqlDeleteGenre);
    $reqDeleteeGenre -> execute([
        ':FkGame' => $idUpdateGame]);
        for ($i=0; $i < count($genres) ; $i++) { 
            htmlspecialchars($genres[$i]);
            $sqlUdpateGenre =("INSERT INTO game_genre  (FK_genre,FK_game) values(?,?)");
            $reqUpdateGenre = $bd -> prepare($sqlUdpateGenre);
            $reqUpdateGenre -> execute([$genres[$i],$idUpdateGame]);
    if(empty($_FILES['img_game']['tmp_name'])){
        $sqlUpdate =("UPDATE game SET name_game=:nameG, date_game=:dGame,describe_game=:descGame WHERE PK_game=:id");
        $reqUpdates = $bd -> prepare($sqlUpdate);
        $reqUpdates -> execute(
            [
                "nameG" => $gameName,
                "dGame" => $gameDate,
                "descGame" => $gameDescribe,
                "id" => $idUpdateGame
            ]
        );
        header("LOCATION:update?id=".$donGames['PK_game']."&success");
    }else{
        unlink('../img/'.$don['game_img'].'')
    }
}
        
}else{
    //si une erreur est détectée on renvoi l'erreur en GET
    header("LOCATION:update?id=".$donGames['PK_game']."&error=$err");
}
}else{
    header("LOCATION:dashboard.php");
}
