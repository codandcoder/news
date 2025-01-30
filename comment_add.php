<?php
//
// +---------------------------------------------------------------------------+
// | NizipRehber Haber Portalý v1.0 [ nrnews_v1.0 ]                            |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Gereksininimleri   : PHP 4 veya üzeri, GD2+ kütüphanesi                   |
// |                                                                           |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Geliþtirici    	: Mahmut ÖZDEMÝR                                       |
// | E-posta        	: mahmuttt88 {at} yahoo {dot} com                      |
// | Web adresi     	: http://www.mahmutozdemir.org/       	               |
// | Tel		     	: +90 5373622826 / +90 5457604888 / +90 5543184701     |
// |                                                                           |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Copyright (C) 2007                                                        |
// |                                                                           |
// | Bu Yazýlým ÜCRETSÝZ DEÐÝLDÝR. Yazýlýmýn Tüm Haklarý Mahmut ÖZDEMÝR'e      |
// | aittir.															       |
// |                                                                           |
// +---------------------------------------------------------------------------+
//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ Ýncler Yapýlýyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
	
	include("config.php");	
	include("includes/includes.php");
	include("securimage.php");

	$id 	= intval($_REQUEST['id']);
	$type 	= strip_tags($_REQUEST['type']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title><?=$settings['site_title']?> [ Yorum Ekle ] </title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="css/function.js" type=text/javascript></script>
<style>
BODY{
background:#FFFFFF;
}
</style>
</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="40" class="popupTitle">YORUM EKLE</td>
  </tr>
  <tr>
    <td style="padding:10px;">
	
	<?php
	
	$name 			= addslashes(strip_tags($_POST['name']));
	$email 			= addslashes(strip_tags($_POST['email']));
	$title 			= addslashes(strip_tags($_POST['title']));
	$message		= addslashes(strip_tags($_POST['message']));
	$secure_code	= addslashes(strip_tags($_POST['secure_code']));
			
	$img = new Securimage();
  	$security = $img->check($secure_code);
	
	if($_POST['submit']){
		$error = "";
		if(!$name){
		$error .= "<li>Ad & Soyad Girmediniz.</li>";
		}
		if(!$email){
		$error .= "<li>E-Mail Adresinizi Girmediniz.</li>";
		}
		if($email && !valid_email($email)){
		$error .= "<li>Geçersiz E-Mail Adresi.</li>";
		}
		if(!$title){
		$error .= "<li>Mesaj Ýçin Baþlýk Girmediniz.</li>";
		}
		if(!$message){
		$error .= "<li>Mesaj Girmediniz.</li>";
		}
		if($security !=true){
		$error .= "<li>Güvenlik Kodunu Yanlýþ Girdiniz.</li>";
		}
		
		if($error){
		echo "<span style='color:red'>".$error."</span>";
		}else{
		
		$date		= time();
		$active 	= "N"; // Y : Aktif, N : Pasif
		$ip			= $_SERVER['REMOTE_ADDR'];
		
		$db->write_query("
						INSERT INTO comments
						(id, type, title, name, email,
						active, date, comment, ip)
						VALUES
						(
						'".$id."',
						'".$type."',
						'".$title."',
						'".$name."',
						'".$email."',
						'".$active."',
						'".$date."',
						'".$message."',
						'".$ip."'
						)")
						
						or die($db->sql_error());
		
		setcookie("comment_add",$id,time()+300); // 5 dk
						
		echo "<div class=\"divAlert\">Yorumunuz Eklendi.Onaylandýktan Sonra Yayýnlanacaktýr.<br>Ýlginiz için teþekkür ederiz.</div>";
		exit;
		
		}
	}
	
	?>
	<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
	<input type="hidden" name="id" value="<?=$id?>" />
	<input type="hidden" name="type" value="<?=$type?>" />
	<p><strong>Ad Soyad :</strong><br />
        <input name="name" type="text" size="50" value="<?=$name?>" />
      </p>
      <p><strong>E-Mail :</strong><br />
        <input name="email" type="text" size="50" value="<?=$email?>"  />
        </p>
      <p><strong>Baþlýk :</strong><br />
        <input name="title" type="text" size="70" value="<?=$title?>"  />
        </p>
      <p><strong>Mesaj :</strong> <br />
        <textarea name="message" cols="71" rows="5" onkeydown="return textareaCounter(this, 'word_left', 500);" onKeyUp="return textareaCounter(this, 'word_left', 500);"><?=$message?></textarea> 
		<input type="text" name="word_left" id="word_left" value="500" style="width: 25;" readonly="true" size="3">
      </p>
	  <p><strong>Güvenlik Kodu :</strong><br /><img src="securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>" align="absmiddle">
<input name="secure_code" type="text" id="secure_code" size="20" maxlength="7" /></p>
	  <input name="submit" type="submit" class="mainButton" value="Gönder" />
    <input name="reset" type="reset" class="mainButton" id="reset" value="Temizle" />
	</form>
	</td>
  </tr>

</table>
</body>
</html>
<?php
ob_end_flush();
?>