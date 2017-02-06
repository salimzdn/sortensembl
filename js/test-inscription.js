// Vérification de la longueur du mot de passe saisi

document.getElementById("mdp").addEventListener("input", function (e) {

    var mdp = e.target.value; // Valeur saisie dans le champ mdp

    var longueurMdp = "faible";

    var couleurMsg = "red"; // Longueur faible => couleur rouge

    if (mdp.length >= 12) {

        longueurMdp = "bonne";
        couleurMsg = "green"; // Longueur moyenne => couleur orange
        

    } else if (mdp.length >= 8) {

        longueurMdp = "suffisante";
        couleurMsg = "orange"; // Longueur suffisante => couleur verte

    }

    var aideMdpElt = document.getElementById("aideMdp");

    aideMdpElt.textContent = "Longueur : " + longueurMdp; // Texte de l'aide

    aideMdpElt.style.color = couleurMsg; // Couleur du texte de l'aide

});

//Vérification de mots de passe identiques

// Contrôle du courriel en fin de saisie

document.getElementById("mdp2").addEventListener("blur", function (e) {

    var mdp2 = e.target.value;
    var mdp=document.getElementById("mdp").value;
    var validiteMdp = "";


    if (mdp !== mdp2) {

        validiteMdp = "Veuillez entrez deux mots de passes identiques";

    }

    document.getElementById("aideMdp2").textContent = validiteMdp;

});

// Vérification avant envoie

function surligne(champ, erreur)
{
   if(erreur)
      champ.style.backgroundColor = "#fba";
   else
      champ.style.backgroundColor = "";
}

function verifNom(champ)
{
   if(champ.value.length < 2 || champ.value.length > 25)
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

function verifMdp(champ)
{
    var mdp = champ.value;
   if( mdp.length <8)
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

function verifMdp2(champ)
{
    var mdp2 = champ.value;
    var mdp=document.getElementById("mdp").value;
   if( mdp!==mdp2)
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

function verifCondition(champ)
{
    var verif = champ.checked;
   if( verif===false)
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

function verifForm(f)
{
    var nomOk = verifNom(f.nom);
    var prenomOk = verifNom(f.prenom);
   var mdpOk=verifMdp(f.passe);
   var mdp2Ok=verifMdp2(f.passe2);
   var condition=verifCondition(f.choix1);
   console.log("fctiooooooooooooooooooooooooooooo");
   if(nomOk &&prenomOk && mdpOk && mdp2Ok&&condition)
      return true;
   else
   {
      alert("Veuillez remplir correctement tous les champs");
      return false;
   }
}
