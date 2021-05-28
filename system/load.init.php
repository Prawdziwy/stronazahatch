<?PHP
	function autoLoadClass($className) {
		if(!class_exists($className))
			if(file_exists('./classes/' . strtolower($className) . '.php'))
				include_once('./classes/' . strtolower($className) . '.php');
			else
				throw new RuntimeException('#E-7 -Cannot load class <b>' . $className . '</b>, file <b>./classes/class.' . strtolower($className) . '.php</b> doesn\'t exist');
	}
	spl_autoload_register('autoLoadClass');

	// DEFINE VARIABLES FOR SCRIPTS AND LAYOUTS (no more notices 'undefinied variable'!)
	if(!isset($_REQUEST['p']) || empty($_REQUEST['p']) || is_array($_REQUEST['p']))
		$_REQUEST['p'] = "mainpage";
	else
		$_REQUEST['p'] = (string) $_REQUEST['p'];

	if(Functions::isValidFolderName($_REQUEST['p']))
	{
		if(Website::fileExists("pages/" . $_REQUEST['p'] . ".php"))
			$subtopic = $_REQUEST['p'];
		else 
			die('Cannot load page <b>' . htmlspecialchars($_REQUEST['p']) . '</b>, file does not exist.');
	}
	else
		die('Cannot load page <b>' . htmlspecialchars($_REQUEST['p']) . '</b>, invalid file name [contains illegal characters].');

	// load config
	include_once('./config/config.php');

	// action that page should execute
	if(isset($_REQUEST['action']))
		$action = (string) $_REQUEST['action'];
	else
		$action = '';

	$servername = "localhost";
	$username = $login_database;
	$password = $password_database;
	$dbname = $name_database;

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	// content

	// server should keep session data for AT LEAST 3 days
	ini_set('session.gc_maxlifetime', 259200);

	// each client should remember their session id for EXACTLY 3  days
	session_set_cookie_params(259200);

	ob_start();
	session_start();
	
	$main_content = '';
	include("pages/" . $subtopic . ".php");
	$main_content .= ob_get_clean();
?>