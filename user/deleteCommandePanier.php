<?php
if(session_status() == PHP_SESSION_NONE){
    //On démarre la session si elle n'existe pas
    session_start();
}
/*Connexion de la base de donnée*/
require '../Admin/ConnectionBD.php';
/*Récupérer l'id de l'item qui est envoyé en get*/
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
/*Id du client en cours dans la session*/ 
$idCli = $_SESSION['auth'][0];

// On met dans la var db la connection de la db
$db = Db::connect(); 

/*On supprime l'item des commandes*/ // Limite 1 pour supprimer qu'un élément

$deleteItems = $db->prepare("delete from commande where idItems = ? and idCli = ? LIMIT 1");
$deleteItems->execute(array($id,$idCli));

//Déco de la base de donnée
Db::disconnect();

?>
