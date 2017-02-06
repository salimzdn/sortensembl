<?php session_start(); 
?>
  <script>
  function inverser(){
  var chiffreA = document.getElementById('chiffre1');
  var chiffreB = document.getElementById('chiffre2');
  var tab = [chiffreA.value, chiffreB.value];
  var tab1 = [chiffreB.value, chiffreA.value];
  if (tab != tab1){
    tab[0] = tab[1];
    tab1[0] = tab1[1];
    chiffreA.value = tab[1];
    chiffreB.value = tab1[1];
    console.log(tab);
    console.log(tab1);
  }
  else{
  console.log("erreur");
  }
}
  </script>

<!DOCTYPE html>

<html>

   <head>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/3.1.1/jquery-ui.min.js"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <?php include("../includes/meta.php");?>

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
  /* IE 6 doesn't support max-height
   * we use height instead, but this forces the menu to always be this tall
   */
  * html .ui-autocomplete {
    height: 100px;
  }

<?<?php 
/*

  * { font-family:Arial; }
h2 { padding:0 0 5px 5px; }
h2 a { color: #224f99; }
a { color:#999; text-decoration: none; }
a:hover { color:#802727; }
p { padding:0 0 5px 0; }

input { padding:5px; border:1px solid #999; border-radius:4px; -moz-border-radius:4px; -web-kit-border-radius:4px; -khtml-border-radius:4px; }*/
 ?>
  </style>

 

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


    </body>

     <?php include("../includes/footer.php");?>


</html>