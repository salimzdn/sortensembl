
    <?php 
            if (!isset($_SESSION['mail']))
                {include ("connexion.php");}
            else
            {
                include("connectee.php");
            }
    ?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/themes/smoothness/jquery-ui.css" />
        <h1> 		
    		<!-- Titre de la page-->
			<span class="intro">Sort'Ensemb</span><br />
			<!-- Slogan-->
			<span class="intro2"> Une nouvelle façon de prendre la route</span>
        </h1>
        <h3 >
            
            <div id="cat" >
            <p>
                <ul class="menu1">
                    <li class="menu1"><a href="../pages/acceuil.php">Accueil</a></li> &nbsp;&nbsp; 
                    <li class="menu1"><a href="../pages/proposition.php">Proposer un covoiturage</a></li> &nbsp;&nbsp; 
                    <li class="menu1"><a href="../pages/Aeroports.php">Aéroports</a></li> &nbsp;&nbsp; 
                    <li class="menu1"><a href="../pages/SpecialeRandonnees.php">Spéciale rando'</a></li> &nbsp;&nbsp; 
    
                </ul>
            </p>
            </div>
        </h3>
