<?php 
if(!isset($_POST['recherche']) || $_POST['depart']=='')
{
	header ('Location: acceuil.php');
}
else
{


	require("../includes/conneciondb.php");
	require("../includes/fonctions.php");

	if(!isset($_POST['date']) || $_POST['date']=="")
	{
		$testDate=0;
	}
	else
	{
		if ( testDate($_POST['date'])==false) 
		{
			$testDate=0;
		}
		else
		{
			$testDate=1;
		}
		
	}
	session_start(); 

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
        
      <?php 
    include("../includes/entete.php");
    ?>   
    </header>

     <?php 
    include("../includes/recherche_trajet.php");
    ?>   

    <?php

    	if($testDate==0)
    	{
    		?>
			<p class="resultatRecherche"> Veuillez entrer une date valide (Format jj/mm/aaaa). </p>
			<?php
    	}
    	else
    	{
			
				$reponse = $bdd->prepare('SELECT * FROM voyage WHERE INSTR( etapes, ? )!=0 AND INSTR( etapes, ? )!=0 AND INSTR( etapes, ? )>INSTR( etapes, ? ) AND date_voyage>=? ORDER BY date_voyage, heures ');
				$reponse->execute(array($_POST["arrivee"],$_POST["depart"],$_POST["arrivee"],$_POST["depart"],dateFRtoSQL($_POST['date'])));			
	    // On affiche chaque entrée une à une
			if (!$reponse->fetch())
			{
				?>
				<p class="resultatRecherche"> Aucun résultat </p>
				<?php
			}
			else
			{
				$reponse = $bdd->prepare('SELECT * FROM voyage WHERE INSTR( etapes, ? )!=0 AND INSTR( etapes, ? )!=0 AND INSTR( etapes, ? )>INSTR( etapes, ? ) AND date_voyage>=? ORDER BY date_voyage,heures');
				$reponse->execute(array($_POST["arrivee"],$_POST["depart"],$_POST["arrivee"],$_POST["depart"],dateFRtoSQL($_POST['date'])));		
					
				while ($donnees = $reponse->fetch())
						{
							$reponse2 = $bdd->prepare('SELECT prenom,nom,photo FROM utilisateur WHERE mail=? ');
							$reponse2->execute(array($donnees['mail']));
							$req2=$reponse2->fetch();
							 
							$horaire=creationHeures($donnees['heures']); 
							$trajet=creationTrajet($donnees['etapes']);
							$places_dispo=creationPlaceDispo($donnees['places_dispo']);
							$nbEtapes=count($horaire);
							
						?>

						<form method="get" action="trajet.php">
						    <p class="resultatRecherche ">
						     <?php 
						    $nomPhoto=$req2['photo'];
						    require("../includes/affichage_photo.php");
						    ?>
						    <strong>Trajet</strong> :
						    <?php echo $trajet ?><br />

						    <?php for($i=0;$i<$nbEtapes;$i++){echo $horaire[$i];?> &nbsp;<?php } ?><br>
						    Le <?php $date= dateSQLtoFR($donnees['date_voyage']);echo $date; ?>, Prix : <?php echo $donnees['prix']; ?>€<br />
						   	Proposé par <?php echo ucfirst($req2['prenom']); ?> <br/>
						    Il reste <?php echo $donnees['places_dispo']; ?> places sur <?php echo $donnees['nbplace']; ?> au total.<br />
						   
						   <input type="hidden" name="id" value="<?php echo ''.$donnees['id'] ;?>" />
						   

						   <input type="submit" name="reserver" value="Réserver" />
						</form>
						</p><br>
						<?php
						$reponse2->closeCursor();
						}

			}
			$reponse->closeCursor(); // Termine le traitement de la requête

    	}

		

?>
<br>
    </body>

     <?php include("../includes/footer.php");?>


</html>