<?php
namespace App\Helper;

use \Geocoder\ProviderAggregator;
use \Http\Discovery\HttpClientDiscovery;
use \League\Geotools\Geotools;
use \Geocoder\Provider\GoogleMaps\GoogleMaps;

/**
 * 
 */
class LatLngLookup {

    private 
        $geotools,
        $geocoder,
        $httpClient;

    public function __construct($apiKey) {
        $this->geotools = new Geotools();
        $this->geocoder = new ProviderAggregator();
        $this->httpClient = HttpClientDiscovery::find();
        $this->geocoder->registerProviders([
            new GoogleMaps($this->httpClient, null, $apiKey)
        ]);
    }

    public function lookupByName($name, $delim) {
        $results = $this->geotools->batch($this->geocoder)->geocode($name)->parallel();
        if(sizeof($results)>0 && $results[0]->getCoordinates()!=NULL) {
            return  $results[0]->getCoordinates()->getLatitude() . $delim . $results[0]->getCoordinates()->getLongitude();
        }
        return FALSE;
    }
}

?>