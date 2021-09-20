<?php
$viewGames =('SELECT * FROM game order by date_game desc');
$request = $bd -> query($viewGames);
?>
<section class="bgVar">
        <div id="news" class="wrapper">
<?php            
while($dons = $request ->fetch() ){
    echo'
            <div class="item-grid">
           <a href="index.php?action=games&id='.$dons['PK_game'].'">
           <img src="img/'.$dons['img_game'].'" alt="cyber">
        </a>
       </div>
       ';
    }
    $request -> closeCursor();
    ?>
</div>
</section>