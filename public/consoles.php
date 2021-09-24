<?php
$viewGamesConsoles =('SELECT game.* ,consoles.names_consoles as nameC  FROM game_consoles INNER JOIN game ON game.PK_game = game_consoles.FK_game 
INNER JOIN consoles ON PK_consoles = FK_consoles  
where FK_consoles=?');
$requestViewConsoles = $bd -> prepare($viewGamesConsoles);
$requestViewConsoles -> execute([$idConsoles]);
?>
<section class="bgVar">
        <div id="news" class="wrapper">
<?php  
if(!$requestViewConsoles ->rowCount()){
    echo ' <h1>Aucun jeux disponible pour la catégorie</h1>';
}else{

    while($donsConsoles = $requestViewConsoles ->fetch()){
        echo'
        <div class="item-grid">
       <a href="index.php?action=games&id='.$donsConsoles['PK_game'].'">
       <img src="img/'.$donsConsoles['img_game'].'" alt="'.$donsConsoles['name_game'].'">
    </a>
    </div>
    ';
        }   
    }
    $requestViewConsoles-> closeCursor();
    ?>
</div>
</section>