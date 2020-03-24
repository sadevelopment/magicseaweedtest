<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Model\GPNearByMe;

class MSWTestCase extends TestCase {

    protected function getConfig() {
        return json_decode(file_get_contents(__DIR__ . "/../config.json"));
    }

    protected function getGPModel($isOpenNow = TRUE) {
        return new GPNearByMe(array(
            "name"=>"MSW Test Site",
            "rating"=>4.5,
            "user_ratings_total"=>10,
            "formatted_address"=>"22 Acacia Drive, Somewhereville, UK",
            "opening_hours"=>array(
                "open_now"=>$isOpenNow?1:null,
                "weekday_text"=>[
                    "Monday: Closed",
                    "Tuesday: 11:00 AM – 11:00 PM",
                    "Wednesday: 11:00 AM – 11:00 PM",
                    "Thursday: 11:00 AM – 11:00 PM",
                    "Friday: 11:00 AM – 11:00 PM",
                    "Saturday: 11:00 AM – 11:00 PM",
                    "Sunday: 12:00 – 10:00 PM"
                ]
        
            )
        ));
    }
}

class StdioMock {

    public function write($message) {
        echo $message;
    }
}

?>