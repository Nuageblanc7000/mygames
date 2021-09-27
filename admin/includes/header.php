<?php
if(!isset($_SESSION['level']) and $_SESSION['level']!=="admin"){
header("LOCATION:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Administration</title>
</head>
<body class="h-auto" style="background-color:white;">

<nav class=" navbar navbar-expand-lg navbar-light"style="background-color:#ff5400;">
  <div class="container-fluid">
    <a class="navbar-brand " style="font-weight:bold;" href="../index.php">Mygames</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active text-white" aria-current="page" href="dashboard.php">Accueil</a>
        <a class="nav-link text-white" href="#">Gestion User</a>
        <a class="nav-link text-white" href="addGame.php">Ajouter-Jeux</a>
        <a class="nav-link text-white" href="dashboard.php?deco" tabindex="-1" aria-disabled="false">Déconnexion</a>
      </div>
    </div>
  </div>
</nav> 