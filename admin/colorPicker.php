<?php
session_start();
if(!isset($_SESSION['level']) and ($_SESSION['level']!=="admin") ){
header("LOCATION:index.php");
}
if(isset($_GET['id']) and !empty($_GET['id'])){
    $id=htmlspecialchars($_GET['id']);
}else{
    header("LOCATION:dashboard.php");
}
require "../connection.php";
    $sqlVerifId = ("SELECT * from game where PK_game=?");
    $reqVerifId = $bd ->prepare($sqlVerifId);
    $reqVerifId -> execute([$id]);
    if($donVerifId = $reqVerifId ->fetch()){
        $err=12;
    }
?>

<?php
include "includes/header.php";
?>
<div class="container-fluid d-flex justify-content-center align-items-center min-vh-100"style="background:url(../img/<?= $donVerifId['bg_game'] ?>);background-repeat:no-repeat;background-size:cover;">
    <div class="row flex-columns">
        <form class="d-flex flex-column align-items-center" action="treatmentTheme.php?id=<?= $id ?>">
            <input class="picker" type="color" name="color" id="">
            <button type="submit" class="btn btn-primary">Envoyer la couleur</button>
        </form>
    </div>
</div>
<?php
include "includes/footer.php";
?>