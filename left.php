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
?><!-- Sol Menü -->
				  <div id="left_menu">
					<?php
					$query = $db->read_query("
												SELECT name, url, style, target
												FROM menu
												ORDER BY line ASC
												") or die($db->sql_error());
												
					while($row = $db->sql_fetcharray($query)){				
					?>
					<ul class="<?=$row[style]?>"><a href="<?=stripslashes($row[url])?>"><?php echo stripslashes($row[name])?></a></ul>
					<?php
					}
					?>
				</div>
				
				<?=$reklam->reklamGoster('sol_1');?>
				<!-- Galeriler -->
				<div><a href="gallery.php"><img src="images/gallery.png" /></a></div>	
				
				<!-- Çok Okunanlar -->
				<div id="mostly_readed">
					<div class="header">ÇOK OKUNANLAR</div>
					<?php
					
					$date = mktime(date("H"),date("i"),date("s"),date("m"),date("d")-3,date("Y"));
					
					$query = $db->read_query("
												SELECT id, title
												FROM news
												WHERE date >= $date
												ORDER BY hits DESC
												LIMIT 10
												");
												
					$i=0;
					while($row = $db->sql_fetcharray($query)){
					
					if($i%2==1) $add_class=" title2"; else $add_class="";
					?>
					<div class="title<?=$add_class?>"><a href="news_detail.php?id=<?=$row[id]?>"><?=stripslashes($row[title])?></a></div>
					<div class="line"><img src="images/spacer.gif" /></div>
					<?php
					$i++;
					}
					?>
				</div>