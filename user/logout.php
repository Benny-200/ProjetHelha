<?php
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    //Déconnexion de la personne, en fonction de si c'est un client, un admin, un livreur ou un cuisinier
    if(isset($_SESSION['auth'])){
        unset($_SESSION['auth']);
    }else if(isset($_SESSION['admin'])){
        unset($_SESSION['admin']);
    }else if(isset($_SESSION['livreur'])){
        unset($_SESSION['livreur']);
    }else if(isset($_SESSION['cuisinier'])){
        unset($_SESSION['cuisinier']);
    }
    header('Location: ../index.html');
?>