<?php
session_start();
if(!isset($_SESSION['level']) and ($_SESSION['level']!=="admin" or $_SESSION['level']!=="batDev") ){
header("LOCATION:index.php");
}
require "../connection.php";
$sqlViewGenre = ("SELECT * from genre");
$reqViewGenre = $bd -> query($sqlViewGenre);
$sqlViewConsoles = ("SELECT * from consoles");
$reqViewConsoles = $bd -> query($sqlViewConsoles);


include "includes/header.php";
?>
<main class="container h-auto">
    <?php
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
?>
    <div class="row h-auto">

        <form action="traitementAddGame.php" method="post" enctype="multipart/form-data">
        <label class="form-label" for=id="name_game">Nom du Jeu</label>    
        <input class="form-control" name="name_game" type="text" id="name_game">
        
        <label class="form-label" for=id="date_game">Date de sortie</label>    
        <input class="form-control" name="date_game" type="date" id="date_game">
        
        <label class="form-label" for=id="">Description du jeux</label>    
        <textarea class="form-control" name="description_game" id="description_game" cols="30" rows="10"></textarea>
        
        <div class="col-auto h-auto mt-2 mb-2 border border-warning">
            <h4 class="text-center">Genres:</h4>
            <div class="col-12 h-auto">
        <?php
        //affichage des genres
        while($donGenres = $reqViewGenre -> fetch()){
        
            echo '<div class=" form-check form-switch m-2">';
            echo '<input  class=" form-check-input form-switch" type="checkbox" name="genres[]" value="'.$donGenres['PK_genre'].'">';
            echo '<label class="p-1 form-check-label">'.$donGenres['name_genre'].'</label>';
            echo '</div>';
        }
        $reqViewGenre -> closeCursor();
        ?>
        </div>
        </div>

        <div class="col-auto h-auto mt-2 mb-2 border border-warning">
            <h4 class="text-center">Plateformes:</h4>
            <div class="col-12 h-auto d-flex flex-wrap justify-content-center">
        <?php
        //affichage des plateformes
        while($donConsoles = $reqViewConsoles -> fetch()){
        
            echo '<div class="form-check form-switch m-2">';
            echo '<input  class="form-check-input form-switch" type="checkbox" name="genres[]" value="'.$donConsoles['PK_consoles'].'">';
            echo '<label class="p-1 form-check-label">'.$donConsoles['names_consoles'].'</label>';
            echo '</div>';
        }
        $reqViewConsoles -> closeCursor();
        ?>
        </div>
        </div>
        <label class="form-label" for="img_game">Ajouter une image</label>
        <input type="file" name="img_game" id="img_name" class="form-control">

        <div class="col-12 d-flex justify-content-evenly mt-1 mb-1">
            <button type="submit" class="btn btn-primary">Ajouter</button>
            <a href="dashBoard.php" class="btn btn-warning">Annuler</a>
        </div>
        </form>
    </div>
</main>

    <?php include "includes/footer.php";