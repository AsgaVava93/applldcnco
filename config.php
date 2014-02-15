<?php
// Variabili globali
global $internal, $CONFIG, $LANG;

// Carica la lista dei messaggi
require_once('lang.php');

// Impedisce il caricamento se non attraverso la pagina index
if( !isset($internal) || !$internal )
	die($LANG['CANTOPEN']);

$CONFIG['title']		= 'Lettura Contatori';		/// Titolo / nome del sito
$CONFIG['db_serv']		= '62.149.150.106';		/// Server SQL
$CONFIG['db_user']		= 'Sql399212';		/// Nome utente SQL
$CONFIG['db_pass']		= '12e86e08';		/// Password SQL
$CONFIG['db_database']		= 'Sql399212_2';		/// Nome database SQL
$CONFIG['timezone']		= "UTC";		/// Fuso orario
$CONFIG['base_url']		= NULL;			/// Indirizzo base (es: http://example.com/).  NULL=autorileva
$CONFIG['debug']		= TRUE;		/// Modalità di debug (mostra più messaggi di errore)

// ======== DO NOT MESS WITH THE STUFF BELOW IF YOU CARE FOR YOUR LIFE ================================================
// Caricamento delle configurazioni specifiche
include_once("config.local.php");

// Autorilevamento indirizzo base
if( $CONFIG['base_url'] === NULL ) {
	$CONFIG['base_url'] = 'http://' . $_SERVER['HTTP_HOST'] .
			substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/")+1);
}	
if( $CONFIG['cgi_path'] === NULL ) {
	$CONFIG['cgi_path'] = '/cgi-bin/';
}	
?>
