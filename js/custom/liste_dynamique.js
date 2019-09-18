/***************************************************************************************************************************
****************************************************************************************************************************
***************************************** Moteur de recherche fournisseur **************************************************
****************************************************************************************************************************
****************************************************************************************************************************/



// $('#laboratoire').autocomplete({
//   source: "./data/liste_fournisseurs.php",
//   select: function(event, ui) {
//     event.preventDefault();
//     $('#laboratoire').val(ui.item.id);
//   }
// });
$(function() {
var listeFournisseurs = './data/liste_fournisseurs.php', 
    fournisseur = $('#laboratoire'),
    results = $('#results'), 
    selectedResult = -1, // Permet de savoir quel résultat est sélectionné : -1 signifie "aucune sélection"
    previousRequest, // On stocke notre précédente requête dans cette variable
    previousValue=fournisseur.value;// On fait de même avec la précédente valeur

var arrayReturn = [];
  $.get({url: listeFournisseurs, success: function(data) {
    $.each(JSON.parse(data), function(key, value) {
      arrayReturn.push({'id': value.id, 'value': value.name, 'echeance': value.echeance, 'mode_reglement': value.mode_reglement});
    });
    loadSuggestions(arrayReturn);
    }
  });


  function loadSuggestions(options) {
    $('#laboratoire').autocomplete({
      source: options,
      select: function(event, ui) {
        $('#result').html(ui.item.echeance);
        $('<div>').attr({'id': ui.item.id, 'echeance': ui.item.echeance, 'mode_reglement': ui.item.mode_reglement, 'className': 'dropdown-item'}).html(ui.item.value);

          laboratoire.value = ui.item.value; // On change le contenu du champ de recherche et on enregistre en tant que précédente valeur
  id_lab.value= ui.item.id;
  mode_paiement.value = ui.item.mode_reglement;
  // laboratoire.attr('data-echeance', ui.item.echeance);
  console.log(laboratoire);
  
  laboratoire.focus(); // Si le résultat a été choisi par le biais d'un clique alors le focus est perdu, donc on le réattribue

      }
    }); 
  }
});







function displayResults(response) { // Affiche les résultats d'une requête
  var json_response = JSON.parse(response);
  results.style.display = Object.keys(json_response).length ? 'block' : 'none'; // On cache le conteneur si on n'a pas de résultats
  if (Object.keys(json_response).length) { // On ne modifie les résultats que si on en a obtenu
    var responseLen = Object.keys(json_response).length;
    results.innerHTML = ''; // On vide les résultats
    $.each(json_response, function (i){
      div = results.appendChild(document.createElement('div'));
      div.className = "dropdown-item";
      div.setAttribute("id", json_response[i].id);
      div.setAttribute("echeance", json_response[i].echeance);
      div.setAttribute("mode_reglement", json_response[i].mode_reglement);
      div.innerHTML = json_response[i].name;
      div.addEventListener('click', function(e) {
        chooseResult(e.target);
      });
    });
  }
} 

function chooseResult(result) { // Choisi un des résultats d'une requête et gère tout ce qui y est attaché
  laboratoire.value = previousValue = result.innerHTML; // On change le contenu du champ de recherche et on enregistre en tant que précédente valeur
  id_lab.value= result.id;
  mode_paiement.value = result.attr('mode_reglement');
  laboratoire.attr('data-echeance', result.attr('echeance'));
  console.log(laboratoire);
  results.hide(); // On cache les résultats
  result.className = ''; // On supprime l'effet de focus
  selectedResult = -1; // On remet la sélection à "zéro"
  laboratoire.focus(); // Si le résultat a été choisi par le biais d'un clique alors le focus est perdu, donc on le réattribue
} 