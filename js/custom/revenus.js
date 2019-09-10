(function(global) {
	var revenus = {
		//Propriétés
		incomeManagement: './data/income_management.php',
		newIncomeSnippet: './snippets/CA/new-income-snippet.html',

		listeDynamiqueScript: './js/custom/liste_dynamique.js',
		eventsScript: './js/custom/events_js.js',
		dateScript: './js/custom/dates_js.js',
		facturesAnnee: './data/factures_annee.php',
		facturesEcheancier: './data/factures_echeancier.php',

		echeancierOverviewSnippet: './snippets/invoice/echeancier-overview-snippet.html',
		echeancierSnippet: './snippets/invoice/echeancier-snippet.html',
		imgValidate: "./images/ico_valider_15.png",
		imgDelete: "./images/ico_supprimer_15.png",

		//Affichage des factures
		display: {
			displayRevenus(data) {
				console.log(data);
			}
		},
		//Gestion des factures
		management: {
			// Saisie des revenus
			newIncome: function() {
				$.get($revenus.incomeManagement, displayNewIncome,'json');
			}
		}
	};

	function displayNewIncome(data){
		$.get($revenus.newIncomeSnippet, function(codeHtml){
			var html = codeHtml;
			 html = $js.insertProperty(html, "MAX_DATE_LISTE", JSON.stringify(data[0]));
			var divContainer = document.getElementById("main-content");
	  	// $js.loadScript("#main-content", $revenus.listeDynamiqueScript);
		  	$js.loadScript("#main-content", $revenus.eventsScript);
		  	$js.loadScript("#main-content", $revenus.dateScript);
		  	divContainer.innerHTML = html;
		  	listeSalaries(data[1], "ListeSalarie");
		}, "html");
		
	}


	global.$revenus = revenus;
})(window);