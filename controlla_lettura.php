<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>Untitled Document</title>
<link href="jquery-mobile/jquery.mobile.theme-1.0.min.css" rel="stylesheet" type="text/css" />
<link href="jquery-mobile/jquery.mobile.structure-1.0.min.css" rel="stylesheet" type="text/css" />
<script src="jquery-mobile/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="jquery-mobile/jquery.mobile-1.0.min.js" type="text/javascript"></script>
</head>

<body>
<div data-role="page" id="menu">
	<div data-role="header">
		<h1>Lettura Contatori</h1>
	</div>
	<div data-role="content">		
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

require_once("functions.php");

 	 $data = $_POST['data'];
     $misura = $_POST['misura'];
     $note = $_POST['note'];
	 $foto = 0;
	 
	 $result = $DB->doquery(sprintf($QUERY->ULTIMA_LETTURA));


		while($row=$DB->fetchrow($result))
		{
			echo "  <tr>
			<td>".$row["data"]."</td>
			<td>".$row["misura"]."</td>
			<td>".$row["foto"]."</td>
			<td>".$row["note"]."</td>
			</tr>";
		}
		
		?>
        
<a href="#confirm" data-role="Continua">Button</a>

<div id="confirm">
<?php

        $result = $DB->doquery(sprintf($QUERY->INSERISCI_LETTURA, $data, $misura, $foto, $note));
		?>
</div>
	</div>
	<div data-role="footer">
    <h4>
    © Lettura Contatori <?php $today=getdate(); echo $today["year"]; ?>
    </h4>
	</div>
</div>
</body>
</html>