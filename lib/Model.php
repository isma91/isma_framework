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
    			var_dump($e->getMessage());
    		}
    	} else {
    		try {
    			self::$pdo = new \PDO("mysql:host=" . $this->_host . ";port=" . $this->_port . ";dbname=" . $this->_database . ";" . $this->_socket, $this->_username, $this->_password);
    		}
    		catch(\PDOException $e)
    		{
    			var_dump($e->getMessage());
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
    public function find_one($where = null, $placeholders=array())
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
    	$className = $className . 's';
    	$db = self::$pdo;
    	if ($db === null) {
    		var_dump("You must check your database configuration !!");
    	} else {
    		$sql = 'SELECT * FROM ' . $className . ' WHERE ' . $where;
    		$request = $db->prepare($sql);
    		$request->execute($placeholders);
    		$value = $request->fetch(\PDO::FETCH_ASSOC);
    		return $value;
    	}
    }
}