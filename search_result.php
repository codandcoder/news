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
			
			$search_word = addslashes(trim(strtolower(strip_tags($_REQUEST['search_word']))));
			$column		 = addslashes(trim(strip_tags($_REQUEST['column'])));
			$order		 = addslashes(trim(strip_tags($_REQUEST['order'])));
			
			$start		 = ($_GET['start']) ? intval($_GET['start']) : '0';
			
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			//~~~~~~~~~~~~~ Üst Çaðýrýlýyor ~~~~~~~~~~//
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		
			include("header.php");
		?>
		<table class="body" width="770" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td class="leftright">
			  <table width="770" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="120" valign="top"  style="background:#EFEFEF;">
				  <?php
				  include("left.php");
				  ?>
				  </td>
                  <td width="490" valign="top" class="centerColumn">
				  <?php
				 	$search_errors = array();
		
					if(!$search_word){
					$search_errors[] = "Lütfen Arama Yapmak için bir kriter giriniz";
					}
					if(strlen($search_word) < 3){
					$search_errors[] = "Arama yapmak için en az 3 harfli bir kriter giriniz.";
					}
				  ?>
				  
				  <!-- Kategori Ýsmi -->
				<div class="cat_name">ARÞÝVDE ARA</div>
				
				<!-- Ara Çizgiler -->
				<div class="center_line"><img src="images/spacer.gif" height="5" /></div>
				
				<!-- Arama Sonuçlarý -->
				<div id="search_result">
					<?php
					if($search_errors){
						foreach($search_errors as $error){
					?>
					<div class="search_error"><?=$error?></div>
					<?php
						}
					?>
					<div>&nbsp;</div>
					<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
					<div class="search_form"><label for="search_word"><b>Arama Kriteri :</b> <input size="50" type="text" name="search_word" id="search_word" value="<?=stripslashes($search_word)?>" /></label></div>
					<div class="search_form"><b>Aranacak Yer :</b> <label for="titles"><input checked="checked" type="radio" name="column" value="title" id="titles" /> Baþlýklarda</label> <label for="all"><input type="radio" name="column" id="all" value="all"> Baþlýk ve Detayda</label></div>
					<div class="search_form"><b>Sýralama :</b> <label for="desc"><input checked="checked" type="radio" name="order" value="desc" id="desc" /> Yeniden -> Eskiye</label> <label for="asc"><input type="radio" name="order" id="asc" value="asc"> Eskiden -> Yeniye</label></div>
					<div class="search_form"><input type="submit" value="arama yap" name="search" /></div>
					</form>
					<?php
					}else{

					if($column == "all"){
					$search = "LOWER(title) like '%".$search_word."%' OR LOWER(spot) like '%".$search_word."%'";
					}else{
					$search = "LOWER(title) like '%".$search_word."%'";
					}
					
					if($order == "asc"){
					$order = "ASC";
					}else{
					$order = "DESC";
					}
					
					$limit = 10;
					
					$sql = "					
							SELECT id, title, spot
							FROM news
							WHERE ".$search."
							ORDER BY date ".$order."
							";
							
					$queryx = $db->write_query($sql) or die($db->sql_error());
					
					$total_result = $db->sql_numrows($queryx);
					?>
					<div style="margin-bottom:5px;"><b>Aranan : <?=stripslashes($search_word);?></b> (<?=$total_result;?> kayýt bulundu)</div>
					<?php
					if(!$total_result){
					
					echo "<div class=\"search_error\"><b>Aradýðýnýz kriterlere uygun sonuç bulunamadý.</b></div>";
					echo "<div style=\"margin-top:10px; margin-left:23px;\"><a href=\"".$_SERVER['PHP_SELF']."\">Geri Dön</a></a></div>";
										
					}
					
					$query = $db->read_query( $sql . " LIMIT $start, $limit") or die($db->sql_error());
					
					while($row = $db->sql_fetcharray($query)){
					?>
					<div class="search_news_box">
						<div class="title"><a href="news_detail.php?id=<?=$row[id]?>"><?php echo stripslashes($row[title]);?></a></div>
						<div class="spot"><a href="news_detail.php?id=<?=$row[id]?>"><?php echo stripslashes($row[spot]);?></a></div>
					</div>
					<?php
					}
					?>
					<?php
					}
					
					if( $total_result > $limit ){
					echo paging(''.$_SERVER['PHP_SELF'].'?search_word='.stripslashes($search_word).'&column='.$column.'&order='.$order.'',$total_result,$limit,$start);
					}
					?>
				</div>		
				  
				  </td>
                  <td width="150" valign="top" style="background:#EFEFEF;">
				  <?php
				  include("right.php");
				  ?>
				  </td>
                </tr>
              </table></td>
		  </tr>
		</table>
<?php
		
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~~~ Alt Çaðýrýlýyor ~~~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
		include("footer.php");
		
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~~~ MySQL Kapatýlýyor ~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
		$db->sql_close();
?>