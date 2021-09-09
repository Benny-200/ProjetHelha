<?php
    //S'il n'y a pas de session on en démarre une
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    require '../Admin/ConnectionBd.php';
    $bdd = Db::connect(); 

    if(isset($_SESSION['auth'])){
        $idCli = $_SESSION['auth'][0];
    }
    //Récupération de l'id avis
    if(!empty($_GET['idAvis']))
        $idAvisCli = $_GET['idAvis'];

    $deletAvis = $bdd->prepare("delete from avis where idCli = ? and idAvis = ?");
    $deletAvis->execute(array($idCli,$idAvisCli));

    Db::disconnect();

?>