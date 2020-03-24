<?php
namespace App\Helper;

use App\Exceptions\InvalidArgumentException;

class GPArgumentRewriter extends Rewriter {

    public function __construct() {
        parent::__construct();
    }

    private function checkMinimumParameterSet($arguments) {
        return sizeof($arguments) >= 1;
    }

    public function rewrite(...$args) {
        $newArguments = array();
        $parts = explode($args[1], $args[3]);

        if(!$this->checkMinimumParameterSet($parts) || $parts[1]==="") {
            throw new InvalidArgumentException("Please check that you include at least lat/lng or place name in your query");
        }


        if(preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?);[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $parts[2])==1) {
            $latlng= explode(",", $parts[0]);
            array_push($newArguments, $latlng[0] . " " . $latlng[1]);
        } else {
           $lookup = new LatLngLookup($args[0]);
           $result = $lookup->lookupByName($parts[0], ",");
           if($result==FALSE) {
                throw new InvalidArgumentException("Unable to find this location: {$parts[0]}");
           }
           array_push($newArguments, $result);
        }

        if(array_key_exists(1, $parts) AND is_numeric($parts[1])) {
            array_push($newArguments, $parts[1]);
        } else {
            array_push($newArguments, $args[2]->radius);
        }

        if(!array_key_exists(2, $parts)) {
            array_push($newArguments, $args[2]->search_term);
            array_push($newArguments, $args[2]->type);
        } else {
            array_push($newArguments, $parts[2]);
        }

        if(array_key_exists(3, $parts)) {
            array_push($newArguments, $parts[3]);
        } else if(sizeof($newArguments)==3) {
            array_push($newArguments, $args[2]->type);
        }
        
        return $newArguments;

    }
}