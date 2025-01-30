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
			
			/* Manþet Sorgusu */
			$query = $db->read_query("
										SELECT id, title, spot, image, date, cuff, type
										FROM news
										WHERE active = 'Y'
										AND cuff_view = 'Y'
										ORDER BY date DESC
										LIMIT 10
										") or die($db->sql_error());
			$cuffNews = array();
								
			while($row = $db->sql_fetcharray($query)){
			$cuffNews[] = $row;
			}
						
			$db->sql_freeresult($query);
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
                  <td width="490" valign="top" class="centerColumn top5px">
				  <table width="490" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="113" valign="top">
					  <div id="headline">
				<?php
				
				
				foreach($cuffNews as $k=>$news){
				$news_url = "news_detail.php?id=".$news[id];
				?>
				<div class="headline_title" id="title<?=$k?>" style="display:none;">
				<a href="<?=$news_url?>"><?php echo stripslashes(makeCuff($news[cuff]));?></a>
				</div>
				<?php
				}
				?>
				<?php
				foreach($cuffNews as $k=>$news){
				?>
				<div class="spot" id="spot<?=$k?>" style="display:none;"><a href="news_detail.php?id=<?=$news[id]?>"><?php echo stripslashes($news[spot]);?></a></div>
				<?php
				}
				?>
				<?php
				foreach($cuffNews as $k=>$news){
				?>
				<div class="headline_image" id="image<?=$k?>" style="display:none;">
				<a href="news_detail.php?id=<?=$news[id]?>"><img width="250" height="180" src="images/news/<?php echo stripslashes($news[image]);?>" alt="<?php echo stripslashes($news[title]);?>"></a>
				</div>
				<?php
				}
				?>
				<div class="textbox">
				<?php
				foreach($cuffNews as $k=>$news){
				?>
				<div class="title<?=getNewsType($news[type])?>"><a href="news_detail.php?id=<?=$news[id]?>" onmouseover="javascript:getCuff(<?=$k?>);"><?php echo stripslashes($news[title]);?></a></div>
				<?php
				}
				?>
				</div>
			</div>
			<script>getCuff(0);</script>  </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>
					  <div id="main_slide_news">
					  	<div class="right"><a href="javascript:void(0);" onclick="javascript:document.getElementById('slider').direction='right';"><img src="images/spacer.gif" width="16" height="92" /></a></div>
						<div class="left"><a href="javascript:void(0);" onclick="javascript:document.getElementById('slider').direction='left';"><img src="images/spacer.gif" width="16" height="92" /></a></div>
						<div class="center">
							<marquee id="slider" onmouseover=this.stop(); style="WIDTH: 100%" onmouseout=this.start(); scrollAmount=3 scrollDelay=1>
							<table cellpadding="0" cellspacing="0" border="0">
								<tr>
								<?php
								$query = $db->read_query("
													SELECT id, title, date, image, spot
													FROM news
													WHERE active = 'Y'
													ORDER BY id DESC
													LIMIT 10
													") or die($db->sql_error());
								while($row = $db->sql_fetcharray($query)){
								?>
								<td>
								<div class="slide_news_box">
									<a href="news_detail.php?id=<?=$row[id]?>">
									<div class="title"><?=stripslashes($row[title])?></div>
									<div class="image"><img src="images/news/<?=$row[image]?>" width="70" height="52" /></div>
									<div class="spot"><?=stripslashes($row[spot])?></div>
									</a>								</div>								</td>
								<?php
								}
								?>
								</tr>
							</table>						
							</marquee>
						</div>
					  </div>					  </td>
                    </tr>

					<tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>
					  <?php
					  			
						$queryx = $db->write_query("SELECT cid, category FROM cats WHERE home = 'Y' ORDER BY cat_order ASC") or die($db->sql_error());
						$i=0;
						while($rowx = $db->sql_fetcharray($queryx)){
						if($i%2==1) $class = " middle_cat_groups2"; else $class = "";
							
							$query = $db->read_query("
															SELECT id, title, image, spot
															FROM news
															WHERE active = 'Y'
															AND cid = $rowx[cid]
															ORDER BY id DESC
															LIMIT 6
															") or die($db->sql_error());
							$news = array();
							while($row = $db->sql_fetcharray($query)){
							$news[] = $row;
							}
						?>
						<div class="middle_cat_groups<?=$class?>">
							<div class="cat"><?=stripslashes(makeCuff($rowx[category]))?></div>
						
							<div class="image"><img src="images/news/<?=stripslashes($news[0][image])?>" width="98" height="65" /></div>
							<div class="spot"><a href="news_detail.php?id=<?=$news[0][id]?>"><b><?=stripslashes($news[0][title])?></b><br /><?=stripslashes($news[0][spot])?></a></div>
							<div class="titles">
								<?php		
								for($j=1; $j<6; $j++){		
								?>
								<div class="title"><a href="news_detail.php?id=<?=$news[$j][id]?>"><?=stripslashes($news[$j][title])?></a></div>
								<?php
								}
								?>
							</div>
						</div>
						<?php
						$i++;
						}						
						$db->sql_freeresult($query);
						$db->sql_freeresult($queryx);
						?> </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
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