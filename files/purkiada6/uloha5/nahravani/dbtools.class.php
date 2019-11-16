<?php
/*
 * Tools for working with MySQL database in PHP
 *
 * @author  Martin Fiala - Grafik studio M - info@grafikstudio-m.cz
 * @license GNU GPL v3
 * @link    http://dbtools.grafikstudio-m.com
 * @package dbtools
 * @version 1
 * @date    1 September 2012
 *
 */
class dbTools{
	
	private $con;
	
	public function dbConnect($server, $username, $pass){
		$this->con = @mysql_connect($server,$username,$pass);
		if (!$this->con){
			die('Could not connect: ' . mysql_error());
			return mysql_error();
  		}else{return true;}
	}
	
	public function dbSelect($db){
		$con = mysql_select_db($db, $this->con);
		if (!$con){
			die('DB Select: ' . mysql_error());
			return mysql_error();
  		}else{return true;}	
	}
	
	public function dbClose(){
		mysql_close($this->con);
	}
	
	public function query($string, $debug=0){
		if ($debug == 1){
			print $string;
		}
		if ($debug == 2){
			error_log($string);
		}
		$result = mysql_query($string, $this->con);
		if ($result == false)
		{
			error_log("SQL error: ".mysql_error()."\n\nQuery: $string\n");
			die("SQL error: ".mysql_error()."\b<br>\n<br>Query: $string \n<br>\n<br>");
		}
		return $result;
	}
	
	public function dbReturn($what, $where, $if, $debug=0){
		$co="SELECT ".$waht." FROM ".$where." WHERE ".$if; 
		(list($value) = mysql_fetch_row($this->query($co, $debug)));
		
		return $value;
	}
	public function dbCount($where, $if, $debug=0){
		return mysql_num_rows($this->query("SELECT * FROM ".$where." WHERE ".$if, $debug));
	}
	
	public function dbList($sql, $debug=0){
		$result = $this->query($sql, $debug);		
		if($lst = mysql_fetch_row($result))
		{
			mysql_free_result($result);
			return $lst;
		}
		mysql_free_result($result);
		return false;
	}
	
	public function dbAssoc($sql, $debug=0){
		$result = $this->query($sql, $debug);
		if($lst = mysql_fetch_assoc($result))
		{
			mysql_free_result($result);
			return $lst;
		}
		mysql_free_result($result);
		return false;
	}
	
	public function sql($sql, $debug=0){
		$lst = $this->dbList($sql, $debug);
		return is_array($lst)?$lst[0]:false;
	}
	
	public function dbTable($sql, $debug=0){
		$result = $this->query($sql, $debug);
		
		$table = array();
		if (mysql_num_rows($result) > 0)
		{
			$i = 0;
			while($table[$i] = mysql_fetch_assoc($result)) 
				$i++;
			unset($table[$i]);                                                                                  
		}                                                                                                                                     
		mysql_free_result($result);
		return $table;
	}
	
	public function deleteTable($table, $debug=0){
		return $this->query("DROP TABLE `".$table."`", $debug);
	}
	
	public function charSet($kod='utf8', $debug=0){
		mysql_set_charset($kod,$this->con);
		return $this->query("SET NAMES '".$kod."';", $debug);	
	}
	
	public function truncate($table, $debug=0){
		return $this->query("TRUNCATE `".$table."`", $debug);
	}
	
	public function delete($table, $if, $debug=0){
		return $this->query("DELETE FROM `".$table."` WHERE ".$if, $debug);
	}
	
	public function explain($table, $debug=0){
		return $this->dbAssoc("EXPLAIN SELECT * FROM  `".$table."`", $debug);
	}
	
	public function status($table, $debug=0){
		return $this->dbAssoc("SHOW TABLE STATUS LIKE  '".$table."'", $debug);
	}
	
	public function returnID(){
		return mysql_insert_id();
	}
	
	public function maxID($table, $colums='id', $debug=0){
		return $this->query("SELECT MAX(id) FROM `".$table."`", $debug);
	}
	
	public function tableSize($debug=0){
		return $this->dbTable("SELECT CONCAT(table_name),
								CONCAT(ROUND(table_rows/1000000,2),'M') rows,
								CONCAT(ROUND(data_length/(1024*1024*1024),2),'G') DATA,
								CONCAT(ROUND(index_length/(1024*1024*1024),2),'G') idx,
								CONCAT(ROUND((data_length+index_length)/(1024*1024*1024),2),'G') total_size,
								ROUND(index_length/data_length,2) idxfrac 
								FROM information_schema.TABLES 
								ORDER BY data_length+index_length DESC;", $debug);
	}
	
	public function backup($tables = '*', $dir='', $explode=';', $debug=0){
		$return='';
		if($tables == '*')
		{
			$tables = array();
			$result = $this->query('SHOW TABLES', $debug);
			while($row = mysql_fetch_row($result))
			{
				$tables[] = $row[0];
			}
		}
		else
		{
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
		
		foreach($tables as $table)
		{
			$result = $this->query('SELECT * FROM '.$table, $debug);
			$num_fields = mysql_num_fields($result);
			
			$return.= 'DROP TABLE IF EXISTS '.$table.$explode;
			$row2 = mysql_fetch_row($this->query('SHOW CREATE TABLE '.$table, $debug));
			$return.= "\n\n".$row2[1].$explode."\n\n";
			
			for ($i = 0; $i < $num_fields; $i++) 
			{
				while($row = mysql_fetch_row($result))
				{
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$num_fields; $j++) 
					{
						$row[$j] = addslashes($row[$j]);
						if (isset($row[$j])) { $return.= "'".$row[$j]."'" ; } else { $return.= "''"; }
						if ($j<($num_fields-1)) { $return.= ','; }
					}
					$return.= ")".$explode."\n";
				}
			}
			$return.="\n\n\n";
		}
		if($dir=='time'){
			$soubor = fopen('./db-backup-'.time().'.sql', "w+");
			fwrite($soubor,$return);
			fclose($soubor);
			return $soubor;
		}elseif($dir!=''){
			$soubor = fopen($dir, "w+");
			fwrite($soubor,$return);
			fclose($soubor);
			return $soubor;
		}else{
			return	$return;
		}			
	}
	
	public function recovery($file, $explode=";", $debug=0){
		if(file_exists($file)){
			$db_file=file_get_contents($file);
		}else{
			$db_file=$file;
		}
		$db_file=explode($explode, $db_file);
		for($i=0; $i<count($db_file); $i++){
			$this->query($db_file[$i], $debug);	
		}
		return true;
	}
	
	public function tableExists($tableName, $debug=0){
		if(mysql_num_rows($this->query("SHOW TABLES LIKE '" . $tableName . "'", $debug))){
			return true;
		}else{
			return false;
		}
	}
	
	public function createDb($name, $debug=0){
		return $this->query("CREATE DATABASE IF NOT EXISTS '".$name."'", $debug);
	}
	
	public function createTable($name, $value=array(), $type='innodb', $debug=0){
		$return="CREATE TABLE  `".$name."`(";
		for($i=0; $i<count($value); $i++){
			$return.=$value[$i];
		}
		$return=substr($return,0,-1).') TYPE='.$type.';'; 
		return $this->query($return, $debug);
	}
	
	public function ctAddID($name='id', $size=255){
		return ($name." int(".$size.") NOT NULL auto_increment,");	
	}
	
	public function ctAddPrymaryKey($name='id'){
		return ("PRIMARY KEY (".$name."),");	
	}
	
	public function ctAdd($name, $value){
		return ($name." ".$value.",");	
	}
	
	public function update($table, $name, $value, $if, $escape=1, $debug=0){
		$command='';
		if(is_array($name) && is_array($value) && count($name)==count($value)){
			for($i=0; $i<count($name); $i++){
				$command.="`".$name[$i]."`='".$this->numeric($value[$i], $escape)."',";	
			}
			$command=substr($command,0,-1);
		}elseif(!is_array($name) && !is_array($value)){
			$command="`".$name."`='".$this->numeric($value, $escape)."'";
		}else{
			return false;	
		}
		$this->query("UPDATE `".$table."` SET `".$command."` WHERE ".$if.";", $debug);	
	}
	
	public function insert($table, $name, $value, $escape=1, $debug=0){
		$command1='';
		$command2='';
		if(is_array($name) && is_array($value) && count($name)==count($value)){
			for($i=0; $i<count($name); $i++){
				$command1.='`'.$name[$i].'`,';
				$command2.=" '".$this->numeric($value[$i], $escape)."',";	
			}
			$command1=substr($command1,0,-1);
			$command2=substr($command2,0,-1);
			$this->query("INSERT INTO `".$table."` (".$command1.") VALUES (".$command2.")", $debug);	
		}elseif($name=='' && is_array($value)){
			for($i=0; $i<count($value); $i++){
				$command2.=" '".$this->numeric($value[$i], $escape)."',";	
			}
			$command2=substr($command2,0,-1);
			$this->query("INSERT INTO `".$table."` VALUES (".$command2.")", $debug);
		}elseif($name!='' && $value!=''){
			$this->query("INSERT INTO `".$table."` (`".$name."`) VALUES ('".$this->numeric($value, $escape)."')", $debug);
		}else{
			return false;	
		}
		
	}
	
	private function numeric($value, $escape){
		if((is_numeric($value) && $escape==0) || (!is_numeric($value) && $escape==0)){
			return $value;
		}else{
			return mysql_real_escape_string($value);	
		}
	}
}
?>