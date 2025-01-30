<?php
//
// +---------------------------------------------------------------------------+
// | NizipRehber Haber Portalý v1.0 [ nrnews_v1.0 ]                            |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Gereksininimleri   : PHP 4 veya üzeri, GD2+ kütüphanesi                   |
// |                                                                           |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Geliþtirici    	: Mahmut ÖZDEMÝR                                       |
// | E-posta        	: mahmuttt88 {at} yahoo {dot} com                      |
// | Web adresi     	: http://www.mahmutozdemir.org/       	               |
// | Tel		     	: +90 5373622826 / +90 5457604888 / +90 5543184701     |
// |                                                                           |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Copyright (C) 2007                                                        |
// |                                                                           |
// | Bu Yazýlým ÜCRETSÝZ DEÐÝLDÝR. Yazýlýmýn Tüm Haklarý Mahmut ÖZDEMÝR'e      |
// | aittir.															       |
// |                                                                           |
// +---------------------------------------------------------------------------+
//
		ob_start();
		header("Content-Type: text/xml");

		
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~~~ Ýncluer Alýnýyor ~~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
		include("../config.php");
		include("../class/mysql.class.php");
		include("../includes/db.php");
		include("../includes/functions.php");
		include("../includes/settings.php");
		
		
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~~~ RSS Bilgileri ~~~~~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		
		echo "<?xml version=\"1.0\" encoding=\"ISO-8859-9\"?>\n\n";
		echo "<rss version=\"1.0\">\n\n";
		echo "<channel>\n";
		echo "<title>".$settings['site_title']."</title>\n";
		echo "<link>".$settings['site_url']."</link>\n";
		echo "<description>".$settings['site_title']." | ".$settings['site_slogan']."</description>\n";
		echo "<language>tr-TR</language>\n\n";
		
		
		$query = $db->read_query("
									SELECT id, title, spot, date
									FROM news
									WHERE active = 'Y'
									ORDER BY id DESC
									LIMIT 10
									") or die($db->sql->error());
									
		while($row = $db->sql_fetcharray($query)){
		
			echo "<item>\n";
			echo "<title>".stripslashes(strip_tags($row[title]))."</title>\n";
			echo "<link>".$settings['site_url']."/news_detail.php?id=".$row[id]."</link>\n";
			echo "<date>".time_to_now($row[date])."</date>\n";
			echo "<description>".stripslashes(strip_tags($row[spot]))."</description>\n";
			echo "</item>\n\n";
		
		}
		
		$db->sql_freeresult($query);
		$db->sql_close();
		
		echo "</channel>\n";
		echo "</rss>";
?>