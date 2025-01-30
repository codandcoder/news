<?php

		session_start();
		
		$session_uid 		= $_SESSION['log_author_id'];
		$session_username 	= $_SESSION['log_username'];
		$session_password 	= $_SESSION['log_password'];

		include("./includes.php");

		
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~ Kontrol Yapýlýyor ~~~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		
		if(session_is_registered("log_username")){
		
			$query = $db->write_query("
										SELECT author_id
										FROM authors
										WHERE username='" . str_replace("\\'", "''", $session_username) . "'
					   					AND password='$session_password'
										");
			$row = $db->sql_fetcharray($query);
		
		}
		
		$login_username 	= $_SESSION['log_username'];
		$login_name 		= $_SESSION['log_name'];
		$login_lastvisit 	= $_SESSION['log_lastvisit'];
		
		if($session_uid == "" || $db->sql_numrows($query)<1){
			echo "<script>top.location='login.php';</script>";
			exit;
		}
	
?>