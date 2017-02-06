<?php 
session_start(); 
include("../includes/fonctions.php");

if (!isset($_SESSION['mail']))
{
      $_SESSION['redirection']="proposition.php";
      header ('Location: connexion.php');
      exit();
}
 
if (isset($_POST['proposition']) && $_POST['proposition'] == 'Valider') 
  {
     $erreur="";

        if (isset($_POST['depart']) && isset($_POST['arrivee'])   && isset($_POST['prix'])  &&
          isset($_POST['prix_etape']) && isset($_POST['bagage']) && isset($_POST['message']))/* regarde si la variable contient une valeur */
      {

        if($_POST['prix']<2 || $_POST['prix_etape']<2)
        {
          $erreur= "Veuillez entrer un prix supérieur ou égal à 2€";
        }
        else
        {
          if(strcmp($_POST['depart'],$_POST['arrivee'])==0 )
          {
            $erreur= "Vous ne pouvez pas effectuer un trajet vers deux points identiques.";
          }
          else 
          {
            if(strcmp($_POST['message'],"")==0 ||strcmp($_POST['message'],"Entrez ici un descriptif de votre trajet.")==0 )
            {
              $erreur= "Veuillez entrer un descriptif pour votre trajet.";
            }
            else
            {
              if (comparaisonDates($_POST['dateAller'],date("d/m/Y"))==false)
              {
                $erreur= "Veuillez entrer une date de trajet supérieur ou égal à la date d'aujourd'hui.";
              }
              else
              {
                if (isset($_POST['dateRetour']) && $_POST['retour']=='oui' && comparaisonDates($_POST['dateRetour'],$_POST['dateAller'])==false)
                {
                  $erreur="Votre date de retour doit être ultérieur à votre date de départ.";
                }
                else
                {
                  $heure=$_POST['heureAller'].":".$_POST['minuteAller'];
                  if(strcmp ($_POST['dateAller'],date("d/m/Y")) ===0 && comparaisonHeures($heure,date("H:i"))==false)
                  {
                    $erreur="Veuillez entrez une heure de trajet supérieur à l'heure actuel";
                  }
                  else
                  {
                      if (testDate($_POST['dateAller'])==false) 
                          {
                               $erreur="Veuillez entrer une date valide (Format jj/mm/aaaa)";
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

                            $email=$_SESSION['mail'];
                            
                            $heures=$heure.":00/";

                            $prix=$_POST['prix'];

                            $listeetape="";

                            $heureArriver="";//Achanger
                            $heures=$heure."-".$heureArriver."/";

                            $place_dispo=$_POST['nbplaces'];


                            if($_POST['autre_ville']=='oui')
                            {
                              $autre_ville=1;
                            }
                            else
                            {
                              $autre_ville=0;
                            }

                            if($autre_ville==1)
                            {
                              $prix_etape=$_POST['prix_etape'];//A changer
                              $prix=$prix."/".$prix_etape;

                              $heureEtapes="";//A changer
                              $heures=$heures.$heureEtapes;

                              $listeetape="";//A modifier en ajoutant toute les etapes

                              $place_etapes="";//A changer
                              $place_dispo=$place_dispo."/".$place_etapes;
                            }
                            else
                            {
                              $prix_etape=-1;
                            }

                            $etapes=$_POST['depart'].$listeetape."/".$_POST['arrivee'];


                            if($_POST['regulier']=='oui')
                            {
                              $regulier=1;
                            }
                            else
                            {
                              $regulier=0;
                            }

                            if($_POST['retour']=='oui')
                            {
                              $retour=1;
                            }
                            else
                            {
                              $retour=0;
                            }

                            

                            $places=$_POST['nbplaces'];
                            

                            if(strcmp($_POST['bagage'],"1")==0)
                            {
                              $bagage=0;
                            }
                            elseif(strcmp($_POST['bagage'],"2")==0)
                            {
                              $bagage=1;
                            }
                            else
                            {
                              $bagage=2;
                            }

                            $message=$_POST['message'];
                            
                            $date=dateFRtoSQL($_POST['dateAller']);
                            $passagers="";
                            $req = $bdd->prepare('INSERT INTO voyage  ( mail, etapes,heures,prix,passagers,etape,regulier,retour,nbplace,places_dispo,bagage,message,date_voyage) VALUES (:mail, :etapes,:heures,:prix,:passagers,:etape,:regulier,:retour,:nbplace,:place_dispo,:bagage,:message,:datevoyage)');
                            $req->execute(array(
                                                    ':mail'=>$email,  
                                                      ':etapes'=>$etapes,
                                                        ':heures'=> $heures,
                                                          ':prix'=>$prix,
                                                            ':passagers'=>$passagers,
                                                              ':etape'=> $autre_ville,
                                                                ':regulier'=>$regulier,
                                                                  ':retour'=>$retour,
                                                                    ':nbplace'=>$places,
                                                                      ':place_dispo'=>$places,
                                                                        ':bagage'=>$bagage,
                                                                          ':message'=>$message,
                                                                            ':datevoyage'=>$date));

                            if(isset($_POST['dateRetour']) && $_POST['retour']=='oui' && comparaisonDates($_POST['dateRetour'],$_POST['dateAller'])==true)
                            {

                              $listeetapeRetour="";//A modifier

                              $etapesretour=$_POST['arrivee'].$listeetapeRetour."/".$_POST['depart'];
                              $date_retour=dateFRtoSQL($_POST['dateRetour']);
                              $req2 = $bdd->prepare('INSERT INTO voyage  ( mail, etapes,heures,prix,passagers,etape,regulier,retour,nbplace,place_dispo,bagage,message,date_voyage) VALUES (:mail, :etapes,:heures,:prix,:passagers,:etape,:regulier,:retour,:nbplace,:place_dispo,:bagage,:message,:datevoyage)');;
                              $req2->execute(array(
                                                      ':mail'=>$email,  
                                                        ':etapes'=>$etapesretour,
                                                          ':heures'=> $heures,
                                                            ':prix'=>$prix,
                                                              ':passagers'=>$passagers,
                                                                ':etape'=> $autre_ville,
                                                                  ':regulier'=>$regulier,
                                                                    ':retour'=>0,
                                                                      ':nbplace'=>$places,
                                                                        ':place_dispo'=>$places,
                                                                          ':bagage'=>$bagage,
                                                                            ':message'=>$message,
                                                                              ':datevoyage'=>$date_retour
                                                                                ));
                            }
                            header ('Location: confirmation_proposition.php');
                            exit();
                          
                          }

                    

                  }
                    
                }
                
              }
              

            }
          }
        }
      }
      else
      {
        $erreur= '<p>Tous les champs sont obligatoire</p>';
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
<script>


var maintenant=new Date();
var jour=maintenant.getDate();
var mois=maintenant.getMonth()+1;
var an=maintenant.getFullYear();



  

<script >


$(document).ready(function() {
    $('input[type=radio][name=regulier]').change(function() {
        if (this.value == 'non') {
            var lundi = document.createElement("input");
            lundi.type = "checkbox";
            lundi.name = "lundi";
            lundi.id= "lundi";
            lundi.placeholder="Autres villes";
            var sem1="lundi";
            document.getElementById("ajout3").appendChild(lundi); 
        }
        else if (this.value == 'oui') {
             var div = document.getElementById("ajout3");
              div.removeChild(div.firstChild);
        }
    });
});

</script>

  <script>
    $( function() {
    $( "#datepicker" ).datepicker({ 
       altField: "#datepicker",
      minDate: 0, 
      maxDate: "+12M +10D", 

     
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

  } );

  </script>

<script >
   $( function() {

    $( "#datepicker2" ).datepicker({
       altField: "#datepicker2",
      minDate: 0, 
      maxDate: "+12M +10D", 

     
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

  <style>
  .ui-autocomplete {
    max-height: 100px;
    max-width:140px;
    
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
  }

  .ui-autocomplete.ui-widget {
  font-family: Verdana,Arial,sans-serif;
  font-size: 12px;
}
  * html .ui-autocomplete {
    height: 100px;
  }

  * { font-family:Arial; }
h2 { padding:0 0 5px 5px; }
h2 a { color: #224f99; }
a { color:#999; text-decoration: none; }
a:hover { color:#802727; }
p { padding:0 0 5px 0; }

input { padding:5px; border:1px solid #999; border-radius:4px; -moz-border-radius:4px; -web-kit-border-radius:4px; -khtml-border-radius:4px; }
  </style>

  </head>
    
    <body>
    
    <header>
       <?php 
    include("../includes/entete.php");
    ?> 
    </header>
                             

         <h1 class="titreproposition"> Itinéraire </h1>


                 
                <form action="proposition.php" name ="form1" method="post">
                  <article>
                       <p class="ponctuel"> <br/>
                             <strong>De :</strong>   
                             <input type="text" name="depart" id="depart" placeholder="Depart" class="saisietxt" />   
                              <script type="text/javascript"> 
                                  $('#depart').autocomplete();
                              </script>                                  
                             <strong> A :</strong>                                   
                             <input type="text" name="arrivee" id="arrivee" placeholder="Destination" class="saisietxt"/> 
                              <script type="text/javascript"> 
                                  $('#arrivee').autocomplete();
                              </script><br>

                             <label for="aller">Date aller</label>      
                             <input type="text" name="dateAller" id="datepicker" class="saisietxt" >

                             <label for="aller">Heure aller</label>      
                             <input type="number" name="heureAller" id="heureAller" min="0" step="1" max="24" class="saisietxt" >
                             <input type="number" name="minuteAller" id="minuteAller"  min="0" step="10" max="60" class="saisietxt"><br>
                             
                             <label for="retour">Date retour</label>  
                             <input type="text" name="dateRetour" id="datepicker2" disabled="true" class="saisietxt">
                             <label for="aller">Heure retour</label>
                             <input type="number" name="heureRetour" id="heureRetour" min="0" step="1" max="24" disabled="true" class="saisietxt">
                             <input type="number" name="minuteRetour" id="minuteRetour" min="0" step="10" max="60" disabled="true" class="saisietxt">
                               <script type="text/javascript"> 

                                  $(document).ready(function() {
                                  $('input[type=radio][name=retour]').change(function() {
                                      if (this.value == 'oui') {
                                         document.getElementById("datepicker2").disabled=false;
                                         document.getElementById("heureRetour").disabled=false;
                                         document.getElementById("minuteRetour").disabled=false;
                                      }
                                      else if (this.value == 'non') {

                                           document.getElementById("datepicker2").disabled=true;
                                           document.getElementById("heureRetour").disabled=true;
                                           document.getElementById("minuteRetour").disabled=true;
                                      }
                                  });
                              });

                               </script>
                            <br />
                            <input type="radio" name="retour" value="oui" id="oui" />&nbsp;Oui <!--<label for="oui">oui</label>-->&nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  
                            <input type="radio" name="retour" value="non" id="non" checked="checked"/>&nbsp;Non<!-- <label for="non">non</label>-->
                          <div id="ajout"></div> 
                          <p class="ponctuel"c>Etapes :
                            
                            <a href="#" id="addScnt">Ajouter une etape</a>

                            <div id="p_scents">
                                <p>
                                    <label for="p_scnts"><input type="text" id="p_scnt_1" size="20" name="p_scnt" value="" placeholder="Etape 1" /></label>
                                    <a href="#" id="remScnt">Supprimer</a>
                                </p>
                            </div>

                          </p>
             
                            <p class="ponctuel">Est-ce un trajet ponctuel ou régulier ?<br />
                                <input type="radio" name="regulier" value="oui" id="oui" checked="checked" /> <label for="oui">ponctuel</label>&nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  
                                <input type="radio" name="regulier" value="non" id="non" /> <label for="non">régulier</label>
                            <div id="ajout3"></div></p>


                <!-- 2eme onglet votre annonce -->
			
         <h1 class="titreproposition"> Votre annonce </h1>
        
                    
                    <p class="ponctuel"> <br/><br/>
                        --> prix aller (exemple saint pierre saint denis 5 €) proposition de prix compte tenu du marché
                              <br/>
                             <input type="number" name="prix"  min="0" step="0.01" max="70" class="saisietxt"/> <br/><br/>
                    <p class="ponctuel"> ---> prix pour les étapes du trajet (par exemple saint-pierre saint Paul 3 €)<br>
                            <input type="number" name="prix_etape" step="0.01" max="70" class="saisietxt" /> 
                             <br /><br />
                              

                      
                            <p class="ponctuel"> De combien de places disposez-vous ? <br />
                                <input type="number" name="nbplaces" value="3" min="0" step="1" max="70" class="saisietxt" /> <br/><br/>
                            </p>


                    <article>
                          <p class="ponctuel"> Quelle taille de bagage acceptez-vous ? <br />

                            <input type="radio" name="bagage" value="1" id="1" checked="checked" /> petit
                            <input type="radio" name="bagage" value="2" id="2" /> moyen
                            <input type="radio" name="bagage" value="3" id="3" />j'ai de la place !<br/><br/>
                          </p>
                    </article> 

                          <div class="places"> N'hésitez pas à décrire votre trajet dans le cadre ci-dessous afin d'interesser le plus de personne ! <br>
                              <label for="message"></label>
                              <textarea name="message" rows="8" cols="45" class="saisietxt">Entrez ici un descriptif de votre trajet.</textarea><br/><br/>
                              <input type="submit" name="proposition" value="Valider" class="boutonrechercher" /><br/><br/>
                          </div>   
                          <br/>
                      </p>
                      
              </form>    
                    <?php 
                        if (isset($erreur)) 
                        {
                            echo $erreur;
                        }
                    ?>
                </p>


<script src="../js/ville.js"></script>
  <script src="../js/test-proposition.js"></script>
  



             <script >              
            $(function() {
        var scntDiv = $('#p_scents');
        var i = $('#p_scents p').size() + 1;
        


        $('#addScnt').live('click', function() {

          if(i<=6)
        {
                $('<p><label for="p_scnts"><input type="text" id="p_scnt" size="20" name="p_scnt_' + i +'" value="" placeholder="Etape '+i+'" /></label> <a href="#" id="remScnt">Supprimer</a></p>').appendTo(scntDiv);
                i++;
                return false; }
        });
       
        $('#remScnt').live('click', function() { 
                if( i > 0 ) {
                        $(this).parents('p').remove();
                        i--;
                }
                return false;
        });
});
</script>
    </body>


    <?php include("../includes/footer.php");?>



</html>


