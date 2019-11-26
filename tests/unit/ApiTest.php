<?php

class ApiTest extends \Codeception\TestCase\WPTestCase{
    /**
     * @test
     * it should be instantiatable
     */
    public function it_should_be_instantiatable(){
        $Api = new ContractorStopwatch\Api();
    }
    
}