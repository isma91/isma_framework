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
if (!defined("framework_version") || !defined("framework_date_version")) {
    die("Access not allowed !!");
}
/**
 * Class DatabaseSeeder
 *
 * In this class, you gonna add some items in your database table
 *
 * PHP Version 7.0.8
 *
 * @category Model
 * @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://www.gnu.org/licenses/agpl-3.0.fr.html
 * @link     https://github.com/isma91/isma_framework/blob/master/database/DatabaseSeeder.php
 */
class DatabaseSeeder extends Model
{
    /*
     * UsersTable
     *
     * Exemple to seed the users table
     *
     * @return void
     */
    public function usersTable ()
    {
        Model::seed_to_database(array("id" => 0, "firstname" => "foo", "lastname" => "bar", "username" => "foo42", "birthdate" => "1994-02-20"), __FUNCTION__);
        Model::seed_to_database(array("id" => 1, "firstname" => "Hello", "lastname" => "Olleh", "username" => "Heeh", "birthdate" => "2000-01-01"), __FUNCTION__);
    }
}