<?php

class nrReklam
{
	var $bolge = '';
	
	function reklamBilgi($yer)
	{
		global $db;
		
		$sorgu = $db->read_query("
									SELECT reklamid, tip,
									dosyaadresi, genislik,
									yukseklik, kod
									FROM reklamlar
									WHERE durum = 'Y'
									AND bolge = '$yer'
									") or die($db->sql_error());
									
		$veri = $db->sql_fetcharray($sorgu);
		
		if($veri)
		{
			return $veri;
		}
		else
		{
			return false;
		}
	}
	
	function reklamGoster($bolge)
	{
		
		$rek = $this->reklamBilgi($bolge);
		
		$tip 			= $rek['tip'];
		$reklamid 		= $rek['reklamid'];
		$dosyaadresi 	= $rek['dosyaadresi'];
		$genislik 		= $rek['genislik'];
		$yukseklik 		= $rek['yukseklik'];
		$kod 			= $rek['kod'];
		
		if($rek)
		{
			if($tip == 1) // Resim
			{
				$reklam = "<a target=\"_blank\" href=\"reklam.php?reklamid=$reklamid\"><img src=\"$dosyaadresi\" border=0 width=$genislik height=$yukseklik></a>";
			}
			elseif($tip == 2) // Flash
			{
				$reklam = "<script>getSWF($genislik, $yukseklik, \"$dosyaadresi\");</script>";
			}
			else
			{
				$reklam = stripslashes($kod);
			}
		
			return "<div>".$reklam."</div>";	
		}
		else
		{
			return false;
		}
	}	
}	
?>