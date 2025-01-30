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
			//~~~~~~~~~~~~~ Üst Çaðýrýlýyor ~~~~~~~~~~//
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		
			include("header.php");
		?>
		
		<?php
	
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			//~~~~~~~~~~~~~ Haber Sorgusu ~~~~~~~~~~~~//
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		
			$page_id = intval($_GET['page_id']);
	
			$query = $db->read_query("
									SELECT title, detail, date
									FROM static_pages
									WHERE active = 'Y' AND page_id = $page_id
									") or die($db->sql_error());
									
			$pageDetail = $db->sql_fetcharray($query);
	
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
				 <!-- Orta Kýsým -->
				<div id="font_tools">
					  <div class="tools">
					<div class="fonts">
						Karakter boyutu :
						<img style="cursor: pointer;" src="images/font_01.gif" align="absmiddle" onClick="return changeSize('text_detail', '12', 'content')" alt="12 Punto"/>
						<img style="cursor: pointer;" src="images/font_02.gif" align="absmiddle" onClick="return changeSize('text_detail', '14', 'content')" alt="14 Punto"/>
						<img style="cursor: pointer;" src="images/font_03.gif" align="absmiddle" onClick="return changeSize('text_detail', '16', 'content')" alt="16 Punto"/>
						<img style="cursor: pointer;" src="images/font_04.gif" align="absmiddle" onClick="return changeSize('text_detail', '18', 'content')" alt="18 Punto"/>
					</div>
					<div class="goback"><img src="images/back_red.gif" align="absmiddle" /> <a href="./index.php">Ana sayfaya Dön</a></b></div>
			
				</div></div>
				<table width="100%" border="0" cellspacing="3" cellpadding="0">
					<tr>
					  <td>
					  <div id="article_detail">
						<div class="title"><?=stripslashes($pageDetail[title])?></div>
						<div class="br1pxdot"><img src="images/spacer.gif" /></div>
						<div class="date"><?php echo time_to_now($pageDetail[date]);?></div>
						<div class="br1pxdot"><img src="images/spacer.gif" /></div>
						<div class="detail content_12" id="text_detail">
						<?=stripslashes($pageDetail[detail])?>
						</div>
					  </div>
					  <script type="text/javascript">changeTarget(document.getElementById("text_detail"))</script>
					  </td>
					</tr>
				  </table>
				  <!-- //Orta Kýsým -->
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