<?php
$viewGamesConsoles =('SELECT game.* ,consoles.name_consoles as nameC FROM game_consoles INNER JOIN game ON PK_game.game = FK_game.game_consoles 
INNER JOIN consoles ON PK_consoles = FK_consoles where 
where FK_consoles=?');
$request = $bd -> query($viewGames);
?>
<section class="bgVar">
        <div id="news" class="wrapper">
<?php            
while($dons = $request ->fetch()){
    echo'
    ';
    }
    $request -> closeCursor();
    ?>
</div>
</section>