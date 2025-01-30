<?php

//
// +---------------------------------------------------------------------------+
// | NizipRehber Haber Portal� v1.0 [ nrnews_v1.0 ]                            |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Gereksininimleri   : PHP 4 veya �zeri, GD2+ k�t�phanesi                   |
// |                                                                           |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Geli�tirici    	: Mahmut �ZDEM�R                                       |
// | E-posta        	: mahmuttt88 {at} yahoo {dot} com                      |
// | Web adresi     	: http://www.mahmutozdemir.org/       	               |
// | Tel		     	: +90 5373622826 / +90 5457604888 / +90 5543184701     |
// |                                                                           |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | Copyright (C) 2007                                                        |
// |                                                                           |
// | Bu Yaz�l�m �CRETS�Z DE��LD�R. Yaz�l�m�n T�m Haklar� Mahmut �ZDEM�R'e      |
// | aittir.															       |
// |                                                                           |
// +---------------------------------------------------------------------------+
//
			
			$cid = intval($_GET['cid']);
			
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			//~~~~~~~~~~~~~ �st �a��r�l�yor ~~~~~~~~~~//
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		
			include("header.php");
			
			$query = $db->read_query("
										SELECT category
										FROM cats
										WHERE cid = $cid
										") or die($db->sql_error());
									
			$row = $db->sql_fetcharray($query);
			$category = stripslashes($row[category]);
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
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><!-- Kategori �smi -->
					<div class="cat_name"><?php echo $category;?></div>
					
					<!-- Ara �izgiler -->
					<div class="center_line"><img src="images/spacer.gif" height="5" /></div>
					
					<!-- Kutulu Haberler -->
					<?php
									$i=0;
									$query = $db->read_query("
																SELECT id, title, date, image, spot
																FROM news
																WHERE active = 'Y'
																AND cid = $cid
																ORDER BY id DESC
																LIMIT 10
																") or die($db->sql_error());
									while($row = $db->sql_fetcharray($query)){
									if($i%2==1) $class = " news_box2"; else $class = "";
							?>
							<div class="news_box<?=$class?>">
							<a href="news_detail.php?id=<?=$row[id]?>">
								<div class="title"><?=stripslashes($row[title])?></div>
								<div class="image"><img src="images/news/<?=$row[image]?>" width="90" height="70" /></div>
								<div class="spot"><?=stripslashes($row[spot])?></div>
							</a>
							</div>
							<?php
							$i++;
							}
							?>
					</td>
                      </tr>
                      <tr>
                        <td>
						<!-- Ara �izgiler -->
						<div class="center_line"><img src="images/spacer.gif" height="5" /></div>
						
						<div id="otherTitles">
							<div class="head">Kategorideki Di�er Haberler</div>
							<?php
									$query = $db->read_query("
																SELECT id, title
																FROM news
																WHERE active = 'Y'
																AND cid = $cid
																ORDER BY id DESC
																LIMIT 10,25
																") or die($db->sql_error());
									while($row = $db->sql_fetcharray($query)){
							?>
							<div class="title"><a href="news_detail.php?id=<?=$row[id]?>"><?=stripslashes($row[title])?></a></div>
							<?php
							}
							?>
						</div>
						</td>
                      </tr>
                    </table>				</td>
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
		//~~~~~~~~~~~~~ Alt �a��r�l�yor ~~~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
		include("footer.php");
		
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~~~ MySQL Kapat�l�yor ~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
		$db->sql_close();
?>