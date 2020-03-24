<?php
namespace App\RequestHandler;

use Ds\Map;
use App\Logging\Logger;
use App\Exceptions\NoHandlerAvailableException;

/**
 * 
 */
class RequestHandlerFactory {
    static $HANDLER_MAP;

    public static function configureFactory($config, $stdio=NULL) {
        RequestHandlerFactory::setupHandlers($config, $stdio);
    }

    /**
     * Set up all the configured search engine
     */
    private static function setupHandlers($config, $stdio=NULL) {
        if(RequestHandlerFactory::$HANDLER_MAP==NULL) {
            RequestHandlerFactory::$HANDLER_MAP = new Map();
            $earchEngines = $config->search_engines;
            foreach($earchEngines as $searchEngine) {
                RequestHandlerFactory::$HANDLER_MAP->put($searchEngine->name, 
                    new $searchEngine->handler(
                            $searchEngine->api_key,
                            $searchEngine->name,
                            $searchEngine->description,
                            new $searchEngine->display_class($stdio),
                            $searchEngine->defaults,
                            new $searchEngine->argument_rewriter()));
            }
        }
    }

    public static function getRequestHandler($name) {
        // TODO: Need to throw an error here if the HANDLER_MAP has not been configured
        // TODO : calling this direct without configuring may throw and error - TestCase for this
        $handler = RequestHandlerFactory::$HANDLER_MAP->get($name, null);
        if($handler == null) {
            throw new NoHandlerAvailableException("The handler for {$name} does not exist!");
            return FALSE;
        }
        return $handler;
    }   
}