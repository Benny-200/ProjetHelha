<?php
if(session_status() == PHP_SESSION_NONE){
    //On démarre la session si elle n'existe pas
    session_start();
}
/*Connexion de la base de donnée*/
require '../Admin/ConnectionBD.php';
$db = Db::connect(); 
//On récupére l'id du client qui a été envoyé en get dans la barre
if(isset($_GET['idcli'])){
    $idcli = $_GET['idcli'];
}


 $ajoutCli = $db->prepare("insert into clientEnAttente (idCli) values(?)");
 $ajoutCli->execute(array($idcli));
/*On supprime l'item des commandes*/

$deleteItems = $db->prepare("delete from commande where idCli = ? ");
$deleteItems->execute(array($idcli));
//Redirection vers la page d'acceuil
header("Location: Cuisine.php");
//Déco de la base de donnée

Db::disconnect();

?>
