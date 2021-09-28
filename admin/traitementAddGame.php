<?php
session_start();
if(!isset($_SESSION['level']) and ($_SESSION['level']!=="admin" or $_SESSION['level']!=="batDev") ){
header("LOCATION:index.php");
}

if(isset($_POST['name_game'])){
    require ("../connection.php");

$err=0;
if(empty($_POST['name_game'])){
    
    $err=1;
}else{
    // on va vérifier si le nom du jeux existe déjà car j'aurais besoin qu'il soit unique pour la suite.
    $name_game = htmlspecialchars($_POST['name_game']);
    $sqlVerifName = ("SELECT * from game where name_game=?");
    $reqVerifName = $bd ->prepare($sqlVerifName);
    $reqVerifName -> execute([$name_game]);
    if($donVerifName = $reqVerifName ->fetch()){
        $err=12;
    }
}
if(empty($_POST['date_game'])){
    $err=2;
}else{
    $date_game = htmlspecialchars($_POST['date_game']);
}
if(empty($_POST['description_game'])){
    $err=3;
}else{
    $describe_game = htmlspecialchars($_POST['description_game']);
}

if(empty($_POST['genres'])){
    $err=4;
}else{
    $genres = $_POST['genres'];
    $sqlVerifGenres = ("SELECT * from genre where PK_genre=?");
    $reqVerifGenres = $bd ->prepare($sqlVerifGenres);
    // si tout c'est bien passé on va maintenant faire l'envoi des données dans leur table respective.
    for ($i=0; $i < count($genres) ; $i++) { 
        htmlspecialchars($genres[$i]);
        $reqVerifGenres -> execute([$genres[$i]]);
        if(!$donGenres = $reqVerifGenres -> fetch()){
            $err=10;
        }
     }
}
if(empty($_POST['consoles'])){
    $err=5;
}else{
    $consoles = $_POST['consoles'];
    $sqlVerifConsoles = ("SELECT * from genre where PK_genre=?");
    $reqVerifConsoles  = $bd ->prepare($sqlVerifConsoles);
    // si tout c'est bien passé on va maintenant faire l'envoi des données dans leur table respective.
    for ($f=0; $f < count($consoles) ; $f++) { 
        htmlspecialchars($genres[$f]);
        $reqVerifConsoles -> execute([$consoles [$f]]);
        if(!$donConsoles = $reqVerifConsoles -> fetch()){
            $err=11;
        }
     }
}

if($err==0){
    if(empty($_FILES['img_game']['tmp_name'])){
        $err=6;
        header("LOCATION:addGame?error=$err");
    }else{
        //gestion de l'image avant d'envoyer tout dans la bd à fin d'être sur que celle ci soit correcte
        //fichier image 1
        $path = "../img/";
        $tmpName = $_FILES['img_game']['tmp_name'];
        $maxSize = 2000000;
        $fileSize=filesize($tmpName);
        $fichier = basename($_FILES['img_game']['name']);
        $extension = strtolower(strrchr($fichier,'.'));
        $extensionAut = ['.jpg','.png','.jpeg','.svg','.jfif'];
        //fichier deux
        $tmpName2 = $_FILES['bg_game']['tmp_name'];
        $fileSize2=filesize($tmpName2);
        $fichier2 = basename($_FILES['bg_game']['name']);
        $extension2 = strtolower(strrchr($fichier2,'.'));
        // les tests
        if($fileSize>$maxSize or $filesize2>$maxSize){
            $err=7;
        }
        if(!in_array($extension,$extensionAut) or !in_array($extension2,$extensionAut)){
            $err=8;
        }
        if(!$err){
            // vérif du nom de fichier pour enlever tout les caractères spéciaux.
            $fichier = strtr($fichier,
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $fichier2 = strtr($fichier2,
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
            $fichier2 = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier2);
//création du numéro random au début du nom de fichier
            $fichierRand =rand().$fichier;
            $fichierRand2 =rand().$fichier2;
            $movePath = $path . $fichierRand;
            $movePath2 = $path . $fichierRand2;

           // on va pouvoir maintenant upload le fichier pour vérifier que tout fonctionne on le met dans un if.
           if(move_uploaded_file($tmpName,$movePath) and move_uploaded_file($tmpName2,$movePath2)){
               // si tout c'est bien passé on va maintenant faire l'envoi des données dans leur table respective.

               //étape 1 je crée mon jeu car j'aurais besoin de son id pour le reste
               $sqlInsertGame = ("INSERT INTO game (name_game,date_game,describe_game,img_game,bg_game) VALUES(?,?,?,?,?)");
               $reqInsertGame = $bd ->prepare($sqlInsertGame);
               $reqInsertGame -> execute([$name_game,$date_game,$describe_game,$fichierRand,$fichierRand2]);
               $reqInsertGame -> closeCursor();
            //étape deux je vais chercher l'id du jeu que je viens de créer
               $sqlRecupIdGame = ("SELECT * from game where name_game = ?");
               $reqRecupIdGame = $bd -> prepare($sqlRecupIdGame);
               $reqRecupIdGame -> execute([$name_game]);
               
               if($donIdGame = $reqRecupIdGame ->fetch()){
                   // si je reçois une réponse et que le nom existe bien alors je récup son id. 
                   // comme j'ai déjà précisé plus haut que deux jeu ne peuvent pas avoir le même nom je peux me permettre d'utiliser le name
                $idGame = htmlspecialchars($donIdGame['PK_game']);
                // je peux donc maintenant insérer dans ma table game_genre car j'aurais un id et les genres sélectionnés.
                $sqlInsertGenres = ("INSERT INTO game_genre (FK_genre,FK_game) VALUES(:FkGenre,:FkGam)");
                $reqInsertGenres = $bd ->prepare($sqlInsertGenres);
                // si tout c'est bien passé on va maintenant faire l'envoi des données dans leur table respective.
                for ($r=0; $r < count($genres) ; $r++) { 
                    htmlspecialchars($genres[$r]);
                    $reqInsertGenres -> execute([
                       "FkGenre" => $genres[$r],
                        "FkGam" => $idGame
                    ]);
                    
                 }
                 $reqInsertGenres -> closeCursor();

                 // on va faire pareil pour les consoles
                 $idGame = htmlspecialchars($donIdGame['PK_game']);
                $sqlInsertConsoles = ("INSERT INTO game_consoles (FK_consoles,FK_game) VALUES(:FkConsoles,:FkGam)");
                $reqInsertConsoles = $bd ->prepare($sqlInsertConsoles);
                // si tout c'est bien passé on va maintenant faire l'envoi des données dans leur table respective.
                for ($z=0; $z < count($consoles) ; $z++) { 
                    htmlspecialchars($consoles[$z]);
                    $reqInsertConsoles -> execute([
                       "FkConsoles" => $consoles[$z],
                        "FkGam" => $idGame
                    ]);
                    
                 }
                 $reqInsertConsoles -> closeCursor();
                 $reqRecupIdGame -> closeCursor();
                 
                 if($extension === ".png"){
                     header("LOCATION:redimPng.php?image=".$fichierRand);
                 }else{
                    header("LOCATION:redim.php?image=".$fichierRand);
                 }
               }
      


           }else{
               $err=9;
            header("LOCATION:addGame?error=$err");    
           }
        }else{
            header("LOCATION:addGame?error=$err");
        }


    }
    

}else{
    header("LOCATION:addGame?error=$err");
}

}else{
    header("LOCATION:dashboard.php");
}