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
		
			$id = intval($_GET['id']);
	
			$db->write_query("UPDATE news set hits = hits + 1 where id = $id");
			
			$query = $db->read_query("
									SELECT news.title, news.spot, news.image, news.cid,
									news.detail, news.date, news.hits, cats.category
									FROM news, cats
									WHERE news.cid = cats.cid AND news.active = 'Y' AND news.id = $id
									") or die($db->sql_error());
									
			$newsDetail = $db->sql_fetcharray($query);
	
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
					<div class="goback"><img src="images/back_red.gif" align="absmiddle" /> <a href="./index.php">Ana sayfaya Dön</a> // <a href="news.php?cid=<?=$newsDetail[cid]?>"><b><?=stripslashes($newsDetail[category])?></b></a></div>
			
				</div></div>
				<table width="100%" border="0" cellspacing="3" cellpadding="0">
					<tr>
					  <td>
					  <div id="article_detail">
					  	<div class="newsImage">
							<div><img src="images/news/<?=$newsDetail[image]?>" width="260" height="180" /></div>
						</div>
						<div class="title"><?=stripslashes($newsDetail[title])?></div>
						<div class="br1pxdot"><img src="images/spacer.gif" /></div>
						<div class="date"><?php echo time_to_now($newsDetail[date]);?></div>
						<div class="br1pxdot"><img src="images/spacer.gif" /></div>
						<div class="detail content_12" id="text_detail">
						<b><?=stripslashes($newsDetail[spot])?></b><br /><br />
						<?=stripslashes($newsDetail[detail])?>
						</div>
						<div class="read_count">Bu yazý toplam <?=$newsDetail[hits]?> defa okundu.</div>
					  </div>
					  <script type="text/javascript">changeTarget(document.getElementById("text_detail"))</script>
					  </td>
					</tr>
					<tr>
					  <td>
					  <!-- Ara Çizgiler -->
						<div class="center_line"><img src="images/spacer.gif" height="5" /></div>
						
						<!-- Yazý Araçlarý -->
						<div id="textTools">
							<div class="item"><img src="images/comment_add.gif" align="absmiddle" /> <a href="javascrit:;" onClick="return openPopUp_520x390('comment_add.php?id=<?=$id?>&type=news','');">Yorum Ekle</a> </div>
							<div class="item"><img src="images/print.gif" align="absmiddle" /> <a target="_blank" href="news_print.php?id=<?=$id?>">Yazdýr </a></div>
							<div class="item"><img src="images/up.gif" align="absmiddle" /> <a href="#top">Yukarý Çýk</a> </div>
						</div>
						
						<!-- Ara Çizgiler -->
						<div class="center_line"><img src="images/spacer.gif" height="5" /></div>
						</td>
				    </tr>
					<?php
					
					$query = $db->write_query("
												SELECT name, title, comment, date
												FROM comments
												WHERE id = $id
												AND type = 'news'
												AND active = 'Y'
												ORDER BY date DESC
												") or die($db->sql_error());
												
					$total_comments = $db->sql_numrows($query);
					
					if(!$total_comments){
					
					echo "<tr><td>Bu Yazýya Henüz Yorum Eklenmemiþ.</td></tr>";
					
					}
					
					$query = $db->read_query("
												SELECT name, title, comment, date
												FROM comments
												WHERE id = $id
												AND type = 'news'
												AND active = 'Y'
												ORDER BY date DESC
												LIMIT 3
												") or die($db->sql_error());
												
					while($row = $db->sql_fetcharray($query)){
					?>
					<tr>
					  <td id="comments">
					  <div class="comment">
						<div class="name"><?php echo stripslashes($row[name]);?></div>
						<div class="title"><?php echo stripslashes($row[title]);?></div>
						<div class="comment"><?php echo stripslashes($row[comment]);?></div>
						<div class="date"><?php echo time_to_now($row[date]);?></div>
					</div></td>
					</tr>
					<?php
					}
					if($total_comments>3){
					?>
					<tr id="comments">
					  <td class="allComments"><a href="javascript:;" onclick="return openPopUp_520x390('comments.php?id=<?=$id?>&type=news','');">Tüm Yorumlarý Göster(<?=$total_comments?>)</a></td>
				  </tr>
				  <?php
					}
					?>
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