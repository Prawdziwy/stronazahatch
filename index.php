<?php
error_reporting(E_ALL ^ E_STRICT ^ E_NOTICE);

// true = show sent queries and SQL queries status/status code/error message
define('DEBUG_DATABASE', false);
// if not defined before, set 'false' to load all normal
if(!defined('ONLY_PAGE'))
	define('ONLY_PAGE', false);

// fix user data, load config, enable class auto loader
include_once('./system/load.init.php');

// LAYOUT
// with ONLY_PAGE we return only page text, not layout
if(!ONLY_PAGE)
	include_once('./system/load.template.php');
else
	echo $main_content;

?>