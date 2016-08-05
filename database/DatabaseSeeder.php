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
     * You just need to add all the arrays in a big array and send to seed_to_database of the Model Class
     *
     * @return void
     */
    public function usersTable ()
    {
        $user0 = array(
            "id" => 1,
            "firstname" => "foo",
            "lastname" => "bar",
            "username" => "foo42",
            "birthdate" => "1994-02-20"
        );
        $user1 = array(
            "id" => 2,
            "firstname" => "Hello",
            "lastname" => "Olleh",
            "username" => "Heeh",
            "birthdate" => "2000-01-01"
        );
        return Model::seed_to_database(array($user0, $user1), __FUNCTION__);
    }
}