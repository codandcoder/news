<?php

	$modul_no = 3;
	
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ �ncler Yap�l�yor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";

	$limit = 15;
	
	$do = trim($_GET['do']) ? addslashes(trim($_GET['do'])) : addslashes(trim($_POST['do'])) ;
	$start = ( isset($_GET['start']) ) ? intval($_GET['start']) : 0;
	$cid = ( isset($_GET['cid']) ) ? intval($_GET['cid']) : intval($_POST['cid']);
	$cat_headline = trim($_GET['do'] == "edit") ? "KATEGOR� D�ZENLE" : "KATEGOR� EKLE";
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

	if($do == "fixorder"){
	
		$query=$db->write_query("select cat_order,cid from cats order by cat_order asc");
		$i=1;
		while($row=$db->sql_fetcharray($query)){
			$db->write_query("update cats set cat_order = '$i' where cid = '".$row[cid]."'");
			$i++;
		}
		
		Header("location:cats.php");
	
	}elseif($do == "order"){

		$cat_order = intval($_GET['cat_order']);
		$new_order = intval($_GET['new_order']);
		
		$db->write_query("update cats set cat_order = '$cat_order' where cat_order = $new_order");
		$db->write_query("update cats set cat_order = '$new_order' where cid = $cid");
		
		Header("location:cats.php");

	}elseif($do=="delete"){
	
		$del = addslashes(trim($_GET['del_ok']));
		$query = $db->read_query("select category from cats where cid = $cid");
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
	<b>D�KKAT:</b> <b><i><?=$row[category]?></i></b> adl� kategoriyi silmek �zeresiniz.<br /><br />
	Kategori Silindi�inde kategoriye ait t�m bilgilerde silinecektir.<br />
	<br />Devam Etmek �stiyor musunuz?<br /><br /><a href="cats.php">[ Hay�r ]</a> | <a href="cats.php?do=delete&cid=<?=$cid?>&del_ok=yes">[ Evet ]</a>
	<?php
	}elseif($del == "yes"){
		$query = $db->write_query("select id from news where cid = $cid");
		while($row = $db->sql_fetcharray($query))
			{
				$db->write_query("delete from news where id = ".$row[id]."");
				$db->write_query("delete from comments where id = ".$row[id]." and type = 'news'");
			}
		$db->write_query("delete from cats where cid = ".$cid."");
		
	?>
	<b>Kay�tlar Silindi.</b><p>
	<a href="cats.php">Sayfaya D�nmek ��in T�klay�n�z.</a>
	<?php
	}
	?>
	</td>
  </tr>

</table>

<?php
}elseif( isset($_POST['save']) ){

	$category 	= addslashes(trim($_POST['category']));
	$home		= addslashes(trim($_POST['home']));
	
	$query = $db->read_query("select cat_order from cats order by cat_order desc limit 1");
	$row=$db->sql_fetcharray($query);
	$order = intval($row[cat_order]);
	$order++;
	
	$sql = ($do != "edit" ) ? "
								INSERT INTO cats
								(category,home,cat_order)
								VALUES('$category','$home','$order')
								" :	"
								UPDATE cats SET
								category = '$category',
								home = '$home'
								WHERE cid=".$cid;

	?>
	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  		<tr>
   		  <td colspan="2" class="listHeader padleft5px" align="center">Bilgilendirme</td>
  		</tr>
  		<tr>
    	  <td class="row5px listEven" align="center">
			<?php
			if(!$category){	
			?>
			L�tfen Geri d�n�p gerekli alanlar� doldurunuz.<br /><br /><a href="javascript:history.back();">Geri</a>
			<?php
			}else{

			$db->write_query($sql) or die($db->sql_error());

			?>
			<b>��leminiz Ger�ekle�tirildi.</b><p>
			<a href="cats.php">L�tfen Bekleyiniz... Sayfaya Y�nlendiriliyorsunuz.</a>
			<meta http-equiv="Refresh" content="2;cats.php" />
			<?php
			}
			?>
		  </td>
  		</tr>
	</table>
<?php
}elseif($do == "new" || $do == "edit"){

	if($do == "edit"){
	
		$query = $db->read_query("select category, home from cats where cid = $cid");
		$row = $db->sql_fetcharray($query);
		
	}
?>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" value="<?=$cid?>" name="cid" />
<input type="hidden" value="<?=$do?>" name="do" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center"><?=$cat_headline?></td>
  </tr>
  <tr>
    <td width="30%" class="row5px listEven"><b>Kategori Ad� :</b></td>
    <td width="70%" class="row5px listOdd"><input name="category" value="<?=stripslashes($row[category])?>" type="text" size="70" /></td>
  </tr>
  <tr>
    <td width="30%" class="row5px listEven"><b>Ana Sayfa Ortas�nda G�ster :</b></td>
    <td width="70%" class="row5px listOdd">
	<input <?php if($row[home] == 'Y') echo "checked";?> name="home" type="radio" value="Y" />
      Evet 
      <input <?php if($row[home]=='N' || $row[home] == "") echo "checked";?> name="home" type="radio" value="N" />
      Hay�r</td>
   </tr>
   <tr>
    <td width="30%" class="row5px listEven" align="center"> </td>
    <td width="70%" class="row5px listOdd"><input name="save" type="submit" class="button" id="save" value="Kaydet" />
      <input name="close" type="button" onclick="javascript:window.location='<?=$_SERVER['PHP_SELF']?>'" class="button" id="close" value="Vazge�" /></td>
  </tr>
</table>
</form>
<?php
}else{
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="5" class="listHeader padleft5px" align="center">KATEGOR�LER [ <span class="style1"><a href="?do=new" class="yellowlink">YEN� KAYIT EKLE</a></span> ]</td>
  </tr>
  <tr>
    <td width="10%" class="padleft5px listTitle" align="center">CatID</td>
    <td width="40%" class="padleft5px listTitle">Kategori Ad� </td>
	<td width="15%" class="padleft5px listTitle">Ana Sayfada G�sterim</td>
	<td width="20%" class="padleft5px listTitle" align="center">Kategori S�ra </td>
    <td width="15%" class="padleft5px listTitle">��lemler </td>
  </tr>
  <?php
  $i=0;
  $query = $db->write_query("select count(cid) as total from cats");
  $row=$db->sql_fetcharray($query);
  $cats_count=$row[total];
  
  $query = $db->write_query("select cid, category, cat_order, home from cats order by cat_order asc limit $start,$limit");
  
  while($row=$db->sql_fetcharray($query)){
  if($i%2==0) $class = "listOdd"; else $class = "listEven";
  
  $order1 = $row[cat_order] - 1;
  $order2 = $row[cat_order] + 1;
  
  ?>
  <tr class="<?=$class?>">
     <td class="padleft5px" align="center"><?php echo $row[cid];?></td>
    <td class="padleft5px"><b><?php echo stripslashes($row[category]);?></b> </td>
	 <td class="padleft5px" align="center"><?php if($row[home] == 'Y') echo "G�sterimde"; else echo "G�sterimde De�il";?></td>
	<td class="padleft5px" align="center">
	<?php if($order1>0){?>
	<a href="cats.php?do=order&cat_order=<?=$row[cat_order]?>&new_order=<?=$order1?>&cid=<?=$row[cid]?>">
	<img src="images/sort0.png"  border="0" align="absmiddle"/> Yukar�</a><?php } ?>
	<?php if($order2>0 && $row[cat_order]<$cats_count ){?><a href="cats.php?do=order&cat_order=<?=$row[cat_order]?>&new_order=<?=$order2?>&cid=<?=$row[cid]?>">
	<img src="images/sort1.png"  border="0" align="absmiddle"/> A�a��</a><?php } ?>
	</td>
    <td class="padleft5px">
	<img src="images/edit.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="cats.php?do=edit&cid=<?=$row[cid]?>">D�zenle</a> &nbsp;|&nbsp;
	<img src="images/delete.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="cats.php?do=delete&cid=<?=$row[cid]?>">Sil</a> </td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<div style="float:right; padding:3px;"><a class="active-link" href="cats.php?do=fixorder">Kategori S�ralar�n� D�zelt</a></div>
<?php
}

if($cats_count>$limit){?>
<div id="page_nav"><?php
echo generate_pagination("cats.php?do", $cats_count, $limit, $start);?></div>
<?php
}
include "footer.php";
?>
</body>
</html>