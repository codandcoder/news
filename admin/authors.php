<?php

	$modul_no = 4;

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ İncler Yapılıyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";

	$limit = 15;
	
	$do = trim($_GET['do']) ? addslashes(trim($_GET['do'])) : addslashes(trim($_POST['do'])) ;
	$start = ( isset($_GET['start']) ) ? intval($_GET['start']) : 0;
	$author_id = ( isset($_GET['author_id']) ) ? intval($_GET['author_id']) : intval($_POST['author_id']);
	$author_headline = trim($_GET['do'] == "edit") ? "YAZAR DÜZENLE" : "YAZAR EKLE";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<link rel="stylesheet" href="images/style.css" type="text/css" />
<script language='JavaScript' type='text/javascript' src='javascripts/functions.js'></script>

</head>

<body class="scrollBar">
<?php

	if($do == "fixorder"){
	
		$query=$db->write_query("select author_order,author_id from authors order by author_order asc");
		$i=1;
		while($row=$db->sql_fetcharray($query)){
		$db->write_query("update authors set author_order = '$i' where author_id = '".$row[author_id]."'");
		$i++;
		}
		
		Header("location: authors.php");
	
	}elseif($do == "order"){
	
		$author_order = intval($_GET['author_order']);
		$new_order = intval($_GET['new_order']);
		
		$db->write_query("update authors set author_order = '$author_order' where author_order = $new_order");
		$db->write_query("update authors set author_order = '$new_order' where author_id = $author_id");
		Header("location: authors.php");
	
	}elseif($do=="delete"){
	
		$del = addslashes(trim($_GET['del_ok']));
		$query = $db->read_query("select name from authors where author_id = $author_id");
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
	<b>DİKKAT:</b> <b><i><?=$row[name]?></i></b> adlı yazarı silmek üzeresiniz.<br /><br />
	Yazar Silindiğinde yazara ait tüm bilgilerde silinecektir.<br />
	<br />Devam Etmek İstiyor musunuz?<br /><br /><a href="authors.php">[ Hayır ]</a> | <a href="authors.php?do=delete&author_id=<?=$author_id?>&del_ok=yes">[ Evet ]</a>
	<?php
	}elseif($del == "yes"){
	
		$query = $db->write_query("select article_id from articles where author_id = $author_id");
		while($row = $db->sql_fetcharray($query))
		{
			$db->write_query("delete from comments where id = ".$row[artic_id]." and type = 'article'");
			$db->write_query("delete from articles where article_id = ".$article_id."");
		}
		$db->write_query("delete from authors where author_id = ".$author_id."");
	
	?>
	<b>Kayıtlar Silindi.</b><p>
	<a href="authors.php">Sayfaya Dönmek İçin Tıklayınız.</a>
	<?php
	}
	?>
	</td>
  </tr>

</table>

<?php
}elseif( isset($_POST['save']) ){

	$name 		= addslashes(trim($_POST['name']));
	$email 		= addslashes(trim($_POST['email']));
	$username 	= addslashes(trim($_POST['username']));
	$password 	= addslashes(trim($_POST['password']));
	$image 		= addslashes(trim($_POST['image']));
		
	
	$query = $db->read_query("select author_order from authors order by author_order desc limit 1");
	$row=$db->sql_fetcharray($query);
	$order = intval($row[author_order]);
	$order++;
	
	if($do == "edit"){	
	
		$query = $db->write_query("select count(author_id) as username_exist from authors where username = '$username' 
		and author_id <> '$author_id'");
		$row = $db->sql_fetcharray($query);
		$user_exist = $row[username_exist];
		$db->sql_freeresult($query);
	
		$query = $db->write_query("select count(author_id) as email_exist from authors where email = '$email' 
		and author_id <> '$author_id'");
		$row = $db->sql_fetcharray($query);
		$email_exist = $row[email_exist];
		$db->sql_freeresult($query);
	
	}else{	
	
		$query = $db->write_query("select count(author_id) as username_exist from authors where username = '$username'");
		$row = $db->sql_fetcharray($query);
		$user_exist = $row[username_exist];
		$db->sql_freeresult($query);
	
		$query = $db->write_query("select count(author_id) as email_exist from authors where email = '$email'");
		$row = $db->sql_fetcharray($query);
		$email_exist = $row[email_exist];
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
			if(!$name || !$email || !$username){	
			?>
			Lütfen Geri dönüp gerekli alanları doldurunuz.<br /><br /><a href="javascript:history.go(-1);">Geri</a>
			<?php
			}elseif($do=="new" && $password == ""){	
			?>
			Lütfen Geri dönüp şifreyi giriniz.<br /><br /><a href="javascript:history.go(-1);">Geri</a>
			<?php
			}elseif(!valid_email($email)){	
			?>
			Geçersiz E-Mail Biçimi. Lütfen Tekrar Giriniz.<br /><br /><a href="javascript:history.go(-1);">Geri</a>
			<?php
			}elseif($email_exist){	
			?>
			Bu Email Adresi Daha önceden Kayıtlı.<br /><br /><a href="javascript:history.go(-1);">Geri</a>
			<?php
			}elseif($user_exist){	
			?>
			Bu Kullanıcı Adı Daha önceden Kayıtlı.<br /><br /><a href="javascript:history.go(-1);">Geri</a>
			<?php
			}else{
			
			if(($do != "edit" ) && $password){
			$password = md5($password);
			}elseif(($do == "edit" ) && $password){
			$password = md5($password);
			$add_query = ", password = '$password' ";
			}
			
			$sql = ($do != "edit" ) ? "INSERT INTO authors(name, email, username, password, image,
			author_order) VALUES('$name','$email','$username','$password','$image','$order')" :
			"UPDATE authors set name = '$name', email = '$email', username = '$username', image = '$image'
			".$add_query." where author_id=".$author_id;
			
			$db->write_query($sql) or die($db->sql_error());

			?>
			<b>İşleminiz Gerçekleştirildi.</b><p>
			<a href="authors.php">Lütfen Bekleyiniz... Sayfaya Yönlendiriliyorsunuz.</a>
			<meta http-equiv="Refresh" content="2; authors.php" />
			<?php
			}
			?>
		  </td>
  		</tr>
	</table>
<?php
}elseif($do == "new" || $do == "edit"){

	if($do == "edit"){
		$query = $db->read_query("select name, username, email,image from authors where author_id = $author_id");
		$row = $db->sql_fetcharray($query);
	}
?>
<form method="post" name="addForm" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" value="<?=$author_id?>" name="author_id" />
<input type="hidden" value="<?=$do?>" name="do" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center"><?=$author_headline?></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Adı &amp; Soyadı  :</b></td>
    <td class="row5px listOdd"><input name="name" type="text" id="name" value="<?=stripslashes($row[name])?>" size="70" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>E-Mail Adresi  :</b></td>
    <td class="row5px listOdd"><input name="email" type="text" id="email" value="<?=stripslashes($row[email])?>" size="70" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Kullanıcı Adı :</b></td>
    <td class="row5px listOdd"><input name="username" type="text" id="username" value="<?=stripslashes($row[username])?>" size="30" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Şifre :</b></td>
    <td class="row5px listOdd"><input name="password" type="password" id="password" value="" size="30" /> <?php if($do=="edit") echo " // Değiştirmeyecekseniz Boş Bırakın";?></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Resim :</b></td>
    <td class="row5px listOdd"><input name="image" type="text" id="image" value="<?=stripslashes($row[image])?>" size="30" />&nbsp;<a href="#"  onclick="javascript:Popup('image.php?do=upload&type=authors','',570, 300);">Resim Yükle</a> | <a href="#"  onclick="javascript:Popup('image.php?do=search&type=authors','',570, 300);">Resimlerde Ara</a></td>
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
    <td colspan="7" class="listHeader padleft5px" align="center">YAZARLAR [ <span class="style1"><a href="?do=new" class="yellowlink">YENİ KAYIT EKLE</a></span> ]</td>
  </tr>
  <tr>
    <td width="7%" class="padleft5px listTitle" align="center">A.ID</td>
    <td width="25%" class="padleft5px listTitle">Yazar Adı </td>
	<td width="15%" class="padleft5px listTitle">Kullanıcı Adı </td>
	<td width="25%" class="padleft5px listTitle">E-Mail</td>
	<td width="13%" class="padleft5px listTitle" align="center">Yazar Sıra </td>
    <td width="15%" class="padleft5px listTitle">İşlemler </td>
  </tr>
  <?php
  $i=0;
  $query = $db->write_query("select count(author_id) as total from authors");
  $row=$db->sql_fetcharray($query);
  $authors_count=$row[total];
  
  $query = $db->write_query("select author_id, username, name, author_order, email from authors order by
  author_order asc limit $start,$limit");
  
  while($row=$db->sql_fetcharray($query)){
  if($i%2==0) $class = "listOdd"; else $class = "listEven";
  
  $order1 = $row[author_order] - 1;
  $order2 = $row[author_order] + 1;
  
  ?>
  <tr class="<?=$class?>">
     <td class="padleft5px" align="center"><?php echo $row[author_id];?></td>
    <td class="padleft5px"><b><?php echo stripslashes($row[name]);?></b> </td>
	<td class="padleft5px"><?php echo stripslashes($row[username]);?> </td>
	 <td class="padleft5px"><?php echo stripslashes($row[email]);?></td>
	<td class="padleft5px" align="center">
	<?php if($order1>0){?><a href="authors.php?do=order&author_order=<?=$row[author_order]?>&new_order=<?=$order1?>&author_id=<?=$row[author_id]?>">
	<img src="images/sort0.png"  border="0" align="absmiddle"/> Yukarı</a><?php } ?>
	<?php if($order2>0 && $row[author_order]<$authors_count ){?><a href="authors.php?do=order&author_order=<?=$row[author_order]?>&new_order=<?=$order2?>&author_id=<?=$row[author_id]?>">
	<img src="images/sort1.png"  border="0" align="absmiddle"/> Aşağı</a><?php } ?>	</td>
    <td class="padleft5px">
	<img src="images/edit.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="authors.php?do=edit&author_id=<?=$row[author_id]?>">Düzenle</a> &nbsp;|&nbsp;
	<img src="images/delete.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="authors.php?do=delete&author_id=<?=$row[author_id]?>">Sil</a> </td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<div style="float:right; padding:3px;"><a class="active-link" href="authors.php?do=fixorder">Yazar Sıralarını Düzelt</a></div>
<?php
}

if($authors_count>$limit){?>
<div id="page_nav"><?php
echo generate_pagination("authors.php?do", $authors_count, $limit, $start);?></div>
<?php
}
include "footer.php";
?>
</body>
</html>