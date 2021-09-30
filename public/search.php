
    <?php
if(isset($_POST["search"])){
$search = $_POST['search'];
    $sqlSearch = ("SELECT * from game where name_game like :game");
    $reqSearch = $bd -> prepare($sqlSearch);
    $reqSearch -> execute([":game" => "%".$search."%"]);
echo'
    <section class="bgVar">
    <div id="news" class="wrapper">';     
while($donSearch = $reqSearch ->fetch() ){

    echo'
    <div class="item-grid">
    <a href="index.php?action=games&id='.$donSearch['PK_game'].'">
    ';
    echo'
    <img src="img/'.$donSearch['img_game'].'" alt="cyber">
    </a>
    </div>
   ';
}
$reqSearch -> closeCursor();
if(!$reqSearch -> rowCount()){
    echo "aucun résultat trouvé";
}
echo'
</div>
</section>';
}
?>


