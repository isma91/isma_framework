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
 * Class Migration
 *
 * In this class, you gonna create, rename, drop table in the database
 *
 * PHP Version 5.6.17
 *
 * @category Model
 * @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://www.gnu.org/licenses/agpl-3.0.fr.html
 * @link     https://github.com/isma91/isma_framework/blob/master/database/Migration.php
 */
class Migration extends Model
{
    /*
     * UsersTable
     *
     * Exemple to create the users table
     */
    public function usersTable ()
    {
        $connection = unserialize(constant('database_config'));
        Model::set_pdo($connection["host"], $connection["port"], $connection["database_name"], $connection["database_username"], $connection["database_password"], $connection["socket"]);
        $array_field = array(
            Model::create_field("increments", "id", null, null, null),
            Model::create_field("text", "firstname", null, "NOT NULL", null),
            Model::create_field("text", "lastname", null, "NOT NULL", null),
            Model::create_field("varchar", "username", 45, "NOT NULL", null),
            Model::create_field("datetime", "birthdate", null, "NOT NULL", null),
        );
        return Model::create_table("users", $array_field);
    }
}