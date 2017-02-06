<?php 

if(isset($_SESSION['mail']))
{
      header ('Location: acceuil.php');
      exit();
}


if (isset($_POST['connexion']) && $_POST['connexion'] == 'Se connecter') 
    {
		// Hachage du mot de passe

		$pass_hache = sha1($_POST['passe']);
		$mail=$_POST['mail'];
		// Vérification des identifiants
		require '../includes/conneciondb.php'; 
		$req = $bdd->prepare('SELECT id, prenom, nom FROM utilisateur WHERE mail = :email AND mdp = :pass');

		$req->execute(array(

		    'email' => $mail,

		    'pass' => $pass_hache));


		$resultat = $req->fetch();

		if (!$resultat)

		{

		    echo 'Mauvais identifiant ou mot de passe !';

		}

		else

		{
		    
			session_start();
		    $_SESSION['id'] = $resultat['id'];
		    $_SESSION['prenom'] = $resultat['prenom'];
		    $_SESSION['nom'] = $resultat['nom'];
		    $_SESSION['mail'] = $_POST['mail'];
		    echo "Bienvenu".$_SESSION['mail'].$_SESSION['id'];
		    if (isset($_SESSION['redirection']))
		    {
		    	$redirection=$_SESSION['redirection'];
		    }
		    else {
		    	$redirection="acceuil.php";
		    }
		    header('Location:' .$redirection);
		    $req->closeCursor(); // Termine le traitement de la requête
		    exit();

		}
	}
?>

    	

    <!DOCTYPE html>
    <html>
    <head>
    	<?php include("../includes/meta.php");?>
    </head>
    <body>
    
    	<?php include ("../includes/connexion.php");?>

    </body>
    </html>