<?php
// Variabili globali.  Vedere index.php per una descrizione
global $internal, $DB, $CONFIG, $LANG;

// Carica la lista dei messaggi
require_once('lang.php');

// Impedisce il caricamento se non attraverso la pagina index
if( !isset($internal) || !$internal )
	die($LANG['CANTOPEN']);

class DatabaseConnection {
	private $link; /// Handler di connessione al database, utilizzato nelle funzioni mysql_ di php
	
	function __construct( ) {
		// Inizializza l'handler di connessione a FALSE
		$this->link = FALSE;
		// Connetti al database
		$this->connect();
	}

	/**
	 * Connetti al server mySQL e seleziona il database
	 */
	public function connect( ) {
		global $LANG, $CONFIG;
		// Crea connessione
		$this->link = mysql_connect($CONFIG['db_serv'], $CONFIG['db_user'], $CONFIG['db_pass']);
		if( !$this->link ) {
			// Termina e visualizza un messaggio di errore in caso di insuccesso
			die($LANG['DB_ERROR'] . showdebug(" - ". mysql_error()));
		}
		// Assicura connessione UTF8 al database
		mysql_query("SET NAMES 'utf8'", $this->link);
		// Imposta fuso orario della connessione
		mysql_query("SET time_zone '{$CONFIG['timezone']}'", $this->link);
		// Seleziona database
		$this->usedb($CONFIG['db_database']);
	}
	
	/**
	 * Seleziona il database
	 * @param	$dbname	Nome del database
	 */
	public function usedb( $dbname ) {
		global $LANG;
		// Termina con un messaggio di errore nel caso la connessione non sia stata effettuata
		if( !$this->link )
			die($LANG['DB_ERROR'] . showdebug(" - ". mysql_error()));
		// Seleziona il database
		if( !mysql_select_db($dbname, $this->link) )
			// E termina con un messaggio di errore in caso di fallimento
			die($LANG['DB_ERROR'] . showdebug(" - ". mysql_error()));
	}
	
	/**
	 * Disconnetti dal server mySQL (A dire il vero, non ce n'è alcun bisogno.)
	 */
	public function disconnect( ) {
		// Se la connessione è attiva, disconnetti
		if( $this->link )
			mysql_close($this->link);
		// E azzera l'handler di connessione
		$this->link = FALSE;
	}

	/**
	 * Esegue una query SQL e restituisce i risultati, da processare tramite fetchrow()
	 * @param	$query	Query SQL
	 * @return	Risultati della query
	 */
	public function doquery( $query ) {
		global $LANG;
		// Termina con un messaggio di errore in caso la connessione non sia stata effettuata
		if( !$this->link )
			die($LANG['DB_ERROR'] . showdebug(" - ". mysql_error()));
		// Esegue la query SQL
		$res = mysql_query($query, $this->link);
		// Mostra un messaggio di errore in caso la query fallisca
		if( $res === FALSE )
			die($LANG['DB_ERROR'] . showdebug(" - ". mysql_error()));
		// Restituisce i risultati della query
		return $res;
	}

	/**
	 * Esegue una query e restituisce la prima riga dei risultati, già processata
	 * tramite fetchrow().  Ripulisce la memoria dei dati della query.
	 * @param	$query	Query SQL
	 * @return	Prima riga dei risultati, come array associativo, oppure TRUE o FALSE
	 */
	public function dosinglequery( $query ) {
		$res = $this->doquery($query);
		if( $res === TRUE || $res === FALSE )
			return $res;
		$row = $this->fetchrow($res);
		$this->freeres($res);
		return $row;
	}
	
	/**
	 * Recupera una riga dai risultati di una query
	 * @param	$res	Risultato di una query SQL, restituito da doquery()
	 * @return	La prima riga non ancora processata, come array associativo
	 */
	public function fetchrow( $res ) {
		return mysql_fetch_assoc($res);
	}
	
	/**
	 * Libera la memoria associata al risultato di una query
	 * @param	$res	Risultato di una query SQL, restituito da doquery()
	 */
	public function freeres( $res ) {
		if( $res && $res !== TRUE )
			mysql_free_result($res);
	}
}
?>
