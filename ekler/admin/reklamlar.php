<?php

	$modul_no = 32;

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ İncler Yapılıyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";

	$limit = 15;
	
	$do = trim($_GET['do']) ? addslashes(trim($_GET['do'])) : addslashes(trim($_POST['do'])) ;
	$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
	$reklamid = ( isset($HTTP_GET_VARS['reklamid']) ) ? intval($HTTP_GET_VARS['reklamid']) : intval($HTTP_POST_VARS['reklamid']);
	$reklam_headline = trim($_GET['do'] == "edit") ? "REKLAM DÜZENLE" : "REKLAM EKLE";
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
		$query = $db->read_query("select baslik from reklamlar where reklamid = $reklamid");
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
	<b>DİKKAT:</b> <b><i><?=$row[baslik]?></i></b> adlı reklamı silmek üzeresiniz.<br /><br />
	<br />Devam Etmek İstiyor musunuz?<br /><br /><a href="reklamlar.php">[ Hayır ]</a> | <a href="reklamlar.php?do=delete&reklamid=<?=$reklamid?>&del_ok=yes">[ Evet ]</a>
	<?php
	}elseif($del == "yes"){

		$db->write_query("delete from reklamlar where reklamid = ".$reklamid."");
	
	?>
	<b>Kayıtlar Silindi.</b><p>
	<a href="reklamlar.php">Sayfaya Dönmek İçin Tıklayınız.</a>
	<?php
	}
	?>
	</td>
  </tr>

</table>

<?php
}elseif( isset($_POST['save']) ){

	$baslik 		= addslashes(trim($_POST['baslik']));
	$bolge 			= addslashes(trim($_POST['bolge']));
	$tip	 		= intval($_POST['tip']);
	$url	 		= addslashes(trim($_POST['url']));
	$dosyaadresi 	= addslashes(trim($_POST['dosyaadresi']));
	$genislik 		= intval($_POST['genislik']);
	$yukseklik 		= intval($_POST['yukseklik']);
	$kod	 		= addslashes(trim($_POST['kod']));
	$durum 			= addslashes(trim($_POST['durum']));
		
	if($do == "edit"){	
	
		$query = $db->write_query("select count(reklamid) as bolgevarmi from reklamlar where bolge = '$bolge' 
		and reklamid <> '$reklamid'");
		$row = $db->sql_fetcharray($query);
		$bolgevarmi = $row[bolgevarmi];
		$db->sql_freeresult($query);
	
	}else{	
	
		$query = $db->write_query("select count(reklamid) as bolgevarmi from reklamlar where bolge = '$bolge'");
		$row = $db->sql_fetcharray($query);
		$bolgevarmi = $row[bolgevarmi];
		$db->sql_freeresult($query);
	
	}
	
?>

	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  		<tr>
   		  <td colspan="2" class="listHeader padleft5px" align="center">Bilgilendirme</td>
  		</tr>
  		<tr>
    	  <td class="row5px listEven" align="center">
			<?php
			if(!$baslik || !$dosyaadresi || !$url || !$bolge || !$tip || !$genislik || !$yukseklik || !$durum){	
			?>
			Lütfen Geri dönüp gerekli alanları doldurunuz.<br /><br /><a href="javascript:history.go(-1);">Geri</a>
			<?php
			}elseif($bolgevarmi){	
			?>
			Bu Bölgede Kayıtlı Reklam Bulunmakta.<br /><br /><a href="javascript:history.go(-1);">Geri</a>
			<?php
			}else{
			
			$sql = ($do != "edit" ) ? "	INSERT INTO reklamlar(baslik, bolge, tip, genislik, yukseklik, dosyaadresi, url, durum, kod, tarih)
										VALUES('$baslik','$bolge','$tip','$genislik','$yukseklik','$dosyaadresi','$url','$durum','$kod','".time()."')"
										:
									  "	UPDATE reklamlar SET
									  	baslik = '$baslik',
										bolge = '$bolge',
										tip = '$tip',
										genislik = '$genislik',
										yukseklik = '$yukseklik',
										dosyaadresi = '$dosyaadresi',
										url = '$url',
										durum = '$durum',
										kod = '$kod'
										WHERE reklamid=".$reklamid;
			
			$db->write_query($sql) or die($db->sql_error());

			?>
			<b>İşleminiz Gerçekleştirildi.</b><p>
			<a href="reklamlar.php">Lütfen Bekleyiniz... Sayfaya Yönlendiriliyorsunuz.</a>
			<meta http-equiv="Refresh" content="2; reklamlar.php" />
			<?php
			}
			?>
		  </td>
  		</tr>
	</table>
<?php
}elseif($do == "new" || $do == "edit"){

	if($do == "edit"){
		$query = $db->read_query("select baslik, bolge, tip, genislik, yukseklik, dosyaadresi, url, durum, kod from reklamlar where reklamid = $reklamid");
		$row = $db->sql_fetcharray($query);
	}
?>
<form method="post" name="addForm" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" value="<?=$reklamid?>" name="reklamid" />
<input type="hidden" value="<?=$do?>" name="do" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center"><?=$reklam_headline?></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Başlık  :</b></td>
    <td class="row5px listOdd"><input name="baslik" type="text" id="baslik" value="<?=stripslashes($row[baslik])?>" size="70" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Bölge :</b></td>
    <td class="row5px listOdd">
	<select name="bolge" id="bolge" style="width:150px;">
      <option selected="selected">-- Seçiniz --</option>
      <?php
		foreach($bolgeler as $k=>$bolge)
		{
		
		if($row[bolge] == $k) $select = "selected";else $select = "";
		?>
      <option <?=$select?> value="<?=$k?>">
      <?=stripslashes($bolge)?>
      </option>
      <?php
		}
		?>
    </select></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Reklam Tipi  :</b></td>
    <td class="row5px listOdd"><select name="tip" id="tip" style="width:100px;">
      <option selected="selected">-- Seçiniz --</option>
      <?php
		foreach($reklamtip as $k=>$tip)
		{
		
		if($row[tip] == $k) $select = "selected";else $select = "";
		?>
      <option <?=$select?> value="<?=$k?>">
      <?=stripslashes($tip)?>
      </option>
      <?php
		}
		?>
    </select></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Reklam Dosyası   :</b></td>
    <td class="row5px listOdd"><input name="dosyaadresi" type="text" id="dosyaadresi" value="<?=stripslashes($row[dosyaadresi])?>" size="70" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Reklam Link   :</b></td>
    <td class="row5px listOdd"><input name="url" type="text" id="url" value="<?=stripslashes($row[url])?>" size="70" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Genişlik x Yükseklik  :</b></td>
    <td class="row5px listOdd"><input name="genislik" type="text" id="genislik" value="<?=intval($row[genislik])?>" size="5" maxlength="4" />
      x
      <input name="yukseklik" type="text" id="yukseklik" value="<?=intval($row[yukseklik])?>" size="5" maxlength="4" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Kod :</b></td>
    <td class="row5px listOdd"><textarea name="kod" cols="70" rows="6" id="kod"><?=stripslashes($row[kod])?></textarea>
// Burayı Reklam Tipini &quot;<strong>Kod</strong>&quot; seçtiyseniz doldurun </td>
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
    <td colspan="10" class="listHeader padleft5px" align="center">REKLAMLAR [ <span class="style1"><a href="?do=new" class="yellowlink">YENİ KAYIT EKLE</a></span> ]</td>
  </tr>
  <tr>
    <td width="7%" class="padleft5px listTitle" align="center">Reklam ID</td>
    <td width="30%" class="padleft5px listTitle">Başlık </td>
	<td width="10%" class="padleft5px listTitle">Bölge </td>
	<td width="10%" class="padleft5px listTitle" align="center">Reklam Tipi </td>
	<td width="8%" class="padleft5px listTitle" align="center">Tıklanma </td>
	<td width="10%" class="padleft5px listTitle">Ek. Tarihi</td>
	<td width="10%" class="padleft5px listTitle" align="center">Durum </td>
    <td width="15%" class="padleft5px listTitle">İşlemler </td>
  </tr>
  <?php
  $i=0;
  $query = $db->write_query("select count(reklamid) as total from reklamlar");
  $row=$db->sql_fetcharray($query);
  $reklamlar_count=$row[total];
  
  $query = $db->write_query("select reklamid, baslik, tip, bolge, tarih, durum, hit from reklamlar order by
  tarih desc limit $start,$limit");
  
  while($row=$db->sql_fetcharray($query)){
  if($i%2==0) $class = "listOdd"; else $class = "listEven";
  
  
  ?>
  <tr class="<?=$class?>">
     <td class="padleft5px" align="center"><?php echo $row[reklamid];?></td>
    <td class="padleft5px"><?php echo stripslashes($row[baslik]);?> </td>
	<td class="padleft5px"><?php echo $bolgeler[$row[bolge]];?> </td>
	 <td class="padleft5px" align="center"><?php echo $reklamtip[$row[tip]];?></td>
	 <td class="padleft5px" align="center"><?php echo intval($row[hit]);?></td>
	 <td class="padleft5px"><?php echo date("d.m.Y H:i",$row[tarih]);?></td>
	<td class="padleft5px" align="center"><?php echo active_passive($row[durum]);?></td>
    <td class="padleft5px">
	<img src="images/edit.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="reklamlar.php?do=edit&reklamid=<?=$row[reklamid]?>">Düzenle</a> &nbsp;|&nbsp;
	<img src="images/delete.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="reklamlar.php?do=delete&reklamid=<?=$row[reklamid]?>">Sil</a> </td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<?php
}

if($reklamlar_count>$limit){?>
<div id="page_nav"><?php
echo generate_pagination("reklamlar.php?do", $reklamlar_count, $limit, $start);?></div>
<?php
}
include "footer.php";
?>
</body>
</html>