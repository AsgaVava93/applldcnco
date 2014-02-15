<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>

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

	$dir = "./images/".md5(mysql_insert_id())."/";
	
	echo $_POST['data'];
	echo $_POST['misura'];
	echo $_POST['note'];
	echo $_FILES["foto"];

 	 $data = $_POST['data'];
     $misura = $_POST['misura'];
     $note = $_POST['note'];
	 resize_photo($dir, $_FILES["foto"], "foto.jpg", 400, 1000);
	 $foto = $_FILES["foto"];

     $result = $DB->doquery(sprintf($QUERY->INSERISCI_LETTURA, $data, $misura, $foto, $note));
	 
	 sleep(5);
	 require_once("index.html");
?>

</body>
</html>