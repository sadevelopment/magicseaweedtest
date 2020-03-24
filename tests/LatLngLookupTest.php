<?php

use App\Helper\LatLngLookup;

class TestLatLngLookup extends MSWTestCase {

    public function testLookup() {
        $latLngLU = new LatLngLookup($this->getConfig()->search_engines[0]->api_key);
        $this->assertEquals("50.9867009|-0.6107242", $latLngLU->lookupByName("Petworth,UK", "|"));
        $this->assertEquals("50.9867009,-0.6107242", $latLngLU->lookupByName("Petworth,UK", ","));
        $this->assertFalse($latLngLU->lookupByName("GaGaLand", "|"));
    }

}