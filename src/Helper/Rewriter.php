<?php

namespace App\Helper;

abstract class Rewriter {

    public function __construct() {}

    abstract function rewrite(...$args);
}