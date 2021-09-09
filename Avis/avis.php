
<?php
//S'il n'y a pas de session on en démarre une
if(session_status() == PHP_SESSION_NONE){
  session_start();
}

//Ajout de l'avis

$errors = array();
$com = "";
$note="";
if((empty($_POST['texteavis']) || empty($_POST['toggle1'])) ){
    $errors['umpty'] = 'Veuillez remplir les informations';
}
else if(!empty($_POST) && (!empty($_POST['texteavis']) || !empty($_POST['toggle1']))){
	$com = $_POST['texteavis'];
	$note = $_POST['toggle1'];
    //On récupère l'id du client
    if(isset($_SESSION['auth'])){
      $idcli = $_SESSION['auth'][0];
      require '../Admin/ConnectionBd.php';
      $bdd = Db::connect(); 
      //Ajout de l'avis
      $insertAvis = $bdd->prepare("insert into avis (idcli,note,textAvis) values(?,?,?)");
      $insertAvis->execute(array($idcli,$note,$com));

      //
      header("Location:avis.php");
      Db::disconnect();
  }
  else{
    $errors['connexionError'] = "Veuillez vous connecter pour pouvoir mettre un commentaire : Veuillez vous diriger vers cette page de <a href='../user/connexion.php'>Connexion</a> en cliquant sur ce lien";
  }
}

?>
<html>
<body>
<head>

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
    <script type="text/javascript" src="afficher.js"></script>

    <!--Css-->
    <link rel="stylesheet" type="text/css" href="styleavis.css"/>

    <title>McSoupex Avis</title>
        <!--Icon-->
        <link rel="icon" type="image/png" href="../ressources/images/b6.png" />
</head>
<div class="container">
<h1>Espace commentaire</h1>

<div class="alert alert-danger">
    <?php if(!empty($errors)){
                  echo '<div class="alert alert-danger">';
                  foreach($errors as $error){
                    echo'<ul><li>'.$error.'</li></ul>';
                  }
                  echo '</div>';
                }
    ?>
</div>

<form method="post">
	<div>
		<input type="radio"  name="toggle1" id="toggle1" value="1"> 1 </input>
		<input type="radio"  name="toggle1" id="toggle1" value="2"> 2 </input>
		<input type="radio"  name="toggle1" id="toggle1" value="3"> 3 </input>
		<input type="radio"  name="toggle1" id="toggle1" value="4"> 4 </input>
		<input type="radio"  name="toggle1" id="toggle1" value="5"> 5 </input>
    <p>
       <label>
       Donnez votre avis !
       </label>
       <br />
       <textarea name="texteavis" id="texteavis" rows="4" cols="50"placeholder="Veuillez remplir votre commentaire"></textarea>       
   </p>
	</div>
	 
	 <div>
    <input type="submit" id="Envoyer">
  </div>
</form>

Les commentaires : <br/>  <br/>


  <!--class table de boostrap-->
<table class="table table-stripped table-bordered">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Note</th>
      <th>Commentaire</th>
      <th>Action</th>
    </tr>
  </thead>
  <!--Id pour que ajax puisse ajouter les données ici-->
  <tbody id="commentaire"></tbody>
</table>
<br/>
<button class="btn btn-default"><a  href="../index.html">Retour au catalogue</a></button>
</div>
</body>
</html>

