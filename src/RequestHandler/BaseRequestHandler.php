<?php
namespace App\RequestHandler;
use Evenement\EventEmitter;

/**
 * Immutable abstract to capture the details of the search engine. This abstract
 * is a subclass of EventEmitter so we can fire off events as we need.<p>
 * 
 * Two events are provided and should be used<br>
 * 
 * result - indictates that the query was a success and results (array) are available
 * error - indicates that the query failed (exception)
 */
abstract class BaseRequestHandler extends EventEmitter {

    protected
        $name,
        $apikey,
        $description,
        $display_class,
        $defaults,
        $argument_rewriter;

    public function __construct($apikey, $name, $description, $display_class, $defaults, $argument_rewriter) {
        $this->apikey = $apikey;
        $this->name = $name;
        $this->description = $description;
        $this->display_class = $display_class;
        $this->defaults = $defaults;
        $this->argument_rewriter = $argument_rewriter;
    }

    public function getApiKey() { return $this->apikey; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getDisplayClass() { return $this->display_class; }
    public function getDefaults() { return $this->defaults; }
    public function getArgumentRewriter() { return $this->argument_rewriter; }

    protected function emitSuccess($results) {
        $this->emit("result", [$results]);
    }

    protected function emitFailure($exception) {
        $this->emit("error", [$exception]);
    }

    public abstract function getUsage();
    public abstract function makeRequest($requestParams);
}

?>