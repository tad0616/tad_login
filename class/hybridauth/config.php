<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------
$config =array(
		"base_url" => "http://tad0.dcs.tn.edu.tw/modules/tad_login/index.php",
		"providers" => array (

			"Google" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "849695598263-o9ppa7unlgoo0dmlsmvrel6hvdembsvk.apps.googleusercontent.com", "secret" => "FMOQiNI7GxIaxIRkX2HxW6b8" ),
			),

			"Facebook" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "759701747403776", "secret" => "8cabc4067ded6975509162c122f638c9" ),
			),

			"Twitter" => array (
				"enabled" => true,
				"keys"    => array ( "key" => "XXXXXXXX", "secret" => "XXXXXXX" )
			),
		),
		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => false,
		"debug_file" => "",
	);

?>