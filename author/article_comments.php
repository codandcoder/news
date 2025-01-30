<?php
	
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ İncler Yapılıyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";

$limit = 15;

$do = trim($_GET['do']) ? addslashes(trim($_GET['do'])) : addslashes(trim($_POST['do'])) ;
$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$comment_id = ( isset($HTTP_GET_VARS['comment_id']) ) ? intval($HTTP_GET_VARS['comment_id']) : intval($HTTP_POST_VARS['comment_id']);
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
$query = $db->read_query("select name from comments where comment_id = $comment_id");
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
	<b>DİKKAT:</b> <b><i><?=$row[name]?></i></b> 'e ait kayıtı silmek üzeresiniz.<br /><br />
	Kayıt Silindiğinde Kayıta ait tüm bilgilerde silinecektir.<br />
	<br />Devam Etmek İstiyor musunuz?<br /><br /><a href="article_comments.php">[ Hayır ]</a> | <a href="article_comments.php?do=delete&comment_id=<?=$comment_id?>&del_ok=yes">[ Evet ]</a>
	<?php
	}elseif($del == "yes"){
	
	$db->write_query("delete from comments where comment_id = ".$comment_id."");
	
	?>
	<b>Kayıtlar Silindi.</b><p>
	<a href="article_comments.php">Sayfaya Dönmek İçin Tıklayınız.</a>
	<?php
	}
	?>
	</td>
  </tr>

</table>

<?php
}elseif( isset($_POST['save']) ){

	$title		 		= addslashes(trim($_POST['title']));
	$email				= addslashes(trim($_POST['email']));
	$name				= addslashes(trim($_POST['name']));
	$comment			= str_replace("\r\n","<br>",addslashes(trim($_POST['comment'])));
	$active				= addslashes(trim($_POST['active']));
	
	
	$sql = "UPDATE comments set
	title = '$title',
	email = '$email',
	name = '$name',
	comment = '$comment',
	active = '$active'
	where comment_id=".$comment_id;

?>
	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  		<tr>
   		  <td colspan="2" class="listHeader padleft5px" align="center">Bilgilendirme</td>
  		</tr>
  		<tr>
    	  <td class="row5px listEven" align="center">
			<?php
			if(!$name || !$email || !$title || !$comment){	
			?>
			Lütfen Geri dönüp gerekli alanları doldurunuz.<br /><br /><a href="javascript:history.back();">Geri</a>
			<?php
			}else{

			$db->write_query($sql) or die($db->sql_error());

			?>
			<b>İşleminiz Gerçekleştirildi.</b><p>
			<a href="article_comments.php">Lütfen Bekleyiniz... Sayfaya Yönlendiriliyorsunuz.</a>
			<meta http-equiv="Refresh" content="2; article_comments.php" />
			<?php
			}
			?>
		  </td>
  		</tr>
	</table>
<?php
}elseif($do == "edit"){


	$query = $db->write_query("select c.comment_id, c.email, c.title, c.comment, c.name, c.ip, c.date, c.active, a.title as
	article_title from comments as c, articles as a where c.id = a.article_id and c.type = 'article' and
	c.comment_id = $comment_id and a.author_id = ".$session_uid."");
	$row = $db->sql_fetcharray($query);

?>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="addForm">
<input type="hidden" value="<?=$comment_id?>" name="comment_id" />
<input type="hidden" value="<?=$do?>" name="do" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center">YORUM DÜZENLE </td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Haber Başlığı   :</b></td>
    <td valign="middle" class="row5px listOdd">&nbsp;<?=stripslashes($row[article_title])?></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Tarih  :</b></td>
    <td class="row5px listOdd">&nbsp;<?=time_to_now($row[date])?></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>IP Adresi   :</b></td>
    <td class="row5px listOdd">&nbsp;<?=$row[ip]?></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Ad Soyad  :</b></td>
    <td class="row5px listOdd"><input name="name" value="<?=stripslashes($row[name])?>" type="text" size="70" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>E-Mail  :</b></td>
    <td class="row5px listOdd"><input name="email" value="<?=stripslashes($row[email])?>" type="text" size="70" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Yorum Başlığı   :</b></td>
    <td class="row5px listOdd"><input name="title" type="text" id="title" value="<?=stripslashes($row[title])?>" size="70" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Yorum :</b></td>
    <td class="row5px listOdd"><textarea name="comment" cols="70" rows="5" id="comment"><?php echo str_replace("<br>","\r\n",stripslashes($row[comment]));?></textarea></td>
  </tr>
   <tr>
    <td class="row5px listEven"><b>Durum :</b></td>
    <td class="row5px listOdd">
	<input <?php if($row[active]=="Y" || $row[active]=="")echo "checked";?> name="active" type="radio" value="Y" />
      Aktif
    <input <?php if($row[active]=="N")echo "checked";?> name="active" type="radio" value="N" />
      Pasif</td>
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
    <td colspan="8" class="listHeader padleft5px" align="center">MAKALE YORUMLARI</td>
  </tr>
  <tr>
    <td width="5%" class="padleft5px listTitle" align="center"> ID</td>
    <td width="25%" class="padleft5px listTitle">Makale </td>
	<td width="20%" class="padleft5px listTitle">Ad Soyad</td>
	<td width="12%" class="padleft5px listTitle">IP</td>
	<td width="15%" class="padleft5px listTitle">Tarih</td>
	<td width="8%" align="center" class="padleft5px listTitle">Onay</td>
    <td width="15%" class="padleft5px listTitle">İşlemler </td>
  </tr>
  <?php
  $i=0;
  $query = $db->write_query("select count(comment_id) as total from comments where type = 'article'");
  $row=$db->sql_fetcharray($query);
  $comments_count=$row[total];
  
  $query = $db->write_query("select c.comment_id, c.name, c.ip, c.date, c.active, a.title from comments as c,
  articles as a where c.id = a.article_id and a.author_id = ".$session_uid." and c.type = 'article' order by c.active desc, c.date desc limit $start,$limit");
  
  while($row=$db->sql_fetcharray($query)){
  if($i%2==0) $class = "listOdd"; else $class = "listEven";
  
  ?>
  <tr class="<?=$class?>">
    <td class="padleft5px" align="center"><?php echo $row[comment_id];?></td>
    <td class="padleft5px"><?php echo stripslashes($row[title]);?></td>
	<td class="padleft5px"><?php echo stripslashes($row[name]);?></td>
	<td class="padleft5px"><?php echo $row[ip];?></td>
	<td class="padleft5px"><?php echo date("d.m.Y H:i",$row[date]);?></td>
	<td class="padleft5px" align="center"><?php echo active_passive($row[active]);?></td>
	<td class="padleft5px">
	<img src="images/edit.gif" width="17" height="17" align="absmiddle"> 
	<a class="blacklink" href="article_comments.php?do=edit&comment_id=<?=$row[comment_id]?>">Düzenle</a> &nbsp;|&nbsp;
	<img src="images/delete.gif" width="17" height="17" align="absmiddle"> 
	<a class="blacklink" href="article_comments.php?do=delete&comment_id=<?=$row[comment_id]?>">Sil</a> </td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<?php
}

if($comments_count>$limit){?>
<div id="page_nav"><?php
echo generate_pagination("article_comments.php?do", $comments_count, $limit, $start);?></div>
<?php
}
include "footer.php";
?>
</body>
</html>