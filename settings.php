<?php


error_reporting(E_ERROR ^ E_DEPRECATED);

$config = json_decode(file_get_contents(__DIR__ . "/config.json"));

function global_exception_handler($exception) {
    echo "Exception caught by global handler @ " . (new DateTime('now'))->format('Y-m-d H:i:s') . "\n";
    echo "MSTest - Uncaught exception:\n\nMessage: " . $exception->getMessage(). "\n\n" . $exception->getTraceAsString() . "\n\n";
    if(sizeof($config->error_email_addresses)>0) {
    	echo "\n\nSending to: " . $config->error_email_addresses . "\n";
        mail($config->error_email_addresses, "Magic Seaweed Test Error", 
            "The Magic Seaweed Test suite has an error. Please check the log and restart the server once the issue has been corrected.\n\nMessage: " . $exception->getMessage() . "\n\n" .$exception->getTraceAsString());
    }
}
  
set_exception_handler('global_exception_handler');

?>