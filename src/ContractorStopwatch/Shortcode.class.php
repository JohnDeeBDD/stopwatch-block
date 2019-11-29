<?php

namespace ContractorStopwatch;

class Shortcode{

    public function enableShortcodeFeature(){
        add_shortcode("contractor-stopwatch", array($this, "returnShortcode"));
    }

    public function returnShortcode(){
        wp_enqueue_script( 'contractor-stopwatch', plugins_url( 'contractor-stopwatch.js', __FILE__ ));
        wp_enqueue_style( 'contractor-stopwatch', plugins_url( 'contractor-stopwatch.css', __FILE__ ));
        wp_enqueue_style( 'contractor-stopwatch', "https://fonts.googleapis.com/css?family=Source+Sans+Pro:300");

        $output = file_get_contents(dirname(__FILE__) . "/contractor-stopwatch.html");
        $ID = get_the_ID();
        $ID = "<input type = 'hidden' name = 'post_ID' id = 'post_ID' value = '$ID' />";
        $output = $output . $ID;

        return $output;
    }

}
