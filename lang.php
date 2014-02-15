<?php

// Variabili globali
global $LANG;


$LANG = Array(  // Lista delle stringhe.  Accessibili tramite $LANG['NOME_STRINGA']
	// General purpose strings
	'CANTOPEN'	=>	"Non sei autorizzato ad aprire questo file.",
	'DB_ERROR'	=>	"Errore di connessione al database ... ",
	'OOPS'		=>	"Oops ... ",
	'OK'		=>	"Ok",
	'LOGIN_ERROR'	=>	"Errore di login",
	'ERROR'		=>	"È avvenuto un errore, riprova",
	'USER_ID'	=>	"Nome utente",
	'PASSWORD'	=>	"Password",
	'SUBMIT'	=>	"Invia",
	'LOGGED_OUT'	=>	"Utente disconnesso.",
	'LOGIN_FAILED'	=>	"Il nome utente e/o la password inseriti non sono validi.",
	'LOGIN_DONE'	=>	"Login effettuato.  Benvenuto.",
	'DATEFORMAT'	=>	"%%d/%%m/%%Y", // Formattazione della data per mysql e php:
			// <http://dev.mysql.com/doc/refman/5.1/en/date-and-time-functions.html#function_date-format>
	'DATEFORMAT2'	=>	"%%d %%M",
	'EVENT_DATEFORMAT' =>	'%%Y-%%m-%%d',
	'CONFIRM'	=>	"Sei sicuro di voler eseguire l'operazione richiesta?",
	'EDIT'		=>	"Modifica",
	'DELETE'	=>	"Cancella",
	'ADD'		=>	"Aggiungi",
	'BACK'		=>	"Indietro",
	'YES'		=>	"Sì",
	'NO'		=>	"No",
	'DOWNLOAD'	=>	"Download",
);
?>
