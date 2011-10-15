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
	throw new \Exception("$msg on line $line of `$file`");
}

// Include Load manually
require_once(__DIR__ . '/library/load.php');

// Run services bound to startup
Service::complete('kernel:startup');