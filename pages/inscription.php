 <?php 
            
            require("../includes/fonctions.php");
            $erreur="";
            $conditionmdp=0;
            if (isset($_POST['passe']))
            {
                if (strlen($_POST['passe'])<8 || $_POST['passe']==$_POST['prenom'] || $_POST['passe']==$_POST['nom'] )
                {
                    $conditionmdp=0;
                }
                else
                {
                    $conditionmdp= 1;
                }
            }
                

            if (isset($_POST['inscription']) && $_POST['inscription'] == 'M\'inscrire') 
            {
                if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['passe']) && isset($_POST['passe2']) && isset($_POST['email']))/* regarde si la variable contient une valeur */
                {
                    if ($_POST['passe'] != $_POST['passe2'])
                    {
                       $erreur=$erreur."Veuillez saisir des mots de passes identiques";
                    }
                    else
                    {
                        if ( $conditionmdp==0) 
                        {
                            $erreur=$erreur."Votre mot de passe doit contenir au moins 8 caractères et être différent de votre nom et de votre prénom";
                        }
                        else
                        {
                            if (!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#is',$_POST['email']))
                            {
                                $erreur=$erreur. "Veuillez entrer une adresse email valide.";
                            }
                            else 
                            {
                                if(!isset($_POST['choix1']))
                                {
                                     $erreur=$erreur. "Vous devez accepter les conditions generales";
                                }
                               else
                                {
                                    if (testDate($_POST['dateNaissance'])==false) 
                                    {
                                         $erreur="Veuillez entrer une date de naissance valide (Format jj/mm/aaaa)";
                                    }
                                    else
                                    {
                                        require('../includes/conneciondb.php'); 
                                        $email=$_POST['email'];
                                        $result = $bdd->prepare('SELECT COUNT(*) FROM utilisateur WHERE mail = ?');
                                        $result->bindParam(1,$email);
                                        $result->execute();
                                        $nb = $result->fetch();

                                        if($nb[0] > 0) {
                                            $erreur=$erreur. "Cette adresse mail est déjà utilisée.";  
                                        }
                                        else {                                  
                                            $email=$_POST['email'];
                                            $prenom=ucfirst($_POST['prenom']);
                                            $nom=ucfirst($_POST['nom']);
                                            if($_POST['civil']=='civil-homme')
                                            {
                                                $sexe=1;
                                            }
                                            else
                                            {
                                                $sexe=2;
                                            }
                                            //$naissancea=intval($_POST['annee']);
                                            $naissancea=dateFRtoSQL($_POST['dateNaissance']);

                                            $dateInscription = date('Y-m-d');
                                            // Hachage du mot de passe

                                            $pass_hache = sha1($_POST['passe']);
                                            
                                            $req = $bdd->prepare('INSERT INTO utilisateur  ( mail, prenom,nom,sexe,dateNaissance,mdp,dateInscription,verifier,photo,voyages) VALUES (:mail, :prenom, :nom,:sexe,:naissancea,:mdp,:dateInscription,:verifier,:photo,:voyages)');
                                            $req->execute(array(
                                                            ':mail'=>$email,  
                                                              ':prenom'=>$prenom,
                                                                ':nom'=>$nom,
                                                                    ':sexe'=> $sexe,
                                                                        ':naissancea'=>$naissancea,
                                                                            ':mdp'=>$pass_hache,
                                                                                ':dateInscription'=>$dateInscription,
                                                                                    ':verifier'=>0,
                                                                                        ':photo'=>"",
                                                                                            ':voyages'=>""));

                                            session_start();

                                            $req2 = $bdd->prepare('SELECT id, prenom FROM utilisateur WHERE mail = ?');

                                            $req2->execute(array($_POST['email']));


                                            $resultat = $req2->fetch();

                                            $_SESSION['id'] = $resultat['id'];
                                            $_SESSION['prenom']=$resultat['prenom'];
                                            $_SESSION['nom'] = $resultat['nom'];
                                            $_SESSION['mail'] = $_POST['email'];
                                            header('Location: acceuil.php');
                                            exit(); 
                                    }
                                    
                                    }
                                }
                            }
                        }   
                
                    }

                }
                 else
                {
                    $erreur=$erreur."Tous les champs sont obligatoires";
                }
                
            }
               


        ?>

<!DOCTYPE html>

<html>

        
    
  <head>
    <?php include("../includes/meta.php");?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/3.1.1/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/3.1.1/themes/smoothness/jquery-ui.css" />


  </head>
    
    <body>
    
    <header>
       <?php 
    include("../includes/entete.php");
    ?> 
    </header>



    <form action="inscription.php" method="post" onsubmit="return verifForm(this)">




        <p class= "attestation">     
                <input type="radio" name="civil" value="civil-homme" id="oui" checked="checked" />&nbsp;Homme &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  
                <input type="radio" name="civil" value="civil-femme" id="non" />&nbsp;Femme 
        </p>

        <p class ="attestation">
                <label><input type="text" name="nom" placeholder="Nom" onblur="verifNom(this)" value="" class="saisietxt" /></label>
                        <span id="aideNom"></span><br/>

                <label><input type="text" name="prenom" placeholder="Prénom" onblur="verifNom(this)" value="" class="saisietxt"/></label>
                        <span id="aidePrenom"></span><br/>

                <label><input type="password" name="passe" id="mdp" placeholder="Créer un mot de passe" onblur="verifMdp(this)" class="saisietxt" value=""></label>
                        <span id="aideMdp"></span><br/>

                <label><input type="password" name="passe2" id="mdp2" placeholder="Confirmer votre mot de passe" class="saisietxt" onblur="verifMdp2(this)"/></label>
                        <span id="aideMdp2"></span><br/>

                <label><input type="email" name="email" placeholder="Adresse e-mail" class="saisietxt"/></label><br/><span id="aideMail"></span>
                 
                            <input type="text" id="datepicker" name="dateNaissance" placeholder="Date de naissance" class="saisietxt">
                            <script type="text/javascript">
                                    jQuery(document).ready(function($){
                                    $("#datepicker").datepicker({
                                            changeMonth: true,
                                            changeYear: true,
                                            altField: "#datepicker",
                                      
                                            closeText: 'Fermer',
                                            prevText: 'Précédent',
                                            nextText: 'Suivant',
                                            currentText: 'Aujourd\'hui',
                                            monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                                            monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
                                            dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                                            dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
                                            dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                                            weekHeader: 'Sem.',
                                            dateFormat: 'dd/mm/yy'});
                                                
                                    });
                            </script>   


        <p class="attestation"> Attestez-vous <br /> avoir plus de 18 ans et avoir pris connaissance des conditions générales et de la politique de confidentialité de Sort’ ensemb ?<br />

                <input type="checkbox" name="choix1" onblur="verifCondition(this)"> oui <br />


                <input type="submit" name="inscription" value="M'inscrire" />

        </p>
        </p>
    </form>

    <?php 
        if (isset($erreur)) 
        {
            echo $erreur;
        }
    ?>
    
    <script src="../js/test-inscription.js"></script>

    </body>


    <?php include("../includes/footer.php"); ?>


</html>