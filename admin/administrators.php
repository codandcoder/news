<?php

	$modul_no = 7;
	
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ İncler Yapılıyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";

	$limit = 15;
	
	$do = trim($_GET['do']) ? addslashes(trim($_GET['do'])) : addslashes(trim($_POST['do'])) ;
	$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
	$id = ( isset($HTTP_GET_VARS['id']) ) ? intval($HTTP_GET_VARS['id']) : intval($HTTP_POST_VARS['id']);
	$cat_headline = trim($_GET['do'] == "edit") ? "YÖNETİCİ DÜZENLE" : "YÖNETİCİ EKLE";
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

if($session_uid == $id){
	echo "<script>alert('Kendi Kendinizi Silemezsiniz'); document.location.href='".$_SERVER['PHP_SELF']."'</script>\n";
	exit;
}

$query = $db->read_query("select username, name from administrators where id = $id");
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
	<b>DİKKAT:</b> <b><i><?=$row[name]?> ( <?=$row[username]?> )</i></b> adlı kayıtı silmek üzeresiniz.<br /><br />
	Kayıt Silindiğinde Kayıta ait tüm bilgilerde silinecektir.<br />
	<br />Devam Etmek İstiyor musunuz?<br /><br /><a href="administrators.php">[ Hayır ]</a> | <a href="administrators.php?do=delete&id=<?=$id?>&del_ok=yes">[ Evet ]</a>
	<?php
	}elseif($del == "yes"){
	
	$db->write_query("delete from administrators where id = ".$id."");
	
	?>
	<b>Kayıtlar Silindi.</b><p>
	<a href="administrators.php">Sayfaya Dönmek İçin Tıklayınız.</a>
	<?php
	}
	?>
	</td>
  </tr>

</table>

<?php
}elseif( isset($_POST['save']) ){

	$name 			= addslashes(trim($_POST['name']));
	$username 		= addslashes(trim($_POST['username']));
	$email 			= addslashes(trim($_POST['email']));
	$password 		= addslashes(trim($_POST['password']));
	
	$permissions	= array();
	
	foreach($_POST['permissions'] as $perm)
	{
		$permissions[]	= $perm;	
	}
	
	$permissions	= implode(",",$permissions);

	$date = time();
	
	if($do == "edit"){	
	
	$query = $db->write_query("select count(id) as username_exist from administrators where username = '$username' 
	and id <> '$id'");
	$row = $db->sql_fetcharray($query);
	$user_exist = $row[username_exist];
	$db->sql_freeresult($query);

	$query = $db->write_query("select count(id) as email_exist from administrators where email = '$email' 
	and id <> '$id'");
	$row = $db->sql_fetcharray($query);
	$email_exist = $row[email_exist];
	$db->sql_freeresult($query);
	
	}else{	
	
	$query = $db->write_query("select count(id) as username_exist from administrators where username = '$username'");
	$row = $db->sql_fetcharray($query);
	$user_exist = $row[username_exist];
	$db->sql_freeresult($query);

	$query = $db->write_query("select count(id) as email_exist from administrators where email = '$email'");
	$row = $db->sql_fetcharray($query);
	$email_exist = $row[email_exist];
	$db->sql_freeresult($query);
	
	}
	
	if($session_uid != $id) $permission_query = ",permissions = '$permissions'"; else $permission_query = "";
	
	
?>
	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  		<tr>
   		  <td colspan="2" class="listHeader padleft5px" align="center">Bilgilendirme</td>
  		</tr>
  		<tr>
    	  <td class="row5px listEven" align="center">
			<?php
			if(!$name || !$username || !$email){	
			?>
			Lütfen Geri dönüp gerekli alanları doldurunuz.<br /><br /><a href="javascript:history.back();">Geri</a>
			<?php
			}elseif($do!="edit" && !$password){	
			?>
			Lütfen Şifreyi doldurunuz.<br /><br /><a href="javascript:history.go(-1);">Geri</a>
			<?php
			}elseif(!count($permissions)){	
			?>
			Lütfen En Az bir tane yetkili olduğu bölüm seçiniz<br /><br /><a href="javascript:history.back();">Geri</a>
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
			$password_query = ", password = '$password' ";
			}
			
			$sql = ($do != "edit" ) ?   "INSERT INTO administrators
							    (name,username,password,email, permissions)
								VALUES
								(
								'$name',
								'$username',
								'$password',
								'$email',
								'$permissions'								
								)" :
								"UPDATE administrators set
								name = '$name',
								username = '$username',
								email = '$email'
								$permission_query
								$password_query
								where id=".$id;

			$db->write_query($sql) or die($db->sql_error());
			
			if($do=="edit" && $password_query){
			
			Header("Location : login.php");
			
			}

			?>
			<b>İşleminiz Gerçekleştirildi.</b><p>
			<a href="administrators.php">Lütfen Bekleyiniz... Sayfaya Yönlendiriliyorsunuz.</a>
			<meta http-equiv="Refresh" content="2; administrators.php" />
			<?php
			}
			?>
		  </td>
  		</tr>
	</table>
<?php
}elseif($do == "new" || $do == "edit"){

if($do == "edit"){
	$query = $db->read_query("select name, username, email, permissions from administrators where id = $id");
	$row = $db->sql_fetcharray($query);
	}
	$permissions = explode(",",$row[permissions]);

?>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="addForm">
<input type="hidden" value="<?=$id?>" name="id" />
<input type="hidden" value="<?=$do?>" name="do" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center"><?=$cat_headline?></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Ad Soyad  :</b></td>
    <td class="row5px listOdd"><input name="name" type="text" id="name" value="<?=stripslashes($row[name])?>" size="70" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>E-Mail :</b></td>
    <td class="row5px listOdd"><input name="email" type="text" id="email" value="<?=stripslashes($row[email])?>" size="70" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Kullanıcı Adı  :</b></td>
    <td class="row5px listOdd"><input name="username" type="text" id="username" value="<?=stripslashes($row[username])?>" size="40" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Şifre :</b></td>
    <td class="row5px listOdd"><input name="password" type="text" id="password" size="40" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Yetkili Olduğu Bölümler  :</b></td>
    <td class="row5px listOdd" style="width:460px">
	<?php
	
	if($session_uid == $id){
	$disable = "disabled";
	}
	
	$qquery = $db->read_query("
								SELECT name, modul_id, code
								FROM modules
								ORDER BY modul_id ASC
								");
	$i=0;
	while($rrow = $db->sql_fetcharray($qquery)){
	$code = $rrow[code];
	?>
	<div style="width:150px; float:left; height:20px;">
	<label for="modul<?=$i?>"><input type="checkbox" name="permissions[]" value="<?=$rrow[code]?>" id="modul<?=$i?>" <?php if(in_array($code,$permissions)){ echo "checked"; } ?> <?=$disable?>/> <?=stripslashes($rrow[name])?></label>
	</div>
	<?php
	$i++;
	}
	?></td>
  </tr>
   <tr>
    <td width="30%" class="row5px listEven" align="center"> </td>
    <td width="70%" class="row5px listOdd"><input name="save" type="submit" class="button" id="save" value="Kaydet" />
      <input name="close" type="button" onclick="javascript:window.location='<?=$_SERVER['PHP_SELF']?>'" class="button" id="close" value="Vazgeç" />      </td>
  </tr>
</table>
</form>
<?php
}else{
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="8" class="listHeader padleft5px" align="center">YÖNETİCİLER [ <span class="style1"><a href="?do=new" class="yellowlink">YENİ KAYIT EKLE</a></span> ]</td>
  </tr>
  <tr>
    <td width="5%" class="padleft5px listTitle" align="center"> ID</td>
    <td width="15%" class="padleft5px listTitle">Ad Soyad </td>
	<td width="20%" class="padleft5px listTitle">E-Mail</td>
	<td width="10%" class="padleft5px listTitle">Kullanıcı Adı </td>
	<td width="25%" class="padleft5px listTitle">Yetkili Olduğu Bölümler </td>
	<td width="12%" class="padleft5px listTitle">Son Giriş </td>
    <td width="13%" class="padleft5px listTitle">İşlemler </td>
  </tr>
  <?php
  $i=0;
  $query = $db->write_query("select count(id) as total from administrators");
  $row=$db->sql_fetcharray($query);
  $administrators_count=$row[total];
  
  $query = $db->write_query("select id, name, username, email, lastvisit, permissions from administrators order by id asc limit
  $start,$limit");
  
  while($row=$db->sql_fetcharray($query)){
  if($i%2==0) $class = "listOdd"; else $class = "listEven";
  
  $permissions = explode(",",$row[permissions]);
  
  $modules = array();
  
  for($j=0; $j < count($permissions); $j++){
  		
		$qquery = $db->write_query("
									SELECT name
									FROM modules
									WHERE code = ".$permissions[$j]."
									") or die($db->sql_error());
									
		$rrow = $db->sql_fetcharray($qquery);
		$modules[] = stripslashes($rrow[name]);
  }
 
  $modules = implode(", ",$modules);

  ?>
  <tr class="<?=$class?>">
    <td class="padleft5px" align="center"><?php echo $row[id];?></td>
    <td class="padleft5px"><?php echo stripslashes($row[name]);?></td>
	<td class="padleft5px"><?php echo stripslashes($row[email]);?></td>
	<td class="padleft5px"><?php echo stripslashes($row[username]);?></td>
	<td class="padleft5px"><?php echo $modules;?></td>
	<td class="padleft5px"><?php if($row[lastvisit]) echo date("d.m.Y H:i",$row[lastvisit]); else echo "hiç giriş yapmadı.";?></td>
	<td class="padleft5px">
	<img src="images/edit.gif" width="17" height="17" align="absmiddle"> 
	<a class="blacklink" href="administrators.php?do=edit&id=<?=$row[id]?>">Düzenle</a>
	<?php if($session_uid != $row[id]) {?>
	 &nbsp;|&nbsp;
	<img src="images/delete.gif" width="17" height="17" align="absmiddle"> 
	<a class="blacklink" href="administrators.php?do=delete&id=<?=$row[id]?>">Sil</a>
	<?php } ?></td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<?php
}

if($administrators_count>$limit){?>
<div id="page_nav"><?php
echo generate_pagination("administrators.php?do", $administrators_count, $limit, $start);?></div>
<?php
}
include "footer.php";
?>
</body>
</html>