<?php

	$modul_no = 0;
	
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ İncler Yapılıyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title>Admin Paneli </title>
</head>

<FRAMESET framespacing="0" border="0" frameborder="0" frameborder="no" border="0" rows=118,*>
	<FRAME name=nav marginWidth=0 marginHeight=0 src="header.php" frameBorder=NO noResize scrolling=no>
	<FRAME name=main scrolling="yes" frameborder="0" marginwidth="5" marginheight="5" border="no" src="home.php">
</FRAMESET>

<noframes>
<body>
Tarayıcınız Frame Desteklemiyor
</body>
</noframes></html>
