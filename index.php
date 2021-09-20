<?php
require "connection.php";

// si $get action existe alors je crée le rooting que j'utiliserais
if(isset($_GET['action']))
{
    //création du tableau qui va me servir de rooter
$rooting =[
"home" => "home.php",
"inscription" => "inscription.php",
"games" => "games.php"
];
//puis ici je vais vérfier que ce qui est dans mon get action est égale à ce qu'il y a dans le tableau
if(array_key_exists($_GET['action'],$rooting))
{
     //si l'info est dans le tableau alors on on dit que action sera egale à get action sinon on le renvoi sur une page 404
     $action=$rooting[$_GET['action']];
     //verification de l'id reçu en get
    if(isset($_GET['id']) and !empty($_GET['id'])){
    
        $id=htmlspecialchars($_GET['id']);

        if($_GET['action'] =="games"){ 

            $verifId = ('SELECT * from game where PK_game=?');
            $verifIdRequest = $bd -> prepare($verifId);
            $verifIdRequest -> execute([$id]);
            if(!$don = $verifIdRequest -> fetch()){
                $action = "404.php"; 
                header("HTTP/1.1 404 Not Found");
            }
        }
    
    
    }else{
        $action = "404.php"; 
        header("HTTP/1.1 404 Not Found");
    }
    
    
}else{
    $action = "404.php"; 
    header("HTTP/1.1 404 Not Found");
}

}else{
    $action="home.php";
}
include "includes/header.php";
require 'public/'.$action;
include "includes/footer.php";
?>