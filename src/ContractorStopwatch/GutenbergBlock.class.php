<?php

namespace ContractorStopwatch;

class GutenbergBlock{

	public function enqueAdminJs(){
		wp_enqueue_script( 'contractor-stopwatch-admin', plugin_dir_url( __FILE__ ) . 'Admin.js', array(), '1.0' );
	}

    public function enableBlockFeature(){
        //die('enableBlockFeature');
        add_action( 'init', array($this, 'registerStopwatchBlock') );
        add_action( 'admin_footer', array($this, 'echoGutenbergCss') );
	    add_action( 'admin_enqueue_scripts', array($this, 'enqueAdminJs') );

    }

    public function echoGutenbergCss(){
            $output = <<<OUTPUT

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">        
<style>
#timerContainer {
  font-family: 'Source Sans Pro', sans-serif;
  font-weight: 300;
  /*width:700px;*/
  margin:20px auto;
  min-height: 60px;
  border-top:0px;
}
.timer, .reset {
  float:left;
  width: 54%;
  padding: 20px 0;
  font-size: 24px;
  text-align:center;
  color: #fff;
  background: #A90000;
  cursor: pointer
}
.reset {
  background: #550000;
  color: white;
  width:14.9%;
  border-left: 1px solid #990000;
}
.reset:hover {
  background: #CC0000;
}
.lighter {
  background: #CC0000
}
</style>
OUTPUT;
            echo ($output);
    }

    public function registerStopwatchBlock() {
        wp_register_script(
            'stopwatch',
            plugins_url( 'gutenberg-block.js', __FILE__ ),
            array( 'wp-blocks', 'wp-element' )
        );

        register_block_type( 'contractor/stopwatch', array(
            'editor_script' => 'stopwatch',
        ) );
    }

}