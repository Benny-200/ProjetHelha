<?php
//Liaison avec la base de donnée
header('Content-type: text/plain; charset=utf-8');
require '../Admin/ConnectionBd.php';
// Balise de navigation

echo '  <nav>
          <ul class="nav nav-pills">';
      // On va se connecter

      $db = Db::connect();

      // récupérer les catégories donc Menu Burger etc

      $categorie_statement = $db->query("select * from categories");
      // On va stocker toutes les lignes dans une variable
      $categories = $categorie_statement->fetchAll(); // il va contenir 2 tab
        // On va boucler sur les menus donc les catégories
        
      foreach($categories as $category){
        //Condition pour l'onglet actif
          if($category['id'] == 1){
            echo utf8_encode('<li role="presentation" class="active"><a href="#'. $category['id'] .'" data-toggle="tab">' . $category['name'] .'</a></li>');
          }
          else{
            echo utf8_encode('<li role="presentation"><a href="#'. $category['id'] .'" data-toggle="tab">' .$category['name'] .'</a></li>');
          }
      }
      echo '</ul>
        </nav>';

        //Comme c'est un système d'onglet on utilise la class tab-content
        
      echo ' <div class="tab-content">';

      // Condition pour l'onglet actif

      foreach($categories as $category){
        if($category['id'] == 1){
          //Onglet actif
          echo utf8_encode('<div class="tab-pane active" id="'.$category['id'].'">');
        }
        else{
          echo utf8_encode('<div class="tab-pane" id="'.$category['id'].'">');
        }

        echo ' <div class="row">';

        $statementItem = $db->prepare('select * from items where items.category = ?');
        $statementItem->execute(array($category['id']));

        // fetch pour récupérer la ligne
        while($chaqueitem = $statementItem->fetch()){
              echo '<div class="col-sm-6 col-md-4">
                      <div class="thumbnail">
                       <img src="ressources/images/'.$chaqueitem['img'].'" alt="..." />
                        <div class="price">'.number_format($chaqueitem['price'],2,'.','').' €</div>
                        <div class="caption">';
              echo utf8_encode('<h4>'. $chaqueitem['name'].'</h4>
                          <p>' . $chaqueitem['description'].'</p>
                          <a href="user/ajoutCommande.php?id='. $chaqueitem['id'].'" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span>Ajouter au panier</a>
                          </div>
                      </div>
                    </div> ');

        }

        echo '</div>
            </div>';
        


      }

      Db::disconnect();
      echo '</div>';

?>