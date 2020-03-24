<?php

use App\Lists\GPNearByMe;

class ShowResultsTest extends MSWTestCase {

    public function testDisplayResults() {
        $results = [$this->getGPModel()];

        $expected = "\n\tName: \e[1;33;40mMSW Test Site\e[0m\n" .
                    "\tAddress: 22 Acacia Drive, Somewhereville, UK\n" .
                    "\tRating: 4.5 / 10\n" .
                    "\tOpening Hours: \e[0;31;42mOpen now\e[0m\n\n" . 
                    "\t\tMonday: Closed\n".
                    "\t\tTuesday: 11:00 AM – 11:00 PM\n".
                    "\t\tWednesday: 11:00 AM – 11:00 PM\n".
                    "\t\tThursday: 11:00 AM – 11:00 PM\n".
                    "\t\tFriday: 11:00 AM – 11:00 PM\n".
                    "\t\tSaturday: 11:00 AM – 11:00 PM\n".
                    "\t\tSunday: 12:00 – 10:00 PM\n\n\n";

        $this->expectOutputString($expected);

        $displayPresenter = new GPNearByMe(new StdioMock());

        $displayPresenter->displayResults($results);

    }

}
?>