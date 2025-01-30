<?php

	$modul_no = 33;

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ İncler Yapılıyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";

	$limit = 15;
	
	$do = trim($_GET['do']) ? addslashes(trim($_GET['do'])) : addslashes(trim($_POST['do'])) ;
	$start = ( isset($_GET['start']) ) ? intval($_GET['start']) : 0;
	$vid = ( isset($_GET['vid']) ) ? intval($_GET['vid']) : intval($_POST['vid']);
	$video_headline = trim($_GET['do'] == "edit") ? "VİDEO DÜZENLE" : "VİDEO EKLE";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<link rel="stylesheet" href="images/style.css" type="text/css" />
<script language='JavaScript' type='text/javascript' src='javascripts/functions.js'></script>

<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
</head>

<body class="scrollBar">
<?php

	if($do=="delete"){
	
		$del = addslashes(trim($_GET['del_ok']));
		$query = $db->read_query("select baslik from videolar where vid = $vid");
		$row = $db->sql_fetcharray($query);
?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center">Bilgilendirme</td>
  </tr>
  <tr>
    <td class="row5px listEven" align="center">
	<?php
	if($del != "yes"){	
	?>
	<b>DİKKAT:</b> <b><i><?=$row[baslik]?></i></b> adlı videoı silmek üzeresiniz.<br /><br />
	<br />Devam Etmek İstiyor musunuz?<br /><br /><a href="videolar.php">[ Hayır ]</a> | <a href="videolar.php?do=delete&vid=<?=$vid?>&del_ok=yes">[ Evet ]</a>
	<?php
	}elseif($del == "yes"){

		$db->write_query("delete from videolar where vid = ".$vid."");
	
	?>
	<b>Kayıtlar Silindi.</b><p>
	<a href="videolar.php">Sayfaya Dönmek İçin Tıklayınız.</a>
	<?php
	}
	?>
	</td>
  </tr>

</table>

<?php
}elseif( isset($_POST['save']) ){

	$baslik 		= addslashes(trim($_POST['baslik']));
	$haberlink		= addslashes(trim($_POST['haberlink']));
	$resim	 		= addslashes(trim($_POST['image']));
	$videokodu 		= addslashes(trim($_POST['videokodu']));
	$durum 			= addslashes(trim($_POST['durum']));
	
?>

	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  		<tr>
   		  <td colspan="2" class="listHeader padleft5px" align="center">Bilgilendirme</td>
  		</tr>
  		<tr>
    	  <td class="row5px listEven" align="center">
			<?php
			if(!$baslik || !$videokodu || !$resim || !$durum){	
			?>
			Lütfen Geri dönüp gerekli alanları doldurunuz.<br /><br /><a href="javascript:history.go(-1);">Geri</a>
			<?php
			}else{
			
			$sql = ($do != "edit" ) ? "	INSERT INTO videolar(baslik, resim, videokodu, haberlink, tarih, durum)
										VALUES('$baslik','$resim','$videokodu','$haberlink','".time()."', '$durum')"
										:
									  "	UPDATE videolar SET
									  	baslik = '$baslik',
										resim = '$resim',
										haberlink = '$haberlink',
										videokodu = '$videokodu',
										durum = '$durum'
										WHERE vid=".$vid;
			
			$db->write_query($sql) or die($db->sql_error());

			?>
			<b>İşleminiz Gerçekleştirildi.</b><p>
			<a href="videolar.php">Lütfen Bekleyiniz... Sayfaya Yönlendiriliyorsunuz.</a>
			<meta http-equiv="Refresh" content="2; videolar.php" />
			<?php
			}
			?>
		  </td>
  		</tr>
	</table>
<?php
}elseif($do == "new" || $do == "edit"){

	if($do == "edit"){
		$query = $db->read_query("select baslik, videokodu, resim, haberlink, durum from videolar where vid = $vid");
		$row = $db->sql_fetcharray($query);
	}
?>
<form method="post" name="addForm" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" value="<?=$vid?>" name="vid" />
<input type="hidden" value="<?=$do?>" name="do" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center"><?=$video_headline?></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Başlık  :</b></td>
    <td class="row5px listOdd"><input name="baslik" type="text" id="baslik" value="<?=stripslashes($row[baslik])?>" size="70" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Resim  :</b></td>
    <td class="row5px listOdd"><input name="image" value="<?=stripslashes($row[resim])?>" type="text" size="40" />
&nbsp; <a href="#"  onclick="javascript:Popup('image.php?do=upload&type=video','',570, 300);">Resim Yükle</a> | <a href="#"  onclick="javascript:Popup('image.php?do=search&type=video','',570, 300);">Resimlerde Ara</a></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Haber Link   :</b></td>
    <td class="row5px listOdd"><input name="haberlink" type="text" id="haberlink" value="<?=stripslashes($row[haberlink])?>" size="70" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Video Kodu :</b></td>
    <td class="row5px listOdd"><textarea name="videokodu" cols="70" rows="6" id="videokodu"><?=stripslashes($row[videokodu])?></textarea></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Durumu  :</b></td>
    <td class="row5px listOdd"><input <?php if($row[durum] == "Y" || $row[durum] == "") echo "checked";?> name="durum" type="radio" value="Y" />
      Aktif
      <input <?php if($row[durum] == "N") echo "checked";?> name="durum" type="radio" value="N" />
      Pasif </td>
  </tr>
  <tr>
    <td width="30%" class="row5px listEven" align="center"> </td>
    <td width="70%" class="row5px listOdd"><input name="save" type="submit" class="button" id="save" value="Kaydet" />
      <input name="close" type="button" onclick="javascript:window.location='<?=$_SERVER['PHP_SELF']?>'" class="button" id="close" value="Vazgeç" /></td>
  </tr>
</table>
</form>
<?php
}else{
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="10" class="listHeader padleft5px" align="center">VİDEOLAR [ <span class="style1"><a href="?do=new" class="yellowlink">YENİ KAYIT EKLE</a></span> ]</td>
  </tr>
  <tr>
    <td width="10%" class="padleft5px listTitle" align="center">VID</td>
    <td width="50%" class="padleft5px listTitle">Başlık </td>
	<td width="15%" class="padleft5px listTitle">Eklenme Tarihi</td>
	<td width="10%" class="padleft5px listTitle" align="center">Durum </td>
    <td width="15%" class="padleft5px listTitle">İşlemler </td>
  </tr>
  <?php
  $i=0;
  $query = $db->write_query("select count(vid) as total from videolar");
  $row=$db->sql_fetcharray($query);
  $videolar_count=$row[total];
  
  $query = $db->write_query("select vid, baslik, tarih, durum from videolar order by
  tarih desc limit $start,$limit");
  
  while($row=$db->sql_fetcharray($query)){
  if($i%2==0) $class = "listOdd"; else $class = "listEven";
  
  
  ?>
  <tr class="<?=$class?>">
     <td class="padleft5px" align="center"><?php echo $row[vid];?></td>
    <td class="padleft5px"><?php echo stripslashes($row[baslik]);?> </td>
	 <td class="padleft5px"><?php echo date("d.m.Y H:i",$row[tarih]);?></td>
	<td class="padleft5px" align="center"><?php echo active_passive($row[durum]);?></td>
    <td class="padleft5px">
	<img src="images/edit.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="videolar.php?do=edit&vid=<?=$row[vid]?>">Düzenle</a> &nbsp;|&nbsp;
	<img src="images/delete.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="videolar.php?do=delete&vid=<?=$row[vid]?>">Sil</a> </td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<?php
}

if($videolar_count>$limit){?>
<div id="page_nav"><?php
echo generate_pagination("videolar.php?do", $videolar_count, $limit, $start);?></div>
<?php
}
include "footer.php";
?>
</body>
</html>