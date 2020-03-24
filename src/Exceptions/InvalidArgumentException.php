<?php
namespace App\Exceptions;

use \Exception;

class InvalidArgumentException extends Exception {
    
    public function __construct($message) {
        parent::__construct($message, 0, null);
    }

    public function __toString() {
        return "{$this->message}\n";
    }
}