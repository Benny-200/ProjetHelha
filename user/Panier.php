<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
//require = include sauf que si le fichier n'existe pas il arrête tout
require '../Admin/ConnectionBD.php';
// On met dans la var db la connection de la db
$db = Db::connect(); 

$idCli = $_SESSION['auth'][0];

$select = $db->prepare("select items.id,items.name,items.price from items inner join commande on items.id = commande.idItems where commande.idCli = ? order by items.id desc");
$select->execute(array($idCli));

/*Calcul du prix*/
$totPrix = $db->prepare("select sum(items.price) as tot from commande inner join items on commande.iditems = items.id where commande.idcli = ?");
$totPrix->execute(array($idCli));
$total = $totPrix->fetch(); // je récupère la ligne et la stock dans une variable $total
//Le i va me permettre de trouver la ligne ou se trouve mon item a supprimer

$i = 0;
// Afficher les données
while($item = $select->fetch()){
    echo '<tr class="tr'.$item['id'].'_'.$i.'">';
        echo utf8_encode('<td>'.$item['name'].'</td>');
        // number format juste pour mettre 2 chiffre après la virgule, . pour séparer le décimal et le vide c'est pour éviter de mettre 1.000 pour 1000 par exemple
        echo '<td>'.number_format((float)$item['price'],2,'.',"").'</td>';
        echo '<td width=300>';
            echo '<a class="btn btn-default" href="viewPanier.php?id='.$item['id'].'"><span class="glyphicon glyphicon-eye-open"></span> voir</a>';echo " ";
            echo '<button class="btn btn-danger" onclick="deleteItems('.$item['id'].','.$i.');"><span class="glyphicon glyphicon-remove"></span> Supprimer</button>';
        echo'</td>';
    echo'</tr>';
    $i = $i+1;  
}

//Affichage du prix
echo '<tr><td><a href="../index.html">Retourner au catalogue</a></td>
          <td id="totalPrixC">Total : '.$total['tot'].'€</td>
          <td><Button class="btn-order"><a href="notification.php">Commander</a></Button></td>
      </tr>';   
// déconnecter la db
Db::disconnect();

?>

<!DOCTYPE html>
<html>
  <head>
    <script>
        /***
         * Cette fonction supprimer l'élément du panier lorsque on clique sur le boutton supprimer
           Elle prend un id et l'indice de la ligne ou se trouve l'élément pour pouvoir le faire disparaitre
           A la fin elle recalcul le prix et l'affiche
         */
        function deleteItems(id,i) {
            $.ajax("deleteCommandePanier.php?id=" + id).done(function () {
                //L'élément supprimé va disparaitre en 1 sec
                $('.tr'+id+'_'+i).fadeOut(1000);  
                $.ajax("prix.php").done(function(data){
                    $("#totalPrixC").html(data);                    
                });
            });
        }

    </script>
 </head>
</html>