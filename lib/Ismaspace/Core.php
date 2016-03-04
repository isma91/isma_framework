<?php
/**
 * isma_framework
 * 
 * PHP Version 5.6.17
 *
 * @category Controller
 * @package  Controller
 * @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://www.gnu.org/licenses/agpl-3.0.fr.html
 * @link     https://github.com/isma91/isma_framework
 */
namespace Ismaspace;
/**
 * Class Core
 *
 * The core of the framework 
 *
 * 
 * PHP Version 5.6.17
 *
 * @category Controller
 * @package  Controller
 * @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://www.gnu.org/licenses/agpl-3.0.fr.html
 * @link     https://github.com/isma91/isma_framework/blob/master/lib/Ismaspace/Core.php
 */
class Core
{
	static public function Run ()
	{
		if (isset($_GET["page"])) {
			if (file_exists(constant("controllers_path") . ucfirst($_GET["page"]) . "Controller.php")) {
				require_once(constant("controllers_path") . ucfirst($_GET["page"]) . "Controller.php");
				$class_name = ucfirst($_GET["page"] . "Controller");
				$class = new $class_name();
				if (empty($_GET['action'])) {
					$action = 'indexAction';
				} else {
					$action = $_GET['action'] . 'Action';
				}
				if (!method_exists($class, $action)) {
					var_dump("Controller " . ucfirst($_GET["page"]) . "Controller" . " have not a method called " . $action . " !!!");
				} else {
					$class->$action();
				}
			} else {
				var_dump("Controller " . ucfirst($_GET["page"]) . "Controller" . " not found !!!");
			}
		}
	}
}