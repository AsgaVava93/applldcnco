<?php
/**********************************************************************************************************************
 * File di definizione delle query.                                                                                   *
 * Contiene tutte le query utilizzate nel sito, per evitare di averle sparse qua e là                                 *
 **********************************************************************************************************************/

// Variabili globali.  Vedere index.php per una descrizione
global $internal, $DB, $CONFIG, $LANG, $QUERY;

// Carica la lista dei messaggi
require_once('lang.php');

// Impedisce il caricamento se non attraverso la pagina index
if( !isset($internal) || !$internal )
	die($LANG['CANTOPEN']);

class MyQueries {
	// Nomi delle tabelle
	private $_CONFIG_TABLE;
	private $_USERS_TABLE;
		
	//querys
	public $CHECK_USER; //controlla l'autorizzazione di un qualsiasi utente


	// Costruttore.  Definisce tutte le stringhe
	function __construct() {
		global $CONFIG, $LANG;

		// Nomi delle tabelle
		$this->_AUDIOS_TABLE		=	'audio';
		
		$this->_CONFIG_TABLE		=	'config';
		
		$this->_ESPACE_EVENTS_TABLE	=	'espace_events';
		$this->_ESPACE_PHOTOGALLERIES_TABLE =	'espace_photogallery';
		$this->_ESPACE_PHOTOS_TABLE	=	'espace_photo';
		
		$this->_LABS_TABLE		=	'labs';
		$this->_LABS_PRINTS_TABLE	=	'labs_prints';
		$this->_LABS_PHOTOS_TABLE 	=	'labs_photos';
		
		$this->_LINKS_TABLE 		=	 'links';
		
		$this->_SEP_CATEGORIES_TABLE	=	'sep_eventcategories';
		$this->_SEP_EVENTS_TABLE	=	'sep_events';
		$this->_SEP_PHOTOGALLERIES_TABLE = 	'sep_photogallery';
		$this->_SEP_PHOTOS_TABLE	=	'sep_photo';
		
		$this->_PRINTS_TABLE		=	'print';
		
		$this->_USERS_TABLE		= 	'user';
		
		$this->_VIDEOS_TABLE = 'videos';
		
		$this->_CONTATORE = 'Contatore';
		
		

		// Operazioni di INSERT
		$this->INSERT_AUDIO = "INSERT INTO `{$this->_AUDIOS_TABLE}` (`title`, `author`, `info`, `tracklist`, `date`, `mp3_title`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')";

		
		$this->INSERT_ESPACE_EVENT =	"INSERT INTO `{$this->_ESPACE_EVENTS_TABLE}` (`date_start`,`date_end`,`vernissage`,`desc`,`location`, `artist`,`title`)".
						" VALUES ('%s','%s','%s','%s','%s','%s','%s')";

		$this->INSERT_ESPACE_PHOTOGALLERY = "INSERT INTO `{$this->_ESPACE_PHOTOGALLERIES_TABLE}`".
						" (`event`)".
						" VALUES ('%d')";
						
		$this->INSERT_ESPACE_PHOTO = 	"INSERT INTO `{$this->_ESPACE_PHOTOS_TABLE}`".
						" (`gallery`, `desc`, `order`)".
						" VALUES ('%d', '%s', '%d')";

		$this->INSERT_ESPACE_PRINT =	"INSERT INTO `{$this->_PRINTS_TABLE}`".
						" (`category`, `author`, `newspaper`, `date`, `subtitles`, `content`)".
						" VALUES ('espace','%s','%s','%s','%s','%s')";

		$this->INSERT_LAB = 		"INSERT INTO `{$this->_LABS_TABLE}` (`name`, `descr`, `date_start`, `date_end`) VALUES ('%s', '%s', '%s', '%s')";

		$this->INSERT_LAB_PHOTO = 	"INSERT INTO `{$this->_LABS_PHOTOS_TABLE}` (`lab`, `descr`) VALUES ('%d', '%s')";
		
		$this->INSERT_LAB_PRINT = 	"INSERT INTO `{$this->_LABS_PRINTS_TABLE}` (`author`, `newspaper`, `date`, `subtitles`, `content`, `lab`) VALUES ('%s', '%s', '%s', '%s', '%s', '%d')";

		$this->INSERT_LINK = 		"INSERT INTO `{$this->_LINKS_TABLE}` (`name`, `link`, `info`) VALUES ('%s', '%s', '%s')";
		
		$this->INSERT_SEP_EVENT	=	"INSERT INTO `{$this->_SEP_EVENTS_TABLE}` ".
						" (`category`, `title`, `short_desc`, `long_desc`, `location`, `date_start`, `date_end`)".
						" VALUES ('%d','%s','%s','%s','%s','%s','%s')";
						
		$this->INSERT_SEP_PHOTOGALLERY = "INSERT INTO `{$this->_SEP_PHOTOGALLERIES_TABLE}`".
						" (`event`, `title`, `date`, `info`, `location`)".
						" VALUES ('%d', '%s', '%s', '%s', '%s')";

		$this->INSERT_SEP_PHOTO = 	"INSERT INTO `{$this->_SEP_PHOTOS_TABLE}`".
						" (`gallery`, `desc`, `order`)".
						" VALUES ('%d', '%s', '%d')";
		
		$this->INSERT_SEP_PRINT	=	"INSERT INTO `{$this->_PRINTS_TABLE}`".
						" (`category`, `author`, `newspaper`, `date`, `subtitles`, `content`)".
						" VALUES ('sep','%s','%s','%s','%s','%s')";
						

		$this->INSERT_VIDEO = 		"INSERT INTO `{$this->_VIDEOS_TABLE}` (`youtube`, `title`, `descr`, `event`, `date`) VALUES ('%s', '%s', '%s', '%d', '%s')";
		
		$this->INSERISCI_LETTURA = 		"INSERT INTO `{$this->_CONTATORE}` (`data`, `misura`, `foto`, `note`) VALUES ('%s', '%s', '%d', '%s')";
		
		$this->VISUALIZZA_LETTURE = 	"SELECT * FROM `{$this->_CONTATORE}` ORDER BY `ID`";
		
		$this->ULTIMA_LETTURA = 	"SELECT * FROM `{$this->_CONTATORE}` WHERE ID = MAX(ID)";

			
		// Operazioni di UPDATE
		$this->UPDATE_AUDIO = "UPDATE `{$this->_AUDIOS_TABLE}` SET `title`='%s', `author`='%s', `info`='%s', `tracklist`='%s', `date`='%s', `mp3_title`='%s' WHERE `id`='%d'";
		
		$this->UPDATE_CONFIG	=	"UPDATE `{$this->_CONFIG_TABLE}` SET `text`='%s' WHERE `id`='%d'";
		
		$this->UPDATE_ESPACE_EVENT =	"UPDATE `{$this->_ESPACE_EVENTS_TABLE}` SET `date_start`='%s', `date_end`='%s', `vernissage`='%s', `desc`='%s', `location`='%s', ".
						" `artist`='%s', `title`='%s' WHERE `id`='%d'";
						
		$this->UPDATE_ESPACE_NOWEVENT =	"UPDATE `{$this->_ESPACE_EVENTS_TABLE}` SET `is_now`='1' WHERE `id`='%d'";
		$this->UPDATE_ESPACE_NOWEVENTS =	"UPDATE `{$this->_ESPACE_EVENTS_TABLE}` SET `is_now`='0'";
		
		$this->UPDATE_ESPACE_PHOTOGALLERY = "UPDATE `{$this->_ESPACE_PHOTOGALLERIES_TABLE}` SET `event`='%d' WHERE `id`='%d'";
		
		$this->UPDATE_ESPACE_PHOTO =	"UPDATE `{$this->_ESPACE_PHOTOS_TABLE}` SET `gallery`='%d', `desc`='%s', `order`='%d' WHERE `id`='%d'";
		
		$this->UPDATE_ESPACE_PRINT =	"UPDATE `{$this->_PRINTS_TABLE}`".
						" SET `author`='%s', `newspaper`='%s', `date`='%s', `subtitles`='%s', `content`='%s'".
						" WHERE `id`='%d' AND `category`='espace'";
						
		$this->UPDATE_LAB =		"UPDATE `{$this->_LABS_TABLE}` SET `name`='%s', `descr`='%s', `date_start`='%s', `date_end`='%s' WHERE `id`='%d'";
				
		$this->UPDATE_LAB_PHOTO = 	"UPDATE `{$this->_LABS_PHOTOS_TABLE}` SET `lab`='%d', `descr`='%s' WHERE `id`='%d'";

		$this->UPDATE_LAB_PRINT = 	"UPDATE `{$this->_LABS_PRINTS_TABLE}` SET `author`='%s', `newspaper`='%s', `date`='%s', `subtitles`='%s', `content`='%s', `lab`='%d' WHERE `id`='%d'";
		
		$this->UPDATE_LINK = 		"UPDATE `{$this->_LINKS_TABLE}` SET `name`='%s', `link`='%s', `info`='%s' WHERE `id`='%d'";
				
		$this->UPDATE_SEP_EVENT	=	"UPDATE `{$this->_SEP_EVENTS_TABLE}` SET `category`='%d', `title`='%s', `short_desc`='%s', `long_desc`='%s', `location`='%s', ".
						" `date_start`='%s', `date_end`='%s' WHERE `id`='%d'";

		$this->UPDATE_SEP_PHOTOGALLERY = "UPDATE `{$this->_SEP_PHOTOGALLERIES_TABLE}` SET `event`='%d', `title`='%s', `date`='%s', `info`='%s', `location`='%s' WHERE `id`='%d'";

		$this->UPDATE_SEP_PHOTO =	"UPDATE `{$this->_SEP_PHOTOS_TABLE}` SET `gallery`='%d', `desc`='%s', `order`='%d' WHERE `id`='%d'";

		$this->UPDATE_SEP_NOWEVENT =	"UPDATE `{$this->_SEP_EVENTS_TABLE}` SET `is_now`='1' WHERE `id`='%d'";
		$this->UPDATE_SEP_NOWEVENTS =	"UPDATE `{$this->_SEP_EVENTS_TABLE}` SET `is_now`='0'";
		
												
		$this->UPDATE_SEP_PRINT =	"UPDATE `{$this->_PRINTS_TABLE}`".
						" SET `author`='%s', `newspaper`='%s', `date`='%s', `subtitles`='%s', `content`='%s'".
						" WHERE `id`='%d' AND `category`='sep'";
		
		$this->UPDATE_VIDEO = 		"UPDATE `{$this->_VIDEOS_TABLE}` SET `youtube`='%s', `title`='%s', `descr`='%s', `event`='%d', `date`='%s' WHERE `id`='%d'";

		
		// Operazioni di DELETE
		$this->DELETE_AUDIO = "DELETE FROM `{$this->_AUDIOS_TABLE}` WHERE `id`='%d'";
		
		$this->DELETE_ESPACE_EVENT =	"DELETE FROM `{$this->_ESPACE_EVENTS_TABLE}` WHERE `id`='%d'";
		$this->DELETE_ESPACE_PHOTOGALLERY = "DELETE FROM `{$this->_ESPACE_PHOTOGALLERIES_TABLE}` WHERE `id`='%d'";
		$this->DELETE_ESPACE_PHOTO =	"DELETE FROM `{$this->_ESPACE_PHOTOS_TABLE}` WHERE `id`='%d'";
		$this->DELETE_ESPACE_PHOTOS =	"DELETE FROM `{$this->_ESPACE_PHOTOS_TABLE}` WHERE `gallery`='%d'";
		$this->DELETE_ESPACE_PRINT =	"DELETE FROM `{$this->_PRINTS_TABLE}` WHERE `category`='espace' AND `id`='%d'";
		
		$this->DELETE_LAB = 		"DELETE FROM `{$this->_LABS_TABLE}` WHERE `id`='%d'";
		$this->DELETE_LAB_PHOTO = 	"DELETE FROM `{$this->_LABS_PHOTOS_TABLE}` WHERE `id`='%d'";
		$this->DELETE_LAB_PRINT =	"DELETE FROM `{$this->_LABS_PRINTS_TABLE}` WHERE `id`='%d'";

		$this->DELETE_LINK = 		"DELETE FROM `{$this->_LINKS_TABLE}` WHERE `id`='%d'";
				
		$this->DELETE_SEP_EVENT =	"DELETE FROM `{$this->_SEP_EVENTS_TABLE}` WHERE `id`='%d'";
		$this->DELETE_SEP_PHOTOGALLERY = "DELETE FROM `{$this->_SEP_PHOTOGALLERIES_TABLE}` WHERE `id`='%d'";
		$this->DELETE_SEP_PHOTO =	"DELETE FROM `{$this->_SEP_PHOTOS_TABLE}` WHERE `id`='%d'";
		$this->DELETE_SEP_PHOTOS =	"DELETE FROM `{$this->_SEP_PHOTOS_TABLE}` WHERE `gallery`='%d'";
		$this->DELETE_SEP_PRINT	=	"DELETE FROM `{$this->_PRINTS_TABLE}` WHERE `category`='sep' AND `id`='%d'";

		$this->DELETE_VIDEO = "DELETE FROM `{$this->_VIDEOS_TABLE}` WHERE `id`='%d'";


		// Operazioni di SELECT
		$this->SELECT_AUDIOS = 		"SELECT * FROM `{$this->_AUDIOS_TABLE}` ORDER BY `date` DESC";
		
		$this->SELECT_AUDIO =		"SELECT * FROM `{$this->_AUDIOS_TABLE}` WHERE `id`='%d'";

		
		$this->SELECT_CONFIG	=	"SELECT * FROM `{$this->_CONFIG_TABLE}` WHERE `id`='%d'";
						
		$this->SELECT_ESPACE_EVENT =	"SELECT *, UNIX_TIMESTAMP(`date_start`) AS dates2, UNIX_TIMESTAMP(`date_end`) AS datee2 ".
						" FROM `{$this->_ESPACE_EVENTS_TABLE}` WHERE `id`='%d'";
						
		$this->SELECT_ESPACE_EVENTS_BY_YEAR = "SELECT e.*, UNIX_TIMESTAMP(`date_start`) AS dates2, UNIX_TIMESTAMP(`date_end`) AS datee2 ".
						" FROM `{$this->_ESPACE_EVENTS_TABLE}` AS e".
						" WHERE ((`date_start` BETWEEN '%s-01-01' AND '%s-12-31') ".
						" OR (`date_end` BETWEEN '%s-01-01' AND '%s-12-31')) ORDER BY `date_start` DESC";
						
		$this->SELECT_ESPACE_EVENTS_BY_YEAR_NO_G = "SELECT e.*, UNIX_TIMESTAMP(`date_start`) AS dates2, UNIX_TIMESTAMP(`date_end`) AS datee2 ".
						" FROM `{$this->_ESPACE_EVENTS_TABLE}` AS e".
						" WHERE ((`date_start` BETWEEN '%s-01-01' AND '%s-12-31') ".
						" OR (`date_end` BETWEEN '%s-01-01' AND '%s-12-31')) ".
						" AND e.`id` NOT IN (SELECT `event` FROM `{$this->_ESPACE_PHOTOGALLERIES_TABLE}`)".
						" ORDER BY `date_start` DESC";
		
		$this->SELECT_ESPACE_NOWEVENT =	"SELECT *, UNIX_TIMESTAMP(`date_start`) AS dates2, UNIX_TIMESTAMP(`date_end`) AS datee2  FROM `{$this->_ESPACE_EVENTS_TABLE}` WHERE `is_now`='1'";
						
		$this->SELECT_ESPACE_PHOTOGALLERIES = "SELECT g.`id` AS gid, e.* FROM `{$this->_ESPACE_PHOTOGALLERIES_TABLE}` AS g, `{$this->_ESPACE_EVENTS_TABLE}` AS e ".
						" WHERE g.`event`=e.`id` AND e.`date_start` BETWEEN '%d-01-01' AND '%d-12-31'";
						
		$this->SELECT_ESPACE_PHOTOGALLERY_EV = "SELECT g.`id` AS gid, e.* FROM `{$this->_ESPACE_PHOTOGALLERIES_TABLE}` AS g, `{$this->_ESPACE_EVENTS_TABLE}` AS e ".
						" WHERE g.`event`=e.`id` AND g.`event`='%d'";
						
		$this->SELECT_ESPACE_PHOTOGALLERY_ID = "SELECT g.`id` AS gid, e.* FROM `{$this->_ESPACE_PHOTOGALLERIES_TABLE}` AS g, `{$this->_ESPACE_EVENTS_TABLE}` AS e ".
						" WHERE g.`event`=e.`id` AND g.`id`='%d'";
						
		$this->SELECT_ESPACE_PHOTOS = 	"SELECT * FROM `{$this->_ESPACE_PHOTOS_TABLE}` WHERE `gallery`='%d' ORDER BY `order` ASC";
							
		$this->SELECT_ESPACE_PRINT =	"SELECT *, DATE_FORMAT(`date`, '{$LANG['DATEFORMAT2']}') AS date2 FROM `{$this->_PRINTS_TABLE}` WHERE `id`='%d' AND `category`='espace'";
		
		$this->SELECT_ESPACE_PRINTS_BY_YEAR = "SELECT *, UNIX_TIMESTAMP(`date`) AS date2".
						" FROM `{$this->_PRINTS_TABLE}` WHERE `category`='espace' AND `date` BETWEEN '%s-01-01' AND '%s-12-31' ORDER BY `date` DESC LIMIT %d, %d";
	
	
		$this->SELECT_LABS =		"SELECT *, UNIX_TIMESTAMP(`date_start`) AS dates2, UNIX_TIMESTAMP(`date_end`) AS datee2 FROM `{$this->_LABS_TABLE}` ORDER BY `order` ASC";

		$this->SELECT_LAB = 		"SELECT *, UNIX_TIMESTAMP(`date_start`) AS dates2, UNIX_TIMESTAMP(`date_end`) AS datee2 FROM `{$this->_LABS_TABLE}` WHERE `id`='%d'";

		$this->SELECT_LAB_PHOTOS = 	"SELECT * FROM `{$this->_LABS_PHOTOS_TABLE}` WHERE `lab`='%d'";
		
		$this->SELECT_LAB_PHOTO = 	"SELECT * FROM `{$this->_LABS_PHOTOS_TABLE}` WHERE `id`='%d'";
		
		$this->SELECT_LAB_PRINTS_OF = 	"SELECT * FROM `{$this->_LABS_PRINTS_TABLE}` WHERE `lab`='%d'";
		
		$this->SELECT_LAB_PRINT	=	"SELECT * FROM `{$this->_LABS_PRINTS_TABLE}` WHERE `id`='%d'";
		
		$this->SELECT_LINKS = 		"SELECT * FROM `{$this->_LINKS_TABLE}`";

		$this->SELECT_LINK = 		"SELECT * FROM `{$this->_LINKS_TABLE}` WHERE `id`='%d'";
		
		$this->SELECT_SEP_CATEGORIES =	"SELECT * FROM `{$this->_SEP_CATEGORIES_TABLE}`";
		$this->SELECT_SEP_CATEGORY =	"SELECT * FROM `{$this->_SEP_CATEGORIES_TABLE}` WHERE `id`='%d'";
		
		
		$this->SELECT_SEP_EVENT =	"SELECT *, UNIX_TIMESTAMP(`date_start`) AS dates2, UNIX_TIMESTAMP(`date_end`) AS datee2 ".
						" FROM `{$this->_SEP_EVENTS_TABLE}` WHERE `id`='%d'";
		
		$this->SELECT_SEP_EVENTS_BY_YEAR = "SELECT e.*, c.`name`, UNIX_TIMESTAMP(`date_start`) AS dates2, UNIX_TIMESTAMP(`date_end`) AS datee2 ".
						" FROM `{$this->_SEP_EVENTS_TABLE}` AS e, `{$this->_SEP_CATEGORIES_TABLE}` AS c ".
						" WHERE `category`=c.`id` AND ((`date_start` BETWEEN '%s-01-01' AND '%s-12-31') ".
						" OR (`date_end` BETWEEN '%s-01-01' AND '%s-12-31')) ORDER BY `date_start` DESC";
						
		$this->SELECT_SEP_NOWEVENT =	"SELECT *, UNIX_TIMESTAMP(`date_start`) AS dates2, UNIX_TIMESTAMP(`date_end`) AS datee2  FROM `{$this->_SEP_EVENTS_TABLE}` WHERE `is_now`='1'";
		
		
		$this->SELECT_SEP_PHOTOGALLERIES_FROM_CAT = "SELECT e.`title` AS eventtitle, UNIX_TIMESTAMP(e.`date_start`) AS eventdate, e.`id` AS eventid ".
						" FROM `{$this->_SEP_CATEGORIES_TABLE}` AS c, `{$this->_SEP_EVENTS_TABLE}` AS e".
						" WHERE c.`id`=e.`category` AND c.`id`='%d' ORDER BY e.`date_start` DESC";
						
		$this->SELECT_SEP_PHOTOGALLERIES = "SELECT *, UNIX_TIMESTAMP(`date`) AS dateg FROM `{$this->_SEP_PHOTOGALLERIES_TABLE}` WHERE `event`='%d'";
		$this->SELECT_SEP_PHOTOGALLERY = "SELECT *, UNIX_TIMESTAMP(`date`) AS date2 FROM `{$this->_SEP_PHOTOGALLERIES_TABLE}` WHERE `id`='%d'";
		$this->SELECT_SEP_PHOTOS = 	"SELECT * FROM `{$this->_SEP_PHOTOS_TABLE}` WHERE `gallery`='%d' ORDER BY `order` ASC";
		
		$this->SELECT_SEP_PRINT =	"SELECT *, DATE_FORMAT(`date`, '{$LANG['DATEFORMAT2']}') AS date2 FROM `{$this->_PRINTS_TABLE}` WHERE `id`='%d' AND `category`='sep'";
		
		$this->SELECT_SEP_PRINTS_BY_YEAR = "SELECT *, UNIX_TIMESTAMP(`date`) AS date2".
						" FROM `{$this->_PRINTS_TABLE}` WHERE `category`='sep' AND `date` BETWEEN '%s-01-01' AND '%s-12-31' ORDER BY `date` DESC LIMIT %d, %d";
	
		$this->SELECT_VIDEOS_OF_EVENT = "SELECT * FROM `{$this->_VIDEOS_TABLE}` WHERE `event`='%d'";
		
		$this->SELECT_VIDEOS_OF_EVENT_NOT_THIS = "SELECT * FROM `{$this->_VIDEOS_TABLE}` WHERE `event`='%d' AND `id`<>'%d'";

		$this->SELECT_VIDEOS = 		"SELECT v.*, e.`title` AS etitle, e.`id` AS eid FROM `{$this->_VIDEOS_TABLE}` AS v, `{$this->_SEP_EVENTS_TABLE}` AS e WHERE v.`event`=e.`id` ORDER BY `date` DESC LIMIT %d, %d";

		$this->SELECT_VIDEO = 		"SELECT v.*, e.`title` AS etitle, e.`id` AS eid FROM `{$this->_VIDEOS_TABLE}` AS v, `{$this->_SEP_EVENTS_TABLE}` AS e WHERE v.`event`=e.`id` AND v.`id`='%d'";
		

						
		$this->CHECK_USER 	= 	"SELECT *".
						" FROM `{$this->_USERS_TABLE}` AS u".
						" WHERE `mail`='%s' AND `password`='%s'";

		// Altre operazioni
	}
}

// Inizializza l'oggetto QUERY cosicché si possa accedere alle query tramite $QUERY->NOME_DELLA_QUERY
$QUERY = new MyQueries();
?>
