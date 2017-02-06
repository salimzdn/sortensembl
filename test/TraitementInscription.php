<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>Covoit Run- inscription/title>

    </head>

    <body>

    

       <?php 

       		$success=true;

       		function conditionmdp()
			{
				if (strlen($_POST['passe'])<8 || $_POST['passe']==$_POST['prenom'] || $_POST['passe']==$_POST['nom'] )
				{
					return 0;
				}
				else
				{
					return 1;
				}
			}

			if (!isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['passe']) || !isset($_POST['passe2']) || !isset($_POST['email']))/* regarde si la variable contient une valeur */
			{
				echo '<p>tous les champs sont obligatoire</p>';
				$success=false;
			}
			elseif ($_POST['passe'] != $_POST['passe2'])
			{
				echo '<p>Veuillez saisir des mots de passes identiques</p>';
				$success=false;
			}
			elseif ( conditionmdp()==0) 
			{
				echo '<p>Votre mot de passe doit contenir au moins 8 caractères et être différent de votre nom et de votre prénom.</p>';
				$success=false;
			}
			elseif(!isset($_POST['choix1']))
			{
				echo '<p>Vous devez accepter les conditions generales</p>';
				$success=false;
			}

			if ($success==false)
			{
				include("inscription.php");
			}
			else
			{

				try

				{
				    $bdd = new PDO('mysql:host=localhost;dbname=test-sorten;charset=utf8', 'root', '');
				    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

				}

				catch(Exception $e)

				{
				        die('Erreur : '.$e->getMessage());
				}

				$email=$_POST['email'];
				$prenom=$_POST['prenom'];
				$nom=$_POST['nom'];
				if($_POST['civil']=='civil-homme')
				{
					$sexe=1;
				}
				else
				{
					$sexe=2;
				}
				$naissancea=intval($_POST['annee']);
				$mdp=$_POST['passe'];
				echo $email;
				echo $prenom;
				echo $nom;
				echo $sexe;
				echo $mdp;
				echo $naissancea;
				
				$req = $bdd->prepare('INSERT INTO utilisateur  ( mail, prenom,nom,sexe,naissancea,mdp,verifier) VALUES (:mail, :prenom, :nom,:sexe,:naissancea,:mdp,:verifier)');
 				$req->execute(array(
                                ':mail'=>$email,  
                                  ':prenom'=>$prenom,
                                    ':nom'=>$nom,
                                    	':sexe'=> $sexe,
                                    		':naissancea'=>$naissancea,
                                    			':mdp'=>$mdp,
                                    				':verifier'=>0));

				echo '<p>bravo</p>';
			}


		?>
        

    </body>

</html>


<p> 


<p>