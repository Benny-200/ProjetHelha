<?php
//S'il n'y a pas de session on en démarre une
if(session_status() == PHP_SESSION_NONE){
  session_start();
}

 require '../Admin/ConnectionBd.php';
 $bdd = Db::connect(); 

 $select = $bdd->query("select avis.*,client.pseudo from avis inner join client using(idcli) ");
  // Afficher les données
 $i = 1;
 while($item = $select->fetch()){
	echo '<tr class="tr_'.$i.'">';
	echo '<td>'.$item['pseudo'].'</td>';
	echo '<td>'.$item['note'].'</td>';
	echo '<td>'.$item['textAvis'].'</td>';
	if(isset($_SESSION['auth'])){
		if($_SESSION['auth'][6]==$item['pseudo']){
			echo '<td><Button id="btnSupp" class="alert alert-danger" onclick="deleteItems('.$item['idAvis'].','.$i.')">Supprimer</Button></td>';
		}else{
			echo "<td></td>";
		}
	}
	echo '</tr>';
	$i = $i+1;
 }

 Db::disconnect();

?>

<!DOCTYPE html>
<html>
  <head>
    <script>
        function deleteItems(id,i) {
            $.ajax("deleteAvis.php?idAvis=" + id).done(function () {
                //L'élément supprimé va disparaitre en 1 sec
                $('.tr_'+i).fadeOut(1000); 
                $.ajax("resetId.php").done(function(){
                  console.log("Cela a été reset");
                }) 
            });
        }
    </script>
 </head>
</html>

