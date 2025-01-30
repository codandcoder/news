<?php

	$modul_no = 16;
	
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ İncler Yapılıyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";

	$limit = 15;
	
	$do = trim($_GET['do']) ? addslashes(trim($_GET['do'])) : addslashes(trim($_POST['do'])) ;
	$start = ( isset($_GET['start']) ) ? intval($_GET['start']) : 0;
	$gallery_id = ( isset($_GET['gallery_id']) ) ? intval($_GET['gallery_id']) : intval($_POST['gallery_id']);
	$cat_headline = trim($_GET['do'] == "edit") ? "GALERİ DÜZENLE" : "GALERİ EKLE";
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

	if($do=="delete"){
	
		$del = addslashes(trim($_GET['del_ok']));
		$query = $db->read_query("select title from gallery where gallery_id = $gallery_id");
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
	<b>DİKKAT:</b> <b><i><?=$row[category]?></i></b> adlı galeri silmek üzeresiniz.<br /><br />
	Galeri Silindiğinde galeriye ait tüm bilgilerde silinecektir.<br />
	<br />Devam Etmek İstiyor musunuz?<br /><br /><a href="gallery.php">[ Hayır ]</a> | <a href="gallery.php?do=delete&gallery_id=<?=$gallery_id?>&del_ok=yes">[ Evet ]</a>
	<?php
	}elseif($del == "yes"){
		$query = $db->write_query("select image_id, image from gallery_images where gallery_id = $gallery_id");
		while($row = $db->sql_fetcharray($query))
			{
				@unlink($settings['root_path']."/images/gallery/".$row[image]);
				$db->write_query("delete from gallery_images where image_id = ".$row[image_id]."");
			}
		$db->write_query("delete from gallery where gallery_id = ".$gallery_id."");
		
	?>
	<b>Kayıtlar Silindi.</b><p>
	<a href="gallery.php">Sayfaya Dönmek İçin Tıklayınız.</a>
	<?php
	}
	?>
	</td>
  </tr>

</table>

<?php
}elseif( isset($_POST['save']) ){

	$title 		= addslashes(trim($_POST['title']));
	$short_desc	= addslashes(trim($_POST['short_desc']));

	$sql = ($do != "edit" ) ? "
								INSERT INTO gallery
								(title, short_desc)
								VALUES('$title', '$short_desc')
								" :	"
								UPDATE gallery SET
								title = '$title',
								short_desc = '$short_desc'
								WHERE gallery_id=".$gallery_id;

	?>
	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  		<tr>
   		  <td colspan="2" class="listHeader padleft5px" align="center">Bilgilendirme</td>
  		</tr>
  		<tr>
    	  <td class="row5px listEven" align="center">
			<?php
			if(!$title){	
			?>
			Lütfen Geri dönüp gerekli alanları doldurunuz.<br /><br /><a href="javascript:history.back();">Geri</a>
			<?php
			}elseif(strlen($short_desc)>200){	
			?>
			Açıklama En Fazla 200 Karakter Olabilir.<br /><br /><a href="javascript:history.back();">Geri</a>
			<?php
			}else{

			$db->write_query($sql) or die($db->sql_error());

			?>
			<b>İşleminiz Gerçekleştirildi.</b><p>
			<a href="gallery.php">Lütfen Bekleyiniz... Sayfaya Yönlendiriliyorsunuz.</a>
			<meta http-equiv="Refresh" content="2;gallery.php" />
			<?php
			}
			?>
		  </td>
  		</tr>
	</table>
<?php
}elseif($do == "new" || $do == "edit"){

	if($do == "edit"){
	
		$query = $db->read_query("select title, short_desc from gallery where gallery_id = $gallery_id");
		$row = $db->sql_fetcharray($query);
		
	}
?>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" value="<?=$gallery_id?>" name="gallery_id" />
<input type="hidden" value="<?=$do?>" name="do" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center"><?=$cat_headline?></td>
  </tr>
  <tr>
    <td width="30%" class="row5px listEven"><b>Galeri Adı :</b></td>
    <td width="70%" class="row5px listOdd"><input name="title" type="text" id="title" value="<?=stripslashes($row[title])?>" size="70" /></td>
  </tr>
  <tr>
    <td width="30%" class="row5px listEven"><b>Galeri Açıklama :</b></td>
    <td width="70%" class="row5px listOdd"><textarea name="short_desc" cols="70" rows="4" id="short_desc"><?=stripslashes($row[short_desc])?>
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
    <td colspan="6" class="listHeader padleft5px" align="center">GALERİLER [ <span class="style1"><a href="?do=new" class="yellowlink">YENİ KAYIT EKLE</a></span> ]</td>
  </tr>
  <tr>
    <td width="10%" class="padleft5px listTitle" align="center">Galeri ID </td>
    <td width="30%" class="padleft5px listTitle">Galeri Adı </td>
    <td width="40%" class="padleft5px listTitle">Açıklama</td>
    <td width="20%" class="padleft5px listTitle">İşlemler </td>
  </tr>
  <?php
  $i=0;
  $query = $db->write_query("select count(gallery_id) as total from gallery");
  $row=$db->sql_fetcharray($query);
  $gallery_count=$row[total];
  
  $query = $db->write_query("select gallery_id, title, short_desc from gallery order by gallery_id desc limit $start,$limit");
  
  while($row=$db->sql_fetcharray($query)){
  if($i%2==0) $class = "listOdd"; else $class = "listEven";
  
  ?>
  <tr class="<?=$class?>">
     <td class="padleft5px" align="center"><?php echo $row[gallery_id];?></td>
    <td class="padleft5px"><?php echo stripslashes($row[title]);?></td>
    <td class="padleft5px"><?php echo stripslashes($row[short_desc]);?></td>
    <td class="padleft5px">
	<img src="images/edit.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="gallery.php?do=edit&gallery_id=<?=$row[gallery_id]?>">Düzenle</a> &nbsp;|&nbsp;
	<img src="images/delete.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="gallery.php?do=delete&gallery_id=<?=$row[gallery_id]?>">Sil</a> </td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<?php
}

if($gallery_count>$limit){?>
<div id="page_nav"><?php
echo generate_pagination("gallery.php?do", $gallery_count, $limit, $start);?></div>
<?php
}
include "footer.php";
?>
</body>
</html>