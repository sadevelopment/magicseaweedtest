<?php
namespace App\RequestHandler;

use App\Model\GPNearByMe;
use SKAgarwal\GoogleApi\PlacesApi;
use \Exception;

class GooglePlacesNearByHandler extends BaseRequestHandler {

    private 
        $gp;

    public function __construct($apikey, $name, $description, $display_class, $defaults, $argument_rewriter) {
        parent::__construct($apikey, $name, $description, $display_class, $defaults, $argument_rewriter);
        $this->gp = new PlacesApi($apikey);
    }

    public function getUsage() {
        return "\nUsage:\n\t" .
                "<lat,lng>|<radius>|<search term>|<type>\nOr\n\t" .
                "<place name>|<radius>|<search term>|<type>\n\n" .
                "Required:\n<lat,lng> or <place name> - one of these are required.\n\n" .
                "Optional Params:\n" .
                "<radius> - if radius is not a numeric will use the default in config.json for this engine\n".
                "<search term> - if not provided will use the default in config.json for this engine\n" . 
                "<type> - if type is not specified will use the default in config.json for this engine\n\n";
    }

    public function makeRequest($requestParams) {
        try {
            $results = $this->gp->nearbySearch($requestParams[0], $requestParams[1], 
                                    array("keyword"=>$requestParams[2], "type"=>$requestParams[3]));

            $shortenedResults = array();
            $arrResults = $results->get('results');
            foreach($arrResults as $result) {
                $details = $this->gp->placeDetails($result['place_id'])->get('result');
                $result['opening_hours'] = $details['opening_hours'];
                $result['formatted_address'] = $details['formatted_address'];
                array_push($shortenedResults, new GPNearByMe($result));
            };

            $this->emit("result", [$shortenedResults]);
        }catch(Exception $e) {
            $this->emit("error", [$e]);
        }
    }

}