<?php

namespace Evolution\Kernel;

// Exception Handler
set_exception_handler(__NAMESPACE__.'\handleException');
function handleException($e) {
	
	// Display with Kernel\Message
	try {
		new Message($e);
	}
	
	// Show something when our exception display fails
	catch(\Exception $d) {
		echo '<head><style>body {font-family: Tahoma, Sans, sans-serif; font-size: 12px;}</style></head>';
		echo '<h1>Error Displaying Message</h1><hr />';
		echo '<h3>Uncaught '.get_class($d).'</h3>'; 
		echo '<p>'.$d->getMessage().'</p>';
		die;
	}
}

// Error Handler
set_error_handler(__NAMESPACE__.'\handleError');
function handleError($no, $msg, $file, $line) {
	throw new \ErrorException("$msg on line $line in file `$file`", 0, $no, $file, $line);
}

// Set dump eval constant
define('d', 'preg_match("/^(.*)\\((\\d+)\\)\\s\\:\\seval\\(\\)\\\'d code/", __FILE__, $___DUMP);
	if(defined("Evolution\\Kernel\\Dump"))throw new Exception("Evolution dump already loaded");
	require_once("'.__DIR__.'/library/dump.php");');

// Include Load manually
require_once(__DIR__ . '/library/load.php');

// Check for a framework and load it - deprecate this
if(is_file($fw = dirname(__DIR__) . '/_framework.php'))
	require_once($fw);

// Run services bound to startup if not in site context
if(!defined('\\Evolution\\Site\\Root'))
	Service::complete('kernel:startup');