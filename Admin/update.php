<?php
     
    require 'ConnectionBd.php';
 
    //Pour récupérer l'id de l'item pour pouvoir modifier tous ses éléments

    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }

    $nameError = "";
    $descriptionError =""; 
    $priceError = "";
    $categoryError = "";
    $imageError = "";
    $name = ""; 
    $description = "";
    $price = "";
    $category = "";
    $image = "";

    // Méthode qui se lance qu'appuie sur ajouter dans le insert et modifier quand je veux changer mes valeurs pour qu'il remplisse la superGlobal post pour pouvoir faire les vérifications
    if(!empty($_POST)) 
    {
        $name               = checkInput($_POST['name']);
        $description        = checkInput($_POST['description']);
        $price              = checkInput($_POST['price']);
        $category           = checkInput($_POST['category']); 
        $image              = checkInput($_FILES['image']['name']);
        $imagePath          = '../ressources/images/'. basename($image);
        $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
        $isSuccess          = true;
        
        if(empty($name)) 
        {
            $nameError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($description)) 
        {
            $descriptionError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        } 
        if(empty($price)) 
        {
            $priceError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        } 
        if(empty($category)) 
        {
            $categoryError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        
        if(empty($image)) // Le input file n'est pas vide ce qui s'ignifie que l'image n'a pas été update
        {
            $isImageUpdated = false;
        }
        else
        {
            $isImageUpdated = true;
            $isUploadSuccess = true;

            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) 
            {
                $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }
            if($_FILES["image"]["size"] > 500000) 
            {
                $imageError = "Le fichier ne doit pas depasser les 500KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess) 
            {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) 
                {
                    $imageError = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                } 
            } 
        }
        
        if($isSuccess)
        {   
            $db = Db::connect();
            
            if($isImageUpdated){
                $statement = $db->prepare("update items set name = ?, description = ?, price = ?, category = ?,img = ? where id = ?");
                $statement->execute(array($name,$description,$price,$category,$image,$id));
            }
            else{
                $statement = $db->prepare("update items set name= ?, description = ?, price = ?, category = ? where id = ?");
                $statement->execute(array($name,$description,$price,$category,$id));
            }
            
            Db::disconnect();
            header("Location: index.php");
        }// Je suis dans le cas ou le post n'a pas été rempli correctement et qu'il y a une erreur dans l'image on veut la remettre à l'ancienne image
        else if($isImageUpdated && !$isUploadSuccess)
        {
            $db = Db::connect();
            $statement = $db->prepare("SELECT * FROM items where id = ?");
            $statement->execute(array($id));
            $item = $statement->fetch();
            $image= $item['img'];
            Db::disconnect();
           
        }

    }else{
        //Premier passage quand on appuie sur le bouton modifier de la liste
        $db = Db::connect();

        // Récupérer toutes les informations de l'item de l'id qu'on a récupéré avec le get
        $statement = $db->prepare("select * from items where id = ?");
        $statement->execute(array($id));

        $item = $statement->fetch();
        // on remplit les donnée pour que quand on rentre la première fois les données soient dans les champs
        $name = $item['name'];
        $description =$item['description'];
        $price = $item['price'];
        $category = $item['category'];
        $image = $item['img'];
        

        Db::disconnect();

    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>McSoupex AdminUpdate</title>
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
                <!--Première colonne-->
                <div class="col-sm-6">
                    <h1><strong>Modifier un item</strong></h1>
                    <br>
                    <form class="form" action="<?php echo 'update.php?id='. $id ;?>" role="form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Nom:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo utf8_encode($name);?>"/>
                            <span class="help-inline"><?php echo $nameError;?></span>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description;?>">
                            <span class="help-inline"><?php echo $descriptionError;?></span>
                        </div>
                        <div class="form-group">
                            <label for="price">Prix: (en €)</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price;?>"/>
                            <span class="help-inline"><?php echo $priceError;?></span>
                        </div>
                        <div class="form-group">
                            <label for="category">Catégorie:</label>
                            <select class="form-control" id="category" name="category">
                            <?php
                            $db = Db::connect();
                            foreach ($db->query('SELECT * FROM categories') as $row) 
                            {   
                                    if($row['id'] == $category){
                                        // Pour séléction la catégorie de l'item
                                        echo '<option selected="selected" value="'. $row['id'] .'">'. $row['name'] . '</option>';
                                    }
                                    else 
                                        echo '<option value="'. $row['id'] .'">'. $row['name'] . '</option>';
                            }

                            //Déconnection de la db
                            Db::disconnect();
                            ?>
                            </select>
                            <span class="help-inline"><?php echo $categoryError;?></span>
                        </div>
                        <div class="form-group">
                            <label for="image">Image:</image>
                            <p><?php echo $image; ?></p>
                            <label for="image">Sélectionner nouvelle une image:</label>
                            <input type="file" id="image" name="image"/> 
                            <span class="help-inline"><?php echo $imageError;?></span>
                        </div>
                        <br>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                            <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                        </div>
                    </form>
                </div>

                <div class="col-sm-6 site">
                <!--Thumbnail pour le cadre blanc-->
                <div class="thumbnail">
                    <img src="<?php echo '../ressources/images/'.$image;  ?>" alt="..." />
                    <div class="price"><?php echo number_format((float)$price,2,'.',""). ' €'; ?></div>
                    <!--Caption c'est pour dans la thumnail mettre tous les éléments en dessous-->
                    <div class="caption">
                    <h4><?php echo '   '. $name; ?></h4>
                    <p><?php echo '   '. $description;?></p>
                    </div>
                </div>
                </div>

            </div>
        </div>   
    </body>

</html>