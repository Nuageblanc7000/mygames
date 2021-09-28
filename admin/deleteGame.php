<?php
session_start();
if(!isset($_SESSION['level']) and $_SESSION['level']!=="admin"){
header("LOCATION:index.php");
}

    if(isset($_GET['id']) and  !empty($_GET['id'])){
        $idDeleteGame = htmlspecialchars($_GET['id']);
    }else{ 
      header("LOCATION:dashboard.php");
    }
    require '../connection.php';
    $sqlVerifIdGame = ("SELECT * FROM game where PK_game=?");
    $reqVerifIdGame = $bd ->prepare($sqlVerifIdGame);
    $reqVerifIdGame -> execute([$idDeleteGame]);
    if(!$donGames = $reqVerifIdGame ->fetch()){
       $reqVerifIdGame -> closeCursor();
     header("LOCATION:dashboard.php");
    }else{
        unlink("../img/".$donGames['img_game']);
        unlink('../img/Mini_'.$donGames['img_game']);

        $sqlDeleteGenre =("DELETE  FROM game_genre where FK_game=:FkGame");
        $reqDeleteeGenre = $bd -> prepare($sqlDeleteGenre);
        $reqDeleteeGenre -> execute([
        ':FkGame' => $idDeleteGame]);
        $reqDeleteeGenre -> closeCursor();

        $sqlDeleteConsoles =("DELETE  FROM game_consoles where FK_game=:FkGame");
        $reqDeleteeConsoles = $bd -> prepare($sqlDeleteConsoles);
        $reqDeleteeConsoles -> execute([
            ':FkGame' => $idDeleteGame]);
        $reqDeleteeConsoles -> closeCursor();

        $sqlDeleteGame =("DELETE  FROM game where PK_game=:PkGam");
        $reqDeleteeGame = $bd -> prepare($sqlDeleteGame);
        $reqDeleteeGame -> execute([
            ':PkGam' => $idDeleteGame]);
        
        $reqDeleteeGame -> closeCursor();
        
        header("LOCATION:dashboard.php?del=success");
    }



    $reqVerifIdGame -> closeCursor();
?>
