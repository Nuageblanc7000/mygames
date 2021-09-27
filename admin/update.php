<?php
session_start();
if(!isset($_SESSION['level']) and ($_SESSION['level']!=="admin" or $_SESSION['level']!=="batDev") ){
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
include "includes/header.php";
echo'
<main class="container">

<div class="row m-auto">';
// si le fichier à bien était modifié on confirme avec ce petit message.
if(isset($_GET['success'])){
    
    echo'<div class="col-12 bg-success text-center"><h4>le fichier portant l\'id'.' '.$don['PK_game'].' '.'à bien était modifié</h4></div>';
}
//gestion des erreurs envoyées en get dans le traitement.
if(isset($_GET['error'])){
    if($_GET['error']==1){
        echo'<div class="col-12 bg-danger text-center"><h4>veuillez indiquer un nom au jeux</h4></div>';
    }elseif($_GET['error']==2){
        echo'<div class="col-12 bg-danger text-center"><h4>veuillez indiquer une date</h4></div>';   
    }elseif($_GET['error']==3){
        echo'<div class="col-12 bg-danger text-center"><h4>veuillez indiquer une description</h4></div>';   
    }elseif($_GET['error']==4){
        echo'<div class="col-12 bg-danger text-center"><h4>Il faut au minimum un genre pour le jeu</h4></div>';
    }elseif($_GET['error']==5){
        echo'<div class="col-12 bg-danger text-center"><h4>la taille de l\'image dépasse la taille autorisée</h4></div>';
    }elseif($_GET['error']==6){
        echo'<div class="col-12 bg-danger text-center"><h4>Veuillez vérifier l\'extension de votre image</h4></div>';
    }elseif($_GET['error']==7){
        echo'<div class="col-12 bg-danger text-center"><h4>Veuillez indiquer au minimum une plateforme</h4></div>';
    }
}
echo'
<form action="traitementUpdate.php?id='.$don['PK_game'].'" method="post" enctype="multipart/form-data">
';
echo'
<div class="col-12">';
// on va créer une requête avec des lefts join pour avoir toute nos genres on va gérer puis on vient faire un left join afin d'aller chercher la table
// intermèdiaire et avoir nos genres qui sont lié aux jeux sélectionné.
    $viewGenre = ('SELECT * FROM game_genre gg RIGHT JOIN genre g ON g.PK_genre  = gg.FK_genre AND gg.FK_game = ?');
$verifGenre = $bd -> prepare($viewGenre);
$verifGenre -> execute([$idGame]);
// ici je viens afficher mes genres et je donne une condition si c'est égale ma FOREIGN KEY de la table intermédiaire est égale
// à mon id alors je ferais en sorte que mes checkbox soit déjà check. Sinon on affiche noramelement le reste
while($donSelectGenre = $verifGenre ->fetch()){
    if ($idGame == $donSelectGenre['FK_game'])
    {
        echo '<div class="form-check">';
        echo '<input class="form-check-input" type="checkbox" name="genres[]" value="'.$donSelectGenre['PK_genre'].'" checked>';
        echo '<label class="form-check-label">'.$donSelectGenre['name_genre'].'</label>';
        echo '</div>';
    } else {
        echo '<div class="form-check">';
        echo '<input class="form-check-input" type="checkbox" name="genres[]" value="'.$donSelectGenre['PK_genre'].'">';
        echo '<label class="form-check-label">'.$donSelectGenre['name_genre'].'</label>';
        echo '</div>';
    }
}
$verifGenre -> closeCursor();


//gestion des Plateformes

$viewConsoles = ('SELECT * FROM game_consoles gc RIGHT JOIN consoles cons ON cons.PK_consoles  = gc.FK_consoles AND gc.FK_game = ?');
$verifConsoles = $bd -> prepare($viewConsoles);
$verifConsoles -> execute([$idGame]);
// on va maintenant afficher les consoles en vérifiant si elles sont cohée ou non
while($donSelectConsoles = $verifConsoles ->fetch()){
    if ($idGame == $donSelectConsoles['FK_game'])
    {
        echo '<div class="form-check form-switch">';
        echo '<input class="form-check-input" type="checkbox" name="consoles[]" value="'.$donSelectConsoles['PK_consoles'].'" checked>';
        echo '<label class="form-check-label">'.$donSelectConsoles['names_consoles'].'</label>';
        echo '</div>';
    } else {
        echo '<div class="form-check form-switch">';
        echo '<input class="form-check-input" type="checkbox" name="consoles[]" value="'.$donSelectConsoles['PK_consoles'].'">';
        echo '<label class="form-check-label">'.$donSelectConsoles['names_consoles'].'</label>';
        echo '</div>';
    }
}
$verifConsoles -> closeCursor();

echo'
</div>
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


