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
namespace app\controllers;
use Ismaspace\Controller;
use \app\models\UsersTable;

/**
 * Class Exmple
 *
 * An exemple class to understand the framework
 *
 * PHP Version 5.6.17
 *
 * @category Controller
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
        /*
         * We have a model named TestTable, so we need to have a table in the database named tests
         * with find_one, we search in the tests table, if we have an username named ismaisma
         * if there is one, we get it in $test and we merge the array to display all the variable
         * with the test.html
         *
         */
        $user_table = new UsersTable();
        $user = $user_table->find_one('username = ?', array('ismaisma'));
        $this->render("Index:test.html", array_merge(array("foo" => "bar", "baz" => 42, "wesh" => "ouais ouais ouais", "b2o" => "izi"), $user));
    }
}