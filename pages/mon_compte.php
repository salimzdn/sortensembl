
<?php session_start();

include("../includes/fonctions.php");
include("../js/onglets.js");

if (!isset($_SESSION['mail']))
{
      $_SESSION['redirection']="mon_compte.php";
      header ('Location: connexion.php');
      exit();
}
else
{
    require ("../includes/conneciondb.php");
      if (isset($_POST['valider']) && $_POST['valider'] == 'Valider')
      {
          if(isset($_FILES['PDP']) AND !empty($_FILES['PDP']['name']))
          {
              $tailleMax=2097152;
              $extensionsValides= array('jpg','png','jpeg');
              if($_FILES['PDP']['size']<=$tailleMax)
              {
                $extensionPhoto=strtolower(substr(strrchr($_FILES['PDP']['name'],'.'), 1));
                if(in_array($extensionPhoto, $extensionsValides))
                {

                    $chemin="../Utilisateur/Photo_Profil/".$_SESSION['id'].".".$extensionPhoto;
                    $resultat=move_uploaded_file($_FILES['PDP']['tmp_name'], $chemin);
                    fctredimimage(250,250,'../Utilisateur/Photo_Profil/',$_SESSION['id'].".".$extensionPhoto,'../Utilisateur/Photo_Profil/',$_SESSION['id'].".".$extensionPhoto);
                    if($resultat)
                    {
                        
                        $updatePDP=$bdd->prepare('UPDATE utilisateur SET photo = ? WHERE id = ?');
                        $updatePDP->execute(array($_SESSION['id'].".".$extensionPhoto,
                          $_SESSION['id']));
                        header('Location : mon_compte.php');


                    }
                    else
                    {
                      $msgPDP="Nous avons rencontré une erreur lors de l'importation de votre fichier, veuillez réessayer";
                    }
                }
                else
                {
                  
                  $msgPDP="Votre photo de profil peut être au format jpg, jpeg ou png.";
                }
              }
              else
              {
                $msgPDP="Votre photos de profil ne doit pas dépasser 2Mo";
              }
          }
        }
}


?>



<!DOCTYPE html>

<html>
    <head>

    	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/3.1.1/jquery-ui.min.js"></script>
    	<?php include("../includes/meta.php");?>
    </head>
  <body> 
    <header>
      <?php include("../includes/entete.php"); ?>

    </header>

    <h1> Mon Compte </h1>
        <h3 >
        <ul id="ul_onglets">
<li id="1" class="onglet_selectionner" onclick="BasculeElement(this);">Mes informations</li>
<li id="2" class="onglet" onclick="BasculeElement(this);">Mes Trajets</li>

</ul>
 
<div id="conteneur-onglet">
<div id="#1" class="contenu-onglet">
  <p class="infospers">
  <?php

    require("../includes/conneciondb.php");

    $reponse = $bdd->prepare('SELECT * FROM utilisateur WHERE id=? ');
    $reponse->execute(array($_SESSION['id']));
    $req=$reponse->fetch(); 
    if($req['sexe']==1)
    {
      $sexe="Mr";
    }
    else
    {
      $sexe="Mme/Mlle";
    }
  ?>

    <?php 
    $nomPhoto=$req['photo'];
    require("../includes/affichage_photo.php");
    ?>
    <br/>
    <div class="infospers">
      Modifier ma Photo de Profil :
      <form method="POST" action="mon_compte.php" enctype="multipart/form-data" >
        
        <input type="file" name="PDP">
        <input type="submit" name="valider" value="Valider">
      </form> 
      
        <?php if(isset($msgPDP)){echo $msgPDP;}?><br><br>
        <?php echo $sexe;?>
         <?php echo ucfirst($req['prenom']);?>
         <?php echo ucfirst($req['nom']);?><br/><br/>
        Date de naissance : <?php $dateNaissance=dateSQLtoFR($req['dateNaissance']);echo $dateNaissance;?><br/>
        Date d'inscription : <?php echo dateSQLtoFR($req['dateInscription']);?><br/>
        <?php echo $req['mail'];?><br/>
    </div>


<script type="text/javascript">
function changermdp(_this)
{
    document.getElementById(FormuChangeMdp).style.display = 'block';

        
}
  </script>

      
      <input class="boutton" onclick="changermdp(this);" type="submit" name="boutonMDP" id="BMDP" value="Mot de passe"/>
      

      <div id="FormuChangeMdp" style="display: none;">
        <form action="mon_compte.php" method="post" class="infospers">
          <label><input type="password" name="oldpasse" id="oldmdp" placeholder="ancien mot de passe"></label><br/>

          <label><input type="password" name="passe" id="mdp" placeholder="Créer un mot de passe" onblur="verifMdp(this)" value=""></label>
                        <span id="aideMdp"></span><br/>

          <label><input type="password" name="passe2" id="mdp2" placeholder="Confirmer votre mot de passe" onblur="verifMdp2(this)"/></label>
                        <span id="aideMdp2"></span><br/><br/>

          <input type="submit" name="changeMdp" value="Changer le mot de passe" />
        </form>
      </div>
    
  </p>
</div>



<div id="#2" class="contenu-onglet" style="display: none;">
<section class="trajets_css">
  <p> Vos trajets en tant que conducteur :<br> <br>

<?php

      $reponse = $bdd->prepare('SELECT * FROM voyage WHERE mail=? ORDER BY date_voyage' );
      $reponse->execute(array($_SESSION['mail']));
      // On affiche chaque entrée une à une
      if (!$reponse->fetch())
      {
        ?>
        Aucun résultat
        <?php
      }
      else
      {
        $reponse = $bdd->prepare('SELECT * FROM voyage WHERE mail=? ORDER BY date_voyage,heures' );
        $reponse->execute(array($_SESSION['mail']));
        
        while ($donnees = $reponse->fetch())
            {
              $trajet =creationTrajet($donnees['etapes']);
              $horaire=creationHeures($donnees['heures']); 
              $nbEtapes=count($horaire);
            ?>
                <?php echo $trajet; ?>,<br />
                <?php for($i=0;$i<$nbEtapes;$i++){echo $horaire[$i];?> &nbsp;<?php } ?><br>
                Le <?php $date= dateSQLtoFR($donnees['date_voyage']);echo $date; ?>, Prix : <?php echo $donnees['prix']; ?>€<br />
                Il reste <?php echo $donnees['places_dispo']; ?> places sur <?php echo $donnees['nbplace']; ?> au total.<br />
               <br>
            <?php
            }

      }
      $reponse->closeCursor(); // Termine le traitement de la requête

      

      ?>





  </p>
  <p> Vos trajets en tant que passager : </p>

  <?php

      /*$reponse = $bdd->prepare('SELECT * FROM utilisateur WHERE mail=? ORDER BY date_voyage' );
      $reponse->execute(array($_SESSION['mail']));
      // On affiche chaque entrée une à une
      if (!$reponse->fetch())
      {
        ?>
        Aucun résultat
        <?php
      }
      else
      {
        $reponse = $bdd->prepare('SELECT * FROM voyage WHERE mail=? ORDER BY date_voyage' );
        $reponse->execute(array($_SESSION['mail']));
        
        while ($donnees = $reponse->fetch())
            {

            ?>
                De <?php echo ucfirst($donnees['depart']); ?> à <?php echo ucfirst($donnees['arrivee']); ?>,<br />
                Le <?php $date= dateSQLtoFR($donnees['date_voyage']);echo $date; ?>, Prix : <?php echo $donnees['prix']; ?>€<br />
                Il reste <?php echo $donnees['place_dispo']; ?> places sur <?php echo $donnees['nbplace']; ?> au total.<br />
               <br>
            <?php
            }

      }
      $reponse->closeCursor(); // Termine le traitement de la requête
*/
      

      ?>



</section>

    



</div>

</div>
        </h3>






  </body>






</html>
