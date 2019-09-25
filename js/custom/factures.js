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
				var results = new Array(), chkbx = $('[name="sousTotalChkbx"]'), dateType = $("#type_date").val(), date_debut = $("#date_debut").val(), date_fin = $("#date_fin").val(), codeType = $("#type").val(), statut = $("#etat").val(), modePaiement = $("#mode_paiement").val();
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
//Revision JQuery
	function displayNewInvoice(data) {
		$.get($factures.newInvoiceSnippet, function (codeHtml){
			$("#main-content").html(codeHtml);
			$('#laboratoire').val(data['LABORATOIRE']);
			$('#id_lab').val(data['ID_FOURNISSEUR']);
			$('#id_facture').val(data['ID_FACTURE']);
			$('#query_type').val(data['QUERY_TYPE']);
			$('#filter_date_debut').val(data['FILTER_DATE_DEBUT']).html(data['FILTER_DATE_DEBUT']);
			$('#filter_date_fin').val(data['FILTER_DATE_FIN']).html(data['FILTER_DATE_FIN']);
			$('#filter_code_type').val(data['FILTER_CODE_TYPE']).html(data['FILTER_CODE_TYPE']);
			$('#filter_mode_paiement').val(data['FILTER_MODE_PAIEMENT']).html(data['FILTER_MODE_PAIEMENT']);
			$('#filter_code_statut').val(data['FILTER_CODE_STATUT']).html(data['FILTER_CODE_STATUT']);
			$('#montant_TTC').val(data['MONTANT_TTC']);
			$('#date_facture').val(data['DATE_FACTURE']).html(data['DATE_FACTURE']);
			$('#date_echeance').val(data['DATE_ECHEANCE']).html(data['DATE_ECHEANCE']);
			$('#comments').val(data['COMMENTAIRES']).html(data['COMMENTAIRES']);
			optionSelect(data['CODE_STATUT'], $("#etat"));
	 		optionSelect(data['CODE_MODE_PAIEMENT'], $("#mode_paiement"));
	 		optionSelect(data['CODE_TYPE'], $("#type"));
			// $("#etat").children('option').val(data['CODE_STATUT']).prop('selected',true);
			// $("#etat option[value=" + data['CODE_STATUT'] + "]").prop('selected', true);
	  }, "html");
	}



	function displayListeFactures(liste) {
		$.get($factures.echeancierSnippet, function (codeHtml){
			var divContainer = $("#main-content").html(codeHtml);
			var typeDate = $("#type_date"),
			 	sort = liste[0]['sort'];

				var parts = liste[0]['date_debut'].split('-');
				var date_debut = new Date(parts[0], parts[1]-1, parts[2]);
				parts = liste[0]['date_fin'].split('-');
				var date_fin = new Date(parts[0], parts[1]-1, parts[2]);
				$("#date_debut").val(formatDate(date_debut));
				$("#date_fin").val(formatDate(date_fin));

				// date_debut.setDate(new Date(liste[0]['date_fin']));
// console.log($("#date_debut").val());
// console.log($("#date_fin").val());
		 	optionSelect(liste[0]['dateType'], $("#type_date"));
			optionSelect(liste[0]['statut'], $("#etat"));
			optionSelect(liste[0]['modePaiement'], $("#mode_paiement"));
			optionSelect(liste[0]['codeType'], $("#type"));

			$("#type_date").on("change", function(){
				$factures.display.displayInvoiceList($("#type_date").val(), $("#date_debut").val(), $("#date_fin").val(), $("#type").val(), $("#etat").val(), $("#mode_paiement").val());
			});
			$("#etat").on("change", function(){
				$factures.display.displayInvoiceList($("#type_date").val(), $("#date_debut").val(), $("#date_fin").val(), $("#type").val(), $("#etat").val(), $("#mode_paiement").val());
			});
			$("#type").on("change", function(){
				$factures.display.displayInvoiceList($("#type_date").val(), $("#date_debut").val(), $("#date_fin").val(), $("#type").val(), $("#etat").val(), $("#mode_paiement").val());
			});
			$("#mode_paiement").on("change", function(){
				$factures.display.displayInvoiceList($("#type_date").val(), $("#date_debut").val(), $("#date_fin").val(), $("#type").val(), $("#etat").val(), $("#mode_paiement").val());
			});
		 	$("#sort_lab").on("click", function(){
		 		$factures.display.displayInvoiceList($("#type_date").val(), $("#date_debut").val(), $("#date_fin").val(), $("#type").val(), $("#etat").val(), $("#mode_paiement").val(), 'NOM_FOURNISSEUR');
		 	});
		 	$("#sort_invoice_date").on("click", function(){
		 		$factures.display.displayInvoiceList($("#type_date").val(), $("#date_debut").val(), $("#date_fin").val(), $("#type").val(), $("#etat").val(), $("#mode_paiement").val(), 'DATE_FACTURE');
		 	});
		 	$("#sort_payment_date").on("click", function(){
		 		$factures.display.displayInvoiceList($("#type_date").val(), $("#date_debut").val(), $("#date_fin").val(), $("#type").val(), $("#etat").val(), $("#mode_paiement").val(), 'DATE_ECHEANCE');
		 	});
		 	$("#sort_type").on("click", function(){
		 		$factures.display.displayInvoiceList($("#type_date").val(), $("#date_debut").val(), $("#date_fin").val(), $("#type").val(), $("#etat").val(), $("#mode_paiement").val(), 'CODE_TYPE');
		 	});
		 	$("#sort_amount").on("click", function(){
		 		$factures.display.displayInvoiceList($("#type_date").val(), $("#date_debut").val(), $("#date_fin").val(), $("#type").val(), $("#etat").val(), $("#mode_paiement").val(), 'MONTANT_TTC');
		 	});
		 	$("#sort_status").on("click", function(){
		 		$factures.display.displayInvoiceList($("#type_date").val(), $("#date_debut").val(), $("#date_fin").val(), $("#type").val(), $("#etat").val(), $("#mode_paiement").val(), 'CODE_STATUT');
		 	});
		 	$("#sort_payment").on("click", function(){
		 		$factures.display.displayInvoiceList($("#type_date").val(), $("#date_debut").val(), $("#date_fin").val(), $("#type").val(), $("#etat").val(), $("#mode_paiement").val(), 'CODE_MODE_PAIEMENT');
		 	});

			$.each(liste[1], function (invoiceKey, invoiceRecord) {
				var tableEcheancier = $("#echeancier"),
				nomFournisseur = invoiceRecord.NOM_FOURNISSEUR,
				dateFacture = invoiceRecord.DATE_FACTURE,
				codeType = invoiceRecord.CODE_TYPE,
				descType = invoiceRecord.DESC_NATURE,
				dateEcheance = invoiceRecord.DATE_ECHEANCE,
				montant_TTC = invoiceRecord.MONTANT_TTC,
				codeStatut = invoiceRecord.CODE_STATUT,
				descStatut = invoiceRecord.DESC_STATUT,
				codeModePaiement = invoiceRecord.CODE_MODE_PAIEMENT,
				descModePaiement = invoiceRecord.DESC_PAIEMENT,
				commentaires = invoiceRecord.COMMENTAIRES,
				idFacture = invoiceRecord.ID_FACTURE;

				chkBx = $('<input>').attr({
					"type": "checkbox",
					"id": "sousTotalChkbx",
					"name": "sousTotalChkbx",
					"onclick": "addValue();",
					"value": montant_TTC
				});
				linkInvoice = $('<a>').attr({'href': '#',
					'onclick': "$factures.management.newInvoice(" + idFacture + ", 'UPDATE', '" + liste[0]['dateType'] + "', '" + liste[0]['date_debut'] + "', '" + liste[0]['date_fin'] + "', " + liste[0]['codeType'] + ", " + liste[0]['statut'] + ", " + liste[0]['modePaiement'] + ");"});
				inputIdFacture = $('<input>').attr({"type": "hidden", "class": "idFacture", "value": idFacture});
				linkInvoice.text(nomFournisseur);
				linkValidate = $('<a>').attr({'href': "#"}).append($('<img>').attr({"src": $factures.imgValidate}));
				if(liste[0]['statut']<3) linkValidate.attr({'onclick': "$factures.management.invoiceNextStatut(" + idFacture + ",'" + liste[0]['dateType']  + "','" + liste[0]['date_debut'] + "','" + liste[0]['date_fin'] + "', " + liste[0]['codeType'] + ", " + liste[0]['statut'] + ", " + liste[0]['modePaiement'] + ");"});
				linkDelete = $('<a>').attr({'href': "#", 'onclick': "$factures.management.deleteInvoice(" + idFacture + ",'" + liste[0]['dateType']  + "','" + liste[0]['date_debut'] + "','" + liste[0]['date_fin'] + "', " + liste[0]['codeType'] + ", " + liste[0]['statut'] + ", " + liste[0]['modePaiement'] + ");"}).append($('<img>').attr({"src": $factures.imgDelete}));

				tableEcheancier.find('tbody').append($('<tr><td align="center">'));
				tableEcheancier.find('tbody tr td').last().append( chkBx ).append(inputIdFacture);
				tableEcheancier.find('tbody tr').last().append('<td class="dateEcheance">' + dateEcheance + '</td>');
				tableEcheancier.find('tbody tr').last().append('<td class="nomFournisseur" value="' + idFacture + '">');
				tableEcheancier.find('tbody tr td').last().append( linkInvoice );
			  tableEcheancier.find('tbody tr').last().append('<td>' + dateFacture + '</td>');
			  tableEcheancier.find('tbody tr').last().append('<td>' + descType + '</td>');
			  tableEcheancier.find('tbody tr').last().append('<td align="right">' + montant_TTC + ' €</td>');
				tableEcheancier.find('tbody tr').last().append('<td>' + descStatut + '</td>');
				tableEcheancier.find('tbody tr').last().append('<td>' + descModePaiement + '</td>');
				tableEcheancier.find('tbody tr').last().append('<td>' + commentaires + '</td>');
				tableEcheancier.find('tbody tr').last().append($('<td>').append(linkValidate));
				tableEcheancier.find('tbody tr').last().append($('<td>').append(linkDelete));
		 	}, "json");
		});
	}

	function displayFactures(liste){
		$.get($factures.echeancierOverviewSnippet, function (codeHtml){
			var year = liste[0]['YEAR'], nextYear = year + 1, previousYear = year - 1;
var divResults = $('<div>').attr({"class": "container"}).html(codeHtml);

		 	// codeHtml = $js.insertProperty(codeHtml, 'YEAR', year);

		 	var divContainer = $("#main-content").html('').append(divResults);
			$('#year').html(year);
		 	var nextYearLink = $("#nextYear").attr({"onclick": "$factures.display.displayInvoice('dateEcheance', " + nextYear + ");"});
		 	var previousYearLink = $("#previousYear").attr({"onclick": "$factures.display.displayInvoice('dateEcheance', " + previousYear + ");"});
		  	var table = $("#tableFactures");
		  	var k = 0;

			for (var i = 0; i < liste[1].length/12; i++) {
				table.find('tbody').append('<tr><td>'+liste[1][k].DESC_STATUT);

				for (var j = 0; j < 12; j++) {
					var date_debut_month = liste[1][k].MONTH,
					date_debut_year = liste[1][k].YEAR,
					date_debut = date_debut_year + '-' + date_debut_month + '-' + '01',
					nextMonth = parseFloat(date_debut_month),
					nextYear = date_debut_year;

					if(date_debut_month == 12) {
						nextMonth = 0;
						nextYear = parseFloat(year) + 1;
					}
					var date_fin =new Date(nextYear, nextMonth, 0);
					if(date_debut_month == 12){
						date_fin = date_fin.getFullYear()+ '-' + date_debut_month + '-' + date_fin.getDate();
					}
					else {
						date_fin = date_fin.getFullYear()+ '-' + nextMonth + '-' + date_fin.getDate();
					}
					var code_statut = liste[1][k].CODE_STATUT;

					var link = $('<a>').attr({"onclick": "$factures.display.displayInvoiceList('dateEcheance', '"+ date_debut+ "', '" + date_fin + "', 0, " + code_statut + ");"});
				   	link.html(liste[1][k].TOTAL_TTC + " €");
			//
			 	   	table.find('tbody tr').last().append($('<td>').append(link));
			   		k++;
				}
			 }
		}, "html");
	}

	global.$factures = factures;
})(window);
