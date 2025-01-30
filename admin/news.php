<?php

	$modul_no = 8;

	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	//~~~~~~~~~~~~~ �ncler Yap�l�yor ~~~~~~~~~//
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
	ob_start();
		
	include "login_check.php";
$limit = 15;

$do = trim($_GET['do']) ? addslashes(trim($_GET['do'])) : addslashes(trim($_POST['do'])) ;
$start = ( isset($_GET['start']) ) ? intval($_GET['start']) : 0;
$id = ( isset($_GET['id']) ) ? intval($_GET['id']) : intval($_POST['id']);
$page_headline = trim($_GET['do'] == "edit") ? "HABER D�ZENLE" : "HABER EKLE";

$title 		= addslashes(trim($_REQUEST['title']));
$cid	 	= intval($_REQUEST['cid']);
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

}
function insertHTML() {
  var html = prompt("L�tfen HTML Kodunu Giriniz");
  if (html) {
    editor.insertHTML(html);
  }
}
HTMLArea.onload = initEditor;

</script>
</head>

<body <? if($do == "new" || $do== "edit"){?> onLoad="HTMLArea.init();"<? } ?>>
<?php

if($do=="delete"){
$del = addslashes(trim($_GET['del_ok']));
$query = $db->read_query("select title from news where id = $id");
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
	<b>D�KKAT:</b> <b><i><?=$row[title]?></i></b> adl� kay�t� silmek �zeresiniz.<br />
	<br />
	<br />Devam Etmek �stiyor musunuz?<br /><br /><a href="news.php">[ Hay�r ]</a> | <a href="news.php?do=delete&id=<?=$id?>&del_ok=yes">[ Evet ]</a>
	<?php
	}elseif($del == "yes"){

	$db->write_query("delete from comments where id = ".$id." and type='news'");
	$db->write_query("delete from news where id = ".$id."");
	
	?>
	<b>Kay�tlar Silindi.</b><p>
	<a href="news.php">Sayfaya D�nmek ��in T�klay�n�z.</a>
	<?php
	}
	?>
	</td>
  </tr>

</table>

<?php
}elseif( isset($_POST['save']) ){

	$cid 		= intval(trim($_POST['cid']));
	$cuff_view 	= addslashes(trim($_POST['cuff_view']));
	$image 		= addslashes(trim($_POST['image']));
	
	$title 		= addslashes($_POST['title']);
	$cuff 		= addslashes($_POST['cuff']);
	$spot 		= addslashes($_POST['spot']);
	$detail 	= addslashes($_POST['detail']);
	$type 		= intval(trim($_POST['type']));
	
	$day 		= trim($_POST['day']);
	$month 		= trim($_POST['month']);
	$year 		= trim($_POST['year']);
	$hour 		= trim($_POST['hour']);
	$min 		= trim($_POST['min']);
	$sec 		= trim($_POST['sec']);
	
	$active 	= addslashes(trim($_POST['active']));
	
	$time = mktime($hour,$min,$sec,$month,$day,$year);
		
	$sql = ($do != "edit" ) ? "
	INSERT INTO news
						(
						cid, title, cuff, cuff_view,
						image, spot, detail, type,
						date, active
						)
						VALUES
						(
						'".$cid."',
						'".$title."',
						'".$cuff."',
						'".$cuff_view."',
						'".$image."',
						'".$spot."',
						'".$detail."',
						'".$type."',
						'".$time."',
						'".$active."'
						)" : "
	UPDATE news set
						cid = '".$cid."',
						title = '".$title."',
						cuff_view = '".$cuff_view."',
						image = '".$image."',
						spot = '".$spot."',
						detail = '".$detail."',
						date = '".$time."',
						active = '".$active."'
						where id=".$id;
?>

	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  		<tr>
   		  <td colspan="2" class="listHeader padleft5px" align="center">Bilgilendirme</td>
  		</tr>
  		<tr>
    	  <td class="row5px listEven" align="center">
			<?php
			
			if(!$cid || !$title || !$spot || !$detail){	
			?>
			L�tfen Geri d�n�p gerekli alanlar� doldurunuz.<br /><br /><a href="javascript:history.go(-1);">Geri</a>
			<?php
			}elseif(strlen($spot)>200){	
			?>
			Spot En Fazla 200 Karakter Olabilir.<br /><br /><a href="javascript:history.go(-1);">Geri</a>
			<?php
			}else{
			
			$db->write_query($sql) or die($db->sql_error());

			?>
			<b>��leminiz Ger�ekle�tirildi.</b><p>
			<a href="news.php">L�tfen Bekleyiniz... Sayfaya Y�nlendiriliyorsunuz.</a>
			<meta http-equiv="Refresh" content="2; news.php" />
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
							SELECT cid, title, cuff_view, cuff, type,
							image, spot, detail, date, active
							from news where id = $id
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

	if(form.cid.value == ""){
			alert("L�tfen Kategori Se�iniz");
			form.cid.focus();
			return false;
			}
			
	if(form.title.value == ""){
			alert("L�tfen Ba�l�k Giriniz");
			form.title.focus();
			return false;
			}
			
	if(form.cuff_view.value == "Y" && (form.cuff.value == "")){
			alert("L�tfen Man�et Giriniz");
			form.cuff.focus();
			return false;
			}
	
	if(form.spot.value == ""){
			alert("L�tfen A��klama Giriniz");
			form.spot.focus();
			return false;
			}
			
	if(form.detail.value == ""){
			alert("L�tfen ��erik Giriniz");
			return false;
			}
			
	}

</script>

<form method="post" name="addForm" action="<?=$_SERVER['PHP_SELF']?>" onSubmit="return SubmitForm(this);">
<input type="hidden" value="<?=$id?>" name="id" />
<input type="hidden" value="<?=$do?>" name="do" />
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="2" class="listHeader padleft5px" align="center"><?=$page_headline?></td>
  </tr>
  <tr>
    <td colspan="2" class="row5px listOdd">L�tfen T�m Alanlar� Eksiksiz Doldurunuz </td>
    </tr>
  <tr>
    <td class="row5px listEven"><b>Haber Kategori   :</b></td>
    <td class="row5px listOdd"><select name="cid" id="cid" style="width:150px;">
      <option selected="selected">-- Se�iniz --</option>
      <?php
		$cat_query = $db->read_query("Select category, cid from cats order by cat_order asc");
		while($cat_row = $db->sql_fetcharray($cat_query)){
		
		if($row[cid] == $cat_row[cid]) $select = "selected";else $select = "";
		?>
      <option <?=$select?> value="<?=$cat_row[cid]?>">
        <?=stripslashes($cat_row[category])?>
        </option>
      <?php
		}
		?>
        </select></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Ba�l�k  :</b></td>
    <td class="row5px listOdd"><input name="title" type="text" id="title" value="<?=stripslashes($row[title])?>" size="70" /></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Man�et  :</b></td>
    <td class="row5px listOdd"><input name="cuff" type="text" id="cuff" value="<?=stripslashes($row[cuff])?>" size="70" /> 
    // Man�ette g�z�kecekse doldurun </td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Man�et G�sterim   :</b></td>
    <td class="row5px listOdd">
	<input name="cuff_view" <?php if($row[cuff_view]=='Y') echo "checked";?> type="radio" value="Y" id="cuff_yes" /> 
	<label for="cuff_yes">Evet</label>
	<input name="cuff_view" <?php if($row[cuff_view]=='N' || $row[cuff_view]=='') echo "checked";?> type="radio" value="N" id="cuff_no" /> 
	<label for="cuff_no">Hay�r</label></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Haber Tipi    :</b></td>
    <td class="row5px listOdd"><input name="type" <?php if($row[type]==1) echo "checked";?> type="radio" value="1" id="type" />
      Fla�
      <input name="type" <?php if($row[type]==2) echo "checked";?> type="radio" value="2" id="type" />
      �zel
      <input name="type" <?php if($row[type]==3) echo "checked";?> type="radio" value="3" id="type" />
      Video
      <input name="type" <?php if(!$row[type]) echo "checked";?> type="radio" value="0" id="type" />
      Normal
      </label></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Resim  :</b></td>
    <td class="row5px listOdd"><input name="image" value="<?=stripslashes($row[image])?>" type="text" size="50" />
&nbsp; <a href="#"  onclick="javascript:Popup('image.php?do=upload&type=news','',570, 300);">Resim Y�kle</a> | <a href="#"  onclick="javascript:Popup('image.php?do=search&type=news','',570, 300);">Resimlerde Ara</a></td>
  </tr>
  <tr>
    <td class="row5px listEven"><b>Spot  :</b></td>
    <td class="row5px listOdd"><textarea name="spot" cols="70" rows="5" id="spot" onChange="return validateLength(this, 'word_left', 200);" onKeyUp="return validateLength(this, 'word_left', 200);" ><?=stripslashes($row[spot])?></textarea> 
    <input type="text" name="word_left" value="200" style="width: 25;" readonly="true" size="3">
    Max 200 Karakter </td>
  </tr>
  <tr>
    <td valign="top" class="row5px listEven"><b>Haber ��eri�i  :</b></td>
    <td class="row5px listOdd" >
			<TEXTAREA id="detail" name="detail" rows=20 cols="50"><?=stripslashes($row[detail])?></TEXTAREA>
			<input type="button" name="ins" value="video ekle" onClick="return insertHTML();" /></td>
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
      <input name="close" type="button" onClick="javascript:window.location='<?=$_SERVER['PHP_SELF']?>'" class="button" id="close" value="Vazge�" /></td>
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
    <td align="left" class="listEven row5px"><strong>Ba�l�k : </strong></td>
    <td align="left" class="row5px listOdd"><input name="title" type="text" value="<?php echo stripslashes($title);?>" id="s_title" size="70" /></td>
  </tr>
  <tr>
    <td align="left" class="listEven row5px"><strong>Kategori : </strong></td>
    <td align="left" class="row5px listOdd">
	<select name="cid" id="cid" style="width:150px;">
		<option>-- Hepsi --</option>
      	<?php
		$cat_query = $db->read_query("Select category, cid from cats order by cat_order asc");
		while($cat_row = $db->sql_fetcharray($cat_query)){
		
		if($cid == $cat_row[cid]) $select = "selected";else $select = "";
		?>
		<option <?=$select?> value="<?=$cat_row[cid]?>"><?=stripslashes($cat_row[category])?></option>
		<?php
		}
		?>
    </select></td>
  </tr>
  <tr>
    <td align="left" class="listEven row5px"><strong>Tarih  Aral��� : </strong></td>
    <td align="left" class="row5px listOdd">
	<select name="start_day" id="start_day">
	  <option value="0" selected="selected">G�n</option>
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
      <option value="0">Y�l</option>
      <?php for($i=2006; $i<=date("Y"); $i++){
	  if($start_time && (date("Y",$start_time) == $i)) $select = "selected"; else $select = ""; 	  
	  ?>
	  <option <?=$select?> value="<?=$i?>"><?=$i?></option>?>
	  <?php }?>
    </select> 
	ile 
    <select name="end_day" id="end_day">
      <option value="0">G�n</option>
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
      <option value="0">Y�l</option>
      <?php for($i=2006; $i<=date("Y"); $i++){
	   if($end_time && (date("Y",$end_time) == $i)) $select = "selected"; else $select = ""; 	  
	  ?>
	  <option <?=$select?> value="<?=$i?>"><?=$i?></option>
      <?php }?>
    </select> 
    aras� </td>
  </tr>
  <tr>
    <td width="21%" align="left" class="listEven row5px"><strong>S�ralama  : </strong></td>
    <td width="79%" align="left" class="row5px listOdd">
	<select name="order_type" id="order_type">
	  <option value="id">-- Se�iniz --</option>
	  <option <?php if($order_type=="id")echo "selected";?> value="id">ID</option>
	  <option <?php if($order_type=="date")echo "selected";?> value="date">Tarih</option>
	  <option <?php if($order_type=="cuff_view")echo "selected";?> value="cuff_view">Man�et</option>
	  <option <?php if($order_type=="active")echo "selected";?> value="active">Durum</option>
 	</select>
	
	<label for="order_asc">
	<input name="order" <?php if($order=="asc")echo "checked";?> id="order_asc" type="radio" value="asc" /> Artan</label>
	<label for="order_desc"><input name="order" <?php if($order=="desc" || $order=="")echo "checked";?> type="radio" id="order_desc" value="desc" /> 
	Azalan</label></td>
  </tr>
  <tr>
    <td align="left" class="row5px listEven">&nbsp;</td>
    <td align="left" class="row5px listOdd"><input name="search" type="submit" class="button" id="search" value="Kay�tlar� Listele" />
    <input name="reset" type="reset" class="button" id="reset" value="Temizle" />
    <input name="close2" type="button" onClick="javascript:window.location='<?=$_SERVER['PHP_SELF']?>'" class="button" id="close2" value="Vazge�" /></td>
  </tr>
</table>
</form>
<div style="height:5px;"></div>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_box" >
  <tr>
    <td colspan="11" class="listHeader padleft5px" align="center">HABERLER [ <span class="style1"><a href="?do=new" class="yellowlink">YEN� KAYIT EKLE</a></span> ]</td>
  </tr>
  <tr>
    <td width="5%" class="padleft5px listTitle" align="center">ID</td>
    <td width="12%" class="padleft5px listTitle">Kategori</td>
	<td width="38%" class="padleft5px listTitle">Ba�l�k</td>
	<td width="13%" class="padleft5px listTitle">Tarih</td>
	<td width="10%" class="padleft5px listTitle" align="center">AnaSayfa</td>
	<td width="7%" class="padleft5px listTitle" align="center">Durum</td>
    <td width="15%" class="padleft5px listTitle">��lemler </td>
  </tr>
  <?php
  
  $add_query 	= "";
  
  if($title){
   	$add_query .= " and news.title LIKE '%$title%' ";
  }
  
  if($cid){
   	$add_query .= " and news.cid=".$cid;
  }
  
  if($start_time){
   	$add_query .= " and news.date >=".$start_time;
  }
  
  if($end_time){
   	$add_query .= " and news.date <= ".$end_time;
  }
  
  
  $add_order 	= "";
  
  if($order_type){
   	$add_order .= " order by news.".$order_type;
  }else{
  	$add_order .= " order by news.id";
  }
  
  if($order){
   	$add_order .= " ".$order;
  }else{
  	$add_order .= " desc";
  }
  
  $i=0;
  $query = $db->write_query("select count(news.id) as total from news as news, cats as cats where
  							news.cid = cats.cid $add_query") or die($db->sql_error());
  $row=$db->sql_fetcharray($query);
  
  $news_count=$row[total];
  
  if(!$news_count){
  	
	echo "<tr>\n";
	echo "  <td class=\"listEven\" align=\"center\" colspan=\"10\">\n";
	echo "   <br>Kay�tl� Veri Bulunamad�.<br><br>";
	echo "	</td>\n";
	echo "</tr>\n";
  
  }
 
  $sql = "select 
		news.id, news.title, news.date,
		news.cid, news.cuff_view, news.active,
		cats.category
		from news as news, cats as cats where news.cid = cats.cid
		$add_query $add_order limit $start,$limit
		";
		
  //echo $sql;
  $query = $db->write_query($sql) or die($db->sql_error());
							
  while($row=$db->sql_fetcharray($query)){
  if($i%2==0) $class = "listOdd"; else $class = "listEven";


  ?>
  <tr class="<?=$class?>">
    <td align="center" class="padleft5px"><?php echo $row[id];?></td>
    <td class="padleft5px"><?php echo stripslashes($row[category]);?></td>
	<td class="padleft5px"><?php echo stripslashes($row[title]);?></td>
	<td class="padleft5px"><?php echo date("d.m.Y H:i",$row[date]);?></td>
	<td class="padleft5px" align="center"><?php if($row[cuff_view]=='Y') echo "<b>Man�et</b>"; else echo "Normal";?></td>
	<td class="padleft5px" align="center"><?php echo active_passive($row[active]);?></td>
	<td class="padleft5px">
	<img src="images/edit.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="news.php?do=edit&id=<?=$row[id]?>">D�zenle</a> &nbsp;|&nbsp;
	<img src="images/delete.gif" width="17" height="17" align="absmiddle"> <a class="blacklink" href="news.php?do=delete&id=<?=$row[id]?>">Sil</a> </td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<?php
}

if($news_count>$limit){?>
<div id="page_nav"><?php
echo generate_pagination("news.php?title=".stripslashes($title)."&cid=$cid&order_type=$order_type&order=$order&start_time=$start_time&end_time=$end_time", $news_count, $limit, $start);?></div>
<?php
}

include "footer.php";
?>
</body>
</html>