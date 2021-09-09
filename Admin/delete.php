<?php
     
    // Je lie ma db
    require 'ConnectionBd.php';
    $db = Db::connect();
    // On récupère  l'id de l'item pour le sélectionner en récupérer ses informations
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $selectName = $db->prepare("SELECT * from items where id = ?");
        $selectName->execute(array($id));
        $row = $selectName->fetch();
        $name = json_encode($row['name']);
    }


    // Quand on a appuyé sur oui on supprime l'item de la DB ensuite on est redirigé vers la page d'acceuil admin
    if(!empty($_POST)){
        $id = $_POST['id'];
        $delete = $db->prepare("delete from items where id = ?");
        $delete->execute(array($id));
        Db::disconnect();
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>McSoupex-DeleteItem</title>
    <!--Icon-->
    <link rel="icon" type="image/png" href="../ressources/images/b6.png" />
    <meta charset="UTF-8">
    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!--bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <!--CSS-->
    <link rel="stylesheet" type="text/css" href="../css/style.css" />

    <!--Font-->
    <link href="http://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet" type="text/css";
  </head>

  <body>
        <h1 class="textLogo"><span class="glyphicon glyphicon-cutlery"></span> McSoupex <span class="glyphicon glyphicon-cutlery"></span></h1>
         <div class="container admin">
            <div class="row">
                <h1><strong>Suppression d'un item --> <?php echo utf8_encode(json_decode($name)); ?> </strong></h1>
                <br>
                <form class="form" action="delete.php" role="form" method="post">
                    <!--On récupére l'id-->
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="alert alert-warning"> Etes vous sur et certain de vouloir supprimer cet item?</p>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">Oui</button>
                        <a class="btn btn-default" href="index.php">Non</a>
                   </div>
                </form>
            </div>
        </div>   
    </body>

</html>