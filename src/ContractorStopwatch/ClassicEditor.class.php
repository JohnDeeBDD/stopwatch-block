<?php

namespace ContractorStopwatch;

class ClassicEditor {

    public function enableClassicEditorMetabox(){
        //die("enableClassicEditorMetabox");
        add_action('init', array($this, "checkIfClassicIsActive"));
    }

    public function checkIfClassicIsActive(){
    	if($this->is_classic_editor_plugin_active()){
		    add_action('add_meta_boxes', array($this, 'addMetabox'));
	    }
    }

	public function is_classic_editor_plugin_active() {
    	//from: https://wordpress.stackexchange.com/questions/320653/how-to-detect-the-usage-of-gutenberg
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		if ( is_plugin_active( 'classic-editor/classic-editor.php' ) ) {
			return true;
		}
		return false;
	}

    public function addMetabox(){
        add_meta_box(
            'contractor-stopwatch',           // Unique ID
            'Stopwatch',  // Box title
            array(new ClassicEditor, 'stopwatchMetaboxCallback')
        );
    }

    public function stopwatchMetaboxCallback(){
    	$output = <<<OUTPUT
<div id="timerContainer">
<div class="timer" onclick="startTimer()">Start</div>
</div>
<br />
<div>
<div class="startTimer reset" onclick="startTimer()" >
    <i class="fas fa-play"></i>
  </div>
<div class="pauseTimer reset" onclick="pauseTimer()" >
    <i class="fas fa-pause"></i>
  </div>
<div class="resetTimer reset" onclick="resetTimer()">Reset</div>
</div>
OUTPUT;
        echo ($output);
    }

}

