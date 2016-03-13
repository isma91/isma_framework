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
use app\controllers;
use Ismaspace\IsmaException;
if (!defined("framework_version") || !defined("framework_date_version")) {
    die("Access not allowed !!");
}
/**
 * Class Core
 *
 * The core of the framework 
 *
 * 
 * PHP Version 5.6.17
 *
 * @category Controller
 * @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://www.gnu.org/licenses/agpl-3.0.fr.html
 * @link     https://github.com/isma91/isma_framework/blob/master/lib/Ismaspace/Core.php
 */
class Core
{
	/**
     * Register_autoload
     *
     * A personal autoload
     *
     * @return Nothing
     */
	public static function register_autoload()
	{
		spl_autoload_register('self::auto_include_once', true);
	}
    /**
     * Auto_include_once
     *
     * Add automatically some include of the given class name
     *
     * @param string; $class_name name of the called class
     *
     * @return Nothing
     */
    public static function auto_include_once ($class_name)
    {
		//var_dump($class_name);
    	if (substr($class_name, 0, 9) === "Ismaspace") {
    		$class = str_replace("Ismaspace\\", "", $class_name);
    		if ($class === "Controller") {
    			include_once constant("controllers_path") . $class . ".php";
    		} elseif ($class === "Model") {
    			include_once constant("lib_path") . $class . ".php";
    		} elseif ($class === "Migration") {
    			include_once constant("database_path") . $class . ".php";
    		} elseif ($class === "IsmaException") {
				include_once constant("ismaspace_path") . "IsmaException.php";
			}
    	}
    	if (substr($class_name, 0, 10) === "app\models") {
    		$class = str_replace("app\models\\", "", $class_name);
    		include_once constant("models_path") . $class . ".php";
    	}
    }
    public static function Run ()
    {
    	try {
    		Core::register_autoload();
    		if (isset($_GET["page"])) {
                $class_name_page = ucfirst($_GET["page"]);
                if (substr($class_name_page, -10) === "Controller") {
                    $class_name_page = substr($class_name_page,0 , -10);
                }
    			if (file_exists(constant("controllers_path") . $class_name_page . "Controller.php")) {
    				require_once(constant("controllers_path") . $class_name_page . "Controller.php");
    				$class_name = 'app\controllers\\' . $class_name_page . "Controller";
    				$class = new $class_name();
    				if (empty($_GET['action'])) {
    					$action = 'indexAction';
    				} else {
    					$action = rtrim($_GET['action'], "Action") . 'Action';
    				}
    				if (!method_exists($class, $action)) {
						die(IsmaException::display_exception("Controller <span class='error_controller'>" . $class_name_page . "Controller</span>" . " have not a method called <span class='error_method'>" . $action . "</span> !!!", 0, __FILE__, __LINE__, debug_backtrace()));
					} else {
						$class->$action();
					}
				} else {
					die(IsmaException::display_exception("Controller <span class='error_controller'>" .$class_name_page . "Controller" . "</span> not found !!!", 0, __FILE__, __LINE__, debug_backtrace()));
    			}
    		}
    	} catch (\Exception $e) {
			die(IsmaException::display_exception($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine(), $e->getTrace()));
    	}
    }
}