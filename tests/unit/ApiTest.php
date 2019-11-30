<?php

//require_once('/var/www/html/wp-content/plugins/stopwatch-block/src/ContractorStopwatch/autoloader.php');

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
        $my_post = array(
            'post_title'    => "Test Post",
            'post_content'  => "Test content.",
            'post_status'   => 'publish',
        );
        $postId = wp_insert_post( $my_post );

        $Api = new ContractorStopwatch\Api();
        $session1 = array(time(), (time()+60) );
        $session2 = array((time()+600) , (time()+700) );
        $session3 = array((time()+880), (time()+999) );
        $data = array($session1,$session2,$session3);
        $data = json_encode($data);

        $Api->setData($postId, $data);
        $returnedData = $Api->getData($postId);

        $this->assertEquals($data, $returnedData);
    }

}
