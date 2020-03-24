<?php
namespace App\RequestHandler;

use App\Model\GPNearByMe;
use SKAgarwal\GoogleApi\PlacesApi;
use \Exception;

/**
 * Google Place implmentation of te search engine. 
 */
class GooglePlacesNearByHandler extends BaseRequestHandler {

    private 
        $gp;

    public function __construct($apikey, $name, $description, $display_class, $defaults, $argument_rewriter) {
        parent::__construct($apikey, $name, $description, $display_class, $defaults, $argument_rewriter);
        $this->gp = new PlacesApi($apikey);
    }

    /**
     * Usage string
     * @return formatted string showing the usage instructions
     */
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

    /**
     * Makes a request to retrieve results given query parameters
     * @param $requestParams - array of parameters
     */
    public function makeRequest($requestParams) {
        try {
            /* 
                0 - lat,lng
                1 - radius
                2 - search term
                3 - type
            */
            $results = $this->gp->nearbySearch($requestParams[0], $requestParams[1], 
                                    array("keyword"=>$requestParams[2], "type"=>$requestParams[3]));

            $shortenedResults = array();
            $arrResults = $results->get('results');
            foreach($arrResults as $result) {
                // Get the details for place so we can get the opening times (weekday_text)
                $details = $this->gp->placeDetails($result['place_id'])->get('result');
                // Overwrite the opening_hours array with the one provided by details
                $result['opening_hours'] = $details['opening_hours'];
                $result['formatted_address'] = $details['formatted_address'];
                array_push($shortenedResults, new GPNearByMe($result));
            };

            // Emit the event that an
            $this->emitSuccess($shortenedResults);
        }catch(Exception $e) {
            $this->emitFailure($e);
        }
    }

}