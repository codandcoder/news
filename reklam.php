<?php

//
// +---------------------------------------------------------------------------+
// | NizipRehber Haber Portal� v1.0 [ nrnews_v1.0 ]                            |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Gereksininimleri   : PHP 4 veya �zeri, GD2+ k�t�phanesi                   |
// |                                                                           |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Geli�tirici    	: Mahmut �ZDEM�R                                       |
// | E-posta        	: mahmuttt88 {at} yahoo {dot} com                      |
// | Web adresi     	: http://www.mahmutozdemir.org/       	               |
// | Tel		     	: +90 5373622826 / +90 5457604888 / +90 5543184701     |
// |                                                                           |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Copyright (C) 2007                                                        |
// |                                                                           |
// | Bu Yaz�l�m �CRETS�Z DE��LD�R. Yaz�l�m�n T�m Haklar� Mahmut �ZDEM�R'e      |
// | aittir.															       |
// |                                                                           |
// +---------------------------------------------------------------------------+
//

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ �ncler Yap�l�yor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
	
	include("config.php");	
	include("includes/includes.php");


			$reklamid = intval($_GET['reklamid']);
			
			$db->write_query("UPDATE reklamlar SET hit = hit + 1 WHERE reklamid = $reklamid");
	
	
			$query = $db->read_query("
										SELECT url
										FROM reklamlar
										WHERE reklamid = $reklamid
										") or die($db->sql_error());
									
			$reklam = $db->sql_fetcharray($query);
			
			echo "<script>window.location = '".$reklam[url]."';</script>";

ob_end_flush();
?>