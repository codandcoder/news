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
			include("securimage.php");
				
				$name 			= addslashes(strip_tags($_POST['name']));
				$email 			= addslashes(strip_tags($_POST['email']));
				$subject		= addslashes(strip_tags($_POST['subject']));
				$message		= addslashes(strip_tags($_POST['message']));
				$secure_code	= addslashes(strip_tags($_POST['secure_code']));
								
				$img = new Securimage();
				$security = $img->check($secure_code);
				
				$errors = array();
				
				if($_POST['contactSend']){
					if(!$name){
					$errors[] = "Ad & Soyad Girmediniz.";
					}
					if(!$email){
					$errors[] = "E-Mail Adresinizi Girmediniz.</li>";
					}
					if($email && !valid_email($email)){
					$errors[] = "Geçersiz E-Mail Adresi.</li>";
					}
					if(!$subject){
					$errors[] = "Ýletiþim Ýçin Konu Seçmediniz.</li>";
					}
					if(!$message){
					$errors[] = "Mesaj Girmediniz.";
					}
					if($security !=true){
					$errors[] = "Güvenlik Kodunu Yanlýþ Girdiniz.";
					}
					
					if(!$errors){
					
					$message  = $settings['site_name']." Ýletiþim Servisi \n\n\n Ad & Soyad : ".stripslashes($name)."\n\n";
					$message .= "Konu : ".stripslashes($subject)."\n\n Mesaj : ".stripslashes($message)."\n\n".$settings['site_url'];
					$headers .= "From: $email\n";
					$headers .= "Reply-To: $email\n";
					$headers .= "Return-Path: $email\n";    // these two to set reply address
					$headers .= "Message-ID: <".time()."-$email\n";
					$headers .= "X-Mailer: PHP v".phpversion();          // These two to help avoid spam-filters
					@mail($settings['site_email'],"".$settings['site_name']." Ýletiþim Mesajý",$message,$headers);
	
					$errors[] = "Mesajýnýza En kýsa zamanda cevap verilecektir.Bizimle Ýletiþim Kurduðunuz için Teþekkürler.";
					$name = "";
					$email = "";
					$message = "";
					$subject = "";
					  
					}
				}	
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
						<!-- Sayfa Ýsmi -->
						<div class="cat_name">ÝLETÝÞÝM BÝLGÝLERÝ</div>
						
						<!-- Ara Çizgiler -->
						<div class="center_line"><img src="images/spacer.gif" height="5" /></div>
					
						
						<div class="contact">
						<p>
						<b><?=$settings['contact_name']?></b>
						</p>
						
						<p>
						<b>Telefon :</b><br />
						<?=$settings['contact_tel']?>
						</p>
						<p>
						<b>E-Mail :</b><br />
						<?=$settings['site_email']?>
						</p>
						<p>
						<b>Adres :</b><br />
						<?=$settings['contact_address']?>
						</p>

						<!-- sayfa adý -->
						<div class="cat_name">BÝZE ULAÞIN</div>
						
						<!-- Ara Çizgiler -->
						<div class="center_line"><img src="images/spacer.gif" height="5" /></div>
						<span style="color:red">
						<?php
						if($errors){
							foreach($errors as $k=>$error){
							echo "<img src=\"images/news_icon_red.gif\" vspace=7 hspace=2 align=absmiddle> ".$error."<br>";
							}
						}
						?>
						</span>
						<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
						<p><strong>Ad Soyad :</strong> * <br />
						  <input name="name" type="text" id="name" value="<?=$name?>" size="60" />
						</p>
						<p><strong>E-Mail :</strong> * <br />
						  <input name="email" type="text" id="email" value="<?=$email?>" size="60" />
						</p>
						<p><strong>Konu :</strong> *<br />
						  <select name="subject" id="subject">
						    <option selected="selected" value="">-- Seçiniz --</option>
						    <option <?php if($subject == "Editör") echo "selected";?> value="Editör">Editör</option>
						    <option <?php if($subject == "Destek") echo "selected";?> value="Destek">Destek</option>
						    <option <?php if($subject == "Ýstek &amp; Eleþtiri") echo "selected";?> value="Ýstek &amp; Eleþtiri">Ýstek &amp; Eleþtiri</option>
					      </select>
						</p>
						<p><strong>Mesajýnýz : </strong>*<br />
						    <textarea name="message" cols="60" rows="6" id="message"><?=$message?></textarea>
						</p>
						<p><strong>Güvenlik Kodu :</strong> * <br />
	    <img src="securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>" align="absmiddle">
<input name="secure_code" type="text" id="secure_code" size="20" maxlength="7" /></p>
						<p>
						  <input name="contactSend" type="submit" id="contactSend" value="Gönder" />
                          <input name="reset" type="reset" id="reset" value="Temizle" />
						</p>
						</form>
						<p>(*)'lý Alanlarýn Doldurulmasý Zorunludur. </p>
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
		//~~~~~~~~~~~~~ Alt Çaðýrýlýyor ~~~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
		include("footer.php");
		
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~~~ MySQL Kapatýlýyor ~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
	
		$db->sql_close();
?>