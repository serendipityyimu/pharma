/***************************************************************************************************************************
****************************************************************************************************************************
***************************************** Moteur de recherche fournisseur **************************************************
****************************************************************************************************************************
****************************************************************************************************************************/

var listeFournisseurs = './data/liste_fournisseurs.php?s=', fournisseur = document.getElementById('laboratoire'),results = document.getElementById('results'), 
  selectedResult = -1, // Permet de savoir quel résultat est sélectionné : -1 signifie "aucune sélection"
  previousRequest, // On stocke notre précédente requête dans cette variable
  previousValue=fournisseur.value;// On fait de même avec la précédente valeur

fournisseur.addEventListener('keyup', function(e) {
  var divs = results.getElementsByTagName('div');
  if (e.keyCode == 38 && selectedResult > -1) { // Si la touche pressée est la flèche "haut"
    divs[selectedResult--].className = '';
    if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
      divs[selectedResult].className = 'result_focus';
    }
  } 
  else if (e.keyCode == 40 && selectedResult < divs.length - 1) { // Si la touche pressée est la flèche "bas" 
    results.style.display = 'block'; // On affiche les résultats  
    if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
      divs[selectedResult].className = '';
    } 
    divs[++selectedResult].className = 'result_focus';  
  }
  else if (e.keyCode == 13 && selectedResult > -1) { // Si la touche pressée est "Entrée"
    chooseResult(divs[selectedResult]);
  }
  else if (laboratoire.value != previousValue) { // Si le contenu du champ de recherche a changé
    previousValue = laboratoire.value;
    if (previousRequest && previousRequest.readyState < XMLHttpRequest.DONE) {
      previousRequest.abort(); // Si on a toujours une requête en cours, on l'arrête
    }
    previousRequest = getResults(previousValue); // On stocke la nouvelle requête
    selectedResult = -1; // On remet la sélection à "zéro" à chaque caractère écrit
  }
});

$('#newInvoiceForm').on('keydown', 'input', function (event) {
  if (event.which == 13) {
    event.preventDefault();
    var $this = $(event.target);
    var index = parseFloat($this.attr('data-index'));
    $('[data-index="' + (index + 1).toString() + '"]').focus();
  }
});

function getResults(keywords) { // Effectue une requête et récupère les résultats
  var xhr = getXMLHttpRequest();
  xhr.open('GET', listeFournisseurs + encodeURIComponent(keywords));
  xhr.addEventListener('readystatechange', function() {
    if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
      displayResults(xhr.responseText);
    }
  });
  xhr.send(null);
  return xhr;
}

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
  mode_paiement.value = result.getAttribute('mode_reglement');
  laboratoire.setAttribute('data-echeance', result.getAttribute('echeance'));
  results.style.display = 'none'; // On cache les résultats
  result.className = ''; // On supprime l'effet de focus
  selectedResult = -1; // On remet la sélection à "zéro"
  laboratoire.focus(); // Si le résultat a été choisi par le biais d'un clique alors le focus est perdu, donc on le réattribue
} 