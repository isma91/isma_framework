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
 * PHP Version 7.0.8
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
    /*
     * Insert
     *
     * Function to insert into SQL return true on SUCCESS or false on FAIL
     *
     * @param array  $fieldAndValue; the array who have the field => $value
     * @param boolean  $getLastId;     get the id of the insert
     *
     * @return boolean|array
     */
    public function insert (array $fieldAndValue, $getLastId = false)
    {
        $bdd = self::$pdo;
        if($bdd === null) {
            die(IsmaException::display_exception("You must check your database configuration !!", 0, __FILE__, __LINE__, debug_backtrace()));
        } else {
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
            $table = rtrim($className, "s") . 's';
            $query = "INSERT INTO `$table` (";
            foreach ($fieldAndValue as $field => $value) {
                $query = $query . "`$field`, ";
            }
            $query = substr($query, 0, -2) . ") VALUES (";
            foreach ($fieldAndValue as $field => $value) {
                if (!is_int($value)) {
                    $value = "'$value'";
                }
                $query = $query . "$value, ";
            }
            $query = substr($query, 0, -2) . ");";
            $sql = $bdd->prepare($query);
            if ($getLastId === true) {
                return array("execute" => $sql->execute(), "lastId" => $bdd->lastInsertId());
            } else {
                return $sql->execute();
            }
        }
    }
    /*
     * Select
     *
     * Function to select something in the SQL, return false in FAIL or an array in SUCCESS
     *
     * @param array  $field;     the array who have $field => $value
     * @param string $where;     the where statement
     * @param array  $innerJoin; Array of arrays for multiple inner join
     * @param string $other      Other thing to add at the end of the SQL query
     *
     * @return boolean|Array
     */
    public function select (array $field, $where = null, array $innerJoin = null, $other = null)
    {
        $bdd = self::$pdo;
        if($bdd === null){
            die(IsmaException::display_exception("You must check your database configuration !!", 0, __FILE__, __LINE__, debug_backtrace()));
        } else {
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
            $table = rtrim($className, "s") . 's';
            $query = "SELECT ";
            foreach ($field as $item) {
                $query = $query . "$item ,";
            }
            $query = substr($query, 0, -1) . "FROM `$table`";
            if (!is_null($innerJoin)) {
                foreach ($innerJoin as $value) {
                    $query = $query . " INNER JOIN " . $value['table'] . " ON " . $value['on'];
                }
            }
            if (!is_null($where)) {
                $query = $query . " WHERE $where";
            }
            if (!is_null($other)) {
                $query = $query . " $other";
            }
            $sql = $bdd->prepare($query);
            if ($sql->execute()) {
                return $sql->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        }
    }
    /*
     * Update
     *
     * Function to update something in the SQL, return false in FAIL or TRUE in SUCCESS
     *
     * @param string $table; the table name
     * @param string $where; the where statement
     * @param array  $fieldAndValue; the array who have $field => $value
     *
     * @return boolean
     */
    public function update (array $fieldAndValue, $where)
    {
        $bdd = self::$pdo;
        if($bdd === null) {
            die(IsmaException::display_exception("You must check your database configuration !!", 0, __FILE__, __LINE__, debug_backtrace()));
        } else {
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
            $table = rtrim($className, "s") . 's';
            $query = "UPDATE $table SET ";
            foreach ($fieldAndValue as $field => $value) {
                if (!is_int($value)) {
                    $value = "'$value'";
                }
                $query = $query . "$field = $value, ";
            }
            $query = substr($query , 0, -2) . " WHERE " . $where;
            $sql = $bdd->prepare($query);
            return $sql->execute();
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
            if ($options == null) {
                $options = "";
            }
            if ($default == null) {
                $default = "";
            }
            if ($length == null) {
                $length = "";
            } else {
                $length = "(" . $length . ")";
            }
            if ($default == null) {
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
    /*
     * Seed_to_database
     *
     * function to parse the $array_array_field to convert him to SQL
     *
     * @param array; $array_array_field Multiple array where is the field to fill
     * @param string; $table_name The table name of the database, was the function name in the DatabaseSeeder Class
     *
     * @return void
     */
    public function seed_to_database (array $array_array_field, $table_name)
    {
        $table_name = substr($table_name, 0 , -5);
        $sql = "";
        foreach ($array_array_field as $array_field)
        {
            $tmp_sql = "INSERT INTO `$table_name` (";
            foreach ($array_field as $field => $value) {
                $tmp_sql = $tmp_sql . "$field, ";
            }
            $tmp_sql = substr($tmp_sql, 0, -2) . ") VALUES (";
            foreach ($array_field as $field => $value) {
                if (!is_int($value)) {
                    $value = "'$value'";
                }
                $tmp_sql = $tmp_sql . "$value, ";
            }
            $tmp_sql = substr($tmp_sql, 0, -2) . ");";
            $sql = $sql . $tmp_sql;
        }
        return $sql;
    }
}
