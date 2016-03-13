<?php
/**
 * isma_framework
 *
 * PHP Version 5.6.17
 *
 * @category Framework
 * @package  Controller
 * @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://www.gnu.org/licenses/agpl-3.0.fr.html
 * @link     https://github.com/isma91/isma_framework
 */
namespace Ismaspace;
use Ismaspace\Controller;
if (!defined("framework_version") || !defined("framework_date_version")) {
    die("Access not allowed !!");
}
/**
 * Class IsmaExceptopn
 *
 * The custom exception of the framework
 *
 * PHP Version 5.6.17
 *
 * @category Controller
 * @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://www.gnu.org/licenses/agpl-3.0.fr.html
 * @link     https://github.com/isma91/isma_framework/blob/master/lib/Ismaspace/IsmaException.php
 */
class IsmaException extends \Exception
{
    public function __construct($message, $code, \Exception $previous)
    {
        parent::__construct($message, $code, $previous);
    }
    /*
     * Database_exception
     *
     * Display the PDOException
     *
     * @param string; $message The error message
     * @param string; $code    The error code
     * @param string; $file    The file where the error come
     * @param int;    $line    The line where the error come
     * @param array;  $trace   The error trace
     *
     * @return array; The PDOException parsed in an array
     */
    public function database_exception ($error_message, $error_code, $error_file, $error_line, $error_trace)
    {
        $array_exception = array();
        if (!empty($error_message) && !empty($error_file) && !empty($error_line) && !empty($error_trace)) {
                $database_config = unserialize(constant("database_config"));
                switch ($error_code) {
                    case 1045:
                        if (empty($database_config["database_username"])) {
                            $error_message = "You don't set a user to connect to the database !!";
                        } else {
                            if (empty($database_config["database_password"])) {
                                $error_message = "Access denied for user <span class='database_username'>" . $database_config["database_username"] . "</span>, maybe you forgot to write the password";
                            } else {
                                $error_message = "Access denied for user <span class='database_username'>" . $database_config["database_username"] . "</span>, maybe you're wrong by writing your password";
                            }
                        }
                        break;
                    case 2005:
                        $error_message = "The host <span class='host'>" . $database_config["host"] . "</span> wasn't a MySQL server";
                        break;
                    case 1049:
                        $error_message = "The database <span class='database_name'>" . $database_config["database_name"] . "</span> wasn't found";
                        break;
                }
                $array_trace = array();
            foreach ($error_trace as $trace) {
                    if (empty($trace["args"])) {
                        $error_args = "()";
                    } else {
                        $error_args = "(";
                        for ($i = 0; $i < count($trace["args"]); $i = $i + 1) {
                            if ($i !== count($trace["args"]) - 1) {
                                $end = ", ";
                            } else {
                                $end = "";
                            }
                            $error_args = $error_args . "'" . $trace["args"][$i] . "'" . $end;
                        }
                        $error_args = $error_args . ")";
                    }
                    array_push($array_trace, "Error in <span class='error_file'>" . $trace["file"] . "</span> line number <span class='error_line'>" . $trace["line"] . "</span> :<br/>Class <span class='error_class'>" . $trace["class"] . "</span> function <span class='error_function'>" . $trace["function"] . $error_args . "</span>  <span class='error_class'>" . $trace["class"] . "</span> <span class='error_type'>" . $trace["type"] . "</span><span class='error_function'>" . $trace["function"] . $error_args . "</span>");
                }
            $array_exception = array(
                    "error_message" => $error_message,
                    "error_code" => $error_code,
                    "error_file" => $error_file,
                    "error_line" => $error_line,
                    "error_traces" => array($array_trace)
                );
        }
            return $array_exception;
    }
    /*
     * Database_exception
     *
     * Display the exception in a html file
     *
     * @param string; $type    The type of error (pdo, runtime etc...)
     * @param string; $message The error message
     * @param string; $code    The error code
     * @param string; $file    The file where the error come
     * @param int;    $line    The line where the error come
     * @param array;  $trace   The error trace
     *
     * @return string;
     */
    static public function display_exception ($type, $message, $code, $file, $line, $trace)
    {
        if (!empty($type)) {
            switch ($type) {
                case "pdo":
                    $array_exception = self::database_exception($message, $code, $file, $line, $trace);
                    $array_exception["error_description"] = constant("error_description");
                    $array_exception["project_name"] = constant("project_name");
                    $array_exception["error_header"] = constant("error_header");
                    Controller::render("error:error.html", $array_exception, "public_path");
                break;
            }
        }
    }
}