<?php
	
	$modul_no = 2;
	
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ İncler Yapılıyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";

	$limit = 15;
	
	$do 			= trim($_GET['do']) ? addslashes(trim($_GET['do'])) : addslashes(trim($_POST['do'])) ;
	$start 			= ( isset($_GET['start']) ) ? intval($_GET['start']) : 0;
	$id 			= ( isset($_GET['id']) ) ? intval($_GET['id']) : intval($_POST['id']);
	$menu_headline 	= trim($_GET['do'] == "edit") ? "MENÜ DÜZENLE" : "MENÜ EKLE";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Admin | <?=$site_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<link rel="stylesheet" href="images/style.css" type="text/css" />
<script type="text/javascript" src="javascripts/functions.js"></script><style>
BODY{
margin:6px;
}
.style1 {color: #FFCC00}
</style>
</head>

<body>
<?php

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~ Sıralamayı Sıfırla ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//

	if($do == "fixorder"){
	
		$query=$db->write_query("select line, id from menu order by line asc");
		$i=1;
		while($row=$db->sql_fetcharray($query)){
		$db->write_query("update menu set line = '$i' where id = '".$row[id]."'");
		$i++;
		}

		Header("location: menu.php");
		die();

	
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~ Sıralama ~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	}elseif($do == "order"){

		$menu_order = intval($_GET['menu_order']);
		$new_order = intval($_GET['new_order']);
		
		$db->write_query("
							UPDATE menu SET line = '$menu_order'
							WHERE id = $new_order
							");
		$db->write_query("
							UPDATE menu SET line = '$new_order'
							WHERE id = $id
							");
		
		Header("location: menu.php");
		die();
	
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~ Silme  ~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	}elseif($do=="delete"){
	
		$del = addslashes(trim($_GET['del_ok']));
		$query = $db->read_query("select name from menu where id = $id");
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
	<b>DİKKAT:</b> <b><i><?=$row[name]?></i></b> adlı menüyü silmek üzeresiniz.<br /><br />
	<br />Devam Etmek İstiyor musunuz?<br /><br /><a href="menu.php">[ Hayır ]</a> | <a href="menu.php?do=delete&id=<?=$id?>&del_ok=yes">[ Evet ]</a>
	<?php
	}elseif($del == "yes"){
		$db->write_query("delete from menu where id = ".$id."");
		
	?>
	<b>Kayıtlar Silindi.</b><p>
	<a href="menu.php">Sayfaya Dönmek İçin Tıklayınız.</a>
	<?php
	}
	?>
	</td>
  </tr>

</table>
	<?php		
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~ Kaydetme ~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//	
	
	}elseif( isset($_POST['save']) ){
		
		$name 	= addslashes(trim($_POST['name']));
		$url	= addslashes(trim($_POST['url']));
		$target = addslashes(trim($_POST['target']));
		$style 	= addslashes(trim($_POST['style']));
	
		$query = $db->read_query("
									SELECT line
									FROM menu
									ORDER BY line DESC
									LIMIT 1");
									
		$row=$db->sql_fetcharray($query);
		$order = intval($row[line]);
		$order++;
		
		$sql = ($do != "edit" ) ? "
									INSERT INTO menu
									(name,url,target,style,line)
									VALUES('$name','$url','$target','$style','$order')
									" : "
									UPDATE menu	SET 
									name = '$name',
									url = '$url', 
									target = '$target', 
									style = '$style' 
									WHERE id=".$id;		

	?>
		
	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  		<tr>
   		  <td colspan="2" class="listHeader padleft5px" align="center">Bilgilendirme</td>
  		</tr>
  		<tr>
    	  <td class="row5px listEven" align="center">
			<?php
			if(!$name || !$url || !$target || !$style ){	
			?>
			Lütfen Geri dönüp gerekli alanları doldurunuz.<br /><br /><a href="javascript:history.back();">Geri</a>
			<?php
			}else{

			$db->write_query($sql) or die($db->sql_error());

			?>
			<b>İşleminiz Gerçekleştirildi.</b><p>
			<a href="menu.php">Lütfen Bekleyiniz... Sayfaya Yönlendiriliyorsunuz.</a>
			<meta http-equiv="Refresh" content="2; menu.php" />
			<?php
			}
			?>
		  </td>
  		</tr>
	</table>
		
<?php

}elseif($do=="new" || $do=="edit"){

	if($do=="edit"){

	$query = $db->read_query("
								SELECT id, name, url, target, style
								FROM menu
								WHERE id = $id
								");
								
	$row = $db->sql_fetcharray($query);

	}
?>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" value="<?=$do?>" name="do" />
<input type="hidden" value="<?=$id?>" name="id" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center"><?php echo $menu_headline;?></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Menü Adı :</b></td>
    <td class="row5px listOdd"><input name="name" type="text" id="name" value="<?php echo stripslashes($row[name])?>" size="50" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>URL Adresi   :</b></td>
    <td class="row5px listOdd"><input name="url" type="text" id="url" value="<?php echo stripslashes($row[url])?>" size="70" />
      Dışarı Link Verecekseniz http:// ile başlayın </td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Target  :</b></td>
    <td class="row5px listOdd"><select name="target" id="target">
      <option value="_self" <?php if($row[target]=="_self") echo "selected";?>>Aynı Pencerede</option>
      <option value="_blank" <?php if($row[target]=="_blank") echo "selected";?>>Yeni Pencere</option>
        </select></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Stil   :</b></td>
    <td class="row5px listOdd"><select name="style" id="style">
      <option value="parent" <?php if($row[style]=="parent") echo "selected";?>>Ana Menü Stili</option>
      <option value="parent1" <?php if($row[style]=="parent1") echo "selected";?>>Alt Menü Stili</option>
    </select>
    </td>
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
    <td colspan="9" class="listHeader padleft5px" align="center">MENÜLER [ <span class="style1"><a href="?do=new" class="yellowlink">YENİ KAYIT EKLE</a></span> ] </td>
  </tr>
  <tr>
    <td width="6%" class="padleft5px listTitle" align="center">Menü ID</td>
    <td width="15%" class="padleft5px listTitle">Menü Adı </td>
	<td width="30%" class="padleft5px listTitle">URL Adresi </td>
	<td width="9%" class="padleft5px listTitle">Target</td>
	<td width="15%" class="padleft5px listTitle" align="center">Menü Sıra</td>
	<td width="11%" class="padleft5px listTitle" align="center">Stil</td>
    <td width="14%" class="padleft5px listTitle">İşlemler </td>
  </tr>
  <?php
  $i=0;
  $query = $db->write_query("select count(id) as total from menu");
  $row=$db->sql_fetcharray($query);
  $total_menu=$row[total];
  
  $query = $db->write_query("select id, name, url, target, style, line from menu order by line asc limit $start,$limit");
  
  while($row=$db->sql_fetcharray($query)){
  if($i%2==0) $class = "listOdd"; else $class = "listEven";
  
  $order1 = $row[line] - 1;
  $order2 = $row[line] + 1;
  ?>
  <tr class="<?=$class?>">
    <td class="padleft5px" align="center"><?php echo $row[id];?></td>
    <td class="padleft5px"><b><?php echo stripslashes($row[name]);?></b> </td>
	<td class="padleft5px"><?php echo stripslashes($row[url]);?></td>
	<td class="padleft5px" align="center"><?php if($row[target]=="_self") echo "Aynı Pencere"; else echo "Yeni Pencere";?></td>
	<td class="padleft5px" align="center">
	<?php if($order1>0){?><a href="menu.php?do=order&menu_order=<?=$row[line]?>&new_order=<?=$order1?>&id=<?=$row[id]?>">
	<img src="images/sort0.png"  border="0" align="absmiddle"/> Yukarı</a><?php } ?>
	<?php if($order2>0 && $row[line]<$total_menu ){?><a href="menu.php?do=order&menu_order=<?=$row[line]?>&new_order=<?=$order2?>&id=<?=$row[id]?>">
	<img src="images/sort1.png"  border="0" align="absmiddle"/> Aşağı</a><?php } ?></td>
	<td align="center" class="padleft5px"><?php if($row[style]=="parent") echo "Ana Menü Stili"; else echo "Alt Menü Stili";?></td>
    <td class="padleft5px">
	<img src="images/edit.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="menu.php?do=edit&id=<?=$row[id]?>">Düzenle</a> &nbsp;|&nbsp;
	<img src="images/delete.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="menu.php?do=delete&id=<?=$row[id]?>">Sil</a> </td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<div style="float:right; padding:3px;"><a class="active-link" href="menu.php?do=fixorder">Menü Sıralarını Düzelt</a></div>
<?php
}

if($total_menu>$limit){?>
<div id="page_nav"><?php
echo generate_pagination("menu.php?do", $total_menu, $limit, $start);?></div>
<?php
}?>
<?php
include "footer.php";
?>
</body>
</html>