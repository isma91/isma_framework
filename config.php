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
/**
 * Config.php
 *
 * Config file for the framework 
 * 
 * PHP Version 5.6.17
 *
 * @category Controller
 * @package  Controller
 * @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://www.gnu.org/licenses/agpl-3.0.fr.html
 * @link     https://github.com/isma91/isma_framework/blob/master/config.php
 */
/* DO NO CHANGES THESE CONSTANT !!
 *
 * We define an alias for DIRECTORY_SEPARATOR
 * And we define some important path like the controllers, models etc...
 * These constant are created for be used more quickly than the original path
 */
if (!defined("DS")) {
	define('DS', DIRECTORY_SEPARATOR);
}
define("framework_path", rtrim(__DIR__, constant("DS")) . constant("DS"));
define("lib_path", constant("framework_path") . "lib" . constant("DS"));
define("public_path", constant("framework_path") . "public" . constant("DS"));
define("controllers_path", constant("framework_path") . "app" . constant("DS") . "controllers" . constant("DS"));
define("models_path", constant("framework_path") . "app" . constant("DS") . "models" . constant("DS"));
define("views_path", constant("framework_path") . "app" . constant("DS") . "views" . constant("DS"));