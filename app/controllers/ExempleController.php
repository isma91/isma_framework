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
//namespace app\controllers;
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

class ExempleController
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
		var_dump("Hello i'm the class " . __CLASS__);
	}
}