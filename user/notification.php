<!DOCTYPE html>
<html>
  <head>
    <title>McSoupex</title>
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
            <?php
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
            echo 'Bonjour  '.$_SESSION['auth'][6] .'<br/>Votre commande a bien été enregistrée, vous serez livré dans les plus brefs délais';
            echo '<br/><button><a href="../index.html">Retourner au catalogue</a></button>';
        ?>
      </div>
    </div>
  </body>
</html>