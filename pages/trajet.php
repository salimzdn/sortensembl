<?php session_start(); 

  require("../includes/conneciondb.php");
  require ("../includes/fonctions.php")
  ?>

<!DOCTYPE html>

<html>

   <head>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/3.1.1/jquery-ui.min.js"></script>
    <?php include("../includes/meta.php");?>

  <style>
  #feedback { font-size: 1.4em; }
  #selectable .ui-selecting { background: #FECA40; }
  #selectable .ui-selected { background: #F39814; color: white; }
  #selectable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #selectable li { margin: 3px; padding: 0.4em; font-size: 0.9em; height: 9px; width: 100px; }
  </style>

    </head>

    <body>
    <header>
        
      <?php 
    include("../includes/entete.php");
    ?>   
    </header>

    <?php

      $reponse = $bdd->prepare('SELECT * FROM voyage WHERE id=?');
      $reponse->execute(array($_GET['id']));

      if (!$reponse->fetch())
    {
      ?>
      <p class="resultatRecherche"> Aucun résultat </p>
      <?php
    }
    else
    {
      $reponse = $bdd->prepare('SELECT * FROM voyage WHERE id=?');
      $reponse->execute(array($_GET['id']));
      $donnees = $reponse->fetch();
      
      $reponse2 = $bdd->prepare('SELECT prenom,nom,photo FROM utilisateur WHERE mail=? ');
      $reponse2->execute(array($donnees['mail']));
      $req2=$reponse2->fetch();      


      $horaire=creationHeures($donnees['heures']); 
      $trajet=creationTrajet($donnees['etapes']);
      $places_dispo=creationPlaceDispo($donnees['places_dispo']);
      $nbEtapes=count($horaire);
              
    ?>

       <?php 
        $nomPhoto=$req2['photo'];
        require("../includes/affichage_photo.php");
        ?>
      <?php echo $trajet ?><br />

      <?php for($i=0;$i<$nbEtapes;$i++){echo $horaire[$i];?> &nbsp;<?php } ?><br>
      Le <?php $date= dateSQLtoFR($donnees['date_voyage']);echo $date; ?>, Prix : <?php echo $donnees['prix']; ?>€<br />
      Proposé par <?php echo ucfirst($req2['prenom']); ?> <br/>
      Il reste <?php echo $donnees['places_dispo']; ?> places sur <?php echo $donnees['nbplace']; ?> au total.<br />

      <?php
         /* if($donnees['place_dispo']==1)
          {
            echo "Faites vite il reste une seule place";
          }
          else
          {
            echo "Il reste ".$donnees['place_dispo']."places sur ".$donnees['nbplace'];
          }
*/
    }

    $reponse->closeCursor(); // Termine le traitement de la requête
    $reponse2->closeCursor();
      ?> <br>

      <p>
      <form>

      <p id="feedback">
<span>Votre voyage:</span> <span id="select-result">none</span>.
</p>
       
<ol id="selectable">
  <li class="ui-widget-content">Item 1</li>
  <li class="ui-widget-content">Item 2</li>
  <li class="ui-widget-content">Item 3</li>
  <li class="ui-widget-content">Item 4</li>
  <li class="ui-widget-content">Item 5</li>
  <li class="ui-widget-content">Item 6</li>
</ol>

      </form>
  <script>
  $( function() {
    $( "#selectable" ).selectable({
      stop: function() {

            
        var result = $( "#select-result" ).empty();
        $( ".ui-selected", this ).each(function() {
          var index = $( "#selectable li" ).index( this );
          result.append( " " + ( index + 1 ) );
        });
      }
    });
  } );

  </script>


      </p>

    </body>

     <?php include("../includes/footer.php");?>


</html>