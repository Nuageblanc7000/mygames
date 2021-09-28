<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Monoton&family=Prompt:wght@200;300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Home</title>
</head>
<body>
  
    <header>
        <div class="wrapper">
        <h1><span>My</span>Games</h1>
        <div class="search">
            <form action="home.php" method="post">
                <input type="search" name="search" id="search"placeholder="recherche...">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
           
        </div>
        <div class="contentBurger"><i class="far fa-user"></i></div>

    </div>
    </header>
    </div>
    <div class="navVar">
    <div class="wrapper">
    <nav>
                <div class="filter">
            <ul>
                <li class="menu">Filtre Alphabétique
                    <ul class="sous">
            <li><a href="x">Croissant <i class="fas fa-sort-alpha-up"></i></a></li>
            <li><a href="">Décroissant <i class="fas fa-sort-alpha-up-alt"></i></a></li>
            <li><a href="">année</a></li>
        </ul>
        <li><a href="index.php?action=home">Home</a></li>
        <?php
$navConsoles =('SELECT * from consoles');
                        $reqCons = $bd -> query($navConsoles);
                     

                        while($donsConsoles = $reqCons -> fetch()){
                        if($donsConsoles['names_consoles']=="playstation"){
                            echo '<li> <a href="index.php?action=consoles&id='.$donsConsoles['PK_consoles'].'" class="cat"><span>PC</span><i class="fab fa-playstation"></i></a></li>';
                        }elseif($donsConsoles['names_consoles']=="xbox"){
                            echo '<li><a href="index.php?action=consoles&id='.$donsConsoles['PK_consoles'].'" class="cat"><span>Playstation</span><i class="fab fa-xbox"></i></a></li>';
                        }elseif($donsConsoles['names_consoles']=="pc"){
                            echo '<li><a href="index.php?action=consoles&id='.$donsConsoles['PK_consoles'].'" class="cat"><span>Xbox</span><i class="fas fa-desktop"></i></a></li>';
                        }
                        }
                        $reqCons -> closeCursor();
                        ?>
    <li class="menu">Genre
        <ul class="sous">
        <?php
            $navGenre =('SELECT * from genre');
            $reqGenreNav = $bd -> query($navGenre);
            while($donsGenresNav = $reqGenreNav -> fetch()){
               echo' <li><a href="index.php?action=categories&id=&id='.$donsGenresNav['PK_genre'].'">'.$donsGenresNav['name_genre'].'</a></li>';
            }
            ?>            
</ul>
</li>
        </ul>
    </div>
    <div class="top">
        <ul> 
            <li><a href="">Classement</a></li>
            <li><a href="">Jeux en test</a></li>
        </ul>
    </div>
</nav>
</div>
</div>