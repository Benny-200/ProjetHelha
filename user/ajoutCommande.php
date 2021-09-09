<?php
    //Start d'une session 
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    //Liaison de la DB
    require '../Admin/ConnectionBd.php';

    //Si le client n'est pas connecté, il est redirigé vers la page de connexion
    if(!isset($_SESSION['auth'])){
        header('Location: connexion.php');
        //Exit pour empêcher la suite de l'exécution du script
        exit();
    }else{
        //S'il est connecté il peut ajouter des commandes
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }

        $idCli = $_SESSION['auth'][0];

        $db = Db::connect();
        
        $statement = $db->prepare("INSERT INTO commande (idcli,quantite,idItems,dateC) values(?,1,?,date(now()))");
        $statement->execute(array($idCli,$id));
        //Déco de la db
        Db::disconnect();
        //Redirection vers la page du panier
        header("Location: Panier.html");
    }

?>