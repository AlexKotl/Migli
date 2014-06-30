<?
###########################################
### Класс для выполнения запросов к базе
###########################################
class CMysql {
	private $link, $script_time, $debug_mode = true;
	public $table_name;

   // connect to database
   function CMysql($database='',$params=array()) {
   	include dirname(__FILE__)."/../admin/inc/db_config.php";
	   $this->link = mysql_connect($db_server,$db_user,$db_password) or die("Cannot connect to DB $db_server:$db_user");
	   $this->table_name = $db_name;
	   if ($database=='') mysql_select_db($db_name); // если дефолтная база, то выбираем ее по умолчанию
	   mysql_query("SET CHARSET utf8");
   }

   function query($string, $return_array=false) {
      if ($return_array==='debug') { echo $string; return true;}
      $start_time = microtime(true);
      if (isset($this)) {
      	if (get_class($this)=='CMysql' && isset($this->link)) { $result = mysql_query($string, $this->link) ; }
      	else $result = mysql_query($string);
      }
      else $result = mysql_query($string);
      $end_time = microtime(true);
      //echo ($end_time - $start_time).'<li>';
      if (DEBUG_MODE===true && ($end_time - $start_time)*100>5) {
      	$info = debug_backtrace();
      	$stack_num = 0;
      	while ($info[$stack_num][file]==__FILE__) $stack_num++; // определяем уровень стэка, чтоб файл не был текущим
      	echo "<li>Query too slow (".round(($end_time - $start_time)*100,2)." ms): $string (Line ".$info[$stack_num][line]." in ".basename($info[$stack_num][file]).")";
      }
      if ($result===false) return false; //mysql_error();
      if ($return_array===true) {
      	$arr = array();
      	while ($row=mysql_fetch_array($result)) array_push($arr,$row);
      	$result = $arr;
      }
      return $result;
   }
   
   function fetch(&$res) {
		return mysql_fetch_array($res);
   }

   function get_row($string) {
      if (isset($this)) {
      	if (get_class($this)=='CMysql' && isset($this->link)) {  $res = $this->query($string, $this->link); }
      	else $res = self::query($string);
      }
      else { $res = self::query($string); }
      
      if ($res===false) return false;
      if (mysql_num_rows($res)==0) return false;
      $row = mysql_fetch_array($res);
      if (count($row)==2) return $row[0];
      else return $row;
   }

   function filter($str,$rule='') {
   	if ($rule=='email') return preg_replace("/([^a-zA-Z0-9@_\.\-])/","",$str);
   	$str = str_replace(array("'",'"'),'',$str);
   	return $str;
   }

   function last_insert_id($table) {
      return self::get_row("select LAST_INSERT_ID() from $table");;
   }

   function insert($table, $vars, $debug='') {
   	$name_arr = $value_arr = array();
   	foreach ($vars as $k=>$v) {
   		if (is_int($k)) {
   		   if ($_GLOBAL[$v]=='') $_GLOBAL[$v] = $_POST[$v];
   			array_push($name_arr,$v);
   			array_push($value_arr,'"'.$_GLOBAL[$v].'"');
   		}
   		else {
   			array_push($name_arr,$k);
   			array_push($value_arr,'"'.$v.'"');
   		}
   	}
   	$res = self::query("insert into $table (".implode(',',$name_arr).") values (".implode(', ',$value_arr).")", $debug);
   	if (!$res) return false; //return mysql_error($res);
   	else return true;
   }

   function update($table, $id, $vars, $debug='') {
   	$id = (int)$id;
   	if ($id==0) return false;
   	$query_str = '';
   	$is_first = true;
   	foreach ($vars as $k=>$v) {
   		if (!$is_first) $query_str .= ", ";
   		if (is_int($k)) {
   		   if ($_GLOBAL[$v]=='') $_GLOBAL[$v] = $_POST[$v];
   		   $query_str .= "$v = \"".$_GLOBAL[$v].'"';
   		}
   		else {
   			$query_str .= "$k = \"$v\"";
   		}
   		$is_first = false;
   	}
   	$res = self::query("update $table set $query_str where id='$id'", $debug);
   	if (!$res) return mysql_error($res);
   	else return true;
   }

   // функция для измерения времени выполнения
   function start_time() {
   	$this->script_time = microtime(true);
   }
   function end_time($display=true) {
   	$delta = microtime(true) - $this->script_time;
   	if ($display) echo "<li>Time: ".round($delta*100,1).' ms';
   	return $delta;
   }

}

?>