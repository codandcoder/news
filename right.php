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
?>
<!-- Yazarlar Devamý -->
				  <?php
					$query = $db->write_query("
												SELECT author_id, name, image
												FROM authors
												ORDER BY author_order ASC
												LIMIT 5,100
												");
												
					while($row = $db->sql_fetcharray($query)){
					
						$qquery = $db->read_query("
													SELECT article_id, title
													FROM articles
													WHERE author_id = $row[author_id]
													AND active = 'Y'
													ORDER BY date DESC
													LIMIT 1
													");
													
						$rrow = $db->sql_fetcharray($qquery);
						
						if($rrow[title]){
						$article = "<a href=\"author_article_detail.php?article_id=".$rrow[article_id]."\">".stripslashes($rrow[title])."</a>";
						}else{
						$article = "Henüz Yazý Eklenmemiþ";
						}
					?>
					<div class="right_author_box">
						<div class="image"><img src="images/authors/th_<?=$row[image]?>" width="38" height="46" /></div>
						<div class="text"><b class="authorName"><?php echo stripslashes($row[name]);?></b><br /><?=$article?></div>
					</div>
					<?php
					}
					?>
					
					<!-- Site'de Arama Yap -->
					<div id="last_comments">
						<form method="post" action="search_result.php">
						<input type="hidden" name="column" value="title" />
						<input type="hidden" name="order" value="desc" />
						<div class="header">ARÞÝVDE ARA</div>
						<div class="title">
						  <input type="text" name="search_word" />
						</div>
						<div class="line"><img src="images/spacer.gif" /></div>
						<div class="title">
						  <input type="submit" name="Submit" value="arama yap" />
						</div>
						<div class="line"><img src="images/spacer.gif" /></div>
						<div class="title"><a href="search_result.php">Geliþmiþ Arama</a> </div>
						<div class="line"><img src="images/spacer.gif" /></div>
						</form>
					</div>
				
				<!-- Son Yorumlananlar -->
				<div id="last_comments">
					<div class="header">SON YORUMLANANLAR</div>
					<?php
					
					$query = $db->read_query("
												SELECT news.id, news.title
												FROM news, comments
												WHERE comments.id = news.id
												AND comments.type = 'news'
												AND comments.active = 'Y'
												GROUP BY comments.id
												ORDER BY comments.comment_id DESC
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
			
				<!-- Anketler -->
				<?php
				if($settings['active_poll']){
				?>
				<div id="poll">
					<div class="header">SÝTE ANKET</div>
					<?php
					
					$query = $db->read_query("
												SELECT poll_id, poll_title, questions
												FROM polls
												WHERE poll_id = ".$settings['active_poll']."
												");
												
					$row = $db->sql_fetcharray($query);
					
					$questions = explode("|",$row[questions]);
					
					?>
					<form method="post" action="polls.php">
					<input type="hidden" name="poll_id" value="<?=$settings['active_poll']?>" />
					<div class="title"><?=stripslashes($row[poll_title])?></div>
					<?php
					for($i=0; $i < count($questions); $i++){
					?>
					<div class="question"><input type="radio" name="options" value="<?=$i?>" /> <?php echo stripslashes($questions[$i]);?></div>
					<div class="line"><img src="images/spacer.gif" /></div>
					<?php
					}
					?>
					<div class="buttons"><input name="votePoll" type="image" src="images/votesubmit.gif" align="absmiddle"/> &nbsp; <a href="polls.php?poll_id=<?=$settings['active_poll']?>">sonuçlarý göster</a></div>
					</form>
				</div>
				<?php
				}
				?>