<!DOCTYPE html>
<html>
  <head>
    <title>McSoupex-Admin</title>
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
    <link href="http://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet" type="text/css"/>;
  </head>
  <body>
  <h1 class="textLogo">
        <!--class="glyphicon glyphicon-cutlery" pour afficher du texte fourchette texte fourchette texte-->
        <span class="glyphicon glyphicon-cutlery"></span> McSoupex
        <span class="glyphicon glyphicon-cutlery"></span>
      </h1>
      <div class="container admin">

          <div class="row">
          <div class="form-actions">
                <a class="btn btn-primary" href="../index.html"><span class="glyphicon glyphicon-arrow-left"></span> Retour au catalogue</a>
          </div>

                                                                <!--btn pour button btn success ce qui lui donne la couleur verte, btnlarge qui le rend grand -->
            <h1><b>Liste des items     </b> <a href="insert.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span>Ajouter</a></h1>
                            <!--class table de boostrap-->
            <table class="table table-stripped table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <!--On va relier à la db-->

                    <?php

                    //requiere = include sauf que si le fichier n'existe pas il arrête tout
                    require 'ConnectionBd.php';
                    
                    // On met dans la var db la connection de la db
                    $db = Db::connect(); 
                    
                    $select = $db->query("select items.id,items.name,items.description,items.price, categories.name as categoryName from items left join categories on items.category = categories.id order by items.id desc");

                    // Afficher les données

                    while($item = $select->fetch()){
                        echo '<tr>';
                        echo utf8_encode('<td>'.$item['name'].'</td>');
                        echo utf8_encode('<td>'.$item['description'] .'</td>');
                        // number format juste pour mettre 2 chiffre après la virgule, . pour séparer le décimal et le vide c'est pour éviter de mettre 1.000 pour 1000 par exemple
                        echo '<td>'.number_format((float)$item['price'],2,'.',"").'</td>';
                        echo '<td>'.$item['categoryName'].'</td>';
                        echo '<td width=300>';
                           // On envoie en get l'id de l'item pour pouvoir le visualiser le modifier ou le supprimer
                           echo '<a class="btn btn-default" href="view.php?id='.$item['id'].'"><span class="glyphicon glyphicon-eye-open"></span> voir</a>';echo " ";
                           echo '<a class="btn btn-primary" href="update.php?id='.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span> modifier</a>';echo " ";
                           echo '<a class="btn btn-danger" href="delete.php?id='.$item['id'].'"><span class="glyphicon glyphicon-remove"></span> supprimer</a>';

                        echo'</td>';
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


