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
					
			
			$poll_id = ($_POST['poll_id']) ? intval($_POST['poll_id']) : intval($_GET['poll_id']);
			$options = intval($_POST['options']);
			
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			//~~~~~~~~~~~~~ �st �a��r�l�yor ~~~~~~~~~~//
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
					$query = $db->read_query("
												SELECT poll_title, questions, answers, date
												FROM polls
												WHERE poll_id = $poll_id
												") or die($db->sql_error());
									
					$row = $db->sql_fetcharray($query);
					
					$questions 	= explode("|",$row[questions]);
					$answers 	= explode("|",$row[answers]);
					
					if($_POST){
						
						$ip = getenv("REMOTE_ADDR");
						
						if(!$ip) $ip = $_SERVER['REMOTE_ADDR'];
						
						$past = time() - 3600;
						$db->write_query("DELETE FROM polls_ip WHERE dateline < $past");
						
						$p_query = $db->read_query("
													SELECT ip
													FROM polls_ip
													WHERE ip = '$ip'
													AND poll_id = $poll_id") or die($db->sql_error());
													
						$p_row = $db->sql_fetcharray($p_query);
						
						if($ip == $p_row[ip]){
							
							$warning = "Bu Ankete Daha �nceden Oy Verdiniz.";
							
						}else{
							
							$db->write_query("INSERT INTO polls_ip
											(ip, dateline, poll_id)
											VALUES('".$ip."','".time()."','".$poll_id."')") or die($db->sql_error());
						
							$answers[$options]++;
							$new_answers = array();
							for($i=0; $i<count($answers); $i++){
							$new_answers[] = $answers[$i];
							}
							$new_answers = implode("|",$new_answers);
							
							$db->write_query("UPDATE polls SET answers = '".$new_answers."' WHERE poll_id = $poll_id") or die($db->sql_error());
														
						}
					}
					
					$total_vote = array_sum($answers);
					if(!$total_vote) $total_vote = 1;
					
					?>
					<!-- Kategori �smi -->
					<div class="cat_name">ANKETLER</div>
					
					<!-- Ara �izgiler -->
					<div class="center_line"><img src="images/spacer.gif" height="5" /></div>
					
					<!-- Anket Sonu�lar� -->
					<div id="poll_result">
						<?php
						if($warning){
						?>
						<div class="warning"><?=$warning?></div>
						<?php
						}
						?>
						<div class="title"><?php echo stripslashes($row[poll_title]);?></div>
						<div class="date"><?php echo time_to_now($row[date]);?></div>
						<?php
						for($i=0; $i<count($questions); $i++){
						
						$percent = ($answers[$i] * 100) / $total_vote;
						$percent = number_format($percent,2,".","");
						?>
						<div class="questions"><?php echo stripslashes($questions[$i]);?> <span style="color:#DD0000;">(<?=$answers[$i]?>)</span></div>
						<div class="percent">
							<div class="percent_pay" style="width:<?=ceil($percent)?>%"><img src="images/poll_percent.png" width="5" height="10" /></div>
							<div><?=$percent?> %</div>
						</div>
						<?php
						}
						?>
					</div>	
					
					<!-- Yaz� Ara�lar� -->
						<div id="textTools">
							<div class="item"><img src="images/comment_add.gif" align="absmiddle" /> <a href="javascrit:;" onClick="return openPopUp_520x390('comment_add.php?id=<?=$poll_id?>&type=poll','');">Yorum Ekle</a> </div>
							<div class="item"><img src="images/up.gif" align="absmiddle" /> <a href="#top">Yukar� ��k</a> </div>
						</div>
									
					<table cellpadding="0" cellspacing="0" border="0">
					<?php
					
					$query = $db->write_query("
												SELECT name, title, comment, date
												FROM comments
												WHERE id = $poll_id
												AND type = 'poll'
												AND active = 'Y'
												ORDER BY date DESC
												") or die($db->sql_error());
												
					$total_comments = $db->sql_numrows($query);
					
					if(!$total_comments){
					
					echo "<tr><td align=\"center\" style=\"padding:5px;\">Bu ankete Hen�z Yorum Eklenmemi�.</td></tr>";
					
					}
					
					$query = $db->read_query("
												SELECT name, title, comment, date
												FROM comments
												WHERE id = $poll_id
												AND type = 'poll'
												AND active = 'Y'
												ORDER BY date DESC
												LIMIT 3
												") or die($db->sql_error());
												
					while($row = $db->sql_fetcharray($query)){
					?>
					<tr>
					  <td id="comments" colspan="5">
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
					  <td class="allComments"><a href="javascript:;" onclick="return openPopUp_520x390('comments.php?id=<?=$id?>&type=poll','');">T�m Yorumlar� G�ster(<?=$total_comments?>)</a></td>
				  </tr>
				  <?php
					}
					?>
					</table>
					
					<!-- Ara �izgiler -->
					<div class="center_line"><img src="images/spacer.gif" height="5" /></div>
					
					<div id="otherTitles">
						<div class="head">Di�er Anketler</div>
						<?php
						$query = $db->read_query("
													SELECT poll_title, poll_id
													FROM polls
													WHERE poll_id <> $poll_id
													ORDER BY date DESC
													");
						while($row = $db->sql_fetcharray($query)){
						?>
						<div class="title"><a href="polls.php?poll_id=<?=$row[poll_id]?>"><?php echo stripslashes($row[poll_title]);?></a></div>
						<?php
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
		//~~~~~~~~~~~~~ Alt �a��r�l�yor ~~~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
		include("footer.php");
		
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~~~ MySQL Kapat�l�yor ~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
		$db->sql_close();
?>