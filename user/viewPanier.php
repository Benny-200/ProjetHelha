<?php
    require '../Admin/ConnectionBd.php';
    // On va récupérer l'id qu'on a envoyé grâce a GET
    if(isset($_GET['id'])){
         $id = $_GET["id"];
    }
    // on se connecte
    $db = Db::connect(); 
    // On utilise une requete préparée du fait qu'on ne connait d'avance l'id
    $select = $db->prepare("select items.id,items.name,items.description,items.price, items.img, categories.name as categoryName from items left join categories on items.category = categories.id where items.id = ?");
    $select->execute(array($id));
    $rowItem = $select->fetch();
    // déconnecter la db
    Db::disconnect();
    function checkInput($data){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>



<!DOCTYPE html>
<html>
  <head>
    <title>McSoupex</title>    
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

    <!--CSS-->
    <link rel="stylesheet" type="text/css" href="../css/style.css" />

    <!--Font-->
    <link href="http://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet" type="text/css";
  </head>
  <body>
  <h1 class="textLogo">
        <!--class="glyphicon glyphicon-cutlery" pour afficher du texte fourchette texte fourchette texte-->
        <span class="glyphicon glyphicon-cutlery"></span> McSoupex
        <span class="glyphicon glyphicon-cutlery"></span>

      </h1>
      <div class="container admin">
          <div class="row">
              <!--col-sm-6 responsive tablette-->
              <div class="col-sm-6">
                <h1><b>Voir un item     </b></h1>
                <br/>

                <form>
                    <div class="form-group">
                        <label> Nom : </label><?php echo '   '. $rowItem['name']; ?>
                   </div>

                   <div class="form-group">
                        <label> Description : </label><?php echo '   '. $rowItem['description']; ?>
                   </div>

                   <div class="form-group">
                        <label> Prix : </label><?php echo '   '. number_format((float)$rowItem['price'],2,'.',""). ' €'; ?>
                   </div>

                   <div class="form-group">
                        <label> Catégorie : </label><?php echo '   '. $rowItem['categoryName']; ?>
                   </div>

                   <div class="form-group">
                        <label> Image : </label><?php echo '   '. $rowItem['img']; ?>
                   </div>
                </form>
                <br>
                <div class="form-actions">
                    <a class="btn btn-primary" href="panier.html"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                </div>

              </div>
            <!--Deuxième colonnne-->
            <div class="col-sm-6 site">
              <!--Thumbnail pour le cadre blanc-->
              <div class="thumbnail">
                <img src="<?php echo '../ressources/images/'.$rowItem['img'];  ?>" alt="..." />
                <div class="price"><?php echo '   '. number_format((float)$rowItem['price'],2,'.',""). ' €'; ?></div>
                <!--Caption c'est pour dans la thumnail mettre tous les éléments en dessous-->
                <div class="caption">
                  <h4><?php echo '   '. $rowItem['name']; ?></h4>
                  <p><?php echo '   '. $rowItem['description'].'';?></p>
                </div>
              </div>
            </div>

          </div>
      </div>

  </body>

</html>


