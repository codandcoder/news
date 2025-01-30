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
		
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~~~ Ýncler Alýnýyor ~~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
		include("../config.php");
		include("../class/mysql.class.php");
		include("../includes/db.php");
		include("../includes/functions.php");
		include("../includes/settings.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title><?=stripslashes($settings['site_title'])?> | Son Dakika Haberler</title>
<link href="../css/style.css" type="text/css" rel="stylesheet" />
<style>
BODY{
	background:#FFFFFF;
}
</style>
</head>

<body>
		<table width="100%" border="1" bordercolor="#d8d8d8" cellspacing="4" cellpadding="0">
          <tr>
            <td  bgcolor="#F8F8F8" style="padding:3px;">[ <a href="<?=$settings['site_url']?>" target="_blank"><?=str_replace("http://","",$settings[site_url])?></a> ]</td>
          </tr>
		  <?php		
		$query = $db->read_query("
									SELECT id, title
									FROM news
									WHERE active = 'Y'
									ORDER BY id DESC
									LIMIT 10
									") or die($db->sql->error());
									
		while($row = $db->sql_fetcharray($query)){
		?>
          <tr>
            <td style="padding:3px;" bgcolor="#f8f8f8"><img src="../images/news_icon_red.gif" align="absmiddle" /> <a href="<?=$settings['site_url']?>/news_detail.php?id=<?=$row[id]?>" target="_blank"><b><?=stripslashes($row[title])?></b></a></td>
          </tr>
		  <?php		
		}
		
		$db->sql_freeresult($query);
		$db->sql_close();
?>
        </table>
