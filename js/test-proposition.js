

function verifDate(champ)
{

	var now= new Date();
	var mois = now.getMonth() +1;
	var jour = now.getDate();
	var annee = now.getFullYear();
	var temp =champ.value.;

	alert(champ.value);
   if(champ.value < date)
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}


function surligne(champ, erreur)
{
   if(erreur)
      champ.style.backgroundColor = "#fba";
   else
      champ.style.backgroundColor = "";
}

