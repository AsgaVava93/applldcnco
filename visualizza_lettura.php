<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<div style="border:none; margin:0;">
<table border="0" cellpadding="3">
	<tr>
    	<th scope="col">Data</th>
    	<th scope="col">Misura</th>
    	<th scope="col">Foto</th>
    	<th scope="col">Note</th>
  	</tr>

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

$result = $DB->doquery(sprintf($QUERY->VISUALIZZA_LETTURE));


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

</table>
</div>
</body>
</html>