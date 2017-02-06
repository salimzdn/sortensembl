
        <article>
            <form action="resultat_recherche.php" method="post" >
                <p class="Recherchetrajet"> Rechercher un trajet <br/ >
                    <input type="text" id="depart" name="depart" placeholder="Départ" class="saisietxt" /> 
                                      
                     <script type="text/javascript"> $('#depart').autocomplete();
                                    
                                            
                                        </script> &nbsp;
                    

                    <input type="text" name="arrivee" id="arrivee" placeholder="Destination" class="saisietxt" >
                    <script type="text/javascript"> 
                        $('#arrivee').autocomplete();
                    </script> &nbsp;&nbsp;&nbsp;
                  <input type="text" name="date" id="datepicker" placeholder="Date du trajet" class="saisietxt">
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
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                            <input type="submit" name="recherche" value="Rechercher" class="boutonrechercher" />
                            <br> <br>
                </p>

            </form>
     </article>
<br><br>

<script src="../js/ville.js"></script>
