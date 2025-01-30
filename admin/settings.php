<?php

		$modul_no = 1;

		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~~~ İncler Yapılıyor ~~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		
		include "login_check.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<link rel="stylesheet" href="images/style.css" type="text/css" />
</head>

<body>
<?php

$query = $db->read_query("select site_title, site_url, site_slogan, site_email, contact_name, active_poll, contact_tel, contact_address, site_tags from settings") or die($db->sql_error());

$row = $db->sql_fetcharray($query);

if( isset($_POST['save']) ){

$site_title 		= addslashes(trim($_POST['site_title']));
$site_url			= addslashes(trim($_POST['site_url']));
$site_email			= addslashes(trim($_POST['site_email']));
$site_slogan 		= addslashes(trim($_POST['site_slogan']));
$site_tags	 		= addslashes(trim($_POST['site_tags']));
$contact_tel	 	= addslashes(trim($_POST['contact_tel']));
$contact_address 	= addslashes(trim($_POST['contact_address']));
$contact_name	 	= addslashes(trim($_POST['contact_name']));
$active_poll 		= intval(trim($_POST['active_poll']));

?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center">Bilgilendirme</td>
  </tr>
  <tr>
    <td class="row4px listEven" align="center">
	<?php
	if(!$site_title || !$site_url || !$site_email || !$site_slogan){	
	?>
	Lütfen Geri dönüp gerekli alanları doldurunuz.<br /><br /><a href="javascript:history.back();">Geri</a>
	<?php
	}else{

	$sql = "update settings set site_title = '$site_title', site_url = '$site_url', site_email = '$site_email',
	site_slogan = '$site_slogan', site_tags = '$site_tags', contact_name = '$contact_name', contact_address = '$contact_address', contact_tel = '$contact_tel', active_poll = '$active_poll'";
	
	$db->write_query($sql) or die($db->sql_error());

	?>
	<b>Ayarlarınız Kaydedildi.</b><p>
	<a href="settings.php">Lütfen Bekleyiniz... Sayfaya Yönlendiriliyorsunuz.</a>
	<meta http-equiv="Refresh" content="2; settings.php" />
	<?php
	}
	?>
	</td>
  </tr>

</table>

<?php
}else{

?>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center">SİTE AYARLARI </td>
  </tr>
 <tr>
    <td width="25%" class="row4px listEven"><b>Site Adı   :</b></td>
    <td width="75%" class="row4px listOdd"><input name="site_title" type="text" id="site_title" value="<?=stripslashes($row[site_title])?>" size="70" /></td>
  </tr>
  <tr>
    <td class="row4px listEven"><b>Site URL   :</b></td>
    <td class="row4px listOdd"><input name="site_url" type="text" id="site_url" value="<?=stripslashes($row[site_url])?>" size="70" /></td>
  </tr>
  <tr>
    <td class="row4px listEven"><b>Site E-Mail  :</b></td>
    <td class="row4px listOdd"><input name="site_email" type="text" id="site_email" value="<?=stripslashes($row[site_email])?>" size="70" /></td>
  </tr>
  <tr>
    <td class="row4px listEven"><b>Site Slogan    :</b></td>
    <td class="row4px listOdd"><input name="site_slogan" type="text" id="site_slogan" value="<?=stripslashes($row[site_slogan])?>" size="70" /></td>
  </tr>
  <tr>
    <td class="row4px listEven"><b>Meta Taglar    :</b></td>
    <td class="row4px listOdd"><textarea name="site_tags" cols="70" rows="5" id="site_tags"><?=stripslashes($row[site_tags])?></textarea>
    Sitenin arama motorlarında siteyi bulmasında yardımcı olur. &quot;,&quot; ile ayırın </td>
  </tr>
  <tr>
    <td class="row4px listEven"><b>Firma &amp; Kuruluş Adı :</b></td>
    <td class="row4px listOdd"><input name="contact_name" type="text" id="contact_name" value="<?=stripslashes($row[contact_name])?>" size="70" />
      İletişim Sayfasında Gözükecek</td>
  </tr>
  <tr>
    <td class="row4px listEven"><b>İletişim Tel   :</b></td>
    <td class="row4px listOdd"><input name="contact_tel" type="text" id="contact_tel" value="<?=stripslashes($row[contact_tel])?>" size="70" />
    İletişim Sayfasında Gözükecek</td>
  </tr>
    <tr>
    <td class="row4px listEven"><b>İletişim Adresi   :</b></td>
    <td class="row4px listOdd"><textarea name="contact_address" cols="70" rows="3" id="contact_address"><?=stripslashes($row[contact_address])?></textarea>
    İletişim Sayfasında Gözükecek. Max : 250 Karakter </td>
  </tr>
 <tr>
    <td class="row4px listEven"><b>Aktif Anket ID si :</b></td>
    <td class="row4px listOdd"><input name="active_poll" type="text" id="active_poll" value="<?=intval($row[active_poll])?>" size="15" maxlength="10" /> 
      // Anketi Kapatmak İçin 0 Değerini Giriniz. </td>
  </tr>
   <tr>
    <td class="row4px listEven" align="center"> </td>
    <td class="row4px listOdd"><input name="save" type="submit" class="button" id="save" value="Kaydet" />
      <span class="row5px listOdd">
      <input name="close" type="button" onclick="javascript:window.location='<?=$_SERVER['PHP_SELF']?>'" class="button" id="close" value="Vazgeç" />
      </span></td>
  </tr>
</table>
</form>
<?php
}
include "footer.php";
?>
</body>
</html>