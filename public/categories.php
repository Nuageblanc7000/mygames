
<section class="bgVar">
        <div id="news" class="wrapper">
    <?php
$sqlCatego = ('SELECT game.*,  genre.name_genre as genreName , FK_genre as FkGenre FROM `game_genre` INNER JOIN genre
                         ON genre.PK_genre =  game_genre.FK_genre  INNER JOIN game ON game.PK_game = game_genre.FK_game 
                         where FK_genre=?');
                         $categoIdRequest = $bd -> prepare($sqlCatego);
                         $categoIdRequest -> execute([$idCat]);
if(!$categoIdRequest -> rowCount()){
  echo ' <h1>Aucun jeux disponible pour la catégorie</h1>';
}else{
    
    while($donsCat = $categoIdRequest -> fetch()){
        echo'
<div class="item-grid">
<a href="index.php?action=games&id='.$donsCat['PK_game'].'">
<img src="img/'.$donsCat['img_game'].'" alt="cyber">
</a>
</div>
';
    }
    $categoIdRequest -> closeCursor();
}
                        ?>
                        </div>
</section>