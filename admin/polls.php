<?php

	$modul_no = 6;

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ İncler Yapılıyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";

	$limit = 15;
	
	$do = trim($_GET['do']) ? addslashes(trim($_GET['do'])) : addslashes(trim($_POST['do'])) ;
	$start = ( isset($_GET['start']) ) ? intval($_GET['start']) : 0;
	$poll_id = ( isset($_GET['poll_id']) ) ? intval($_GET['poll_id']) : intval($_POST['poll_id']);
	$cat_headline = trim($_GET['do'] == "edit") ? "ANKET DÜZENLE" : "ANKET EKLE";
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
$query = $db->read_query("select poll_title from polls where poll_id = $poll_id");
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
	<b>DİKKAT:</b> <b><i><?=$row[poll_title]?></i></b> adlı kayıtı silmek üzeresiniz.<br /><br />
	Kayıt Silindiğinde Kayıta ait tüm bilgilerde silinecektir.<br />
	<br />Devam Etmek İstiyor musunuz?<br /><br /><a href="polls.php">[ Hayır ]</a> | <a href="polls.php?do=delete&poll_id=<?=$poll_id?>&del_ok=yes">[ Evet ]</a>
	<?php
	}elseif($del == "yes"){
	
	$db->write_query("delete from polls where poll_id = ".$poll_id."");
	
	?>
	<b>Kayıtlar Silindi.</b><p>
	<a href="polls.php">Sayfaya Dönmek İçin Tıklayınız.</a>
	<?php
	}
	?>
	</td>
  </tr>

</table>

<?php
}elseif( isset($_POST['save']) ){

	$poll_title 		= addslashes(trim($_POST['poll_title']));
	$questions			= str_replace("\r\n","|",addslashes(trim($_POST['questions'])));
	$answers			= str_replace("\r\n","|",addslashes(trim($_POST['answers'])));
	
	$question_count 	= count(explode("|",$questions));
	$answer_count 		= count(explode("|",$answers));
	
	$date = time();
	
	$sql = ($do != "edit" ) ? "INSERT INTO polls
	(
	poll_title,questions,answers,date
	)
	VALUES
	(
	'$poll_title',
	'$questions',
	'$answers',
	'$date'
	)" :
	"UPDATE polls set
	poll_title = '$poll_title',
	questions = '$questions',
	answers = '$answers'
	where poll_id=".$poll_id;

?>
	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  		<tr>
   		  <td colspan="2" class="listHeader padleft5px" align="center">Bilgilendirme</td>
  		</tr>
  		<tr>
    	  <td class="row5px listEven" align="center">
			<?php
			if(!$poll_title || !$questions || !$answers){	
			?>
			Lütfen Geri dönüp gerekli alanları doldurunuz.<br /><br /><a href="javascript:history.back();">Geri</a>
			<?php
			}elseif($question_count != $answer_count){	
			?>
			Seçenek Sayınız ile Cevap Sayınız birbirini Tutmuyor<br /><br /><a href="javascript:history.back();">Geri</a>
			<?php
			}else{

			$db->write_query($sql) or die($db->sql_error());

			?>
			<b>İşleminiz Gerçekleştirildi.</b><p>
			<a href="polls.php">Lütfen Bekleyiniz... Sayfaya Yönlendiriliyorsunuz.</a>
			<meta http-equiv="Refresh" content="2; polls.php" />
			<?php
			}
			?>
		  </td>
  		</tr>
	</table>
<?php
}elseif($do == "new" || $do == "edit"){

if($do == "edit"){
	$query = $db->read_query("select poll_title, questions, answers from polls where poll_id = $poll_id");
	$row = $db->sql_fetcharray($query);
	}
?>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="addForm">
<input type="hidden" value="<?=$poll_id?>" name="poll_id" />
<input type="hidden" value="<?=$do?>" name="do" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center"><?=$cat_headline?></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Anket Sorusu :</b></td>
    <td class="row5px listOdd"><input name="poll_title" value="<?=stripslashes($row[poll_title])?>" type="text" size="70" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Seçenekler :</b></td>
    <td class="row5px listOdd"><textarea cols="70" name="questions" rows="5"><?php echo str_replace("|","\r\n",$row[questions]);?></textarea>
      ENTER'e basarak yeni seçenek girebilirsiniz </td>
  </tr>
   <tr>
    <td class="row5px listEven"><b>Cevaplar :</b></td>
    <td class="row5px listOdd"><textarea cols="70" name="answers" rows="5"><?php echo str_replace("|","\r\n",$row[answers]);?></textarea>      
      ENTER'e basarak yeni cevap girebilirsiniz </td>
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
    <td colspan="5" class="listHeader padleft5px" align="center">ANKETLER [ <span class="style1"><a href="?do=new" class="yellowlink">YENİ KAYIT EKLE</a></span> ]</td>
  </tr>
  <tr>
    <td width="10%" class="padleft5px listTitle" align="center">Anket ID</td>
    <td width="50%" class="padleft5px listTitle">Anket Sorusu</td>
	<td width="20%" class="padleft5px listTitle">Tarih</td>
    <td width="20%" class="padleft5px listTitle">İşlemler </td>
  </tr>
  <?php
  $i=0;
  $query = $db->write_query("select count(poll_id) as total from polls");
  $row=$db->sql_fetcharray($query);
  $polls_count=$row[total];
  
  $query = $db->write_query("select poll_id, poll_title, date from polls order by date desc limit
  $start,$limit");
  
  while($row=$db->sql_fetcharray($query)){
  if($i%2==0) $class = "listOdd"; else $class = "listEven";
  
  ?>
  <tr class="<?=$class?>">
    <td class="padleft5px" align="center"><?php echo $row[poll_id];?></td>
    <td class="padleft5px"><?php echo stripslashes($row[poll_title]);?></td>
	<td class="padleft5px"><?php echo date("d.m.Y H:i",$row[date]);?></td>
	<td class="padleft5px">
	<img src="images/edit.gif" width="17" height="17" align="absmiddle"> 
	<a class="blacklink" href="polls.php?do=edit&poll_id=<?=$row[poll_id]?>">Düzenle</a> &nbsp;|&nbsp;
	<img src="images/delete.gif" width="17" height="17" align="absmiddle"> 
	<a class="blacklink" href="polls.php?do=delete&poll_id=<?=$row[poll_id]?>">Sil</a> </td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<?php
}

if($polls_count>$limit){?>
<div id="page_nav"><?php
echo generate_pagination("polls.php?do", $polls_count, $limit, $start);?></div>
<?php
}
include "footer.php";
?>
</body>
</html>