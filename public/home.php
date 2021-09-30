<?php
$viewGames =('SELECT *  FROM game order by date_game desc');
$request = $bd -> query($viewGames);

//création d'un système d'expiration.
$dateExpire = date("Y-m-d");
$dayExpire = " +1 day";
$dateExpire = strtotime(date("Y-m-d", strtotime($dateExpire)) . $dayExpire);
?>
<section class="bgVar">
        <div id="news" class="wrapper">
                <?php            
while($dons = $request ->fetch() ){
        $dateDuJeu = strtotime($dons['date_ajout_game']);
        echo'
        <div class="item-grid">
        <a href="index.php?action=games&id='.$dons['PK_game'].'">
        ';
        if($dateDuJeu <= $dateExpire){
                
                echo'
                <div class="news">News</div>';
        }
        echo'
        <img src="img/'.$dons['img_game'].'" alt="cyber">
        </a>
        </div>
       ';
    }
    $request -> closeCursor();
    ?>
</div>
</section>