<?php
require '../Admin/ConnectionBd.php';
$db = Db::connect();
//J'initialise à vide les erreurs pour pas avoir de problème
$nom = "";
$prenom = "";
$adresse = "";
$tel = "";
$mdp = "";
$confirmmdp="";
$pseudo ="";
$isSuccess=false;

$errors = array();
//Vérification des valeurs entrées par l'utilisateur
if(!empty($_POST)){
    $nom           = checkInput($_POST['nomcli']);
    $prenom        = checkInput($_POST['prenomcli']);
    $adresse       = checkInput($_POST['adressecli']);
    $tel           = checkInput($_POST['telcli']); 
    $mdp           = checkInput($_POST['mdp']);         
    $pseudo        = checkInput($_POST['pseudo']);            
    $confirmmdp    = checkInput($_POST['confirmmdp']); 

    if(empty($nom) ) 
    {
        $errors['nomError'] = "erreur nom";
    }
    if(empty($prenom) ) 
    {
        $errors['$prenomError'] = "erreur prenom";
    } 
    if(empty($adresse)) 
    {
        $errors['$adresseError'] = "erreur adresse";
    } 
    if(empty($tel)) 
    {
        $errors['$telError'] = "erreur tel";
    }
    if(empty($mdp) || $mdp != $confirmmdp) 
    {
      $errors['$mdpError'] = "Vous devez remplir votre mot de passe";    
    }
    if(empty($pseudo)) 
    {
        $errors['$pseudoError'] ="pseudo pas correcte";  
    }
    else{
      $pseudoUnique = $db->prepare('select idcli from client where pseudo = ?');
      $pseudoUnique->execute(array($pseudo));
      $uniqueCli = $pseudoUnique->fetch();
      if($uniqueCli){
        $errors['$pseudoUniqueError'] ="pseudo déjà utilisé pour un autre compte veuillez changer";  
      }
    }
    if(empty($errors)){
      $isSuccess = true;
    }
}
//S'il n'y pas d'erreur, on crypte le mot de passe, et on ajoute le client
if($isSuccess) 
{
    $statement = $db->prepare("INSERT INTO client (nomcli,prenomcli,adressecli,telcli,mdp,pseudo) values(?,?, ?, ?, ?,?)");
    $cryptageMdp = password_hash($mdp,PASSWORD_BCRYPT);
    $statement->execute(array($nom,$prenom,$adresse,$tel,$cryptageMdp,$pseudo));

    /*Je le connecte directement*/
    $query = $db->prepare('select * from client where pseudo = ?');
    $query->execute(array($pseudo));
    $client = $query->fetch();
    if(session_status() == PHP_SESSION_NONE){
      session_start();
    }
    //On démarre la session du client directement après l'inscription
    $_SESSION['auth'] = $client;
    //Redirection vers la page d'acceuil
    header("Location: ../index.html");
    
}
//Fonction qui vérifie l'intégrité des données
function checkInput($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
Db::disconnect();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>McSoupex : Inscription</title>
        <!--Icon-->
        <link rel="icon" type="image/png" href="../ressources/images/b6.png" />
    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
                }
        ?>
      <div class="row">
        <div id="formInscription">
          <div class="form-text">Inscription</div>
          <div class="form-saisie">            
            <form method="POST">
              <span>Nom:</span>
              <input
                type="text"
                id="nomcli"
                name="nomcli"
                placeholder="Tapez votre nom"
                required
              />
              <span>Prénom:</span>
              <input
                type="text"
                id="prenomcli"
                name="prenomcli"
                placeholder="Tapez votre Prénom"
                required
              />
              <span>Pseudo:</span>
              <input
                type="text"
                id="pseudo"
                name="pseudo"
                placeholder="Tapez votre pseudo"
                required
              />
              <span>Mot de passe:</span>
              <input
                type="password"
                id="mdp"
                name="mdp"
                placeholder="Tapez votre mot de passe"
                required
              />
              <span>Veuillez confirmer votre mot de passe</span>
              <input
                type="password"
                id="confirmmdp"
                name="confirmmdp"
                placeholder="Tapez votre mot de passe"
                required
              />
              <span>Adresse:</span>
              <input
                type="text"
                id="adressecli"
                name="adressecli"
                placeholder="Tapez votre Adresse"
                required
              />
              <span>Téléphone:</span>
              <input
                type="tel"
                id="telcli"
                name="telcli"
                placeholder="Tapez votre numéro de Téléphone"
                required
              />
              <input type="submit" id="btnInscription" value="Inscription" />
              <div class="form-actions">
                <a class="btn btn-primary" href="../index.html"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
             </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
