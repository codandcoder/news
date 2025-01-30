<?

class mySQL{

var $sql_link = "";
var $host = "localhost";
var $username = "";
var $password = "";

function sql_connect($dbname)
{
$this->sql_link = @mysql_connect($this->host , $this->username , $this->password);
if(!$this->sql_link) {echo"Veri Tabani Baglanti Hatasi"; exit();}
if(@!mysql_select_db($dbname , $this->sql_link)){echo"Tablo Mevcut Degil"; exit();}
}

function write_query($sorgu)
{
if($this->sql_link) return mysql_query($sorgu); else return false;
}

function read_query($sorgu)
{
if($this->sql_link) return mysql_unbuffered_query($sorgu); else return false;
}

function sql_fetchobject($sorgu)
{
if($this->sql_link) return mysql_fetch_object($sorgu); else return false;
}

function sql_freeresult($sorgu)
{
if($this->sql_link) return mysql_free_result($sorgu); else return false;
}

function sql_fetcharray($sorgu)
{
if($this->sql_link) return mysql_fetch_array($sorgu); else return false;
}

function sql_fetchrow($sorgu)
{
if($this->sql_link) return mysql_fetch_row($sorgu); else return false;
}

function sql_fieldname($sorgu , $i)
{
if($this->sql_link) return mysql_field_name($sorgu , $i); else return false;
}

function sql_nextid()
{
if($this->sql_link) return @mysql_insert_id($this->sql_link);	else return false;
}

function sql_numrows($sorgu)
{
if($this->sql_link) return mysql_num_rows($sorgu); else return false;
}

function sql_error()
{
if($this->sql_link) return mysql_error(); else return "";
}

function sql_close()
{
if($this->sql_link) return mysql_close($this->sql_link); else return false;
}



}//end db

?>
