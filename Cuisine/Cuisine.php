<!DOCTYPE html>
<html>
  <head>
    <title>McSoupex Cuisine</title>
    <!--Icon-->
    <link rel="icon" type="image/png" href="../ressources/images/b6.png" />
    <meta charset="UTF-8">
    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!--bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <!-- Css et JS-->
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <!--Font-->
    <link href="http://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet" type="text/css";/>
  </head>
  <body>
  <h1 class="textLogo">
        <!--class="glyphicon glyphicon-cutlery" pour afficher du texte fourchette texte fourchette texte-->
        <span class="glyphicon glyphicon-cutlery"></span> Cuisine
        <span class="glyphicon glyphicon-cutlery"></span>

      </h1>


      <div class="container admin">

          <div class="row">

                                                                <!--btn pour button btn success ce qui lui donne la couleur verte, btnlarge qui le rend grand -->
            <h1><b>Liste des commandes     </b> <!--<a href="insert.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span>Ajouter</a>--></h1>
                            <!--class table de boostrap-->
            <table class="table table-stripped table-bordered">
                <thead>
                    <tr>
                        <!--<th>Id Commande</th>-->
                        <th>Id client</th>
                        <th>Nom client</th>
                        <th>Numero client</th>
                        <th>Commande</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <!--On va relier à la db-->

                    <?php

                    //requiere = include sauf que si le fichier n'existe pas //il arrête tout
                    require '../Admin/ConnectionBd.php';
                    echo '<button class="btn btn-default"><a href="../index.html">Retourner au catalogue</a></button><br/>';

                    // On met dans la var db la connection de la db
                    $db = Db::connect(); 
                    
                    $select = $db->query("select commande.idcli,client.nomcli,client.telcli,group_concat(items.name,'----',commande.quantite separator '**' )as comms from commande inner join client using (idcli) inner join items on items.id = commande.idItems group by idcli");
                    // Afficher les données

                    while($item = $select->fetch()){
                        echo '<tr>';
                        echo '<td>'.$item['idcli'].'</td>';
                        echo '<td>'.$item['nomcli'] .'</td>';
                        echo '<td>'.$item['telcli'] .'</td>';
                        echo utf8_encode('<td>'.$item['comms'] .'</td>');
                        echo '<td><a class="btn btn-primary" href="deleteCommandeCuisine.php?idcli='.$item['idcli'].'">Commande prête</a></td>';
                        echo'</tr>';
                    }


                    // déconnecter la db
                    Db::disconnect();
                    
                    ?>
                </tbody>

            </table>

          </div>
      </div>

  </body>

</html>

