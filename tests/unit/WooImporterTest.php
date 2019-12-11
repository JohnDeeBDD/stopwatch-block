<?php

class WooImporter extends \Codeception\TestCase\WPTestCase{

    /**
     * @test
     * it should be instantiatable
     */
    public function it_should_be_instantiatable(){
        $WooImporter = new ContractorStopwatch\WooImporter();
    }

    /**
     * @skip
     * it should create a WooOrder
     */
    public function itShouldCreateWooOrder(){
        $WooImporter = new ContractorStopwatch\WooImporter();
        $args = array('post_title' => "Test Post");
        $ID = wp_insert_post( $args );
        $data = array("1576006310722", "1576006313669", "1576006315064","1576006318969","1576006321652","1576006324757");
        $rate = 11;
        $WooImporter->data = $data;
        $WooImporter->rate = $rate;

        $order = $WooImporter->createOrder();

        $this->assertEquals("",$order);


    }

    /**
     * @test
     * it should compute a fee line item
     */
    public function itShouldComputeTheFeeLineItem(){
        $WooImporter = new ContractorStopwatch\WooImporter();
        $startTime = 1333699439;
        $endTime = 1333699499;
        $rate = 11;
        $lineItemString = $WooImporter->computeLineItem($startTime, $endTime, $rate);
        $this->assertEquals("2012-04-06T08:03:59Z - 2012-04-06T08:04:59Z @ $11/hr", $lineItemString);
    }
}
