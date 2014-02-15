<?php

// Variabili globali
global $internal, $DB, $CONFIG, $LANG, $QUERY;

// Carica i parametri di configurazione
require_once('config.php');

// Carica la lista delle query
require_once('query.php');

// Carica la lista dei messaggi
require_once('lang.php');

// Impedisce il caricamento se non attraverso la pagina index
if( !isset($internal) || !$internal )
	die($LANG['CANTOPEN']);

// Imposta il fuso orario corretto
date_default_timezone_set($CONFIG['timezone']);

/**
 * Riduce i messaggi di errore se la modalità di debug è disattivata
 * @param	$message	Messaggio di errore
 * @return	Messaggio di errore, o stringa vuota se debug è disattivato
 */
function showdebug( $message ) {
	global $CONFIG;
	if( $CONFIG['debug'] === TRUE )
		return $message;
	return '';
}

// Carica funzioni di connessione al database
require_once('functionsdb.php');

// Inizializza la connessione al database
$DB = new DatabaseConnection();

/**
 * Verifica l'avvenuta autenticazione
 * @param	$auth	Array con i dati di autenticazione dell'utente
 * @return	TRUE se l'utente è autenticato, FALSE altrimenti
 */
function isAuth( $auth ) {
	if( !isset($auth) || !$auth || !$auth['uid'] )
		return FALSE;
	return TRUE;
}

/**
 * Verifica l'avvenuta autenticazione per un account amministrativo
 * @param	$auth	Array con i dati di autenticazione dell'utente
 * @return	TRUE se l'utente è autenticato e amministratore, FALSE altrimenti
 */
function isAdmin( $auth ) {

	if( isAuth($auth) && $auth['level'] >= 2 )
		return TRUE;
	return FALSE;
}

function isUser( $auth ) {

	if( isAuth($auth) && $auth['level'] >= 1 )
		return TRUE;
	return FALSE;
}


/**
 * Verifica i dati di autenticazione dell'utente
 * @param	$username	Nome utente
 * @param	$password	Password (non criptata)
 * @return	Array con i dati di autenticazione, oppure NULL
 */
function checkAuth( $username, $password ) {
	global $CONFIG, $QUERY, $DB;
	$result = $DB->dosinglequery(sprintf($QUERY->CHECK_USER, mysql_real_escape_string($username), $password));
	if( !$result )
		return NULL;
	$retval = Array(
		'uid' => $username,
		'pwd' => $password,
		'level' => $result['level'],
	);
	return $retval;
}




/**
 * Restituisce l'url assoluto della pagina richiesta
 * @param	$path	Percorso relativo della pagina
 * @return	URL assoluto
 */
function site_url( $path = NULL ) {
	global $CONFIG;
	return $CONFIG['base_url'] . ( $path ? $path : '' );
}

function createbutton( $type, $urlquery = '', $confirm = FALSE, $little = FALSE, $msg = "" ) {
	global $LANG;
	// Array dei pulsanti esistenti
	$images = array(
		'DELETE' => 'button_delete.png',
		'EDIT' => 'button_edit.png',
		'ADD' => 'button_add.png',
		'BACK' => 'button_back.png',
		'YES' => 'button_on.png',
		'NO' => 'button_off.png',
		'DOWNLOAD' => 'button_load.png',
	);
	// Inizializza variabili
	$link_open = '';
	$link_close = '';
	$img = '';
	if ( $little )
		$images[$type] = str_replace(".png", "_little.png", $images[$type]);
		
	if( $urlquery != '' ) {
		// Tag di apertura del link
		$link_open = "<a class=\"iconbutton\" href=\"{$_SERVER['PHP_SELF']}?{$urlquery}\"";
		// Javascript di conferma
		if( $confirm == TRUE )
			$link_open .= " onclick=\"return confirm('". str_replace("'", "\'", $LANG['CONFIRM'].$msg) ."');\"";
		// Chiude tag di apertura
		$link_open .= ">";
		// Tag di chiusura
		$link_close = "<span>{$LANG[$type]}</span></a> ";
	}
	// Controlla se $type esiste in $images
	if( array_key_exists($type, $images) )
		$img = "<img src=\"".site_url("images/buttons/{$images[$type]}")."\" alt=\"{$LANG[$type]}\" title=\"{$LANG[$type]}\"/>";
	else
		$img = $LANG[$type];
	return $link_open . $img . $link_close;
}


/*
 * Conta gli elementi di una tabella
 * se viene chiamata specificando il secondo e il terzo parametro, conta tutte le righe che rispettano una condizione
 * altrimenti conta tutte le righe della tabella
 * @param	$table_name		Nome della tabella
 * @param	$parameter_name		Nome dell'attributo che rispetta la condizione
 * @param	$paramter_name		Valore che deve avere l'attributo che rispetta la condizione
 * @return	$result			Risultato della query
*/
function count_elements ( $table_name, $parameter_name = "no", $parameter_value = "no" )
{
	global $CONFIG, $QUERY, $DB;
	if($parameter_name=="no" || $parameter_value=="no")
		$result = $DB->dosinglequery(sprintf($QUERY->SELECT_COUNT_ALL, $table_name));
	else
		$result = $DB->dosinglequery(sprintf($QUERY->SELECT_COUNT, $table_name, $parameter_name, $parameter_value));
	

	/* se non è presente alcun elemento, stampa il messaggio */
	if($result["num"]==0 || $result==NULL)
		$result["num"] = "Non &egrave; presente alcun elemento";
		
	return $result["num"];
}

/*
 * Validizza una stringa da inserire nel database.
 * @param	$string			Stringa da inserire
 * @param	$must			Specifica se è un campo obbligatorio
 * @param	$field_name		Nome del tipo di stringa
 * @param	&$err			Variabile di segnalazione errori da passare per indirizzo
 * @param	&$msg			Messaggio di errore che memorizza i campi mancanti
*/
function validate_string ($string, $must=false, $field_name=NULL, &$err, &$msg)
{
	/* elimina spazi adiacenti */
	$string = trim($string);
	/* controlla che la stringa non sia vuota o nulla */
	if($string!="" && $string!=NULL)
		$string = mysql_real_escape_string($string);
	else if($must) /* se è un campo obbligatorio e non è stato compilato, aggiorna le variabili d'errore */
	{
		if(!$err)
			$msg = "Mancano i seguenti campi: ";
		$msg .= $field_name . ", ";
		$err = true;
	}
	return $string;
}


/* Convert Extended ASCII Characters to HTML Entities */
function ascii2entities($string){
    for($i=128;$i<=255;$i++){
        $entity = htmlentities(chr($i), ENT_QUOTES, 'cp1252');
        $temp = substr($entity, 0, 1);
        $temp .= substr($entity, -1, 1);
        if ($temp != '&;'){
            $string = str_replace(chr($i), '', $string);
        }
        else{
            $string = str_replace(chr($i), $entity, $string);
        }
    }
    return $string;
}



function num_to_month($string){

	switch($string)
	{
		case "01": $string="Gennaio"; break;
		case "02": $string="Febbraio"; break;
		case "03": $string="Marzo"; break;
		case "04": $string="Aprile"; break;
		case "05": $string="Maggio"; break;
		case "06": $string="Giugno"; break;
		case "07": $string="Luglio"; break;
		case "08": $string="Agosto"; break;
		case "09": $string="Settembre"; break;
		case "10": $string="Ottobre"; break;
		case "11": $string="Novembre"; break;
		case "12": $string="Dicembre"; break;
	}
	return $string;
}

function month_to_num($string){

	switch ($string)
	{
		case "January": $string="01"; break;
		case "February": $string="02"; break;
		case "March": $string="03"; break;
		case "April": $string="04"; break;
		case "May": $string="05"; break;
		case "June": $string="06"; break;
		case "July": $string="07"; break;
		case "August": $string="08"; break;
		case "September": $string="09"; break;
		case "October": $string="10"; break;
		case "November": $string="11"; break;
		case "December": $string="12"; break;

	}
	return $string;
}




function resize_photo($targetpath, $file, $filename, $max_width, $max_height)
{
	//se il file esiste già, cancellalo per sostituirlo
	if(file_exists(getcwd() . $targetpath . $filename))
	{
		unlink(getcwd() . $targetpath . $filename);
	}

	/* ridimensiona l'immagine */
	move_uploaded_file($file['tmp_name'], getcwd(). $targetpath . $filename);

	list($width, $height, $type, $attr) = getimagesize(getcwd(). $targetpath . $filename);

	if($width>$height)
	{
	//	$max_width = 800;
		$max_height = round($max_width*$height/$width);
	}
	else
	{
	//	$max_height = 600;
		$max_width = round($max_height*$width/$height);
	}

	$thumb = imagecreatetruecolor($max_width, $max_height);
	$source = imagecreatefromjpeg(getcwd(). $targetpath . $filename);
	imagecopyresized($thumb, $source, 0, 0, 0, 0, $max_width, $max_height, $width, $height);
	unlink(getcwd() . $targetpath . $filename);
	imagejpeg($thumb, getcwd(). $targetpath . $filename, 100);

}


function ltgt ($string)
{
	$string = str_replace("&lt;","<",$string);
	$string = str_replace("&gt;",">",$string);
	$string = str_replace("=&quot;","=\"",$string);
	$string = str_replace("&quot;>","\">", $string);
	return $string;
}

function nozero_date ($string)
{
	if(substr($string, 0, 1)=="0")
		return substr($string, 1);
	else
		return $string;
}


function svuota_cartella($dirpath) {
  $handle = @opendir($dirpath);
  while (($file = @readdir($handle)) !== false) {
    //echo "Cancellato: " . $file . "<br/>";
    @unlink($dirpath . $file);
  }
  @closedir($handle);
}

/*
 Validizza le stringhe dei form da inserire nel database
 Non converte i caratteri html solamente se richiesto nel secondo parametro
*/
function validize_string ($string, $must_html=true, $is_link=false) {
	$string = trim($string);
	if($must_html)
		$string = htmlentities($string, ENT_COMPAT, "UTF-8");
	else
	{
	
		$string = preg_replace("/<script.*?>.*?<\/script>/im","",$string);
	
		$string = preg_replace("/<object.*?>.*?<\/object>/im","",$string);
		$string = preg_replace("/<iframe.*?>.*?<\/iframe>/im","",$string);
		$string = preg_replace("/<applet.*?>.*?<\/applet>/im","",$string);
		$string = preg_replace("/<meta.*?>.*?<\/meta>/im","",$string);
		$string = preg_replace("/<form.*?>.*?<\/form>/im","",$string);
		$string = str_replace("<br>", "<br />", $string);
		$string = str_replace("<BR>", "<br />", $string);
		$string = str_replace("<P", "<p", $string);
		$string = str_replace("</P>", "</p>", $string);
		$string = str_replace("<IMG", "<img", $string);
		$string = str_replace("</IMG>", "</img>", $string);
		$string = str_replace("class=\"left_align\">", "class=\"left_align\" />", $string);
		$string = str_replace("class=\"right_align\">", "class=\"right_align\" />", $string);
	//	$string = str_replace("&", "&amp;", $string);
		$string = str_replace("à", "&agrave;", $string);
		$string = str_replace("è", "&egrave;", $string);
		$string = str_replace("ì", "&igrave;", $string);
		$string = str_replace("ò", "&ograve;", $string);
		$string = str_replace("ù", "&ugrave;", $string);
		$string = str_replace("è", "&eacute;", $string);
		$string = str_replace("È", "&Egrave;", $string);
		$string = str_replace("•", "&bull;", $string);
		$string = str_replace("&amp;nbsp;", "&nbsp;", $string);
		$string = str_replace("&amp;amp;", "&amp;", $string);
	//	$string = str_replace("%5C%22", "", $string);
	//	$string = str_replace("'", "&#039;", $string);
		$string = str_replace("<div>", "<p>", $string);
		$string = str_replace("</div>", "</p>", $string);
		$string = str_replace("</p><p>", "<br />", $string);
		$string = str_replace("<p>", "<br />", $string);
		$string = str_replace("</td>", "", $string);
		$string = str_replace("</tr>", "", $string);
		$string = str_replace("</table>", "", $string);
		$string = str_replace("</textarea>", "", $string);
		$string = str_replace("</body>", "", $string);
		$string = str_replace("</html>", "", $string);
	/*	$string = preg_replace('!(</?)(\w+)([^>]*?>)!e', "'\\1'.strtolower('\\2').'\\3'", $string);
	*/
	}
	$string = mysql_real_escape_string($string);
	return $string;
}

function youtube_id( $string ) {
	
	$string = str_replace("http://www.youtube.com/watch?v=", "", $string);
	$string = str_replace("http://www.youtube.it/watch?v=", "", $string);
	$string = str_replace("http://www.youtube.com/?v=", "", $string);
	$string = str_replace("http://www.youtube.it/?v=", "", $string);
	$string = str_replace("http://www.youtube.com/vi/", "", $string);
	$string = str_replace("http://www.youtube.it/vi/", "", $string);
	$string = str_replace("http://youtu.be/", "", $string);
	$string = str_replace("&feature=fvwrel", "", $string);
	$string = str_replace("&amp;feature=fvwrel", "", $string);
	$string = str_replace("&feature=feedf", "", $string);
	$string = str_replace("&amp;feature=feedf", "", $string);
	$string = str_replace("&feature=aso", "", $string);
	$string = str_replace("&amp;feature=aso", "", $string);
	$string = str_replace("&feature=related", "", $string);
	$string = str_replace("&amp;feature=related", "", $string);
	
	if(strlen($string)!=11 && strlen($string)!=10)
		return NULL;
	else
	{
		return $string;
	}
}


/* espressione regolare che controlla la validità di una mail */
function check_mail ($string) {
	/*
	if(preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $email))
		return false;
	else
		return true;
	*/
	$regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
	$regexp = "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/";
	if (preg_match($regexp, $string)) 
   		return true;
	else
		return false;
}

?>
