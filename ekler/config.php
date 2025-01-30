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

// MySQL Parametreleri
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "password";
$dbname = "nrnewsv1";

// Site Dizini

$rootPath = "f:/phpServer/Reactor/Core/htdocs/nrnewsv1.0"; //  C:/httpdocs/niziprehber.com gibi

$bolgeler = array(
					'ust' => 'Üst Logo Yaný',
					'sol_1' => 'Sol 1',
					'sol_2' => 'Sol 2',
					'sol_3' => 'Sol 3',
					'sag_1' => 'Sað 1',
					'sag_2' => 'Sað 2',
					'sag_3' => 'Sað 3',
					'orta_1' => 'Sayfa Orta 1',
					'orta_2' => 'Sayfa Orta 2',
					'orta_3' => 'Sayfa Orta 3',
					'haber' => 'Haber Detay Altý',
					); 
					
$reklamtip	= array('', 'Resim', 'Flash', 'Kod');

?>