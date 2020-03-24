<?php

namespace App\Lists;

abstract class ListPresenter {
    private
        $stdio;

    public function __construct($stdio) {
        $this->stdio = $stdio;
    }

    public abstract function displayResults($results);

    protected function writeResults($result) {
        if($this->stdio!=null) {
            $this->stdio->write($result . "\n\n");
        } else {
            echo $results . "\n\n";
        }
    }

}