<?php

    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    //Si l'utilisateur n'est pas connecté 
    if(!isset($_SESSION['auth'])){
        //Redirection vers la page de connexion s'il n'est pas connecté
        header('Location: connexion.php');
        //Exit pour empêcher la suite de l'exécution du script
        exit();
    }
    //Si on est connecté on va pouvoir voir les informations du compte et les modifier
    else{
        $messages = array();

        if(!empty($_POST)){

            $newPassword ="";
           //Vérifications du mot de passe
            if($_POST['mdp'] != $_POST['mdp_confirm']){
                $messages['error'] = 'Les mots de passes ne correspondent pas';
            }
            else{
                $clientId = $_SESSION['auth'][0];

                /*Condition pour le mot de passe quand il change ou pas*/
                if(!empty($_POST['mdp']) || empty(!$_POST['mdp_confirm']))
                  $newPassword = password_hash($_POST['mdp'],PASSWORD_BCRYPT);
                else
                  $newPassword = $_SESSION['auth'][5];
                
                require '../Admin/ConnectionBd.php';
                $db = Db::connect(); 

                //Modifications de chaque champs séparément
                $updatemdp = $db->prepare('update client set mdp = ? where idcli = ?');
                $updatemdp->execute(array($newPassword,$clientId));

                $updatenom = $db->prepare('update client set nomcli = ? where idcli = ?');
                $updatenom->execute(array($_POST['name'],$clientId));

                $updateprenom = $db->prepare('update client set prenomcli = ? where idcli = ?');
                $updateprenom->execute(array($_POST['firstName'],$clientId));

                $updateadresse = $db->prepare('update client set adressecli = ? where idcli = ?');
                $updateadresse->execute(array($_POST['Adresse'],$clientId));

                $updatetel = $db->prepare('update client set telcli = ? where idcli = ?');
                $updatetel->execute(array($_POST['tel'],$clientId));

                $updatepseudo = $db->prepare('update client set pseudo = ? where idcli = ?');
                $updatepseudo->execute(array($_POST['pseudo'],$clientId));

                //Déconnexion du compte lors d'un changement
                require 'logout.php';
                Db::disconnect(); 
            }
        }
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>McSoupexAccount</title>
    <!--Icon-->
    <link rel="icon" type="image/png" href="../ressources/images/b6.png" />
    <meta charset="utf-8" />
    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!--bootstrap -->
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"
    />

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--Font-->
    <link
      href="http://fonts.googleapis.com/css?family=Holtwood+One+SC"
      rel="stylesheet"
      type="text/css"
    />

    <!--CSS-->
    <link rel="stylesheet" type="text/css" href="../css/style.css" />

    <!--JS-->
    <script type="text/javascript" src="../js/script.js"></script>
  </head>
  <body>
    <h1 class="textLogo">
      <!--class="glyphicon glyphicon-cutlery" pour afficher du texte fourchette texte fourchette texte-->
      <span class="glyphicon glyphicon-cutlery"></span> McSoupex
      <span class="glyphicon glyphicon-cutlery"></span>
    </h1>

    <div class="container admin">
      <div class="row">
        <h1>
          <b>Compte de </b>
          <b> <?php echo $_SESSION['auth'][6]; ?>
          <?php if(!empty($messages)){
                  echo '<div class="alert alert-danger">';
                  foreach($messages as $message){
                    echo'<ul><li>'.$message.'</li></ul>';
                  }
                  echo '</div>';
                }
          ?>

        </h1>

        <form class="form" role="form" method="post">
            <div class="form-group">
                <label for="name">Nom:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $_SESSION['auth'][1];?>"/>
            </div>

            <div class="form-group">
                <label for="firstName">Prenom:</label>
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Prénom" value="<?php echo $_SESSION['auth'][2];?>"/>
            </div>

            <div class="form-group">
                <label for="pseudo">Pseudo:</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="pseudo" value="<?php echo $_SESSION['auth'][6];?>"/>
            </div>

            <div class="form-group">
                <label for="Adresse">Adresse:</label>
                <input type="text" class="form-control" id="Adresse" name="Adresse" placeholder="Adresse" value="<?php echo $_SESSION['auth'][3];?>"/>
            </div>

            <div class="form-group">
                <label for="tel">Téléphone:</label>
                <input type="text" class="form-control" id="tel" name="tel" placeholder="Téléphone" value="<?php echo $_SESSION['auth'][4];?>"/>
            </div>

            <div class="form-group">
                <label for="mdp">Mot de passe:</label>
                <input type="password" class="form-control" id="mdp" name="mdp" placeholder="mot de passe"/>
            </div>

            <div class="form-group">
                <label for="mdp">Confirmation du Mot de passe:</label>
                <input type="password" class="form-control" id="mdp_confirm" name="mdp_confirm" placeholder="Confirmez votre mot de passe"/>
            </div>

            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
        </form>
      </div>
      <br/>
      <button class="btn btn-default"><a href="notification.php">Messagerie</a></button>
      <button class="btn btn-default"><a href="../index.html">Retour au catalogue</a></button>

    </div>
  </body>
</html>
