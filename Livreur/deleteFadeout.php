<?php
    require '../Admin/ConnectionBD.php';
    // On met dans la var db la connection de la db
    $db = Db::connect(); 

    if(!empty($_GET['idCli'])) 
    {        
        $idCli = $_GET['idCli'];
    }
    //On supprimer le client en attente de la liste lorsque sa commande est partie
    $del = $db->prepare("delete from clientEnAttente where idcli =?");
    $del->execute(array($idCli));
    Db::disconnect();
?>