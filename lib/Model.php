<?php
/**
* isma_framework
* 
* PHP Version 5.6.17
*
* @category FrameWork
* @author   isma91 <ismaydogmus@gmail.com>
* @license  http://www.gnu.org/licenses/agpl-3.0.fr.html
* @link     https://github.com/isma91/isma_framework
*/
namespace Ismaspace;
use Ismaspace\IsmaException;
if (!defined("framework_version") || !defined("framework_date_version")) {
    die("Access not allowed !!");
}
/**
 * Class Model
 *
 * An abstract class where you have all important method for every model
 * 
 * PHP Version 5.6.17
 *
 * @category Model
 * @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://www.gnu.org/licenses/agpl-3.0.fr.html
 * @link     https://github.com/isma91/isma_framework/blob/master/lib/Model.php
 */
abstract Class Model
{
	static private $_host,
	$_port,
	$_database,
	$_username,
	$_password,
	$_socket;
	static protected $pdo;

    /**
     * Construct
     *
     * Create a database connection with PDO
     *
     * @return Nothing
     */
    public function __construct()
    {
    	include_once __DIR__ . '/../config.php';
    	$connection = unserialize(constant('database_config'));
    	$this->_host     = $connection['host'];
    	$this->_port     = $connection['port'];
    	$this->_database = $connection['database_name'];
    	$this->_username = $connection['database_username'];
    	$this->_password = $connection['database_password'];
    	$this->_socket   = $connection['socket'];
    	if ($this->_socket === null) {
    		try {
    			self::$pdo = new \PDO("mysql:host=" . $this->_host . ";port=" . $this->_port . ";dbname=" . $this->_database, $this->_username, $this->_password);
    		}
    		catch(\PDOException $e)
    		{
				die(IsmaException::display_exception($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine(), $e->getTrace()));
			}
		} else {
			try {
				self::$pdo = new \PDO("mysql:host=" . $this->_host . ";port=" . $this->_port . ";dbname=" . $this->_database . ";" . $this->_socket, $this->_username, $this->_password);
			}
			catch(\PDOException $e)
			{
				die(IsmaException::display_exception($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine(), $e->getTrace()));
    		}
    	}
    }
	/*
	 * Get_pdo
	 *
	 * Function to get the pdo
	 *
	 * @return PDO; $pdo
	 */
	static public function get_pdo () {
		return self::$pdo;
	}
	/*
	 * Set_pdo
	 *
	 * Create a new PDO statement
	 *
	 * @param string;  $host      Host of the database
	 * @param integer; $port      Port of the database
	 * @param string;  $database  Name of the database
	 * @param string;  $username  Username to connect to the database
	 * @param string;  $password  Password to connect to the database
	 * @param string;  $Socket    Path of the mysql socket (linux only)
	 */
	static public function set_pdo ($host, $port, $database, $username, $password, $socket = null) {
		if (!empty($host) && !empty($database) && !empty($port) && !empty($username)) {
			if ($socket === null) {
				try {
					self::$pdo = new \PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $database, $username, $password);
				}
				catch(\PDOException $e)
				{
					die(IsmaException::display_exception($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine(), $e->getTrace()));
				}
			} else {
				try {
					self::$pdo = new \PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $database . ";" . $socket, $username, $password);
				}
				catch(\PDOException $e)
				{
					die(IsmaException::display_exception($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine(), $e->getTrace()));
				}
			}
		}
	}
    /**
     * Find_one
     *
     * Made an SQL request to find a match
     *
     * @param string; $where        the condition
     * @param array;  $placeholders the value of the condition
     *
     * @return Array
     */
    public function find_one ($where = null, $placeholders=array())
    {
    	$className = get_called_class();
    	if (preg_match('/app/', $className)) {
    		$className = str_replace('app\\', '', $className);
    	}
    	if (preg_match('/models/', $className)) {
    		$className = str_replace('models\\', '', $className);
    	}
    	if (preg_match('/Table/', $className)) {
    		$className = str_replace('Table', '', $className);
    	}
    	$className = lcfirst($className);
    	$className = rtrim($className, "s") . 's';
    	$db = self::$pdo;
    	if ($db === null) {
			die(IsmaException::display_exception("You must check your database configuration !!", 0, __FILE__, __LINE__, debug_backtrace()));
    	} else {
    		$sql = 'SELECT * FROM ' . $className . ' WHERE ' . $where;
    		$request = $db->prepare($sql);
    		$request->execute($placeholders);
    		$value = $request->fetch(\PDO::FETCH_ASSOC);
    		return $value;
    	}
    }
	/**
	 * Find_all
	 *
	 * Made an SQL request to find all
	 *
	 * @param string; $field The field that we want to get
	 *
	 * @return Array
	 */
	public function find_all ($field = "*", $placeholders=array())
	{
		$className = get_called_class();
		if (preg_match('/app/', $className)) {
			$className = str_replace('app\\', '', $className);
		}
		if (preg_match('/models/', $className)) {
			$className = str_replace('models\\', '', $className);
		}
		if (preg_match('/Table/', $className)) {
			$className = str_replace('Table', '', $className);
		}
		$className = lcfirst($className);
		$className = rtrim($className, "s") . 's';
		$db = self::$pdo;
		if ($db === null) {
			die(IsmaException::display_exception("You must check your database configuration !!", 0, __FILE__, __LINE__, debug_backtrace()));
		} else {
			$sql = 'SELECT ' . $field . ' FROM ' . $className;
			$request = $db->prepare($sql);
			$request->execute();
			$value = $request->fetchAll(\PDO::FETCH_ASSOC);
			$array_field = array();
			if ($field !== "*") {
				foreach ($value as $value_field) {
					foreach ($value_field as $val) {
						$array_field[$field][] = $val;
					}
				}
			} else {
				foreach ($value as $value_field) {
					foreach ($value_field as $key => $val) {
						$array_field[$key][] = $val;
					}
				}
			}
			return $array_field;
		}
	}
	/*
	 * Create_field
	 *
	 * Create a filed to add in the table with Create_table
	 *
	 * @param string; $type    Type of the field
	 * @param string; $name    Name of the field
	 * @param string: $length  Length of the value of the field
	 * @param string: $options Option for the field
	 * @param string; $default If the field have a default value
	 *
	 * @return string; The sql query
	 */
	public function create_field($type, $name, $length = null, $options = null, $default = null)
	{
		if (!empty($type) && !empty($name)) {
			if ($options === null) {
				$options = "";
			}
			if ($default === null) {
				$default = "";
			}
			if ($length === null) {
				$length = "";
			} else {
				$length = "(" . $length . ")";
			}
			if ($default === null) {
				$default = "";
			} else {
				$default = "DEFAULT" . " '" . $default . "'";
			}
			$type_name = strtoupper($type);
			switch ($type) {
				case "blob":
					$length = "";
					$default = "";
					break;
				case "boolean":
					$length = "";
					$default = "";
					break;
				case "char":
					break;
				case "date":
					$length = "";
					$default = "";
					break;
				case "datetime":
					$length = "";
					$default = "";
					break;
				case "decimal":
					break;
				case "double":
					$length = "";
					break;
				case "enum":
					if ($length === null) {
						return "";
					}
					if ($default !== null) {
						$validate_default = false;
						foreach (explode(",", $length) as $value) {
							if ($default === $value) {
								$validate_default = true;
								break;
							}
						}
						if ($validate_default === true) {
							$default = "DEFAULT '" . " " . $default . "'";
						} else {
							$default = "DEFAULT NULL";
						}
					}
					break;
				case "float":
					break;
				case "increments":
					$type_name = "INT";
					$options = "NOT NULL PRIMARY KEY AUTO_INCREMENT";
					$default = "";
					break;
				case "integer":
					break;
				case "longtext":
					$default = "";
					$length = "";
					break;
				case "mediumint":
					break;
				case "mediumtext":
					$default = "";
					$length = "";
					break;
				case "smallint":
					break;
				case "varchar":
					break;
				case "text":
					$length = "";
					break;
				case "time":
					$length = "";
					$default = "";
					break;
				case "timestamp":
					$length = "";
					$default = "DEFAULT CURRENT_TIMESTAMP";
					break;
				default:
					break;
			}
			return "`$name`" . " " . "$type_name" . "$length" . " " . $options . " " . $default;
		}
		return "";
	}
	/*
	 * Create_table
	 *
	 * Create a table in the database of the framework
	 *
	 * @param string; $table_name  the table name
	 * @param array;  $array_field array of the field and type
	 *
	 * @return string; The Final sql query to create the table
	 */
	public function create_table ($table_name, array $array_field)
	{
		if (!empty($table_name) && !empty($array_field)) {
			$db = self::$pdo;
			if ($db === null) {
				die(IsmaException::display_exception("You must check your database configuration !!", 0, __FILE__, __LINE__, debug_backtrace()));
			} else {
				$sql = "CREATE TABLE IF NOT EXISTS `$table_name`(";
				for ($i = 0; $i < count($array_field); $i = $i + 1) {
					if ($i === count($array_field) - 1) {
						$sql = $sql . $array_field[$i];
					} else {
						$sql = $sql . $array_field[$i] . ", ";
					}
				}
				$sql = $sql . ");";
				return $sql;
			}
		}
	}
	/*
	 * Database_execute
	 *
	 * Function to execute all sql request
	 *
	 * @param string; $sql The sql query
	 *
	 * @return void
	 */
	static public function database_execute ($sql) {
		if (!empty($sql)) {
			if (self::$pdo === null) {
				die(IsmaException::display_exception("You must check your database configuration !!", 0, __FILE__, __LINE__, debug_backtrace()));
			} else {
				try {
					self::$pdo->exec($sql);
				} catch (\PDOException $e) {
					die(IsmaException::display_exception($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine(), $e->getTrace()));
				}
			}
		}
	}
}