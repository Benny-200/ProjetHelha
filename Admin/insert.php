<?php
     
    // Je lie ma db
    require 'ConnectionBd.php';
 
    //J'initialise à vide les erreurs pour pas avoir de problème
    $nameError = "";
    $descriptionError = "";
    $priceError = "";
    $categoryError = "";
    $imageError = "";
    $name = "";
    $description =""; 
    $price = "";
    $category = "";
    $image = "";

    //On récupére les variables avec la méthode Post
    if(!empty($_POST)) 
    {
        $name               = checkInput($_POST['name']);
        $description        = checkInput($_POST['description']);
        $price              = checkInput($_POST['price']);
        $category           = checkInput($_POST['category']); 
        $image              = checkInput($_FILES["image"]["name"]);
        $imagePath          = '../ressources/images/'. basename($image); //basename : nom de l'image
        $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION); // on récupére l'extansion grâce à la constant PATHINFO de l'image
        $isSuccess          = true;
        $isUploadSuccess    = false;
        // On vérifie si les champs sont vide
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
        if(empty($image)) 
        {
            $imageError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        else
        {
            $isUploadSuccess = true;

            // Vérification des images pour savoir si ils sont de bonne extension sinon erreur
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) 
            {
                $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }
            // On regarde si la taille est correcte < de 500KB sinon erreur
            if($_FILES["image"]["size"] > 500000) 
            {
                $imageError = "Le fichier ne doit pas depasser les 500KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess) 
            {
                //S'il y a un problème lors de l'upload de l'image
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) 
                {
                    $imageError = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                } 
            } 
        }
        
        //Si tous ce passe bien on ajout l'item dans la DB et on se redirige vers la page d'acceuil de l'admin
        if($isSuccess && $isUploadSuccess) 
        {
            $db = Db::connect();
            $statement = $db->prepare("INSERT INTO items (name,description,price,category,img) values(?, ?, ?, ?, ?)");
            $statement->execute(array($name,$description,$price,$category,$image));
            Db::disconnect();
            header("Location: index.php");
        }
    }

    // Fonction qui vérifie l'intégrité des données en prenant une donnée en argument
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
    <title>McSoupex-Admin Ajout</title>
    <!--Icon-->
    <link rel="icon" type="image/png" href="../ressources/images/b6.png" />
    <!--utf8-->
    <meta charset="UTF-8">
    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!--bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1" /> <!--Initialiser la valeur du viewport à celle de l'ordinateur si ordi, téléphone si téléphone tablette si tablette etc... et zoom à 1 grâce initial scale-->
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
                <h1><strong>Ajouter un item</strong></h1>
                <br>
                <form class="form" action="insert.php" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nom:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name;?>">
                        <span class="help-inline"><?php echo $nameError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description;?>">
                        <span class="help-inline"><?php echo $descriptionError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="price">Prix: (en €)</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price;?>">
                        <span class="help-inline"><?php echo $priceError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="category">Catégorie:</label>
                        <select class="form-control" id="category" name="category">
                        <?php
                           $db = Db::connect();
                           foreach ($db->query('SELECT * FROM categories') as $row) 
                           {
                                echo '<option value="'. $row['id'] .'">'. $row['name'] .'</option>';
                           }
                           Db::disconnect();
                        ?>
                        </select>
                        <span class="help-inline"><?php echo $categoryError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="image">Sélectionner une image:</label>
                        <input type="file" id="image" name="image"> 
                        <span class="help-inline"><?php echo $imageError;?></span>
                    </div>
                    <br>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                   </div>
                </form>
            </div>
        </div>   
    </body>

</html>