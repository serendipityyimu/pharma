<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $title ?></title>

        <link rel="stylesheet" href="public/css/bootstrap.min.css" />
        <link rel="stylesheet" href="public/jquery/jquery-ui.min.css" />
        <link rel="stylesheet" href="public/css/style.css" rel="stylesheet" />
        <link rel="stylesheet" href="public/css/MonthPicker.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Lora|Oxygen" rel="stylesheet" />
    </head>

    <body>
      <nav id="header-nav" class="navbar navbar-expand-md">
  			<div class='container'>
  				<a href="factures.php?display=dateEcheance" class="navbar-brand">Home</a>
  				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsable-nav" aria-controls="collapsable-nav" aria-expanded="false" aria-label="Toggle navigation">
  					<span class="navbar-toggler-icon"></span>
  				</button>
  				<div id="collapsable-nav" class="collapse navbar-collapse">
  					<ul class="navbar-nav mr-auto">
  						<li class="nav-item dropdown">
  							<a class="nav-link dropdown-toggle" href="#" id="revenuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Revenus</a>
  								<div class="dropdown-menu" aria-labelledby="revenuDropdown">
  									<a class="dropdown-item" id="CaTvaDisplay" href="revenus.php">CA par taux de TVA</a>
  									<a class="dropdown-item" href="revenus.php?display=new">Saisie CA par taux de TVA</a>
  								</div>
  						</li>
  						<li class="nav-item"><a class="nav-link" href="factures.php?display=new">Nouvelle facture</a></li>
  						<li class="nav-item"><a class="nav-link" href="factures.php?display=dateEcheance">Echeancier</a></li>
  						<li class="nav-item dropdown">
  							<a class="nav-link dropdown-toggle" href="#" id="personnelDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Personnel</a>
  								<div class="dropdown-menu" aria-labelledby="personnelDropdown">
  									<a class="dropdown-item" href="salary.php?display=new">Saisie des salaires</a>
  									<a class="dropdown-item" href="salary.php">Récapitulatif masse salariale</a>
  									<a class="dropdown-item" href="salary.php?display=list">Gestion des salariés</a>
  								</div>
  						</li>
  						<li class="nav-item"><a class="nav-link" href="financement.php">Financement</a></li>
  						<li class="nav-item dropdown">
  							 <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
  							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
  								<a class="dropdown-item" href="#" onclick="js.loadDisplayMainContent('snippets/synthese-CA-snippet.php', 'js/javascript.js');">Synthèse</a>
  								<a class="dropdown-item" href="tresorerie.php">Trésorerie</a>
  								<a class="dropdown-item" href="compte_resultat.php">Comptes de résultats</a>
  								<a class="dropdown-item" href="plan_financement.php">Plan de financement</a>
  								<a class="dropdown-item" href="bilan.php">Bilan</a>
  							</div>
  						</li>
  					</ul>
  				</div> <!-- collapsable-nav -->
  			</div> <!-- container -->
  		</nav>
  		<div class="container" id="main-content"><?= $content ?> </div>

    </body>
</html>
