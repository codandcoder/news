<?php

function makeCuff($text){

	$find 		= array('ý','i','þ','ð');
	$replace 	= array('I','Ý','þ','Ð');
	
	$text 		= str_replace($find,$replace,$text);
	$text		= strtoupper($text);
	
	return $text;
}


function getNewsType($type){

	if($type == 1){
	return " flash";
	}elseif($type == 2){
	return " private";
	}elseif($type == 3){
	return " video";
	}else{
	return NULL;
	}

}

function active_passive($value){

	if($value == "Y"){
		$out = "<font color=\"green\">Aktif</font>";
	}else{
		$out = "<font color=\"red\">Pasif</font>";
	}
	
	return $out;

}

function clean_username($username)
{
	$username = substr(htmlspecialchars(str_replace("\'", "'", trim($username))), 0, 25);
	$username = login_ltrim($username, "\\");
	$username = str_replace("'", "\'", $username);

	return $username;
}


function login_ltrim($str, $charlist = false)
{
	if ($charlist === false)
	{
		return ltrim($str);
	}
	
	$php_version = explode('.', PHP_VERSION);

	// php version < 4.1.0
	if ((int) $php_version[0] < 4 || ((int) $php_version[0] == 4 && (int) $php_version[1] < 1))
	{
		while ($str{0} == $charlist)
		{
			$str = substr($str, 1);
		}
	}
	else
	{
		$str = ltrim($str, $charlist);
	}

	return $str;
}



function time_to_now($time) {  
$days = array(  
            "Pazar",  
            "Pazartesi",  
            "Sal&#305;",  
            "Çar&#351;amba",  
            "Per&#351;embe",  
            "Cuma",  
            "Cumartesi"  
        );  

$months =array(  
            NULL,  
            "Ocak",  
            "&#350;ubat",  
            "Mart",  
            "Nisan",  
            "May&#305;s",  
            "Haziran",  
            "Temmuz",  
            "A&#287;ustos",  
            "Eylül",  
            "Ekim",  
            "Kas&#305;m",  
            "Aral&#305;k"  
        ); 
 
$date = date("d",$time)." ".$months[date("n",$time)]." ".date("Y",$time)." ".$days[date("w",$time)]." Saat ".date("H:i",$time);  

  return $date;  
}


function valid_email($email) {
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
	

function seo($str) {
		$str=strtolower($str);
		
		$find = array("'",',', ' ', '&gt;', '&lt;', '?', '.', '&quot;', '&#039', ';', '#' ,'&amp','/','=','-','+',':','@',
		'Þ','þ','Ö','ö','Ð','ð','Ç','ç','Ý','ý','Ü','ü');
		$replace = array('','_', '_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_',
		's','s','o','o','g','g','c','c','i','i','u','u');
		$str = str_replace($find,$replace,$str);
		
		$str = str_replace("_","-",$str);
		return $str;
	}

function paging($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = TRUE)
{

	$total_pages = ceil($num_items/$per_page);

	if ( $total_pages == 1 )
	{
		return '';
	}
	
	
	$on_page = floor($start_item / $per_page) + 1;

	$page_string = '';
	
	if ( $total_pages > 12 )
	{
		$init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;

		for($i = 1; $i < $init_page_max + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<b><span class="page_link_active">' . $i . '. </span></b>' : '<a href="' . $base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page )  . '" class="page_link">' . $i . '.</a> ';
		}

		if ( $total_pages > 3 )
		{
			if ( $on_page > 1  && $on_page < $total_pages )
			{

				$init_page_min = ( $on_page > 4 ) ? $on_page : 5;
				$init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;

				for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
				{
					$page_string .= ($i == $on_page) ? '<b><span class="page_link_active">' . $i . '. </span></b>' : '<a class="page_link" href="' . $base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) . '">' . $i . '.</a> ';

				}

			}

			for($i = $total_pages - 2; $i < $total_pages + 1; $i++)
			{
				$page_string .= ( $i == $on_page ) ? '<b><span class="page_link_active">' . $i . '. </span></b>'  : '<a class="page_link" href="' . $base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page )  . '">' . $i . '.</a> ';
			}
		}
	}
	else
	{
		for($i = 1; $i < $total_pages + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<b><span class="page_link_active">' . $i . '. </span></b>' : '<a href="' . $base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) . '" class="page_link">' . $i . '.</a> ';
		}
	}

	if ( $add_prevnext_text )
	{
		if ( $on_page > 1 )
		{
			$page_string = ' <img src="images/prev.gif" align="absmiddle" alt="Önceki Sayfa"> <a href="' . $base_url . "&amp;start=" . ( ( $on_page - 2 ) * $per_page )  . '">Önceki</a>&nbsp;' . $page_string;
		}

		if ( $on_page < $total_pages )
		{
			$page_string .= ' <a href="' . $base_url . "&amp;start=" . ( $on_page * $per_page ) . '"> Sonraki</a>&nbsp;<img src="images/next.gif" align="absmiddle" alt="Sonraki Sayfa">';
		}
		
	}
	
	$page_string = '<div id="paging"><div class="onpage">Þuan <b>'.$on_page.'.</b> Sayfadasýnýz</div><div class="pages">'.$page_string.'</div></div>';
	// $page_string = 'Sayfalar : ' . $page_string;

	return $page_string;
}
	

?>