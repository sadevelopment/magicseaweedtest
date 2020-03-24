<?php

namespace App\Lists;

/**
 * Abstract ListPresenter - this should be implemented for each search engine
 * required. 
 */
abstract class ListPresenter {
    private
        $stdio;

    /**
     * Takes a stdio instance (defaults to NULL). stdio should probably be better
     * being wrapped by our own object with a known interface that all providers should implement.
     */
    public function __construct($stdio = NULL) {
        $this->stdio = $stdio;
    }

    public abstract function displayResults($results);

    /**
     * Display the results
     */
    protected function writeResults($result) {
        if($this->stdio!=null) {
            $this->stdio->write($result . "\n\n");
        } else {
            echo $results . "\n\n";
        }
    }

}