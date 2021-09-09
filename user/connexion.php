<?php

require '../Admin/ConnectionBd.php';

$mdp = "";
$pseudo ="";

$errors = array();
$isSuccess = false;

// vérification des données entrées par l'utilisateur
if(!empty($_POST)){

    $mdp           = checkInput($_POST['mdp']);         
    $pseudo        = checkInput($_POST['pseudo']);   

    if(empty($mdp)) 
    {
      $errors['mdpError'] = 'Ce champ ne peut pas être vide';
    }
    if(empty($pseudo)) 
    {
      $errors['pseudoError'] = 'Ce champ ne peut pas être vide';
    }

    if(empty($errors)){
      $isSuccess = true;
    }

}
// Si les données sont correcte on regarde si c'est un admin, un cuisinier, un livreur ou un client
if($isSuccess) 
{
    $db = Db::connect();

    $statementadmin = $db->prepare("select * from admin where pseudoAdmin = ?");
    $statementadmin->execute(array($pseudo));
    $loginAdmin = $statementadmin->fetch();

    $statementLivreur = $db->prepare("select * from livreur where nom = ?");
    $statementLivreur->execute(array($pseudo));
    $loginLivreur = $statementLivreur->fetch();

    $statementCuisinier = $db->prepare("select * from cuisinier where nom = ?");
    $statementCuisinier->execute(array($pseudo));
    $loginCuisinier = $statementCuisinier->fetch();

    //Session par type (admin, livreur, cuisinier et client)

    if($loginAdmin['pseudoAdmin']){
      if(session_status() == PHP_SESSION_NONE){
        session_start();
      }
      if($loginAdmin['mdp']==$mdp){
      $_SESSION['admin'] = $loginAdmin;
      header("Location: ../index.html");
      exit();}else{
        $errors['mdpLogin'] = "<div class='alert alert-danger'>Votre nom d'utilisateur ou votre mot de passe est incorrecte</div>";
      }

    }
    else if($loginLivreur['nom']){
      if(session_status() == PHP_SESSION_NONE){
        session_start();
      }
      if($loginLivreur['mdp']==$mdp){
        $_SESSION['livreur'] = $loginLivreur;
        header("Location: ../index.html");
        exit();
      }else{
        $errors['mdpLogin'] = "<div class='alert alert-danger'>Votre nom d'utilisateur ou votre mot de passe est incorrecte</div>";
      }
    }
    else if($loginCuisinier['nom']){
      if(session_status() == PHP_SESSION_NONE){
        session_start();
      }
      if($loginCuisinier['mdp']==$mdp){
        $_SESSION['cuisinier'] = $loginCuisinier;
        header("Location: ../index.html");
        exit();
      }else{
        $errors['mdpLogin'] = "<div class='alert alert-danger'>Votre nom d'utilisateur ou votre mot de passe est incorrecte</div>";
      }

    }
    else{
      $statement = $db->prepare("select * from client where pseudo = ?");
      $statement->execute(array($pseudo));
      $login = $statement->fetch();
      if(password_verify($mdp,$login['mdp'])){
        if(session_status() == PHP_SESSION_NONE){
          session_start();
        }
  
        $_SESSION['auth'] = $login;
        header("Location: ../index.html");
        exit();
       
      }else{
        $errors['mdpLogin'] = "<div class='alert alert-danger'>Votre nom d'utilisateur ou votre mot de passe est incorrecte</div>";
      }
    }
    Db::disconnect();
    

    
}

// Fonction qui vérifie l'intégrité des données
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
    <meta charset="utf-8" />
    <title>McSoupex : Connexion</title>
        <!--Icon-->
        <link rel="icon" type="image/png" href="../ressources/images/b6.png" />
    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!--js-->
    <script type="text/javascript" src="../js/script.js"></script>

    <!--bootstrap -->
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"
    />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--Css-->
    <link rel="stylesheet" type="text/css" href="connexion.css" />
  </head>
  <body>
    <div class="container admin">
    <?php if(!empty($errors)){
                  echo '<div class="alert alert-danger"><p>Vous navez pas rempli le formulaire dinscription correctement></p>';
                  foreach($errors as $error){
                    echo'<ul><li>'.$error.'</li></ul>';
                  }
                  echo '</div>';
                }
    ?>
      <div class="row">
        <div id="formInscription">
          <div class="form-text">Connexion</div>
          <div class="form-saisie">
            <form method="POST">
              <span>Pseudo:</span>
              <input
                type="text"
                id="pseudo"
                name="pseudo"
                placeholder="Tapez votre pseudo"
              />
              <span>Mot de passe:</span>
              <input
                type="password"
                id="mdp"
                name="mdp"
                placeholder="Tapez votre mot de passe"
              />
              <input type="submit" id="btnConnexion" value="Connexion" />
            </form>
            <p>Vous n'êtes pas encore inscrit?</p><Button class="btn btn-default"><a href="inscription.php">Inscription</a></Button>
            <div class="form-actions">
                <a class="btn btn-primary" href="../index.html"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
