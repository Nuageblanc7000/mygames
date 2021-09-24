<?php
session_start();
if(!isset($_SESSION['level']) and $_SESSION['level']!=="admin"){
header("LOCATION:index.php");
}
if(isset($_GET["deco"])){
    session_destroy();
    header("LOCATION:index.php");
}
?>
<?php
include "includes/header.php";
require "../connection.php";
$viewGames =('SELECT * FROM game order by date_game desc');
$requestGame = $bd -> query($viewGames);
echo'
<table class="table"> 
<thead>
';
while($donGames = $requestGame ->fetch()){
echo'
<tr>
<th>'.$donGames['name_game'].'</th>
</tr>
</thead>
<body>
<tr>
 <td>'.$donGames['describe_game'].' </td>
 <td><a class="btn btn-warning" href="update.php?id='.$donGames['PK_game'].'">Modifier</a></td>
 <td><a class="btn btn-danger" href="delete.php?id='.$donGames['PK_game'].'">Delelte</a></td>
</tr>
</tbody>
';
}
    ?>
    
</table>
<?php
include "includes/footer.php";
?>