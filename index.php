<?php
global // Variabili globali
	$internal,	/// Protezione dal caricamento via URL per pagine progettate per essere incluse
	$DB,		/// Oggetto di connessione al database
	$CONFIG,	/// Array associativo contenente i parametri di configurazione
	$LANG,		/// Array associativo contenente stringhe e messaggi usati di frequente
	$QUERY,		/// Oggetto contenente tutte le query SQL
	$pagetitle, 	/// Conterrà il titolo della pagina da visualizzare nel campo html title e nell'header del content
	$act,		/// Conterrà il nome della sottopagina caricata
	$auth,		/// Conterrà i dati dell'utente autenticato
	$okmessage,	/// Conterrà messaggi di stato
	$errormessage;	/// Conterrà messaggi di errore

$internal = TRUE;


// Configurazione, funzioni e inizializzazione database
require_once("functions.php");

?>

<!DOCTYPE html> 
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>jQuery Mobile Web App</title>
<link href="jquery-mobile/jquery.mobile.theme-1.0.min.css" rel="stylesheet" type="text/css"/>
<link href="jquery-mobile/jquery.mobile.structure-1.0.min.css" rel="stylesheet" type="text/css"/>
<script src="jquery-mobile/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="jquery-mobile/jquery.mobile-1.0.min.js" type="text/javascript"></script>
</head> 
<body> 

<div data-role="page" id="menu">
	<div data-role="header">
		<h1>Lettura Contatori</h1>
	</div>
	<div data-role="content">	
		<ul data-role="listview">
			<li><a href="#precedenti">Letture Precedenti</a></li>
            <li><a href="#nuova">Nuova Lettura</a></li>
			<li><a href="#istruzioni">Guida</a></li>
		</ul>		
	</div>
	<div data-role="footer">
    <h4>
    © Lettura Contatori <?php $today=getdate(); echo $today["year"]; ?>
    </h4>
	</div>
</div>

<div data-role="page" id="precedenti">
	<div data-role="header">
		<h1>Letture Precedenti</h1>
	</div>
	<div data-role="content">	
		<?php
			require_once("visualizza_lettura.php");
		?>		
	</div>
	<div data-role="footer">
    <h4>
    © Lettura Contatori <?php $today=getdate(); echo $today["year"]; ?>
    </h4>
	</div>
</div>

<div data-role="page" id="nuova">
	<div data-role="header">
		<h1>Nuova Lettura</h1>
	</div>
	<div data-role="content">
    <form action="inserisci_lettura.php" method="POST"  />
	  <div data-role="fieldcontain">
    <label for="data">Data:</label>
    
	    <input type="text" name="data" id="data" value="<?php $today=getdate(); echo $today["mday"]."/".$today["month"]."/".$today["year"]; ?>"  />
	      
	    <label for="misura">Misura:</label>
	    <input type="number" name="misura" id="misura" value=""  />
        
	    <label for="note">Note:</label>
	    <textarea cols="40" rows="8" name="note" id="note"></textarea>
        
	  	<input type="file" name="foto" id="foto" size="45" />
      </div>
	  <input type="submit" value="Invia Lettura" />
    </form>
	</div>
	<div data-role="footer">
    <h4>
    © Lettura Contatori <?php $today=getdate(); echo $today["year"]; ?>
    </h4>
	</div>
</div>

<div data-role="page" id="istruzioni">
	<div data-role="header">
		<h1>Istruzioni</h1>
	</div>
	<div data-role="content">	
		Non c'è molto da dire, clicca straclicca e riclicca!		
	</div>
	<div data-role="footer">
    <h4>
    © Lettura Contatori <?php $today=getdate(); echo $today["year"]; ?>
    </h4>
	</div>
</div>

<script>
 
function scatta_foto()
{	
	navigator.camera.getPicture(onSuccess, onFail, { quality: 50 }); 
}

function onSuccess(imageData) {
}

function onFail(message) {
    alert('Failed because: ' + message);
}
</script>

</body>
</html>