<?php
/**
* isma_framework
* 
* PHP Version 5.6.17
*
* @category Framework
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
define("ismaspace_path", constant("lib_path") . "Ismaspace" . constant("DS"));
define("public_path", constant("framework_path") . "public" . constant("DS"));
define("controllers_path", constant("framework_path") . "app" . constant("DS") . "controllers" . constant("DS"));
define("models_path", constant("framework_path") . "app" . constant("DS") . "models" . constant("DS"));
define("views_path", constant("framework_path") . "app" . constant("DS") . "views" . constant("DS"));
define("css_path", constant("public_path") . "css" . constant("DS"));
define("js_path", constant("public_path") . "js" . constant("DS"));
define("img_path", constant("public_path") . "img" . constant("DS"));
define("font_path", constant("public_path") . "font" . constant("DS"));
define("database_path", constant("framework_path") . constant("DS") . "database" . constant("DS"));
/*
 * To check the framework version
 */
if (!defined("framework_version")) {
	define("framework_version", "1.5.00");
}
if (!defined("framework_date_version")) {
	define("framework_date_version", "05-08-2016");
}
if (!defined("cmd_version")) {
	define("cmd_version", "1.4.0");
}
if (!defined("cmd_date_version")) {
	define("cmd_date_version", "05-08-2016");
}
/*YOU MUST CHANGE THESE VALUE !!
 * Change $database_array's value to connect the framework with your database !!
 *
 * You can see the $database_exemple but do not use him !!!
 * You can change the error_description value, project_name and error_header if you want
 *
 */
$database_exemple = array(
	'host' => 'localhost',
	'port' => '3306',
	'database_name' => 'test',
	'database_username' => 'root',
	'database_password' => '*******',
	'socket' => null
	);
$database_array = array(
	'host' => '',
	'port' => '',
	'database_name' => '',
	'database_username' => '',
	'database_password' => '',
	'socket' => null
	);
define('database_config', serialize($database_array));
define("error_description", "You are in the error page !!");
define("project_name", basename(__DIR__));
define("error_header", "Looks like something is wrong !!");