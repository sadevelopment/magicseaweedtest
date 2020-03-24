<?php
namespace App\Logging;

use \DateTime;
use \DateTimeZone;

class Logger {

	static $config;
	static $stdio;

    public static function init($config, $stdio = NULL) {
		Logger::$config = $config;
		Logger::$stdio = $stdio;
    }

    public static function rawConsole($message) {
	    if(Logger::$_config->logging->active) {
			if(Logger::$stdio===NULL) {
				echo $message . "\n";
			} else {
				Logger::$stdio->write($message);
			}
	    }
    }
    
    public static function console($message) {
	    if(Logger::$_config->logging->active) {
            $dt = new DateTime("now");
		    $dt->setTimeZone(date_default_timezone_get());
		    $local = $dt->format('Y-m-d H:i:s');
		    $outputMessage = $message . ' received@ ' . $local . "\n";
			if(Logger::$stdio===NULL) {
				echo $outputMessage;
			} else {
				Logger::$stdio->write($outputMessage);
			}
	    }
	}
}

?>