<?php


class ModelTest extends MSWTestCase {

    public function testModelGetters() {
        $model = $this->getGPModel();

        $this->assertEquals("Open now", $model->getOpenNow());
        $this->assertEquals("MSW Test Site", $model->getName());
        $this->assertEquals(4.5, $model->getRating());
        $this->assertEquals(10, $model->getTotalRatings());
        $this->assertEquals("22 Acacia Drive, Somewhereville, UK", $model->getFormattedAddress());
        $this->assertEquals(10, $model->getTotalRatings());
        $this->assertCount(2, $model->getOpeningHours());

    }

    public function testModelClosed() {
        $model = $this->getGPModel(false);
        $this->assertEquals("Currently Closed", $model->getOpenNow());
    }
}

?>