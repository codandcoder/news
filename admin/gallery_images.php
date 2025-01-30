<?php

	$modul_no = 17;

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ İncler Yapılıyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";

$limit = 15;

$do = trim($_GET['do']) ? addslashes(trim($_GET['do'])) : addslashes(trim($_POST['do'])) ;
$start = ( isset($_GET['start']) ) ? intval($_GET['start']) : 0;
$image_id = ( isset($_GET['image_id']) ) ? intval($_GET['image_id']) : intval($_POST['image_id']);
$page_headline = trim($_GET['do'] == "edit") ? "RESİM DÜZENLE" : "RESİM EKLE";


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

<body>
<?php

if($do=="delete"){
$del = addslashes(trim($_GET['del_ok']));
$query = $db->read_query("select title from gallery_images where image_id = $image_id");
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
	<b>DİKKAT:</b> <b><i><?=$row[image_id]?></i></b> nolu resmi silmek üzeresiniz.<br /><br />
	<br />Devam Etmek İstiyor musunuz?<br /><br /><a href="gallery_images.php">[ Hayır ]</a> | <a href="gallery_images.php?do=delete&image_id=<?=$image_id?>&del_ok=yes">[ Evet ]</a>
	<?php
	}elseif($del == "yes"){

	$db->write_query("delete from gallery_images where image_id = ".$image_id."");
	
	?>
	<b>Kayıtlar Silindi.</b><p>
	<a href="gallery_images.php">Sayfaya Dönmek İçin Tıklayınız.</a>
	<?php
	}
	?>
	</td>
  </tr>

</table>

<?php
}elseif( isset($_POST['save']) ){

	$short_desc	= addslashes(trim($_POST['short_desc']));
	$image	 	= addslashes(trim($_POST['image']));
	$gallery_id	= intval(trim($_POST['gallery_id']));
		
	$time = time();
		
	$sql = ($do != "edit" ) ? "INSERT INTO gallery_images (gallery_id, short_desc, image, date)	VALUES('$gallery_id', '$short_desc', '$image', '$time')" : "UPDATE gallery_images set gallery_id = '$gallery_id', short_desc = '$short_desc', image = '$image' where image_id=".$image_id;
?>

	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  		<tr>
   		  <td colspan="2" class="listHeader padleft5px" align="center">Bilgilendirme</td>
  		</tr>
  		<tr>
    	  <td class="row5px listEven" align="center">
			<?php
			if(!$gallery_id || !$image){	
			?>
			Lütfen Geri dönüp gerekli alanları doldurunuz.<br /><br /><a href="javascript:history.go(-1);">Geri</a>
			<?php
			}else{
			
			$db->write_query($sql) or die($db->sql_error());

			?>
			<b>İşleminiz Gerçekleştirildi.</b><p>
			<a href="gallery_images.php">Lütfen Bekleyiniz... Sayfaya Yönlendiriliyorsunuz.</a>
			<meta http-equiv="Refresh" content="2; gallery_images.php" />
			<?php
			}
			?>
		  </td>
  		</tr>
	</table>
<?php
}elseif($do == "new" || $do == "edit"){

if($do == "edit"){
	$query = $db->read_query("select gallery_id, short_desc, image from gallery_images where image_id = $image_id");
	$row = $db->sql_fetcharray($query);
	}
?>

<form method="post" name="addForm" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" value="<?=$image_id?>" name="image_id" />
<input type="hidden" value="<?=$do?>" name="do" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center"><?=$page_headline?></td>
  </tr>
    <tr>
    <td class="row5px listEven"><b>Galeri Seçin :</b></td>
    <td class="row5px listOdd"><select name="gallery_id" id="gallery_id">
      <option selected="selected">-- Seçiniz --</option>
      <?php
		$cat_query = $db->read_query("Select title, gallery_id from gallery order by gallery_id desc");
		while($cat_row = $db->sql_fetcharray($cat_query)){
		
		if($row[gallery_id] == $cat_row[gallery_id]) $select = "selected";else $select = "";
		?>
      <option <?=$select?> value="<?=$cat_row[gallery_id]?>">
        <?=stripslashes($cat_row[title])?>
        </option>
      <?php
		}
		?>
        </select></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Resim  :</b></td>
    <td class="row5px listOdd"><input name="image" type="text" id="image" value="<?=stripslashes($row[image])?>" size="70" />
      &nbsp; <a href="#"  onclick="javascript:Popup('image.php?do=upload&amp;type=gallery','',570, 300);">Resim Yükle</a> | <a href="#"  onclick="javascript:Popup('image.php?do=search&amp;type=gallery','',570, 300);">Resimlerde Ara</a></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Açıklama  :</b></td>
    <td class="row5px listOdd"><textarea name="short_desc" cols="70" rows="4" id="short_desc"><?=stripslashes($row[short_desc])?>
    </textarea></td>
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
    <td colspan="7" class="listHeader padleft5px" align="center">GALERİ RESİMLERİ [ <span class="style1"><a href="?do=new" class="yellowlink">YENİ KAYIT EKLE</a></span> ]</td>
  </tr>
  <tr>
    <td width="10%" class="padleft5px listTitle" align="center">ID</td>
    <td width="20%" class="padleft5px listTitle">Galeri</td>
	<td width="40%" class="padleft5px listTitle">Kısa Açıklama</td>
	<td width="15%" class="padleft5px listTitle">Tarih</td>
    <td width="15%" class="padleft5px listTitle">İşlemler </td>
  </tr>
  <?php
  $i=0;
  $query = $db->write_query("select count(p.image_id) as total from gallery_images as p, gallery as c where p.gallery_id = c.gallery_id");
  $row=$db->sql_fetcharray($query);
  $gallery_images_count=$row[total];
  
  if(!$gallery_images_count){
  	
	echo "<tr>\n";
	echo "  <td class=\"listEven\" align=\"center\" colspan=\"5\">\n";
	echo "   <br>Kayıtlı Veri Bulunamadı.<br><br>";
	echo "	</td>\n";
	echo "</tr>\n";
  
  }
 
 
  $query = $db->write_query("select p.image_id, p.short_desc, p.date, c.title from gallery_images as p, gallery as c
  where p.gallery_id = c.gallery_id order by p.date desc, p.gallery_id desc limit $start,$limit");
  
  while($row=$db->sql_fetcharray($query)){
  if($i%2==0) $class = "listOdd"; else $class = "listEven";


  ?>
  <tr class="<?=$class?>">
    <td class="padleft5px" align="center"><?php echo $row[image_id];?></td>
    <td class="padleft5px"><?php echo stripslashes($row[title]);?></td>
	<td class="padleft5px"><?php echo stripslashes($row[short_desc]);?></td>
	<td class="padleft5px"><?php echo date("d.m.Y - H:i",$row[date]);?> </td>
	<td class="padleft5px">
	<img src="images/edit.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="gallery_images.php?do=edit&image_id=<?=$row[image_id]?>">Düzenle</a> &nbsp;|&nbsp;
	<img src="images/delete.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="gallery_images.php?do=delete&image_id=<?=$row[image_id]?>">Sil</a> </td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<?php
}

if($gallery_images_count>$limit){?>
<div id="page_nav"><?php
echo generate_pagination("gallery_images.php?do", $gallery_images_count, $limit, $start);?></div>
<?php
}
include "footer.php";
?>
</body>
</html>