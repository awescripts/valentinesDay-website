<?php
// Define configuration
error_reporting( E_ALL );
ini_set("display_errors","off");
define("DB_HOST", "localhost");
define("DB_USER", "admin");
define("DB_PASS", "6LaE[azcsGCjUh8R");
define("DB_NAME", "valentine");

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
	public function dbclose()
	{
		$this->dbh=null;
	}
	public function execute()
	{
		return $this->stmt->execute();
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

function sanitise_store($data)
{
$data = trim($data);
$data = addslashes($data);
$data = htmlentities($data);
return $data;
}
function sanitise_retrieve($data)
{
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}


$name=strip_tags($_POST['name']);
$email=strip_tags($_POST['email']);
$year=strip_tags($_POST['year']);
$gender=strip_tags($_POST['gender']);
$department=strip_tags($_POST['department']);

$q1=strip_tags($_POST['q1']);
$q2=strip_tags($_POST['q2']);
$q3=strip_tags($_POST['q3']);
$q4=strip_tags($_POST['q4']);
$q5=strip_tags($_POST['q5']);
$q6=strip_tags($_POST['q6']);
$q7=strip_tags($_POST['q7']);
$q8=strip_tags($_POST['q8']);
$q9=strip_tags($_POST['q9']);
$q10=strip_tags($_POST['q10']);
$q11=strip_tags($_POST['q11']);
$q12=strip_tags($_POST['q12']);
$q13=strip_tags($_POST['q13']);
$q14=strip_tags($_POST['q14']);

$db1 = new Database();
$db1->insertdata('users',array("name"=>$name,"gender"=>$gender,"email"=>$email,"department"=>$department,"year"=>$year,"q1"=>$q1,"q2"=>$q2,"q3"=>$q3,"q4"=>$q4,"q5"=>$q5,"q6"=>$q6,"q7"=>$q7,"q8"=>$q8,"q9"=>$q9,"q10"=>$q10,"q11"=>$q11,"q12"=>$q12,"q13"=>$q13,"q14"=>$q14));
$db1->dbclose();

header('Location:'."success-page.html");
?>