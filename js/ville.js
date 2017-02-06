var listeVille = [
	
"Saint-Denis",
"Aéroport",
"La montagne",
"Bellepierre",
"Saint-Pierre",
"Ravine blanche",
"Ravine des Cabris",
"Ligne des bambous",
"Ligne paradis",
"Basse terre",
"Terre Sainte",
"Pierrefond",
"Bras Panon",
"Cilaos",
"Entre-Deux",
"La Possession",
"Le Port",
"Les Avirons",
"Les Trois-Bassins",
"Etang Sale",
"Etang Salé les hauts",
"Etang Salé les bains",
"La Petite-Ile",
"Grand Anse",
"Le Tampon",
"Petit tampon",
"Trois marre",
"La chattoire ",

"La plaine des Caffres",
"La Plaine des Palmistes",
"Salazie",
"Saint-Leu",
"Sainte-Marie",
"Sainte-Rose",
"Saint-Andre",
"Sainte-Suzanne",
"Saint-Philippe",
"Saint-Louis",

"Saint-Paul",
"Saint-Gilles les bains",
"Saint-Gilles les hauts",
"La Saline les hauts ",
"La saline les bains",
"Plateau Caillou",
"Saint-Benoît",
"Saint-Joseph",
"Mafate"


];

/*var villeElt = document.querySelector("input");
var suggestionsElt = document.getElementById("suggestions");

// Gère le changement de valeur saisie
villeElt.addEventListener("input",function () {
	suggestionsElt.innerHTML = ""; // Vidage de la liste des suggestions
	listeVille.forEach(function (ville) {
		//SI valeur en cours de saisie correspond au début de la ville 
		if (ville.indexOf(villeElt.value) === 0) {
			var suggestionElt = document.createElement("div");
			suggestionElt.classList.add("suggestion");
			suggestionElt.textContent = ville;
			// Gère le clic sur une suggestion
			suggestionElt.addEventListener("click", function (e) {
				//Remplacement de la valeur saisie pare la suggestion
				villeElt.value = e.target.textContent;
				//Vidage de la liste des suggstions 
				suggestionsElt.innerHTML = "";
			});
			suggestionsElt.appendChild(suggestionElt);
		}
		
	});
});*/

$('#depart').autocomplete({

    source : listeVille

});


$('#arrivee').autocomplete({

    source : listeVille

});