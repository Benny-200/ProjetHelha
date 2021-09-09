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
$totPrix = $db->prepare("select sum(items.price) as tot from commande inner join items on commande.iditems = items.id where commande.idcli = ?");
$totPrix->execute(array($idCli));
$total = $totPrix->fetch();


//Affichage du nouveau prix
echo 'Total : '.$total['tot'].'€';
Db::disconnect();


?>