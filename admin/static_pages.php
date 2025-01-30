<?php

	$modul_no = 5;

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ İncler Yapılıyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";

$limit = 15;

$do = trim($_GET['do']) ? addslashes(trim($_GET['do'])) : addslashes(trim($_POST['do'])) ;
$start = ( isset($_GET['start']) ) ? intval($_GET['start']) : 0;
$page_id = ( isset($_GET['page_id']) ) ? intval($_GET['page_id']) : intval($_POST['page_id']);
$page_headline = trim($_GET['do'] == "edit") ? "SAYFA DÜZENLE" : "SAYFA EKLE";

$s_title = trim($_REQUEST['s_title']);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<link rel="stylesheet" href="images/style.css" type="text/css" />
<script language='JavaScript' type='text/javascript' src='javascripts/functions.js'></script>
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
<script type="text/javascript">
   _editor_url = "../htmlarea/";
   _editor_lang = "en";
</script>
<script type="text/javascript" src="../htmlarea/htmlarea.js"></script>
<script type="text/javascript">
var editor = null;
function initEditor() {
  editor = new HTMLArea("detail");

  // comment the following two lines to see how customization works
  editor.generate();
  return false;

  // BEGIN: code that adds a custom button
  // uncomment it to test
  var cfg = editor.config; // this is the default configuration

function insertHTML() {
  var html = prompt("Lütfen HTML Kodunu Giriniz");
  if (html) {
    editor.insertHTML(html);
  }
}
}
HTMLArea.onload = initEditor;

</script>
</head>

<body onLoad="HTMLArea.init();">

<?php

if($do=="delete"){
$del = addslashes(trim($_GET['del_ok']));
$query = $db->read_query("select title from static_pages where page_id = $page_id");
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
	<b>DİKKAT:</b> <b><i><?=$row[title]?></i></b> adlı sayfayı silmek üzeresiniz.<br /><br />
	<br />Devam Etmek İstiyor musunuz?<br /><br /><a href="static_pages.php">[ Hayır ]</a> | <a href="static_pages.php?do=delete&page_id=<?=$page_id?>&del_ok=yes">[ Evet ]</a>
	<?php
	}elseif($del == "yes"){

	$db->write_query("delete from static_pages where page_id = ".$page_id."");
	
	?>
	<b>Kayıtlar Silindi.</b><p>
	<a href="static_pages.php">Sayfaya Dönmek İçin Tıklayınız.</a>
	<?php
	}
	?>
	</td>
  </tr>

</table>

<?php
}elseif( isset($_POST['save']) ){

	$title 		= addslashes(trim($_POST['title']));
	$detail 	= addslashes(trim($_POST['detail']));
	$active 	= addslashes(trim($_POST['active']));
		
	
	$time = time();
		
	$sql = ($do != "edit" ) ? "INSERT INTO static_pages (title, detail, active, date)	VALUES('$title', '$detail', '$active',
	'$time')" :	"UPDATE static_pages set title = '$title', detail = '$detail', active = '$active' where page_id=".$page_id;
?>

	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  		<tr>
   		  <td colspan="2" class="listHeader padleft5px" align="center">Bilgilendirme</td>
  		</tr>
  		<tr>
    	  <td class="row5px listEven" align="center">
			<?php
			if(!$title || !$detail || !$active){	
			?>
			Lütfen Geri dönüp gerekli alanları doldurunuz.<br /><br /><a href="javascript:history.go(-1);">Geri</a>
			<?php
			}else{
			
			$db->write_query($sql) or die($db->sql_error());

			?>
			<b>İşleminiz Gerçekleştirildi.</b><p>
			<a href="static_pages.php">Lütfen Bekleyiniz... Sayfaya Yönlendiriliyorsunuz.</a>
			<meta http-equiv="Refresh" content="2; static_pages.php" />
			<?php
			}
			?>
		  </td>
  		</tr>
	</table>
<?php
}elseif($do == "new" || $do == "edit"){

if($do == "edit"){
	$query = $db->read_query("select title, date, detail, active from static_pages where page_id = $page_id");
	$row = $db->sql_fetcharray($query);
	}
?>
<script>
	function SubmitForm(form){

	if(form.title.value == ""){
			alert("Lütfen Başlık Giriniz");
			form.title.focus();
			return false;
			}
	
	if(form.detail.value == ""){
			alert("Lütfen İçerik Giriniz");
			return false;
			}
	}

</script>

<form method="post" name="addForm" action="<?=$_SERVER['PHP_SELF']?>" onSubmit="return SubmitForm(this);">
<input type="hidden" value="<?=$page_id?>" name="page_id" />
<input type="hidden" value="<?=$do?>" name="do" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center"><?=$page_headline?></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Başlık  :</b></td>
    <td class="row5px listOdd"><input name="title" type="text" id="title" value="<?=stripslashes($row[title])?>" size="70" /></td>
  </tr>
  <tr>
    <td valign="top" class="row5px listEven"><b>Sayfa İçeriği  :</b></td>
    <td class="row5px listOdd" >
			<TEXTAREA id="detail" name="detail" rows=20 cols="50"><?=stripslashes($row[detail])?></TEXTAREA> 
</td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Durumu  :</b></td>
    <td class="row5px listOdd">
	<input <?php if($row[active] == "Y" || $row[active] == "") echo "checked";?> name="active" type="radio" value="Y" />Aktif
  	<input <?php if($row[active] == "N") echo "checked";?> name="active" type="radio" value="N" />Pasif
  </td>
  </tr>
  <tr>
    <td width="30%" class="row5px listEven" align="center"> </td>
    <td width="70%" class="row5px listOdd"><input name="save" type="submit" class="button" id="save" value="Kaydet" />
      <input name="close" type="button" onClick="javascript:window.location='<?=$_SERVER['PHP_SELF']?>'" class="button" id="close" value="Vazgeç" /></td>
  </tr>
</table>
</form>
<?php
}else{
?>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="4" class="listHeader padleft5px" align="center">HEMEN BUL</td>
  </tr>
  <tr>
    <td width="21%" align="left" class="listEven row5px"><strong>Başlık : </strong></td>
    <td width="79%" align="left" class="row5px listOdd"><input name="s_title" type="text" value="<?php echo $s_title;?>" id="s_title" size="70" /></td>
  </tr>
  <tr>
    <td align="left" class="row5px listEven">&nbsp;</td>
    <td align="left" class="row5px listOdd"><input name="search" type="submit" class="button" id="search" value="Kayıtları Listele" />
    <input name="reset" type="reset" class="button" id="reset" value="Temizle" />
    <input name="close2" type="button" onClick="javascript:window.location='<?=$_SERVER['PHP_SELF']?>'" class="button" id="close2" value="Vazgeç" /></td>
  </tr>
</table>
</form>
<div style="height:5px;"></div>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="7" class="listHeader padleft5px" align="center">SAYFALAR [ <span class="style1"><a href="?do=new" class="yellowlink">YENİ KAYIT EKLE</a></span> ]</td>
  </tr>
  <tr>
    <td width="8%" class="padleft5px listTitle" align="center">S.ID</td>
    <td width="50%" class="padleft5px listTitle">Sayfa Başlığı</td>
	<td width="12%" class="padleft5px listTitle" align="center">Durum</td>
	<td width="15%" class="padleft5px listTitle">Tarih</td>
    <td width="15%" class="padleft5px listTitle">İşlemler </td>
  </tr>
  <?php
  
  if($s_title){
   	$add_query = " where title LIKE '%$s_title%'";
  }else{
  	$add_query = "";
  }
  
  $i=0;
  $query = $db->write_query("select count(page_id) as total from static_pages $add_query");
  $row=$db->sql_fetcharray($query);
  $static_pages_count=$row[total];
  
  if(!$static_pages_count){
  	
	echo "<tr>\n";
	echo "  <td class=\"listEven\" align=\"center\" colspan=\"5\">\n";
	echo "   <br>Kayıtlı Veri Bulunamadı.<br><br>";
	echo "	</td>\n";
	echo "</tr>\n";
  
  }
 
 
  $query = $db->write_query("select page_id, title, date, active from static_pages $add_query order by date desc limit $start,$limit");
  
  while($row=$db->sql_fetcharray($query)){
  if($i%2==0) $class = "listOdd"; else $class = "listEven";


  ?>
  <tr class="<?=$class?>">
    <td class="padleft5px" align="center"><?php echo $row[page_id];?></td>
    <td class="padleft5px"><?php echo stripslashes($row[title]);?></td>
	<td class="padleft5px" align="center"><?php echo active_passive($row[active]);?></td>
	<td class="padleft5px"><?php echo date("d.m.Y - H:i",$row[date]);?> </td>
	<td class="padleft5px">
	<img src="images/edit.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="static_pages.php?do=edit&page_id=<?=$row[page_id]?>">Düzenle</a> &nbsp;|&nbsp;
	<img src="images/delete.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="static_pages.php?do=delete&page_id=<?=$row[page_id]?>">Sil</a> </td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<?php
}

if($static_pages_count>$limit){?>
<div id="page_nav"><?php
echo generate_pagination("static_pages.php?s_title=$s_title", $static_pages_count, $limit, $start);?></div>
<?php
}
include "footer.php";
?>
</body>
</html>