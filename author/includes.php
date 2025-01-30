<?php

		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~~~ DIR Tanýmlama ~~~~~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		
		define('CWD', (($getcwd = getcwd()) ? $getcwd : '.'));
		define("DIR","./../");
		
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~~~ Ýncler Yapýlýyor ~~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			
		include_once(DIR . "/config.php");
		include_once(DIR . "/class/mysql.class.php");
		include_once(DIR . "/includes/db.php");
		include_once(DIR . "/includes/functions.php");
		include_once(DIR . "/includes/settings.php");
		include_once(DIR . "/includes/page_navigation.php");

?>