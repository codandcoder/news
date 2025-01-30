<?php

		session_start();


		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~~~ Ýncler Yapýlýyor ~~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		
		include("./includes.php");
		

if (isset( $_POST['submit'] )) {

		$username=clean_username(trim($_POST['username']));
		$password=addslashes(trim($_POST['password']));
		
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~ Kontrol Yapýlýyor ~~~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		
		if(!$username) {
				echo "<script>alert('Lütfen Kullanýcý adýnýzý girin'); document.location.href='login.php'</script>\n";
				exit();
		
		}
		
		if(!$password){
				echo "<script>alert('Lütfen Þifrenizi girin'); document.location.href='login.php'</script>\n";
				exit();
		}
		
		$password=md5($password);


		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		//~~~~~~~~~~~~~ Sorgu Yapýlýyor ~~~~~~~~~~//
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		
		$sql 		= "SELECT author_id, name, lastvisit
					   FROM authors
					   WHERE username='" . str_replace("\\'", "''", $username) . "'
					   AND password='$password'";
			
		$query=$db->write_query($sql) or die($db->sql_error());
		$count=$db->sql_numrows($query);
		$row=$db->sql_fetcharray($query);


		if($count<1){
		
			echo "<script>alert('Kullanýcý adýnýzý ve/veya Þifrenizi yanlýþ girdiniz');
				  document.location.href='login.php'</script>\n";
			exit;
			
		}else{
	
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			//~~~~~~~~~~~~~ Giriþ Yapýlýyor ~~~~~~~~~~//
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//	
			
			$log_author_id 	= $row[author_id];
			$log_name		= $row[name];
			$log_lastvisit 	= $row[lastvisit];
			$log_username 	= $username;
			$log_password 	= $password;
			
			
			session_register("log_author_id");
			session_register("log_username");
			session_register("log_password");
			session_register("log_name");
			session_register("log_lastvisit");
				
			$visit_time = time();
			$db->write_query("UPDATE authors SET lastvisit = '$visit_time' WHERE author_id = '".$row[author_id]."'");
			
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			//~~~~~~~~~~~~~ Giriþ Yapýldý ~~~~~~~~~~~~//
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
			
			header("location: index.php");
			exit;
		}
}
?>
<title>Yazar Giriþ | <?=$settings['site_title']?></title>
<link rel="stylesheet" href="images/style.css" type="text/css">
<center>
<div id="login_form"><br />
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="5%">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td width="6%">&nbsp;</td>
    </tr>
    <tr>
      <td height="196">&nbsp;</td>
      <td width="54%" align="right" valign="top"><table width="94%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="64"><img src="images/login_logo.jpg" width="183" height="49" /></td>
        </tr>
        <tr>
          <td height="73"><img src="images/editor_text.jpg" width="162" height="32" /></td>
        </tr>
        <tr>
          <td id="login_footer_text"><p><strong>e-posta : <a href="mailto:mahmuttt88@yahoo.com">mahmuttt88@yahoo.com</a></strong></p>
            <p>Bu yazýlýmýn tüm haklarý Mahmut ÖZDEMÝR'e aittir.<br />
              Daha fazla bilgi için <a href="http://mahmut.niziprehber.com" target="_blank">http://mahmut.niziprehber.com</a></p></td>
        </tr>
      </table></td>
      <td width="35%" align="center" valign="top"><table width="94%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="17" colspan="2" align="center" class="login_text">&nbsp;</td>
        </tr>
       <form method="post" action="<?=$_SERVER['PHP_SELF']?>">
	    <tr>
          <td  height="36" colspan="2" align="center" class="login_text">Giriþ Ekraný </td>
        </tr>
        <tr>
          <td height="25" class="login_text_1">Kullanýcý  :            </td>
          <td height="25"><input name="username" type="text" class="login_form" id="username" size="15" /></td>
        </tr>
        <tr>
          <td height="25" class="login_text_1">Þifre :            </td>
          <td height="25"><input name="password" type="password" class="login_form" id="password" size="15" /></td>
        </tr>
        <tr>
          <td height="20" colspan="2" align="right" style="padding-right:15px"><input name="submit" type="submit" class="login_button" id="submit" value="giriþ" /></td>
        </tr>
		</form>
        <tr>
          <td height="50" colspan="2">&nbsp;</td>
        </tr>
      </table></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
</center>
 <p align="center" style="color:#2F4457;">Yazýlým & Tasarým : Mahmut ÖZDEMÝR [ cep : 05373622826 ]</p>