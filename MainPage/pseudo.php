<?php 
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
// Affichage du nom en fonction de si c'est un livreur, client, cuisinier ou admin
// Affichage du btn déconnecter
if(isset($_SESSION['auth'])){
    echo '<p id="welcome">Welcome '. $_SESSION['auth'][6].'</p>
          <p><a class="btn btn-default" id="logout" href="user/logout.php">Se déconnecter</a></p>
           <a class="btn btn-default" id="btnpanier" href="user/Panier.html" class="btn btn-default">Panier</a>';
}else if(isset($_SESSION['admin'])){
    echo '<p id="welcome">Welcome '. $_SESSION['admin'][1].'</p>
          <p><a class="btn btn-default" id="logout" href="user/logout.php">Se déconnecter</a></p>
          <a href="Admin/index.php" id="btnpanier" class="btn btn-default">Admin</a>';
}
else if(isset($_SESSION['livreur'])){
    echo '<p id="welcome">Welcome '. $_SESSION['livreur'][1].'</p>
          <p><a class="btn btn-default" id="logout" href="user/logout.php">Se déconnecter</a></p>
          <a href="Livreur/livreur.php" id="btnpanier" class="btn btn-default">Livreur</a>';
}
else if(isset($_SESSION['cuisinier'])){
    echo '<p id="welcome">Welcome '. $_SESSION['cuisinier'][1].'</p>
          <p><a class="btn btn-default" id="logout" href="user/logout.php">Se déconnecter</a></p>
          <a href="cuisine/cuisine.php" id="btnpanier" class="btn btn-default">Cuisine</a>';
}

?>