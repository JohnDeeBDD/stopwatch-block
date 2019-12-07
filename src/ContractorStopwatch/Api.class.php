<?php

namespace ContractorStopwatch;

class Api{

    public function enableApiRoutes(){

        add_action( 'rest_api_init', function () {
            register_rest_route(
                'contractor-stopwatch',
                'v1/save-data',
                array(
                    'methods' => 'POST',
                    'callback' =>
                        array(
                            $this,
                            'moveDataInsideForPost',
                        ),
                    'permission_callback' =>
                        function () {
                            return true;
                        }
                )
            );
        }
        );

        add_action( 'rest_api_init', function () {
            register_rest_route(
                'contractor-stopwatch',
                'v1/get-data',
                array(
                    'methods' => array('GET', ' POST'),
                    'callback' =>
                        array(
                            $this,
                            'moveDataInsideForGet',
                        ),
                    'permission_callback' =>
                        function () {
                            return true;
                        }
                )
            );
        }
        );

        add_action( 'rest_api_init', function () {
            register_rest_route(
                'contractor-stopwatch',
                'v1/reset-clock',
                array(
                    'methods' => 'GET',
                    'callback' =>
                        array(
                            $this,
                            'resetClock',
                        ),
                    'permission_callback' =>
                        function () {
                            return true;
                        }
                )
            );
        }
        );

    }

    public function moveDataInsideForGet(){
        $postID = $_REQUEST['postID'];
        return ($this->getData($postID));
    }
    public function moveDataInsideForPost(){
        $postID = $_REQUEST['postID'];
        $data = $_REQUEST['data'];
        return ($this->setData($postID, $data));
    }

    public function setData($postID, $data){
        update_post_meta($postID, "stopwatchData", $data);
        return "Sucess!";
    }

    public function getData($postID){
        $data = get_post_meta( $postID, "stopwatchData", true);
        return $data;
    }

    public function resetClock(){
        $postID = $_REQUEST['postID'];

    }
}