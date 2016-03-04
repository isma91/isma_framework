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
/* Array to have some path easier  */
$path_array = array(
	"framework" => rtrim(__DIR__, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR,
	"lib" => "lib" . DIRECTORY_SEPARATOR,
	"public" => "public" . DIRECTORY_SEPARATOR,
	"controllers" => "app" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR,
	"models" => "app" . DIRECTORY_SEPARATOR . "models" . DIRECTORY_SEPARATOR,
	"views" => "app" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR
	);