(function(global) {
	var factures = {
		//Propriétés
		invoiceManagement: './data/invoice_management.php',
		listeDynamiqueScript: './js/custom/liste_dynamique.js',
		eventsScript: './js/custom/events_js.js',
		dateScript: './js/custom/dates_js.js',
		facturesAnnee: './data/factures_annee.php',
		facturesEcheancier: './data/factures_echeancier.php',
		newInvoiceSnippet: './snippets/invoice/new-invoice-snippet.html',
		echeancierOverviewSnippet: './snippets/invoice/echeancier-overview-snippet.html',
		echeancierSnippet: './snippets/invoice/echeancier-snippet.html',
		imgValidate: "./images/ico_valider_15.png",
		imgDelete: "./images/ico_supprimer_15.png",

		//Affichage des factures
		display: {
			//Tableau récapitulatif des factures par année, mois et état
			displayInvoice: function(dateType, year) {
			  if(year == null){ year = new Date().getFullYear();}
			  $.get($factures.facturesAnnee,{dateType : dateType, year : year} , displayFactures, 'json');
			},
			//Liste des factures détaillées
			displayInvoiceList: function(dateType, date_debut, date_fin, codeType, statut, modePaiement, sort) {
				$.get($factures.facturesEcheancier, {dateType: dateType, date_debut: date_debut, date_fin: date_fin, codeType: codeType, statut: statut, modePaiement: modePaiement, sort: sort}, displayListeFactures, 'json');
			}
		},
		//Gestion des factures
		management: {
			// Creation d'une nouvelle facture
			newInvoice: function(idFacture, queryType, dateType, dateDebut, dateFin, codeType, statut, modePaiement) {
				  $.get($factures.invoiceManagement, {ID_FACTURE : idFacture, QUERY_TYPE : queryType, DATETYPE : dateType, DATE_DEBUT : dateDebut, DATE_FIN: dateFin, CODE_TYPE : codeType, CODE_STATUT : statut, MODE_PAIEMENT: modePaiement}, displayNewInvoice, 'json');
			},
			//Raccourci pour passer au statut suivant
			invoiceNextStatut: function(idFacture,dateType, date_debut, date_fin, codeType, statut, modePaiement) {
				if(statut<3){
					$.post($factures.invoiceManagement,{id_facture : idFacture, QUERY_TYPE : 'NEXT_STATUT'}, function(data) {							
						$factures.display.displayInvoiceList(dateType, date_debut, date_fin, codeType, statut, modePaiement);
					});					
				}
			},
			multipleInvoicesNextStatut: function(listeFactures) {
				var results = new Array(), chkbx = document.getElementsByName('sousTotalChkbx'), dateType = document.getElementById("type_date").value, date_debut = document.getElementById("date_debut").value, date_fin = document.getElementById("date_fin").value, codeType = document.getElementById("type").value, statut = document.getElementById("etat").value, modePaiement = document.getElementById("mode_paiement").value;
				for(let i = 0, length1 = chkbx.length; i < length1; i++){
        	if (chkbx[i].checked == true) {
        		//On récupère dans le table echeancier, pour chaque ligne, l'identifiant de la facture et on le garde dans results
          	results.push($("#echeancier tr").eq(i+1).find(".idFacture").val());
        	}
      	}
	      for (var i = 0; i < results.length; i++) {
	      	$factures.management.invoiceNextStatut(results[i], dateType, date_debut, date_fin, codeType, statut, modePaiement);
	      }
			},
			// Suppression d'une facture
			deleteInvoice: function(idFacture,dateType, date_debut, date_fin, codeType, statut, modePaiement) {
				$.post($factures.invoiceManagement,{id_facture : idFacture, QUERY_TYPE : 'DELETE'}, function(data) {
		     	$factures.display.displayInvoiceList(dateType, date_debut, date_fin, codeType, statut, modePaiement);
		    });
			}
		}
	};
	function displayNewInvoice(data) {
		$.get($factures.newInvoiceSnippet, function (codeHtml){
	  	var html = codeHtml, state = '', modePaiement = '', invoiceType = '';
	  	$.each(data, function (key, val) {
	    	html = $js.insertProperty(html, key, val);
	    	if(key =='CODE_STATUT') {
	    		state = val;
	    	}
	    	if(key == 'CODE_MODE_PAIEMENT') {
	    		modePaiement = val;
	    	}
	        if(key == 'CODE_TYPE') {
	    		invoiceType = val;
	    	}
	  	});
	  	var divContainer = document.getElementById("main-content");
	  	$js.loadScript("#main-content", $factures.listeDynamiqueScript);
	  	$js.loadScript("#main-content", $factures.eventsScript);
	  	$js.loadScript("#main-content", $factures.dateScript);
	  	divContainer.innerHTML = html;
	 		optionSelect(state, "etat");
	 		optionSelect(modePaiement, "mode_paiement");
	 		optionSelect(invoiceType, "type");
	  }, "html");			
	}
	function displayListeFactures(liste) {
		$.get($factures.echeancierSnippet, function (codeHtml){
			var html = codeHtml, divResults = document.createElement("div");
			divResults.innerHTML = html;
			var divContainer = document.getElementById("main-content");
		 	divContainer.innerHTML = "";
		 	divContainer.appendChild(divResults);
		 	$js.loadScript("#main-content", $factures.eventsScript);

		 	var typeDate = document.getElementById("type_date"),date_debut = document.getElementById("date_debut"),	date_fin = document.getElementById("date_fin"),	statut = document.getElementById("etat"),	type = document.getElementById("type"),	modePaiement = document.getElementById("mode_paiement"), sort_lab = document.getElementById("sort_lab"),	sort_invoice_date = document.getElementById("sort_invoice_date"),	sort_payment_date = document.getElementById("sort_payment_date"),	sort_type = document.getElementById("sort_type"), sort_amount = document.getElementById("sort_amount"), sort_status = document.getElementById("sort_status"), sort_payment = document.getElementById("sort_payment");
		 	optionSelect(liste[0]['dateType'], "type_date");
			optionSelect(liste[0]['statut'], "etat");
			optionSelect(liste[0]['modePaiement'], "mode_paiement");
			optionSelect(liste[0]['codeType'], "type");
			date_debut.value = liste[0]['date_debut'];
			date_fin.value = liste[0]['date_fin'];
			var sort = liste[0]['sort'];
			$('#date_debut').datepicker($.datepicker.regional["fr"]);
			$('#date_fin').datepicker($.datepicker.regional["fr"]);
			$('#date_debut').removeClass('hasDatepicker');
			$('#date_fin').removeClass('hasDatepicker');
			$('#date_debut').datepicker({
				onSelect: function (dateSelected, i){
			 		date_debut.value = dateSelected;
			 		$factures.display.displayInvoiceList(typeDate.value, date_debut.value, date_fin.value, type.value, statut.value, modePaiement.value);
			 	}
			});
			$('#date_fin').datepicker({
				onSelect: function (dateSelected, i){
			 		date_fin.value = dateSelected;
			 		$factures.display.displayInvoiceList(typeDate.value, date_debut.value, date_fin.value, type.value, statut.value, modePaiement.value);
			 	}
			});
			typeDate.addEventListener("change", function(){
				$factures.display.displayInvoiceList(typeDate.value, date_debut.value, date_fin.value, type.value, statut.value, modePaiement.value);
			});
			statut.addEventListener("change", function(){
				$factures.display.displayInvoiceList(typeDate.value, date_debut.value, date_fin.value, type.value, statut.value, modePaiement.value);
			});
			type.addEventListener("change", function(){
				$factures.display.displayInvoiceList(typeDate.value, date_debut.value, date_fin.value, type.value, statut.value, modePaiement.value);
			});
			modePaiement.addEventListener("change", function(){
				$factures.display.displayInvoiceList(typeDate.value, date_debut.value, date_fin.value, type.value, statut.value, modePaiement.value);
			});
		 	sort_lab.addEventListener("click", function(){
		 		$factures.display.displayInvoiceList(typeDate.value, date_debut.value, date_fin.value, type.value, statut.value, modePaiement.value, 'NOM_FOURNISSEUR');
		 	});
		 	sort_invoice_date.addEventListener("click", function(){
		 		$factures.display.displayInvoiceList(typeDate.value, date_debut.value, date_fin.value, type.value, statut.value, modePaiement.value, 'DATE_FACTURE');
		 	});
		 	sort_payment_date.addEventListener("click", function(){
		 		$factures.display.displayInvoiceList(typeDate.value, date_debut.value, date_fin.value, type.value, statut.value, modePaiement.value, 'DATE_ECHEANCE');
		 	}); 
		 	sort_type.addEventListener("click", function(){
		 		$factures.display.displayInvoiceList(typeDate.value, date_debut.value, date_fin.value, type.value, statut.value, modePaiement.value, 'CODE_TYPE');
		 	}); 
		 	sort_amount.addEventListener("click", function(){
		 		$factures.display.displayInvoiceList(typeDate.value, date_debut.value, date_fin.value, type.value, statut.value, modePaiement.value, 'MONTANT_TTC');
		 	}); 
		 	sort_status.addEventListener("click", function(){
		 		$factures.display.displayInvoiceList(typeDate.value, date_debut.value, date_fin.value, type.value, statut.value, modePaiement.value, 'CODE_STATUT');
		 	}); 
		 	sort_payment.addEventListener("click", function(){
		 		$factures.display.displayInvoiceList(typeDate.value, date_debut.value, date_fin.value, type.value, statut.value, modePaiement.value, 'CODE_MODE_PAIEMENT');
		 	});

			$.each(liste[1], function (invoiceKey, invoiceRecord) {
				var tableEcheancier = document.getElementById("echeancier"), row = tableEcheancier.insertRow(-1), nomFournisseur = invoiceRecord.NOM_FOURNISSEUR, dateFacture = invoiceRecord.DATE_FACTURE, codeType = invoiceRecord.CODE_TYPE, descType = invoiceRecord.DESC_NATURE, dateEcheance = invoiceRecord.DATE_ECHEANCE, montant_TTC = invoiceRecord.MONTANT_TTC, codeStatut = invoiceRecord.CODE_STATUT, descStatut = invoiceRecord.DESC_STATUT, codeModePaiement = invoiceRecord.CODE_MODE_PAIEMENT, descModePaiement = invoiceRecord.DESC_PAIEMENT, commentaires = invoiceRecord.COMMENTAIRES, idFacture = invoiceRecord.ID_FACTURE, cell = row.insertCell(-1);

				chkBx = document.createElement("INPUT");
				$js.setAttributes(chkBx, {"type": "checkbox", "id": "sousTotalChkbx", "name": "sousTotalChkbx", "onclick": "addValue();", "value": montant_TTC});
				cell.appendChild(chkBx);
		  	var cell = row.insertCell(-1);
		  	$js.setAttributes(cell, {"class": "dateEcheance"});
		  	cell.appendChild(document.createTextNode(dateEcheance));
		  	var cell = row.insertCell(-1);
		  	$js.setAttributes(cell, {"class": "nomFournisseur","value": idFacture});
		  	var linkInvoice = document.createElement('a');
		  	$js.setAttributes(linkInvoice, {'href': '#'});
		  	linkInvoice.appendChild(document.createTextNode(nomFournisseur));
		  	$js.setAttributes(linkInvoice, {'onclick': "$factures.management.newInvoice(" + idFacture + ", 'UPDATE', '" + liste[0]['dateType'] + "', '" + liste[0]['date_debut'] + "', '" + liste[0]['date_fin'] + "', " + liste[0]['codeType'] + ", " + liste[0]['statut'] + ", " + liste[0]['modePaiement'] + ");"});
		  	cell.appendChild(linkInvoice);
		  	var inputIdFacture = document.createElement('INPUT');
		  	$js.setAttributes(inputIdFacture, {"type": "hidden", "class": "idFacture", "value": idFacture});
		  	cell.appendChild(inputIdFacture);
		  	var cell = row.insertCell(-1);
		  	cell.appendChild(document.createTextNode(dateFacture));
				var cell = row.insertCell(-1);
				cell.appendChild(document.createTextNode(descType));
		  	var cell = row.insertCell(-1);
		  	cell.style.textAlign = "right";
		  	cell.appendChild(document.createTextNode(montant_TTC + " €"));
		  	var cell = row.insertCell(-1);
		  	cell.appendChild(document.createTextNode(descStatut));
		  	var cell = row.insertCell(-1);
		  	cell.appendChild(document.createTextNode(descModePaiement));
		  	var cell = row.insertCell(-1);
		  	cell.appendChild(document.createTextNode(commentaires));
		  	var cell = row.insertCell(-1);
				validateButton(idFacture,liste[0]['dateType'], liste[0]['date_debut'], liste[0]['date_fin'], liste[0]['codeType'], liste[0]['statut'], liste[0]['modePaiement'], cell);
				var cell = row.insertCell(-1);
				deleteButton(idFacture,liste[0]['dateType'], liste[0]['date_debut'], liste[0]['date_fin'], liste[0]['codeType'], liste[0]['statut'], liste[0]['modePaiement'], cell);
		 	}, "json");	 	
		});
	}
	function validateButton(idFacture,dateType, date_debut, date_fin, codeType, statut, modePaiement, cell){
		var linkValidate = document.createElement("a");
		var imgValidate = document.createElement('IMG');
		$js.setAttributes(imgValidate, {"src": $factures.imgValidate});
		linkValidate.appendChild(imgValidate);
		$js.setAttributes(linkValidate, {'href': "#"});
		if(statut<3){
			$js.setAttributes(linkValidate, {'onclick': "$factures.management.invoiceNextStatut(" + idFacture + ",'" + dateType  + "','" + date_debut + "','" + date_fin + "', " + codeType + ", " + statut + ", " + modePaiement + ");"});
		}
		cell.appendChild(linkValidate);
	}
	function deleteButton(idFacture,dateType, date_debut, date_fin, codeType, statut, modePaiement, cell){
		var linkDelete = document.createElement("a");
		var imgDelete = document.createElement('IMG');
		$js.setAttributes(imgDelete, {"src": $factures.imgDelete});
		linkDelete.appendChild(imgDelete);
		$js.setAttributes(linkDelete, {'href': "#", 'onclick': "$factures.management.deleteInvoice(" + idFacture + ",'" + dateType  + "','" + date_debut + "','" + date_fin + "', " + codeType + ", " + statut + ", " + modePaiement + ");"});
		cell.appendChild(linkDelete);	
	}
	function displayFactures(liste){
		$.get($factures.echeancierOverviewSnippet, function (codeHtml){
			var year = liste[0]['YEAR'], nextYear = year + 1, previousYear = year - 1;
		 	var html = codeHtml;
		 	html = $js.insertProperty(html, 'YEAR', year);
		 	var divResults = document.createElement("div");
		 	$js.setAttributes(divResults, {"class": "container"});
		 	divResults.innerHTML = html;
		 	var divContainer = document.getElementById("main-content");
		 	divContainer.innerHTML = "";
		 	divContainer.appendChild(divResults); 
		 	var nextYearLink = document.getElementById("nextYear");
		 	$js.setAttributes(nextYearLink, {"onclick": "$factures.display.displayInvoice('dateEcheance', " + nextYear + ");"});
		 	var previousYearLink = document.getElementById("previousYear");
		 	$js.setAttributes(previousYearLink, {"onclick": "$factures.display.displayInvoice('dateEcheance', " + previousYear + ");"});
		  var table = document.getElementById("tableFactures");
		  var k=0;
		  
			for (var i = 0; i < liste[1].length/12; i++) {
			  var row = table.insertRow(-1);
			  var cellStatut = row.insertCell(-1);
			  cellStatut.innerHTML = liste[1][k].DESC_STATUT;
			  for (var j = 0; j < 12; j++) {
			  	var tableCell = row.insertCell(-1);
			  	var date_debut_month = liste[1][k].MONTH;
			  	var date_debut_year = liste[1][k].YEAR;
			  	var date_debut = '01-' + date_debut_month + '-' + date_debut_year;
			  	var nextMonth = parseFloat(date_debut_month);
			  	var nextYear = date_debut_year;
				  if(date_debut_month == 12) {
				    nextMonth = 0;
				    nextYear = parseFloat(year) + 1;
				  }
			   	var date_fin =new Date(nextYear, nextMonth, 0);
			   	if(date_debut_month == 12){
			   		date_fin = date_fin.getDate()+ '-' + date_debut_month + '-' + date_fin.getFullYear();
			   	}
			   	else {
			   		date_fin = date_fin.getDate()+ '-' + nextMonth + '-' + date_fin.getFullYear();
			   	}
			   	var code_statut = liste[1][k].CODE_STATUT;
			   	var link = document.createElement("a");
			   	$js.setAttributes(link, {"onclick": "$factures.display.displayInvoiceList('dateEcheance', '"+ date_debut+ "', '" + date_fin + "', 0, " + code_statut + ");"});
			   	link.innerHTML = liste[1][k].TOTAL_TTC + " €";
			   	tableCell.appendChild(link);
			   	k++;
			  }
			 }
		}, "html");
	}

	global.$factures = factures;
})(window);