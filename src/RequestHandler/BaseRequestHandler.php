<?php
namespace App\RequestHandler;
use Evenement\EventEmitter;

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

    public abstract function getUsage();
    public abstract function makeRequest($requestParams);
}

?>