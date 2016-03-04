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
namespace app\controllers;
use Ismaspace\Controller;
/**
 * Class Exmple
 *
 * An exemple class to understand the framework
 * 
 * PHP Version 5.6.17
 *
 * @category Controller
 * @package  Controller
 * @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://www.gnu.org/licenses/agpl-3.0.fr.html
 * @link     https://github.com/isma91/isma_framework/blob/master/app/controllers/ExempleController.php
 */

class ExempleController extends Controller
{
	/*
	 * IndexAction
	 *
	 * if you don't set an action in the url, the action
	 * is gonna be indexAction, so we strongly recommend
	 * to create an method called indexAction
	 *
	 */
	public function indexAction()
	{
		$this->render("Index:test.html", array("foo" => "bar", "baz" => 42, "wesh" => "ouais ouais ouais", "b2o" => "izi"));
	}
}