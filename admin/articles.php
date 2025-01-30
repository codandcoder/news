<?php

	$modul_no = 9;
	
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ Ýncler Yapýlýyor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";

$limit = 15;

$do = trim($_GET['do']) ? addslashes(trim($_GET['do'])) : addslashes(trim($_POST['do'])) ;
$start = ( isset($_GET['start']) ) ? intval($_GET['start']) : 0;
$article_id = ( isset($_GET['article_id']) ) ? intval($_GET['article_id']) : intval($_POST['article_id']);
$page_headline = trim($_GET['do'] == "edit") ? "KÖÞE YAZISI DÜZENLE" : "KÖÞE YAZISI EKLE";

$title 		= addslashes(trim($_REQUEST['title']));
$author_id	= intval($_REQUEST['author_id']);
$order_type	= trim($_REQUEST['order_type']);
$order 		= trim($_REQUEST['order']);

$start_time	= intval($_GET['start_time']);
$end_time	= intval($_GET['end_time']);

$start_day	= intval($_POST['start_day']);
$start_month= intval($_POST['start_month']);
$start_year	= intval($_POST['start_year']);

$end_day	= intval($_POST['end_day']);
$end_month	= intval($_POST['end_month']);
$end_year	= intval($_POST['end_year']);

$start_time = ( $start_time ) ? $start_time : mktime(0,0,0,$start_month,$start_day,$start_year);
$end_time = ( $end_time ) ? $end_time : mktime(0,0,0,$end_month,$end_day,$end_year);

if($start_time == 943912800 || $start_time == -1) $start_time = "";
if($end_time == 943912800 || $end_time == -1) $end_time = "";

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

<body <? if($do == "new" || $do== "edit"){?> onLoad="HTMLArea.init();"<? } ?>>
<?php

if($do=="delete"){
$del = addslashes(trim($_GET['del_ok']));
$query = $db->read_query("select title from articles where article_id = $article_id");
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
	<b>DÝKKAT:</b> <b><i><?=$row[title]?></i></b> adlý kayýtý silmek üzeresiniz.<br />
	<br />
	<br />Devam Etmek Ýstiyor musunuz?<br /><br /><a href="articles.php">[ Hayýr ]</a> | <a href="articles.php?do=delete&article_id=<?=$article_id?>&del_ok=yes">[ Evet ]</a>
	<?php
	}elseif($del == "yes"){
	
	$db->write_query("delete from comments where id = ".$article_id." and type='article'");
	$db->write_query("delete from articles where article_id = ".$article_id."");
	
	?>
	<b>Kayýtlar Silindi.</b><p>
	<a href="articles.php">Sayfaya Dönmek Ýçin Týklayýnýz.</a>
	<?php
	}
	?>
	</td>
  </tr>

</table>

<?php
}elseif( isset($_POST['save']) ){

	$author_id	= intval(trim($_POST['author_id']));
	$title 		= addslashes(trim($_POST['title']));
	$article 	= addslashes($_POST['detail']);
	
	$day 		= trim($_POST['day']);
	$month 		= trim($_POST['month']);
	$year 		= trim($_POST['year']);
	$hour 		= trim($_POST['hour']);
	$min 		= trim($_POST['min']);
	$sec 		= trim($_POST['sec']);
	
	$active 	= addslashes(trim($_POST['active']));
	
	$time = mktime($hour,$min,$sec,$month,$day,$year);
		
	$sql = ($do != "edit" ) ? "
	INSERT INTO articles
						(
						author_id, title, article, date,
						active
						)
						VALUES
						(
						'".$author_id."',
						'".$title."',
						'".$article."',
						'".$time."',
						'".$active."'
						)" : "
	UPDATE articles set
						author_id = '".$author_id."',
						title = '".$title."',
						article = '".$article."',
						date = '".$time."',
						active = '".$active."'
						where article_id=".$article_id;
?>

	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  		<tr>
   		  <td colspan="2" class="listHeader padleft5px" align="center">Bilgilendirme</td>
  		</tr>
  		<tr>
    	  <td class="row5px listEven" align="center">
			<?php
			
			if(!$author_id || !$title || !$article){	
			?>
			Lütfen Geri dönüp gerekli alanlarý doldurunuz.<br /><br /><a href="javascript:history.go(-1);">Geri</a>
			<?php
			}else{
			
			$db->write_query($sql) or die($db->sql_error());

			?>
			<b>Ýþleminiz Gerçekleþtirildi.</b><p>
			<a href="articles.php">Lütfen Bekleyiniz... Sayfaya Yönlendiriliyorsunuz.</a>
			<meta http-equiv="Refresh" content="2; articles.php" />
			<?php
			}
			?>
		  </td>
  		</tr>
	</table>
<?php
}elseif($do == "new" || $do == "edit"){

if($do == "edit"){
	$query = $db->read_query("
							SELECT author_id, title, article, date, active
							from articles where article_id = $article_id
							");
	$row = $db->sql_fetcharray($query);
	}
	
$time_day 	= isset ($row[date]) ? date("d",$row[date]) : date("d");
$time_month = isset ($row[date]) ? date("m",$row[date]) : date("m");
$time_year 	= isset ($row[date]) ? date("Y",$row[date]) : date("Y");
$time_hour 	= isset ($row[date]) ? date("H",$row[date]) : date("H");
$time_min 	= isset ($row[date]) ? date("i",$row[date]) : date("i");
$time_sec 	= isset ($row[date]) ? date("s",$row[date]) : date("s");
?>
<script>
	function SubmitForm(form){

	if(form.author_id.value == ""){
			alert("Lütfen Yazar Seçiniz");
			form.author_id.focus();
			return false;
			}
			
	if(form.title.value == ""){
			alert("Lütfen Baþlýk Giriniz");
			form.title.focus();
			return false;
			}
			
	if(form.detail.value == ""){
			alert("Lütfen Ýçerik Giriniz");
			return false;
			}
			
	}

</script>

<form method="post" name="addForm" action="<?=$_SERVER['PHP_SELF']?>" onSubmit="return SubmitForm(this);">
<input type="hidden" value="<?=$article_id?>" name="article_id" />
<input type="hidden" value="<?=$do?>" name="do" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center"><?=$page_headline?></td>
  </tr>
  <tr>
    <td colspan="2" class="row5px listOdd">Lütfen Tüm Alanlarý Eksiksiz Doldurunuz </td>
    </tr>
  <tr>
    <td class="row5px listEven"><b>Makale Yazarý :</b></td>
    <td class="row5px listOdd"><select name="author_id" id="author_id" style="width:150px;">
      <option selected="selected">-- Seçiniz --</option>
      <?php
		$a_query = $db->read_query("Select author_id, name from authors order by author_order asc");
		while($a_row = $db->sql_fetcharray($a_query)){
		
		if($row[author_id] == $a_row[author_id]) $select = "selected";else $select = "";
		?>
      <option <?=$select?> value="<?=$a_row[author_id]?>">
        <?=stripslashes($a_row[name])?>
        </option>
      <?php
		}
		?>
        </select></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Baþlýk  :</b></td>
    <td class="row5px listOdd"><input name="title" type="text" id="title" value="<?=stripslashes($row[title])?>" size="70" /></td>
  </tr>
 <tr>
    <td valign="top" class="row5px listEven"><b>Makale Ýçeriði  :</b></td>
    <td class="row5px listOdd">
	<TEXTAREA id="detail" name="detail" rows=20 cols="50"><?=stripslashes($row[article])?></TEXTAREA> 
      	</td>
  </tr>

   <tr>
    <td class="row5px listEven"><b>Tarih  :</b></td>
    <td class="row5px listOdd"><select name="day" id="day">
      <?php for($i=1; $i<32; $i++){
	  if($i<10) $i = "0".$i;?>
      <option <?php if($time_day == $i) echo "selected";?> value="<?=$i?>"><?=$i?></option>
      <?php }?>
    </select>
      <select name="month" id="select2">
        <?php for($i=1; $i<13; $i++){
		if($i<10) $i = "0".$i;
		?>
        <option <?php if($time_month == $i) echo "selected";?> value="<?=$i?>"><?=$i?></option>
        <?php }?>
      </select>
      <select name="year" id="select3">
        <?php for($i=2006; $i<=date("Y"); $i++){?>
        <option <?php if($time_year == $i) echo "selected";?> value="<?=$i?>"><?=$i?></option>
        <?php }?>
      </select>
      <select name="hour" id="select4">
        <?php for($i=0; $i<24; $i++){
		if($i<10) $i = "0".$i;?>
        <option <?php if($time_hour == $i) echo "selected";?> value="<?=$i?>"><?=$i?></option>
        <?php }?>
        </select>
      <select name="min" id="select5">
        <?php for($i=0; $i<60; $i++){
		if($i<10) $i = "0".$i;?>
        <option <?php if($time_min == $i) echo "selected";?> value="<?=$i?>"><?=$i?></option>
        <?php }?>
      </select>
      <select name="sec" id="select6">
        <?php for($i=0; $i<60; $i++){
		if($i<10) $i = "0".$i;?>
        <option <?php if($time_sec == $i) echo "selected";?> value="<?=$i?>"><?=$i?></option>
        <?php }?>
      </select></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Durumu  :</b></td>
    <td class="row5px listOdd">
	<input <?php if($row[active] == "Y" || $row[active] == "") echo "checked";?> name="active" type="radio" value="Y" />Aktif
  	<input <?php if($row[active] == "N") echo "checked";?> name="active" type="radio" value="N" />Pasif  </td>
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
    <td colspan="2" class="listHeader padleft5px" align="center">HEMEN BUL</td>
  </tr>
  <tr>
    <td align="left" class="listEven row5px"><strong>Baþlýk : </strong></td>
    <td align="left" class="row5px listOdd"><input name="title" type="text" value="<?php echo stripslashes($title);?>" id="s_title" size="70" /></td>
  </tr>
  <tr>
    <td align="left" class="listEven row5px"><strong>Yazar : </strong></td>
    <td align="left" class="row5px listOdd">
	<select name="author_id" id="author_id" style="width:150px;">
		<option>-- Hepsi --</option>
      	<?php
		$a_query = $db->read_query("Select name, author_id from authors order by author_order asc");
		while($a_row = $db->sql_fetcharray($a_query)){
		
		if($author_id == $a_row[author_id]) $select = "selected";else $select = "";
		?>
		<option <?=$select?> value="<?=$a_row[author_id]?>"><?=stripslashes($a_row[name])?></option>
		<?php
		}
		?>
    </select></td>
  </tr>
  <tr>
    <td align="left" class="listEven row5px"><strong>Tarih  Aralýðý : </strong></td>
    <td align="left" class="row5px listOdd">
	<select name="start_day" id="start_day">
	  <option value="0" selected="selected">Gün</option>
      <?php for($i=1; $i<32; $i++){
	  if($i<10) $i = "0".$i;
	  if($start_time && (date("d",$start_time) == $i)) $select = "selected"; else $select = ""; 	  
	  ?>
	  <option <?=$select?> value="<?=$i?>"><?=$i?></option>
	  <?php }?>
    </select>
	
	<select name="start_month" id="start_month">
      <option value="0">Ay</option>
      <?php for($i=1; $i<13; $i++){
	  if($i<10) $i = "0".$i;
	  if($start_time && (date("m",$start_time) == $i)) $select = "selected"; else $select = ""; 	  
	  ?>
	  <option <?=$select?> value="<?=$i?>"><?=$i?></option>
	  <?php }?>
    </select>
	
	<select name="start_year" id="start_year">
      <option value="0">Yýl</option>
      <?php for($i=2006; $i<=date("Y"); $i++){
	  if($start_time && (date("Y",$start_time) == $i)) $select = "selected"; else $select = ""; 	  
	  ?>
	  <option <?=$select?> value="<?=$i?>"><?=$i?></option>?>
	  <?php }?>
    </select> 
	ile 
    <select name="end_day" id="end_day">
      <option value="0">Gün</option>
      <?php for($i=1; $i<32; $i++){
	  if($i<10) $i = "0".$i;
	  if($end_time && (date("d",$end_time) == $i)) $select = "selected"; else $select = ""; 	  
	  ?>
	  <option <?=$select?> value="<?=$i?>"><?=$i?></option>
      <?php }?>
    </select>
    <select name="end_month" id="end_month">
      <option value="0">Ay</option>
      <?php for($i=1; $i<13; $i++){
	  if($i<10) $i = "0".$i;
	   if($end_time && (date("m",$end_time) == $i)) $select = "selected"; else $select = ""; 	  
	  ?>
	  <option <?=$select?> value="<?=$i?>"><?=$i?></option>
      <?php }?>
    </select>
    <select name="end_year" id="end_year">
      <option value="0">Yýl</option>
      <?php for($i=2006; $i<=date("Y"); $i++){
	   if($end_time && (date("Y",$end_time) == $i)) $select = "selected"; else $select = ""; 	  
	  ?>
	  <option <?=$select?> value="<?=$i?>"><?=$i?></option>
      <?php }?>
    </select> 
    arasý </td>
  </tr>
  <tr>
    <td width="21%" align="left" class="listEven row5px"><strong>Sýralama  : </strong></td>
    <td width="79%" align="left" class="row5px listOdd">
	<select name="order_type" id="order_type">
	  <option value="article_id">-- Seçiniz --</option>
	  <option <?php if($order_type=="article_id")echo "selected";?> value="article_id">ID</option>
	  <option <?php if($order_type=="date")echo "selected";?> value="date">Tarih</option>
	  <option <?php if($order_type=="active")echo "selected";?> value="active">Durum</option>
 	</select>
	
	<label for="order_asc">
	<input name="order" <?php if($order=="asc")echo "checked";?> id="order_asc" type="radio" value="asc" /> Artan</label>
	<label for="order_desc"><input name="order" <?php if($order=="desc" || $order=="")echo "checked";?> type="radio" id="order_desc" value="desc" /> 
	Azalan</label></td>
  </tr>
  <tr>
    <td align="left" class="row5px listEven">&nbsp;</td>
    <td align="left" class="row5px listOdd"><input name="search" type="submit" class="button" id="search" value="Kayýtlarý Listele" />
    <input name="reset" type="reset" class="button" id="reset" value="Temizle" />
    <input name="close2" type="button" onClick="javascript:window.location='<?=$_SERVER['PHP_SELF']?>'" class="button" id="close2" value="Vazgeç" /></td>
  </tr>
</table>
</form>
<div style="height:5px;"></div>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="9" class="listHeader padleft5px" align="center">KÖÞE YAZILARI  [ <span class="style1"><a href="?do=new" class="yellowlink">YENÝ KAYIT EKLE</a></span> ]</td>
  </tr>
  <tr>
    <td width="5%" class="padleft5px listTitle" align="center">ID</td>
    <td width="17%" class="padleft5px listTitle">Yazar</td>
	<td width="40%" class="padleft5px listTitle">Baþlýk</td>
	<td width="15%" class="padleft5px listTitle">Tarih</td>
	<td width="8%" class="padleft5px listTitle" align="center">Durum</td>
    <td width="15%" class="padleft5px listTitle">Ýþlemler </td>
  </tr>
  <?php
  
  $add_query 	= "";
  
  if($title){
   	$add_query .= " and articles.title LIKE '%$title%' ";
  }
  
  if($author_id){
   	$add_query .= " and articles.author_id=".$author_id;
  }
  
  if($start_time){
   	$add_query .= " and articles.date >=".$start_time;
  }
  
  if($end_time){
   	$add_query .= " and articles.date <= ".$end_time;
  }
  
  
  $add_order 	= "";
  
  if($order_type){
   	$add_order .= " order by articles.".$order_type;
  }else{
  	$add_order .= " order by articles.article_id";
  }
  
  if($order){
   	$add_order .= " ".$order;
  }else{
  	$add_order .= " desc";
  }
  
  $i=0;
  $query = $db->write_query("select count(articles.article_id) as total from articles as articles, authors as authors where articles.author_id = authors.author_id $add_query");
  $row=$db->sql_fetcharray($query) or die($db->sql_error());
  
  $articles_count=$row[total];
  
  if(!$articles_count){
  	
	echo "<tr>\n";
	echo "  <td class=\"listEven\" align=\"center\" colspan=\"10\">\n";
	echo "   <br>Kayýtlý Veri Bulunamadý.<br><br>";
	echo "	</td>\n";
	echo "</tr>\n";
  
  }
 
  $sql = "select 
		articles.article_id, articles.title, articles.date, 
		articles.active,authors.name
		from articles as articles, authors as authors where articles.author_id = authors.author_id
		$add_query $add_order limit $start,$limit
		";
		
  //echo $sql;
  $query = $db->write_query($sql) or die($db->sql_error());;
							
  while($row=$db->sql_fetcharray($query)){
  if($i%2==0) $class = "listOdd"; else $class = "listEven";


  ?>
  <tr class="<?=$class?>">
    <td align="center" class="padleft5px"><?php echo $row[article_id];?></td>
    <td class="padleft5px"><?php echo stripslashes($row[name]);?></td>
	<td class="padleft5px"><?php echo stripslashes($row[title]);?></td>
	<td class="padleft5px"><?php echo date("d.m.Y H:i",$row[date]);?></td>
	<td class="padleft5px" align="center"><?php echo active_passive($row[active]);?></td>
	<td class="padleft5px">
	<img src="images/edit.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="articles.php?do=edit&article_id=<?=$row[article_id]?>">Düzenle</a> &nbsp;|&nbsp;
	<img src="images/delete.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="articles.php?do=delete&article_id=<?=$row[article_id]?>">Sil</a> </td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<?php
}

if($articles_count>$limit){?>
<div id="page_nav"><?php
echo generate_pagination("articles.php?title=".stripslashes($title)."&author_id=$author_id&order_type=$order_type&order=$order&start_time=$start_time&end_time=$end_time", $articles_count, $limit, $start);?></div>
<?php
}

include "footer.php";
?>
</body>
</html>