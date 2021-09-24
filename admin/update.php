<?php
session_start();
if(!isset($_SESSION['level']) and $_SESSION['level']!=="admin"){
header("LOCATION:index.php");
}

if(isset($_GET['id']) and !empty($_GET['id'])){
    require "../connection.php";
    $idGame=htmlspecialchars($_GET['id']);
    //verification de l'id reçu en get
    $verifId = ('SELECT * from game where PK_game=?');
    $verifIdRequest = $bd -> prepare($verifId);
    $verifIdRequest -> execute([$idGame]);
    if(!$don = $verifIdRequest -> fetch()){
        header("HTTP/1.1 404 Not Found");
    }
    $verifIdRequest -> closeCursor();
}else{
    header("HTTP/1.1 404 Not Found");

}
$viewGenres = ('SELECT * from genre');
$verifGenres = $bd -> query($viewGenres);

$viewGenre = ('SELECT genre.name_genre as genreN,genre.PK_genre as PkGenre, game_genre.FK_game as FkGame from game_genre 
LEFT JOIN genre ON genre.PK_genre = FK_genre 
LEFT JOIN game ON game.PK_game =FK_game');
$verifGenre = $bd -> query($viewGenre);
include "includes/header.php";
echo'
<main class="container">
<div class="row m-auto">
<form action="traitementUpdate.php?id='.$don['PK_game'].'" method="post" enctype="multipart/form-data">
';
   while($donSelectGenre = $verifGenre ->fetch()){
    if ($donSelectGenre['FkGame'] == $idGame)
    {
        echo '<div class="form-check">';
        echo '<input class="form-check-input" type="checkbox" name="genres[]" value="'.$donSelectGenre['PkGenre'].'" checked>';
        echo '<label class="form-check-label">'.$donSelectGenre['genreN'].'</label>';
        echo '</div>';
    } else {
        echo '<div class="form-check">';
        echo '<input class="form-check-input" type="checkbox" name="genres[]" value="'.$donSelectGenre['PkGenre'].'">';
        echo '<label class="form-check-label">'.$donSelectGenre['genreN'].'</label>';
        echo '</div>';
    }
   }

    echo'
    </label>
    <label for="name_game" class="form-label">Non du jeux:</label>
    <input  class="form-control" type="text" name="name_game" id="name_game" value="'.$don['name_game'].'">
    <label for="date_game" class="form-label">Date de sortie:</label>
    <input   class="form-control" type="date" name="date_game" id="date_game" value="'.$don['date_game'].'">
    <label for="describe_game" class="form-label">Description du jeux:</label>
    <textarea class="form-control" name="describe_game" id="describe_game" cols="30" rows="10">'.$don['describe_game'].'</textarea>
    <label for="describe_game" class="form-label">modifié image:</label>
    <input class="form-control" type="file" name="img_game" id="img_game">
    
    <button type="submit" class="btn btn-warning">Modifié</button>
    <a href="dashboard.php" class="btn btn-danger">Annuler</a>
    </form>
    </div>
    </main>
    ';
include "includes/footer.php";

?>


