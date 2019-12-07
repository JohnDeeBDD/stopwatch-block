<?php

namespace ContractorStopwatch;

class MetaDataFetcher{

	public function enableAPIroute(){
		add_action ('rest_api_init', array($this, 'doRegisterRoutes'));
	}

	public function doRegisterRoutes(){
		register_rest_route(
			'parler/v2',
			'fetch-post-meta',
			array(
				'methods'               => array('GET','POST'),
				'callback'              => array($this, 'returnMetaData'),
				'permission_callback'   => function(){return TRUE;}
				//'permission_callback'   => array(new \Parler\SiteAuth(),'authenticateApiRequest')
			)
		);
	}

	public function returnMetaData(){
		if (!(isset($_REQUEST['post-id']))){
			return "ERROR: No post ID";
		}
		$postID = $_REQUEST['post-id'];
		$meta = get_post_meta($postID);
		$meta = json_encode($meta);
		return $meta;
	}
}


