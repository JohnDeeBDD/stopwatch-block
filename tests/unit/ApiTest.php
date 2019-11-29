<?php

require_once('/var/www/html/wp-content/plugins/stopwatch-block/src/ContractorStopwatch/autoloader.php');

class ApiTest extends \Codeception\TestCase\WPTestCase{
    
  //  public function __construct(){
        //require_once('/var/www/html/wp-content/plugins/stopwatch-block/src/ContractorStopwatch/autoloader.php');
   // }

    /**
     * @test
     * it should be instantiatable
     */
    public function it_should_be_instantiatable(){
        $Api = new ContractorStopwatch\Api();
    }


    /**
     * @test
     * it should accept a status update
     */
    public function itShouldAcceptStatusUpdate(){
        $Api = new ContractorStopwatch\Api();
        $browserTime = time();
        $postId = 6;

        $Api->setStartTime($browserTime, $postId);

        $returnedTime = $Api->getStartTime($postId);

        $this->assertEquals($browserTime, $returnedTime);

    }

}

/*
 *         register_rest_route(
            'parler',
            'published-tag-id',
            array(
                'methods' => 'GET',
                'callback' =>
                array(
                    new \Parler\SyncFeature(),
                    'returnPublishedTagID',
                ),
                'permission_callback' => function () {
                //todo!!
                return true;
                //return current_user_can( 'edit_others_posts' );
                }
                )
            );
 */