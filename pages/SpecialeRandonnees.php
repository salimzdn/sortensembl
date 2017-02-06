<?php 
session_start(); 

?>

<!DOCTYPE html>

<html>
    
     <head>
    <img src="../images/SpecialeRandonnees.jpg" height="352" width="1510">
    <?php include("../includes/meta.php");?>
    </head>

    <body>
    <header>
        
      <?php 
    include("../includes/entete.php");
    ?>   
    </header>
   


    <body>

    
        <article>
            <form>
                <p class="Recherchetrajet"> Rechercher un trajet <br/ ><br/ > 
                    <strong>De :</strong>   
                    <input type="text" name="depart" placeholder="Depart" />  
                    <strong> A :</strong>  
                    <input type="text" name="arrivée" placeholder="Destination" /><br /><br/ > 
                     
                </p>
            </form>
            <br><div class="boutonrechercher">Rechercher</div><br/ >
        </article>


    
    </body>

    <?php include("../includes/footer.php");?>

</html>