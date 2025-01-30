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
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ Ýncler Yapýlýyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
	
	include("config.php");	
	include("includes/includes.php");

	$id 	= intval($_REQUEST['id']);
	$type 	= strip_tags($_REQUEST['type']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title><?=$settings['site_title']?> [ Yorumlar ] </title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style>
BODY{
background:#FFFFFF;
}
</style>
</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="40" align="left" class="popupTitle">YORUMLAR</td>
  </tr>
	<!-- Yorumlar -->
					<?php
					
					$query = $db->read_query("
												SELECT name, title, comment, date
												FROM comments
												WHERE id = $id
												AND type = '$type'
												AND active = 'Y'
												ORDER BY date DESC
												") or die($db->sql_error());
												
					while($row = $db->sql_fetcharray($query)){
					?>
						<tr>
					  <td id="comments" style="padding:10px;">
					  <div class="comment">
						<div class="name"><?php echo stripslashes($row[name]);?></div>
						<div class="title"><?php echo stripslashes($row[title]);?></div>
						<div class="comment"><?php echo stripslashes($row[comment]);?></div>
						<div class="date"><?php echo time_to_now($row[date]);?></div>
					</div></td>
					</tr>
					<?php
					}
				
					?>

</table>
</body>
</html>
<?php
ob_end_flush();
?>