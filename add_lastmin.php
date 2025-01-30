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
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: 100;
}
-->
</style>

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
				 	<!-- Kategori Ýsmi -->
					<div class="cat_name">SÝTENE SONDAKÝKA EKLE </div>
					
					<!-- Ara Çizgiler -->
					<div class="center_line"><img src="images/spacer.gif" height="5" /></div>
					
					<table width="100%" border="0" cellspacing="5" cellpadding="0">
                      <tr>
                        <td>Aþaðýda verilen kodu websitende HTML kodlarý arasýna ekleyerek sitemize son eklenen haberlerin sizin sitenizde de görünmesini saðlayabilirsiniz. </td>
                      </tr>
                      <tr>
                        <td height="1"></td>
                      </tr>
                      <tr>
                        <td><strong>Script Kodu : </strong></td>
                      </tr>
                      <tr>
                        <td>
						<textarea name="textarea" style="font:100 11px Tahoma;" cols="90" rows="4"><iframe src="<?=$settings['site_url']?>/rss/lastmin.php" marginheight="0" marginheight="0" scrolling="no" width="250" height="150" frameborder="0">Tarayýcýnýz Frame Desteklememektedir. </iframe></textarea></td>
                      </tr>
					  <tr>
                        <td height="1"></td>
                      </tr>
                      <tr>
                        <td>Frame boyutlarýný deðiþtirebilirsiniz.Geniþliði deðiþtirmek için <span class="style1">width=&quot;250&quot; </span>de <span class="style1">250</span> yerine istediðiniz boyutu girebilirsiniz. Yüksekliðini deðiþtirmek için <span class="style1">height=&quot;150&quot; </span>de <span class="style1">150</span> yerine istediðiniz boyutu girebilirsiniz. </td>
                      </tr>
					  <tr>
                        <td height="1"></td>
                      </tr>
                      <tr>
                        <td><strong>Örnek : </strong></td>
                      </tr>
                      <tr>
                        <td>
						<iframe scrolling="no" src="rss/lastmin.php" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="300">Tarayýcýnýz Frame Desteklememektedir</iframe></td>
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