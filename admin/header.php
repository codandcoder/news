<?php

	$modul_no = 0;

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ �ncler Yap�l�yor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Admin | <?=$site_title?></title>
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
		<div id="header_login"><b>Ho�geldin</b><span class="menu_title"><b> <?=$login_name?> (<?php echo $login_username;?>);</b></span><br />
		  Son Giri� Tarihiniz : <?php if($login_lastvisit){ echo date("d.m.Y, H:i",$login_lastvisit); } else { echo "--";}?><br />
		  <a href="logout.php" target="_top" class="yellowlink"><strong>Sistemden ��k��</strong></a></div>
		<img src="images/logo.jpg" width="250" height="60" /></td>
      </tr>
	  <tr>
        <td><div id="dolphincontainer">
	<div id="dolphinnav">
	<ul>
	<li><a target="main" href="javascript:;" rel="home"><span>ANA SAYFA </span></a></li>
	<?php
	if(in_array("1",$permissions_list) || in_array("2",$permissions_list) || in_array("3",$permissions_list) || in_array("4",$permissions_list) || in_array("5",$permissions_list) || in_array("6",$permissions_list) || in_array("7",$permissions_list) || in_array("16",$permissions_list) || in_array("17",$permissions_list)){
	?>
	<li><a target="main" href="javascript:;" rel="general_actions"><span>GENEL ��LEMLER </span></a></li>
	<?php
	}
	?>
	<?php
	if(in_array("6",$permissions_list) || in_array("8",$permissions_list) || in_array("9",$permissions_list) || in_array("10",$permissions_list) || in_array("11",$permissions_list)){
	?>
	<li><a target="main" href="javascript:;" rel="text_actions"><span>YAZI ��LEMLER� </span></a></li>
	<?php
	}
	?>
	</ul>
	</div>
	
	<!-- Sub Menus container. Do not remove -->
	<div id="dolphin_inner">
	<div id="home" class="innercontent">
	<a target="main" href="home.php">Y�netim Ana Sayfa</a> | <a target="_blank" href="../index.php" >Site Ana Sayfas�</a>	</div>
	
	<div id="general_actions" class="innercontent">
	<?php
	if(in_array("1",$permissions_list)){
	?>
	<a href="settings.php" target="main">Site Ayarlar�</a> &nbsp;|&nbsp; 
	<?php
	 }
	 ?>
	<?php
	if(in_array("2",$permissions_list)){
	?>
	<a href="menu.php" target="main">Men�ler</a> &nbsp;|&nbsp; 
	<?php
	 }
	 ?>
	<?php
	if(in_array("3",$permissions_list)){
	?>
	<a href="cats.php" target="main">Haber Kategorileri</a> &nbsp;|&nbsp; 
	<?php
	 }
	 ?>
	<?php
	if(in_array("4",$permissions_list)){
	?>
	<a href="authors.php" target="main">Yazarlar</a> &nbsp;|&nbsp; 
	<?php
	 }
	 ?>
	 <?php
	if(in_array("5",$permissions_list)){
	?>
	<a href="static_pages.php" target="main">Sabit Sayfalar</a> &nbsp;|&nbsp; 
	<?php
	 }
	 ?>
	<?php
	if(in_array("6",$permissions_list)){
	?>
	<a href="polls.php" target="main">Anketler</a> &nbsp;|&nbsp; 
	<?php
	 }
	 ?>
	  <?php
	if(in_array("16",$permissions_list)){
	?>
	<a href="gallery.php" target="main">Galeriler</a> &nbsp;|&nbsp; 
	<?php
	 }
	 ?>
	 <?php
	if(in_array("17",$permissions_list)){
	?>
	<a href="gallery_images.php" target="main">Galeri Resimleri</a> &nbsp;|&nbsp; 
	<?php
	 }
	 ?>
	<?php
	if(in_array("7",$permissions_list)){
	?>
	<a href="administrators.php" target="main">Site Y�neticileri</a>
	<?php
	 }
	 ?>
	</div>

	<div id="text_actions" class="innercontent">
	 <?php
	if(in_array("8",$permissions_list)){
	?>
	 <a href="news.php" target="main">Haber Y�netimi</a> &nbsp;|&nbsp; <a href="news.php?do=new" target="main">Haber Ekle</a> &nbsp;|&nbsp; 
	 <?php
	 }
	 ?>
	 <?php
	if(in_array("9",$permissions_list)){
	?><a href="articles.php" target="main">K��e Yaz�lar�</a> &nbsp;|&nbsp; <a href="articles.php?do=new" target="main">K��e Yaz�s� Ekle</a> &nbsp;|&nbsp; 
	<?php
	}
	?>
	<?php
	if(in_array("10",$permissions_list)){
	?>
	<a href="news_comments.php" target="main">Haber Yorumlar�</a> &nbsp;|&nbsp; 
	<?php
	}
	?>
	<?php
	if(in_array("11",$permissions_list)){
	?><a href="article_comments.php" target="main">K��e Yaz�s� Yorumlar�</a> &nbsp;|&nbsp; 
	<?php
	}
	?>
	<?php
	if(in_array("6",$permissions_list)){
	?><a href="poll_comments.php" target="main">Anket Yorumlar�</a>
	<?php
	}
	?>
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
	 
 


