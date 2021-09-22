<?php
require "connection.php";

// si $get action existe alors je crée le rooting que j'utiliserais
if(isset($_GET['action']))
{
    //création du tableau qui va me servir de rooter
$rooting =[
"home" => "home.php",
"inscription" => "inscription.php",
"games" => "games.php",
"categories" => "categories.php"
];
//puis ici je vais vérfier que ce qui est dans mon get action est égale à ce qu'il y a dans le tableau
if(array_key_exists($_GET['action'],$rooting))
{
    
    
    if($_GET['action'] =="games"){ 
        if(isset($_GET['id']) and !empty($_GET['id'])){
            $idGame=htmlspecialchars($_GET['id']);
            //verification de l'id reçu en get
            
            $verifId = ('SELECT * from game where PK_game=?');
            $verifIdRequest = $bd -> prepare($verifId);
            $verifIdRequest -> execute([$idGame]);
            if(!$don = $verifIdRequest -> fetch()){
                $action = "404.php"; 
                header("HTTP/1.1 404 Not Found");
            }else{
                $action =$rooting["games"];
            }
            $verifIdRequest -> closeCursor();
        }else{
            $action = "404.php"; 
            header("HTTP/1.1 404 Not Found");
        }
    }elseif(isset($_GET['action'])=="categories"){
        if(isset($_GET['id']) and !empty($_GET['id'])){
            $idCat = htmlspecialchars($_GET['id']);
          $verifIdCat =("SELECT * from genre where PK_genre=?");
          $verifIdCatRequest = $bd ->prepare($verifIdCat);
          $verifIdCatRequest -> execute([$idCat]);
          if(!$donCat = $verifIdCatRequest -> fetch()){
            $action = "404.php"; 
            header("HTTP/1.1 404 Not Found");   
          }else{
            $action=$rooting['categories'];
          }
          
        }else{
            $action = "404.php"; 
            header("HTTP/1.1 404 Not Found");
        }
    }
    
    else{
        //si l'info est dans le tableau alors on on dit que action sera egale à get action sinon on le renvoi sur une page 404
        $action=$rooting[$_GET['action']];
        
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