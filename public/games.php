
<section class="bgVar" data-bg=img/<?=$don['bg_game']?>>

        <div id="news" class="wrapper">
            <div class="games">
                <div class="gameImg">
                    <img src="img/<?= $don['img_game']?>" alt="<?= $don['name_game']?>">
                </div>

                <div class="cardInfo">
                    <h1><?=$don['name_game']?></h1>
                    <div class="describe_game">

                        <p><?=$don['describe_game']?></p>
                    </div>

                    <div class="categorie">
                        <?php
                         $sqlCatego = ('SELECT game.*,  genre.name_genre as genreName , FK_genre as FkGenre FROM `game_genre` INNER JOIN genre
                         ON genre.PK_genre =  game_genre.FK_genre  INNER JOIN game ON game.PK_game = game_genre.FK_game where game.PK_game=?');
                         $categoIdRequest = $bd -> prepare($sqlCatego);
                         $categoIdRequest -> execute([$idGame]);

                        while($donsCat = $categoIdRequest -> fetch()){

                            echo '<a href="index.php?action=categories&id='.$donsCat['FkGenre'].'" class="cat">'.$donsCat['genreName'].'</a>';
                        }
                        $categoIdRequest -> closeCursor();
                        ?>
                        
                        
                    </div>

                    </div>
                </div>
    <div>
    </section>