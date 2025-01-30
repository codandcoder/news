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
// | Web adresi     	: http://mahmut.niziprehber.com/                       |
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
			$gallery_id		= intval($_GET['gallery_id']);
			$image_no		= intval($_GET['image_no']);
			$title	 		= strip_tags(trim($_GET['title']));
			$start		 	= ($_GET['start']) ? intval($_GET['start']) : '0';
								
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			//~~~~~~~~~~~~~ Üst Çaðýrýlýyor ~~~~~~~~~~//
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		
			include("header.php");
			
			$limit = 1;
	
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
                      <td>
						<!-- Kategori Ýsmi -->
						<div class="cat_name">GALERÝLER <?php if($title) echo "&raquo; ".$title;?></div>
						
						<!-- Ara Çizgiler -->
						<div class="center_line"><img src="images/spacer.gif" height="5" /></div>
					</td>
                    </tr>
                    <?php
					if($gallery_id){
						
						$queryx = $db->write_query("
					  							SELECT image_id
												FROM gallery_images
												WHERE gallery_id = $gallery_id
					  							") or die($db->sql_error());
						
						$total_result = $db->sql_numrows($queryx);

						
					?>
					<tr>
                      <td style="padding-top:5px;">
					  <?php
					  
					   
					  
					  $query = $db->read_query("
					  							SELECT image_id, short_desc, image, date
												FROM gallery_images
												WHERE gallery_id = $gallery_id
												ORDER BY date DESC
												LIMIT $start, $limit
					  							") or die($db->sql_error());
					  					  
					  while($row = $db->sql_fetcharray($query)){
					  ?>
					  <div id="big_gallery_box">
					  		<div class="image"><img src="images/gallery/<?=$row[image]?>"/></div>
							<div class="info"><?=stripslashes($row[short_desc])?><br />
							<b>Tarih :</b> <?=time_to_now($row[date])?></div>
					  </div>
					  <?php
					  }
					  ?>
					  </td>
                    </tr>
					<?php
					if( !$total_result ){
					?>
                    <tr>
                      <td style="padding:5px;" align="center"><b>Kayýtlý Veri Bulunamadý</b></td>
                    </tr>
					<?php
					  }
					?>
					<?php
					if( $total_result > $limit ){
					?>
                    <tr>
                      <td><?php echo paging(''.$_SERVER['PHP_SELF'].'?gallery_id='.stripslashes($gallery_id).'&title='.$title.'',$total_result,$limit,$start);?></td>
                    </tr>
					<?php
					  }
					?>
					<?php
					}else{
					?>
				    <tr>
                      <td>
					  <?php
					  $i=0;
					  $query = $db->read_query("
					  							SELECT g.gallery_id, g.title, g.short_desc, gi.image
												FROM gallery as g
												RIGHT JOIN gallery_images as gi on ( g.gallery_id = gi.gallery_id )
												GROUP BY g.gallery_id
												ORDER BY g.gallery_id DESC
												") or die($db->sql_error());
												
					  while($row = $db->sql_fetcharray($query)){
					  if($i%2==1) $class = " gallery_box2"; else $class = "";

					  ?>
					  <div class="gallery_box<?=$class?>">
					  	<a href="gallery.php?gallery_id=<?=$row[gallery_id]?>&title=<?=stripslashes($row[title])?>">
					  	<div class="image"><img src="images/gallery/<?=stripslashes($row[image])?>" width="100" height="75" /></div>
						<div class="info"><b class="title"><?=stripslashes($row[title])?></b><br /><?=stripslashes($row[short_desc])?></div>
						</a>
					  </div>
					  <?php
					  $i++;
					  }
					  ?>
					  </td>
                    </tr>
					<?php
					}
					?>
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
		?>
		
		<?php
		
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~~~ MySQL Kapatýlýyor ~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
		$db->sql_close();
		?>

		
		