<?php
session_start();
if(!isset($_SESSION['level']) and $_SESSION['level']!=="admin"){
    header("LOCATION:index.php");
    }
if(isset($_GET['id']) and  !empty($_GET['id'])){
    $idUpdateGame = htmlspecialchars($_GET['id']);
}else{ 
    header("LOCATION:dashboard.php");
}
require '../connection.php';
$sqlIdGame = ("SELECT * FROM game where PK_game=?");
$reqVerifIdGame = $bd ->prepare($sqlIdGame);
$reqVerifIdGame -> execute([$idUpdateGame]);
if(!$donGames = $reqVerifIdGame ->fetch()){
   $reqVerifIdGame -> closeCursor();
    header("LOCATION:dashboard.php");
}
$reqVerifIdGame -> closeCursor();
//à partir d'ici on va vérifier si le formulaire existe puis on va vérifier erreur par erreur
if(isset($_POST['name_game'])){
$err=0;
if(empty($_POST['name_game'])){
    $err=1;
}else{
    $gameName = htmlspecialchars($_POST['name_game']);
}
if(empty($_POST['date_game'])){
    $err=2;
}else{
    $gameDate = htmlspecialchars($_POST['date_game']);
}
if(empty($_POST['describe_game'])){
    $err=3;
}else{
    $gameDescribe = htmlspecialchars($_POST['describe_game']);
}
if(empty($_POST['genres'])){
    $err=4;
}else{
    $genres=$_POST['genres'];
}
if(empty($_POST['consoles'])){
    $err=7;

}else{
    $consoles=$_POST['consoles'];
}
if($err==0){
    
    
    //on crée aussi les genre à partir d'ici comme ça si avant il y a eu un problème avec le jeu les gens ne sont pas envoyé seul
    // on supprime d'abord tout pour après faire l'insertions des nouveaux genres
    $sqlDeleteGenre =("DELETE  FROM game_genre where FK_game=:FkGame");
    $reqDeleteeGenre = $bd -> prepare($sqlDeleteGenre);
    $reqDeleteeGenre -> execute([
        ':FkGame' => $idUpdateGame]);
        $reqDeleteeGenre -> closeCursor();
// on vient les remettres ici en les traitant 
        for ($i=0; $i < count($genres) ; $i++) { 
            htmlspecialchars($genres[$i]);
            $sqlUdpateGenre =("INSERT INTO game_genre  (FK_genre,FK_game) values(?,?)");
            $reqUpdateGenre = $bd -> prepare($sqlUdpateGenre);
            $reqUpdateGenre -> execute([$genres[$i],$idUpdateGame]);
             }
             $reqUpdateGenre -> closeCursor();
    

             // on vient faire pareil pour les consoles 
    $sqlDeleteConsoles =("DELETE  FROM game_consoles where FK_game=:FkGame");
    $reqDeleteeConsoles = $bd -> prepare($sqlDeleteConsoles);
    $reqDeleteeConsoles -> execute([
        ':FkGame' => $idUpdateGame]);
    
    $reqDeleteeConsoles -> closeCursor();
// on vient les remettres ici en les traitant 
        for ($f=0; $f < count($consoles) ; $f++) { 
            htmlspecialchars($consoles[$f]);
            $sqlUdpateConsoles =("INSERT INTO game_consoles  (FK_consoles,FK_game) values(?,?)");
            $reqUpdateConsoles = $bd -> prepare($sqlUdpateConsoles);
            $reqUpdateConsoles -> execute([$consoles[$f],$idUpdateGame]);
             }
             $reqUpdateConsoles -> closeCursor();
             
    if(empty($_FILES['img_game']['tmp_name']) and empty($_FILES['bg_game']['tmp_name'])){//si aucun fichier je fais l'update du reste sans demander à la bd de modifié l'image
        $sqlUpdate =("UPDATE game SET name_game=:nameG, date_game=:dGame,describe_game=:descGame WHERE PK_game=:id");
        $reqUpdates = $bd -> prepare($sqlUpdate);
        $reqUpdates -> execute(
            [
                "nameG" => $gameName,
                "dGame" => $gameDate,
                "descGame" => $gameDescribe,
                "id" => $idUpdateGame
            ]
        );
        header("LOCATION:update?id=".$donGames['PK_game']."&success");
    }elseif(empty($_FILES['img_game']['tmp_name']) and !empty($_FILES['bg_game']['tmp_name'])){
    // si il y a un changement d'image.
    $path = '../img/';
    $pathMini ='../img/mini_';
    $tmpName2 = $_FILES['bg_game']['tmp_name'];
    // la fonction filesize nous permet de récupérer la taille d'un fichier.
    $sizeFile2 = filesize($tmpName);
    $maxSize=1000000;
    // on utilise la fonction basename pour récupérer le nom du fichier
    $fichier2 = basename($_FILES['bg_game']['name']);
    // récupération de l'extension et je la transforme en minuscule si jamais on reçois une extension en maj.
    $extension2 = strtolower(strrchr($fichier2,'.'));
    $extensionAut = ['.jpg','.png','.jpeg','.svg','.jfif'];
    //var_dump($fichier,$sizeFile,$extension);
    
    // puis on test la taille du fichier.
    if($maxSize<$sizeFile2){
        $err=5;
        echo "la tailel est trop grande";
       }
       if(!in_array($extension2,$extensionAut)){
           $err=6;
           echo "mauvaise extension";
       }
       if(!$err){// si l'erreur n'existe pas alors je fini le traitement du fichier et je l'envoi.
           $fichier2 = strtr($fichier2, 
           'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
           'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
           // on remplace tout les caractères spéciaux par des tirets.
           $fichier2 = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier2);
           
           // on vient créer un numéro aléatoire au début du nom de fichier pour éviter les doublons qui pourrait venir écraser l'autre.
           $fichierRand2 = rand().$fichier2;
           // on créer une variable qui contient le chemin + le nom du fichier.
           $FileMove2 =$path . $fichierRand2;

           if(move_uploaded_file($tmpName2,$FileMove2)){
               //on va supprimer les images ainsi que la miniatures avant l'upload des nouveaux fichiers.
                unlink($path.$donGames['bg_game']);
               // on met une condition pour vérifier que le fichier c'est bien upploadé 
               // unlink($pathMini.$don['game_img']);
               // si l'image c'est bien envoyée alors on peut maintenant faire notre requête update pour transmettre les autres infos du jeux.
               $sqlUpdate =("UPDATE game SET name_game=:nameG, date_game=:dGame,describe_game=:descGame ,img_game=:img,bg_game=:bg WHERE PK_game=:id");
   $reqUpdates = $bd -> prepare($sqlUpdate);
   $reqUpdates -> execute(
       [
           "nameG" => $gameName,
           "dGame" => $gameDate,
           "descGame" => $gameDescribe,
           "img" => $donGames['img_game'],
           "bg" => $fichierRand2,
           "id" => $idUpdateGame
       ]
   );
           }
           $reqUpdates -> closeCursor();
           header("LOCATION:update?id=".$donGames['PK_game']."&success");

       }else{
           header("LOCATION:update?id=".$donGames['PK_game']."&error=$err");
       }

    }elseif(!empty($_FILES['img_game']['tmp_name']) and empty($_FILES['bg_game']['tmp_name'])){
         // si il y a un changement d'image.
         $path = '../img/';
         $pathMini ='../img/mini_';
         $tmpName = $_FILES['img_game']['tmp_name'];
         // la fonction filesize nous permet de récupérer la taille d'un fichier.
         $sizeFile = filesize($tmpName);
         $maxSize=1000000;
         // on utilise la fonction basename pour récupérer le nom du fichier
         $fichier = basename($_FILES['img_game']['name']);
         // récupération de l'extension et je la transforme en minuscule si jamais on reçois une extension en maj.
         $extension = strtolower(strrchr($fichier,'.'));
         $extensionAut = ['.jpg','.png','.jpeg','.svg','.jfif'];
         //var_dump($fichier,$sizeFile,$extension);
         
         // puis on test la taille du fichier.
         if($maxSize<$sizeFile){
             $err=5;
             echo "la tailel est trop grande";
            }
            if(!in_array($extension,$extensionAut)){
                $err=6;
                echo "mauvaise extension";
            }
            if(!$err){// si l'erreur n'existe pas alors je fini le traitement du fichier et je l'envoi.
                $fichier = strtr($fichier, 
                'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                // on remplace tout les caractères spéciaux par des tirets.
                $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
                
                // on vient créer un numéro aléatoire au début du nom de fichier pour éviter les doublons qui pourrait venir écraser l'autre.
                $fichierRand = rand().$fichier;
                // on créer une variable qui contient le chemin + le nom du fichier.
                $FileMove =$path . $fichierRand;
                var_dump($FileMove);
                if(move_uploaded_file($tmpName,$FileMove)){
                    //on va supprimer les images ainsi que la miniatures avant l'upload des nouveaux fichiers.
                     unlink($path.$donGames['img_game']);
                     unlink($pathMini.$donGames['img_game']);
    
                    // on met une condition pour vérifier que le fichier c'est bien upploadé 
                    // unlink($pathMini.$don['game_img']);
                    // si l'image c'est bien envoyée alors on peut maintenant faire notre requête update pour transmettre les autres infos du jeux.
                    $sqlUpdate =("UPDATE game SET name_game=:nameG, date_game=:dGame,describe_game=:descGame ,img_game=:img,bg_game=:bg WHERE PK_game=:id");
        $reqUpdates = $bd -> prepare($sqlUpdate);
        $reqUpdates -> execute(
            [
                "nameG" => $gameName,
                "dGame" => $gameDate,
                "descGame" => $gameDescribe,
                "img" => $fichierRand,
                "bg" => $donGames['bg_game'],
                "id" => $idUpdateGame
            ]
        );
                }
                $reqUpdates -> closeCursor();
                
                if($extension === ".png"){
                    header("LOCATION:redimPng.php?image=".$fichierRand);
                }else{
                   header("LOCATION:redim.php?image=".$fichierRand);
                }

            }else{
                header("LOCATION:update?id=".$donGames['PK_game']."&error=$err");
            }
    
        }
    
    
    else{
         // si il y a un changement d'image.
         $path = '../img/';
         $pathMini ='../img/mini_';
         $tmpName = $_FILES['img_game']['tmp_name'];
         $tmpName2 = $_FILES['bg_game']['tmp_name'];
         // la fonction filesize nous permet de récupérer la taille d'un fichier.
         $sizeFile = filesize($tmpName);
         $sizeFile2 = filesize($tmpName2);
         $maxSize=1000000;
         // on utilise la fonction basename pour récupérer le nom du fichier
         $fichier = basename($_FILES['img_game']['name']);
         $fichier2 = basename($_FILES['bg_game']['name']);
         // récupération de l'extension et je la transforme en minuscule si jamais on reçois une extension en maj.
         $extension = strtolower(strrchr($fichier,'.'));
         $extension2 = strtolower(strrchr($fichier2,'.'));
         $extensionAut = ['.jpg','.png','.jpeg','.svg','.jfif'];
         //var_dump($fichier,$sizeFile,$extension);
         
         // puis on test la taille du fichier.
         if($maxSize<$sizeFile or $maxSize<$sizeFile2){
             $err=5;
             echo "la tailel est trop grande";
            }
            if(!in_array($extension,$extensionAut) or !in_array($extension2,$extensionAut)){
                $err=6;
                echo "mauvaise extension";
            }
            if(!$err){// si l'erreur n'existe pas alors je fini le traitement du fichier et je l'envoi.
                $fichier = strtr($fichier, 
                'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                $fichier2 = strtr($fichier2, 
                'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                // on remplace tout les caractères spéciaux par des tirets.
                $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
                $fichier2 = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier2);
                
                // on vient créer un numéro aléatoire au début du nom de fichier pour éviter les doublons qui pourrait venir écraser l'autre.
                $fichierRand = rand().$fichier;
                $fichierRand2 = rand().$fichier2;
                // on créer une variable qui contient le chemin + le nom du fichier.
                $FileMove =$path . $fichierRand;
                $FileMove2=$path . $fichierRand2;
                var_dump($FileMove);
                if(move_uploaded_file($tmpName,$FileMove) and move_uploaded_file($tmpName2,$FileMove2)){
                    //on va supprimer les images ainsi que la miniatures avant l'upload des nouveaux fichiers.
                     unlink($path.$donGames['img_game']);
                     unlink($pathMini.$donGames['img_game']);
    
                    // on met une condition pour vérifier que le fichier c'est bien upploadé 
                    // unlink($pathMini.$don['game_img']);
                    // si l'image c'est bien envoyée alors on peut maintenant faire notre requête update pour transmettre les autres infos du jeux.
                    $sqlUpdate =("UPDATE game SET name_game=:nameG, date_game=:dGame,describe_game=:descGame ,img_game=:img,bg_game=:bg WHERE PK_game=:id");
        $reqUpdates = $bd -> prepare($sqlUpdate);
        $reqUpdates -> execute(
            [
                "nameG" => $gameName,
                "dGame" => $gameDate,
                "descGame" => $gameDescribe,
                "img" => $fichierRand,
                "bg" => $fichierRand2,
                "id" => $idUpdateGame
            ]
        );
                }
                $reqUpdates -> closeCursor();
                if($extension === ".png"){
                    header("LOCATION:redimPng.php?image=".$fichierRand);
                }else{
                   header("LOCATION:redim.php?image=".$fichierRand);
                }

            }else{
                header("LOCATION:update?id=".$donGames['PK_game']."&error=$err");
            }
        }
        
        
    }else{
        //si une erreur est détectée on renvoi l'erreur en GET
        header("LOCATION:update?id=".$donGames['PK_game']."&error=$err");
    }
}else{
    header("LOCATION:dashboard.php");
}
