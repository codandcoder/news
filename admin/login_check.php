<?php

		session_start();
		
		$session_uid 		= $_SESSION['a_admin_id'];
		$session_username 	= $_SESSION['a_username'];
		$session_password 	= $_SESSION['a_password'];

		include("./includes.php");

		
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~ Kontrol Yapýlýyor ~~~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		
		$query = $db->write_query("
									SELECT id, permissions
									FROM administrators
									WHERE username='" . str_replace("\\'", "''", $session_username) . "'
									AND password='$session_password'
									");
		$row = $db->sql_fetcharray($query);
		
		$permissions_list = explode(",",$row[permissions]);

		$login_username 	= $_SESSION['a_username'];
		$login_name 		= $_SESSION['a_name'];
		$login_lastvisit 	= $_SESSION['a_lastvisit'];
		
		if($session_uid == "" || $db->sql_numrows($query)<1){
			echo "<script>top.location='login.php';</script>";
			exit;
		}
		
		if($modul_no != "0" && !in_array($modul_no,$permissions_list)){		
			echo "<script>alert('Sizin Bu Bölümde Yetkiniz Bulunmuyor.');top.location='index.php';</script>";
			exit;
		}

?>