<?php

	$modul_no = 0;

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ İncler Yapılıyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Yazar | <?=$settings['site_title']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<link rel="stylesheet" href="images/style.css" type="text/css" />
<script type="text/javascript" src="javascripts/dolphin.js"></script>
<style>
BODY{
margin:0px;
}
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="header">
		<div id="header_login"><b>Hoşgeldin</b><span class="menu_title"><b> <?=$login_name?> (<?php echo $login_username;?>);</b></span><br />
		  Son Giriş Tarihiniz : <?php if($login_lastvisit){ echo date("d.m.Y, H:i",$login_lastvisit); } else { echo "--";}?><br />
		  <a href="logout.php" target="_top" class="yellowlink"><strong>Sistemden Çıkış</strong></a></div>
		<img src="images/logo.jpg" width="250" height="60" /></td>
      </tr>
	  <tr>
        <td><div id="dolphincontainer">
	<div id="dolphinnav">
	<ul>
	<li><a target="main" href="javascript:;" rel="home"><span>ANA SAYFA </span></a></li>
	<li><a target="main" href="javascript:;" rel="actions"><span>İŞLEMLERİNİZ </span></a></li>
	</ul>
	</div>
	
	<!-- Sub Menus container. Do not remove -->
	<div id="dolphin_inner">
	<div id="home" class="innercontent">
	<a target="main" href="home.php">Yazar Paneli Ana Sayfa</a> | <a target="_blank" href="../index.php" >Site Ana Sayfası</a>	</div>
	

	<div id="actions" class="innercontent">
	<a href="articles.php" target="main">Köşe Yazılarınız</a> &nbsp;|&nbsp; <a href="articles.php?do=new" target="main">Köşe Yazısı Ekle</a> &nbsp;|&nbsp; <a href="article_comments.php" target="main">Köşe Yazısı Yorumları</a>
	</div>


	<!-- End Sub Menus container -->
	</div>

	</div>
<script type="text/javascript">
//dolphintabs.init("ID_OF_TAB_MENU_ITSELF", SELECTED_INDEX)
dolphintabs.init("dolphinnav", 1)
</script></td>
      </tr>
	  </table>

</body>
</html>
	 
 


