<?php
session_start();
if(isset($_POST['login'])){

if(!empty($_POST['login']) and !empty($_POST['password'])){

$login = htmlspecialchars($_POST['login']);
$password = htmlspecialchars($_POST['password']);
require "../connection.php";
$verifUser = ("SELECT * from membres where member_name=:membreN");
$reqUser = $bd -> prepare($verifUser);
$reqUser -> execute([':membreN' => $login]);

if(!$donUser = $reqUser -> fetch()){
    $err=3;
}else{
    if(!password_verify($password,$donUser['member_password'])){
        $err=4;
    }else{
        if($donUser['level'] !== "admin"){
            $err=5;
        }else{
            $_SESSION['level']=$donUser['level'];
            header("LOCATION:dashboard.php");
        }

    }
}

}else{
    $err=2;
}

}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.1/js/bootstrap.min.js" integrity="sha512-ewfXo9Gq53e1q1+WDTjaHAGZ8UvCWq0eXONhwDuIoaH8xz2r96uoAYaQCm1oQhnBfRXrvJztNXFsTloJfgbL5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script></head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.1/css/bootstrap.min.css" integrity="sha512-6KY5s6UI5J7SVYuZB4S/CZMyPylqyyNZco376NM2Z8Sb8OxEdp02e1jkKk/wZxIEmjQ6DRCEBhni+gpr9c4tvA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <body>
    <div class="container vh-100">
        <div class="row">
        <h4 class="h-4 text-center">Administration:</h4>
        <form action="index.php" method="post">
            <div class="group mb-3">

                <label for="login" class="form-label">Login:</label>
                <input class="form-control"type="text" name="login" id="login">
            </div>
            <div class="group mb-3">
                
                <label for="password" class="form-label">password:</label>
                <input class="form-control" type="password" name="password" id="password">
            </div>
            <button class="btn btn-primary mt-1 m-auto d-block" type="submit">Connexion</button>
        </form>
        <?php
        if(isset($err)){
         echo '<div class="alert alert-danger alert-dismissible fade show">';
           if($err==1){
                echo "les champs n'existent pas";
            }elseif($err==2){
                echo "champs vide";
            }elseif($err==3){
                echo "pseudo inconnu";
            }elseif($err==4){
                echo "password inconnu";
            }else{
                echo "vous n'avez pas le level requis";
            }
           echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        echo '</div>';
    }
    ?>
        </div>
    </div>
    
</body>
</html>