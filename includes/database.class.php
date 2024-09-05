<?php
// Define configuration
error_reporting( E_ALL );
ini_set("display_errors","off");
define("DB_HOST", "localhost");
define("DB_USER", "admin");
define("DB_PASS", "6LaE[azcsGCjUh8R");
define("DB_NAME", "project");

class Database
{
	private $host = DB_HOST;
	private $user = DB_USER;
	private $pass = DB_PASS;
	private $dbname = DB_NAME;
	
	private $dbh;
	private $error;
	private $stmt;
	
	public function __construct()
	{
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
		$options = array(
			PDO::ATTR_PERSISTENT    => true,
			PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION,
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
		);
		try
		{
			$this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
		}
		catch(PDOException $e)
		{
			$this->error = $e->getMessage();
		}
	}
	public function query($query)
	{
		$this->stmt = $this->dbh->prepare($query);
	}
	public function bind($param, $value, $type = null)
	{
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}
	public function dbclose()
	{
		$this->dbh=null;
	}
	public function execute()
	{
		return $this->stmt->execute();
	}
	public function resultset()
	{
		$this->execute("set names utf8");
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	public function single()
	{
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}
	public function rowCount()
	{
		return $this->stmt->rowCount();
	}
	public function lastInsertId()
	{
		return $this->dbh->lastInsertId();
	}
	public function beginTransaction()
	{
		return $this->dbh->beginTransaction();
	}
	public function endTransaction()
	{
		return $this->dbh->commit();
	}
	public function cancelTransaction()
	{
		return $this->dbh->rollBack();
	}
	public function debugDumpParams()
	{
		return $this->stmt->debugDumpParams();
	}
	public function insertdata($tablename,$other = array())
	{
		if(count($other) > 0)
		{
			$keys 	= array_keys($other);
			$columns = implode(",", $keys);
			$colVals = implode(",:", $keys);
			$sql=$this->dbh->prepare("INSERT INTO `{$tablename}` ( $columns) VALUES( :$colVals)");
			foreach($other as $k=>$v)
			{
				$sql->bindValue(":$k", $v);
			}
			$sql->execute();
			$this->dbh=null;
			return true;
		}
	}
}
if($action=="Add")
{
$db1 = new Database();
$db1->insertdata('users',array("name"=>$name,"gender"=>$gender,"email"=>$email,"department"=>$department,"year"=>$year,"q1"=>$q1,"q2"=>$q2,"q3"=>$q3,"q4"=>$q4,"q5"=>$q5,"q6"=>$q6,"q7"=>$q7,"q8"=>$q8,"q9"=>$q9,"q10"=>$q10,"q11"=>$q11,"q12"=>$q12,"q13"=>$q13,"q14"=>$q14,"q15"=>$q15,"q16"=>$q16,"q17"=>$q17,"q18"=>$q18,"q19"=>$q19,"q20"=>$q20,"q21"=>$q21));
$db1->dbclose();
}
?>