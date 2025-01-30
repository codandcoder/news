<?php

class nrReklam
{
	var $bolge ='';
	
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
		
		return $veri;
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
		
		if($tip == 1) // Resim
		{
			$reklam = "<a href=\"reklam.php?reklamid=$reklamid\"><img src=\"$dosyaadresi\" border=0 width=$genislik height=$yukseklik></a>";
		}
		elseif($tip == 2) // Flash
		{
			$reklam = "<script>getSWF($genislik, $yukseklik, \"$dosyaadresi\");</script>";
		}
		else
		{
			$reklam = stripslashes($kod);
		}
		
		return $reklam;	
	}	
}

	$bolgeler = array(
						'sol_1',
						'sol_2',
						'sol_3',
						'sag_1',
						'sag_2',
						'sag_3',
						'orta_1',
						'orta_2',
						'orta_3',
						'haber',
						); 
	
	$sorgu = $db->read_query("
								SELECT reklamid, bolge, tip,
								dosyaadresi, genislik,
								yukseklik, kod
								FROM reklamlar
								WHERE durum = 'Y'
								") or die($db->sql_error());
								
	$reklamlar = array();
	$i=0;
	while($veri = $db->sql_fetcharray($sorgu))
	{
		$reklamlar[$i][$veri['bolge']]['reklamid'] 		= $veri['reklamid'];
		$reklamlar[$i][$veri['bolge']]['tip'] 			= $veri['tip'];
		$reklamlar[$i][$veri['bolge']]['dosyaadresi'] 	= stripslashes($veri['dosyaadresi']);
		$reklamlar[$i][$veri['bolge']]['genislik'] 		= $veri['genislik'];
		$reklamlar[$i][$veri['bolge']]['yukseklik'] 	= $veri['yukseklik'];
		$reklamlar[$i][$veri['bolge']]['kod'] 			= stripslashes($veri['kod']);
		
		$i++;
	}
	
	function reklamCagir($reklamid, $genislik, $yukseklik, $tip, $dosyaadresi, $kod)
	{
		if($tip == 1) // Resim
		{
			$reklam = "<a href=\"reklam.php?reklamid=$reklamid\"><img src=\"$dosyaadresi\" border=0 width=$genislik height=$yukseklik></a>";
		}
		elseif($tip == 2) // Flash
		{
			$reklam = "<script>getSWF($genislik, $yukseklik, \"$dosyaadresi\");</script>";
		}
		else
		{
			$reklam = $kod;
		}
		
		return $reklam;	
	}

?>