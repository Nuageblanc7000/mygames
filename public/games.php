
<section class="bgVar" data-bg=img/<?=$don['bg_game']?>>

        <div id="news" class="wrapper">
            <div class="games">
                <div class="gameImg">
                    <img src="img/<?= $don['img_game']?>" alt="<?= $don['name_game']?>">
                </div>

                <div class="cardInfo">

                <!-- WORKING PROGRESS !! -->
                <div class="categorie">
                        <?php
                        $viewGamesConsoles =('SELECT game.* ,consoles.names_consoles as nameC, FK_consoles AS Fkc, FK_game AS Fkg FROM game_consoles INNER JOIN game ON game.PK_game = game_consoles.FK_game 
                        INNER JOIN consoles ON PK_consoles = FK_consoles
                        where FK_game=?');
                        $test = $bd -> prepare($viewGamesConsoles);
                        $test ->execute([$idGame]);

                        while($donsConsoles = $test -> fetch()){

                            echo '<a href="index.php?action=categories&id='.$donsConsoles['Fkc'].'" class="cat">'.$donsConsoles['nameC'].'</a>';
                        }
                        $test -> closeCursor();
                        ?>
                        
                        
                    </div>
<!---------------------------------!! -->

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