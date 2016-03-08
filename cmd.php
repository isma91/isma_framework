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
 * Cmd.php
 *
 * A PHP script to create easier controller,model and do some other stuff
 *
 * PHP Version 5.6.17
 *
 * @category CLI
 * @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://www.gnu.org/licenses/agpl-3.0.fr.html
 * @link     https://github.com/isma91/isma_framework/blob/master/cmd.php
 */
require_once("config.php");
require_once(constant("lib_path") . "Ismaspace" . constant("DS") . "Core.php");
\Ismaspace\Core::run();
use Ismaspace\Migration;
use Ismaspace\Model;
/*
 * Colorize
 *
 * To color the text and the background to the cli command
 *
 * @param   string; $test       the text
 * @param  string;  $background the color of the background
 * @param  string;  $color      the color of the text
 * @param  boolean; $line_feed  if we add a \n at the end of the text
 * @return string
 */
function colorize($text, $background = null, $color = null,  $line_feed = true) {
    if (empty($text)) {
        return;
    }
    $array_text_color = array(
        "null" => "\033[0m",
        "black" => "\033[30m",
        "red" => "\033[31m",
        "green" => "\033[32m",
        "orange" => "\033[33m",
        "blue" => "\033[34m",
        "purple" => "\033[35m",
        "cyan" => "\033[36m",
        "grey" => "\033[37m",
        "bold_grey" => "\033[1;30m",
        "bold_red" => "\033[1;31m",
        "bold_green" => "\033[1;32m",
        "yellow" => "\033[1;33m",
        "bold_blue" => "\033[1;34m",
        "bold_purple" => "\033[1;35m",
        "bold_cyan" => "\033[1;36m",
        "white" => "\033[1;37m",
    );
    $array_background = array(
        "null" => "\e[0m",
        "black" => "\e[40m",
        "red" => "\e[41m",
        "green" => "\e[42m",
        "yellow" => "\e[43m",
        "blue" => "\e[44m",
        "purple" => "\e[45m",
        "cyan" => "\e[46m",
        "grey" => "\e[47m",
    );
    if ($color === null) {
        $color = "null";
    }
    if ($background === null) {
        $background = "null";
    }
    foreach ($array_text_color as $color_name => $color_code) {
        if ($color === $color_name) {
            $color = $color_code;
            break;
        }
    }
    foreach ($array_background as $background_name => $background_code) {
        if ($background === $background_name) {
            $background = $background_code;
            break;
        }
    }
    if ($line_feed === true) {
        $line_feed = "\n";
    } else {
        $line_feed = "";
    }
    $text = $text . $array_background["null"] . $array_text_color["null"] . $line_feed;
    echo "$background" . "$color" . "$text";
}
if (!defined("framework_version") || !defined("framework_date_version") || !defined("cmd_version") || !defined("cmd_date_version")) {
    die("Access not allowed !!");
}
if (version_compare(phpversion(), '5.6.0', '<')) {
    die("Your PHP version isn't high enough, you must ave at least PHP 5.6 !!");
}
/*
 * Display_cmd
 *
 * Display all the Options and Argument
 *
 * @return void
 */
function display_cmd () {
    colorize("Welcome to the cmd of ", null, "white", false);
    colorize("isma_framework ", null, "bold_green", false);
    colorize("!!", null, "white", true);
    colorize("cmd.php        ", null, "white", false);
    colorize("version ", null, null, false);
    colorize(constant("cmd_version"), "grey", "black", false);
    colorize(" ", null, null, false);
    colorize("date ", null, null, false);
    colorize(constant("cmd_date_version"), "grey", "black", true);
    colorize("isma_framework", null, "bold_green", false);
    colorize(" ", null, null, false);
    colorize("version ", null, null, false);
    colorize(constant("framework_version"), "grey", "black", false);
    colorize(" ", null, null, false);
    colorize("date ", null, null, false);
    colorize(constant("framework_date_version"), "grey", "black", true);
    colorize("You can have the latest version of the framework and the cmd on github !!", null, "white", true);
    colorize("https://github.com/isma91/isma_framework.git", null, "white", true);
    colorize("Usage :", null, "orange", true);
    colorize("command [Options] [Arguments]", null, "white", true);
    colorize(" ", null, null, true);
    colorize("Options :", null, "orange", true);
    colorize("  -h --help               ", null, "green", false);
    colorize("Display this help message", null, null, true);
    colorize("  -v --version            ", null, "green", false);
    colorize("Display the framework and the cmd version", null, null, true);
    colorize("  --check                 ", null, "green", false);
    colorize("Display all the check options you can use with cmd", null, null, true);
    colorize("  --create                ", null, "green", false);
    colorize("Display all the create options you can use with cmd", null, null, true);
    colorize("  -f --fresh                 ", null, "green", false);
    colorize("Delte all exemple in the framework to have a fresh start", null, null, true);
    colorize("Check :", null, "orange", true);
    colorize("  check:isma                ", null, "green", false);
    colorize("Check if the current version of the framework is the latest", null, null, true);
    colorize("  check:cmd                ", null, "green", false);
    colorize("Check if the current version of the cmd is the latest", null, null, true);
    colorize("  check:controller         ", null, "green", false);
    colorize("Check if the core controller has been edited", null, null, true);
    colorize("  check:model              ", null, "green", false);
    colorize("Check if the core model has been edited", null, null, true);
    colorize("  check:core               ", null, "green", false);
    colorize("Check if the core autoload has been edited", null, null, true);
}
/*
 * Display_version
 *
 * Display the version of the framework and the cmd
 *
 * @return void
 */
function display_version () {
    colorize("cmd.php        ", null, "white", false);
    colorize("version ", null, null, false);
    colorize(constant("cmd_version"), "grey", "black", false);
    colorize(" ", null, null, false);
    colorize("date ", null, null, false);
    colorize(constant("cmd_date_version"), "grey", "black", true);
    colorize("isma_framework", null, "bold_green", false);
    colorize(" ", null, null, false);
    colorize("version ", null, null, false);
    colorize(constant("framework_version"), "grey", "black", false);
    colorize(" ", null, null, false);
    colorize("date ", null, null, false);
    colorize(constant("framework_date_version"), "grey", "black", true);
    colorize("You can have the latest version of the framework and the cmd on github !!", null, "white", true);
    colorize("https://github.com/isma91/isma_framework.git", null, "white", true);
}
/*
 * Display_check
 *
 * Display all the check options
 *
 * @return void
 */
function display_check () {
    colorize("Check :", null, "orange", true);
    colorize("  check:isma                ", null, "green", false);
    colorize("Check if the current version of the framework is the latest", null, null, true);
    colorize("  check:cmd                ", null, "green", false);
    colorize("Check if the current version of the cmd is the latest", null, null, true);
    colorize("  check:controller         ", null, "green", false);
    colorize("Check if the core controller has been edited", null, null, true);
    colorize("  check:model              ", null, "green", false);
    colorize("Check if the core model has been edited", null, null, true);
    colorize("  check:core               ", null, "green", false);
    colorize("Check if the core autoload has been edited", null, null, true);
}
/*
 * Check_file
 *
 * Check if a file is changed or not
 *
 * @param string; $file the file name
 * @return void
 */
function check_file ($file) {
    colorize("Checking your core " . $file . " file ...", "cyan", "black", true);
    switch ($file) {
        case "model":
            $content_url = file_get_contents("http://framework.ismaydogmus.fr/lib/Model.php");
            $path = constant("lib_path") . "Model.php";
            break;
        case "controller":
            $content_url = file_get_contents("http://framework.ismaydogmus.fr/app/controllers/Controller.php");
            $path = constant("controllers_path") . "Controller.php";
            break;
        case "core":
            $content_url = file_get_contents("http://framework.ismaydogmus.fr/lib/Ismaspace/Core.php");
            $path = constant("lib_path") . "Ismaspace" . constant("DS") . "Core.php";
            break;
    }
    if (file_exists($path)) {
        $content_local = file_get_contents($path);
        if ($content_url === $content_local) {
            colorize(ucfirst($file) . ".php has not been changed !!", "green", "black", true);
        } else {
            colorize("Your "  . ucfirst($file) . ".php has been changed !!", "red", "black", true);
            colorize("Did you want to overwride your local " . ucfirst($file) . ".php by the original ?", "grey", "black", true);
            colorize("[Y] [N]: ", "grey", "black", false);
            $ask = 0;
            $answer = fopen("php://stdin", "r");
            $response = fgets($answer);
            $response = trim($response);
            $response = mb_strtoupper(substr($response, 0, 1));
            while ($ask === 0) {
                if ($response === "Y") {
                    $ask++;
                    colorize("Overwrite the the local " . $file . " to the original one ...", "cyan", "black", true);
                    try {
                        file_put_contents($path, $content_url);
                    } catch (Exception $e) {
                        colorize("We overwrite but it looks like it wasn't successful...", "red", "black", true);
                        colorize("Create a new issue in https://github.com/isma91/isma_framework/issues and we gonna do our best to fix your problem", "red", "black", true);
                    }
                    colorize("We successfully overwrite your local " . ucfirst($file) . ".php enjoy the framework !!", "green", "black", true);
                } elseif ($response === "N") {
                    colorize("Your " . ucfirst($file) . ".php has been edited !! If it's you, it's at your own risk !!", "yellow", "black", true);
                    $ask++;
                } else {
                    colorize("Tape N to refuse the overwrite or Y to get " . ucfirst($file) . ".php to the original one !!", "yellow", "black");
                    colorize("[Y] [N]: ", "grey", "black", false);
                    $ask = 0;
                    $answer = fopen("php://stdin", "r");
                    $response = fgets($answer);
                    $response = trim($response);
                    $response = mb_strtoupper(substr($response, 0, 1));
                }
            }
        }
    } else {
        colorize("There is not " . ucfirst($file) . ".php in his directory !!", "red", "black", true);
        colorize("We can create a new " . ucfirst($file) . ".php in his directory if you want...", "grey", "black", true);
        colorize("[Y] [N]: ", "grey", "black", false);
        $ask = 0;
        $answer = fopen("php://stdin", "r");
        $response = fgets($answer);
        $response = trim($response);
        $response = mb_strtoupper(substr($response, 0, 1));
        while ($ask === 0) {
            if ($response === "Y") {
                $ask++;
                colorize("Creation of " . ucfirst($file) . ".php in his directory...", "cyan", "black", true);
                try {
                    file_put_contents($path, $content_url);
                } catch (Exception $e) {
                    colorize("It looks like we can't create " . ucfirst($file) . ".php in his directory...", "red", "black", true);
                    colorize("Create a new issue in https://github.com/isma91/isma_framework/issues and we gonna do our best to fix your problem", "red", "black", true);
                }
                colorize("We successfully create " . ucfirst($file) . ".php enjoy the framework !!", "green", "black", true);
            } elseif ($response === "N") {
                colorize("You don't have " . ucfirst($file) . ".php in his directory !!", "red", "black", true);
                colorize("The framework don't gonna work properly !!", "red", "black", true);
                $ask++;
            } else {
                colorize("Tape N to refuse to create or Y to get a new " . ucfirst($file) . ".php in his directory !!", "yellow", "black");
                colorize("[Y] [N]: ", "grey", "black", false);
                $ask = 0;
                $answer = fopen("php://stdin", "r");
                $response = fgets($answer);
                $response = trim($response);
                $response = mb_strtoupper(substr($response, 0, 1));
            }
        }
    }
}
/*
 * Check_cmd
 *
 * Check if your cmd or framework is in the last version
 *
 * @param string $const The framework or cmd version
 * @return void
 */
function check_version($const) {
    $config_content_url = file_get_contents("http://framework.ismaydogmus.fr/config.php");
    $config_content_local = file_get_contents(constant("framework_path") . "config.php");
    if ($const === "cmd") {
        preg_match('/(define\(\"cmd_version\"\,\ \")(.*)(?="\)\;)/', $config_content_url, $version_url);
        preg_match('/(define\(\"cmd_version\"\,\ \")(.*)(?="\)\;)/', $config_content_local, $version_local);
    } elseif ($const) {
        preg_match('/(define\(\"framework_version\"\,\ \")(.*)(?="\)\;)/', $config_content_url, $version_url);
        preg_match('/(define\(\"framework_version\"\,\ \")(.*)(?="\)\;)/', $config_content_local, $version_local);
    }
    colorize("You " . $const . " version is           ", null, "white", false);
    colorize(end($version_local), "grey", "black", true);
    colorize("The latest version of " . $const . " is ", null, "white", false);
    colorize(end($version_url), "grey", "black", true);
    if (version_compare(end($version_local), end($version_url), '<')) {
        colorize("Your version is outdated !! You must get the latest version of " . $const . " !!", "red", "black", true);
    } elseif (version_compare(end($version_local), end($version_url), '=')) {
        colorize("Your " . $const . " version is the latest !!", "green", "black");
    } else {
        colorize("You can't have a most recent version than " . end($version_url) . " !! You must change the contant with the good version !!", "yellow", "black");
    }
}
/*
 * Fresh start
 *
 * Remove all the exemple in the framework
 *
 * @return void
 */
function fresh_start () {
    colorize("Getting all the exemple in th framework...", "cyan", "black", true);
    $array_file_exemple = array(
        constant("framework_path") . "test.sql" => "test.sql",
        constant("controllers_path") . "ExempleController.php" => "ExempleController.php",
        constant("models_path") . "TestTable.php" => "TestTable.php",
        constant("views_path") . "Index/test.html" => "test.html",
        constant("css_path") . "materialize.min.css" => "materialize.min.css",
        constant("css_path") . "mui.min.css" => "mui.min.css",
        constant("js_path") . "jquery-2.1.4.min.css" => "jquery-2.1.4.min.css",
        constant("js_path") . "materialize.min.css" => "materialize.min.css",
        constant("js_path") . "mui.min.css" => "mui.min.css",
        constant("img_path") . "3k.jpg" => "3k.jpg",
        constant("img_path") . "confused.gif" => "confused.gif",
        constant("font_path") . "Pacifico.ttf" => "Pacifico.ttf",
    );
    $array_folder_exemple = array(
        constant("views_path") . "Index/" => "Index"
    );
    foreach ($array_file_exemple as $file_path => $file_name) {
        if (file_exists($file_path)) {
            unlink($file_path);
            colorize("Removing", "cyan", "black", false);
            colorize(" ", null, null, false);
            colorize($file_name, "cyan", "white", true);
        } else {
            colorize($file_name, "yellow", "white", false);
            colorize(" ", null, null, false);
            colorize("not found !!", "yellow", "white", true);
        }
    }
    foreach ($array_folder_exemple as $folder_path => $folder_name) {
        if (file_exists($folder_path)) {
            rmdir($folder_path);
            colorize("Removing", "cyan", "black", false);
            colorize(" ", null, null, false);
            colorize($folder_name, "cyan", "white", true);
        } else {
            colorize($folder_name, "yellow", "white", false);
            colorize(" ", null, null, false);
            colorize("not found !!", "yellow", "white", true);
        }
    }
    colorize("All test file and folder are removed !! Enjoy the fresh start !!", "green", "black", true);
}
/*
 * Create_table
 *
 * Create a table in the database with the help of Migration.php
 *
 * @param string: $table_name The table name
 *
 * @return void
 */
function create_table ($table_name) {
    $function_name = $table_name . "Table";
    colorize("Here is the SQL query :", "cyan", "black", true);
    $create_table = Migration::$function_name();
    colorize($create_table, "cyan", "white", true);
    colorize("Did you want to execute this query ?", "grey", "black", true);
    colorize("[Y] [N]: ", "grey", "black", false);
    $ask = 0;
    $answer = fopen("php://stdin", "r");
    $response = fgets($answer);
    $response = trim($response);
    $response = mb_strtoupper(substr($response, 0, 1));
    while ($ask === 0) {
        if ($response === "Y") {
            $ask++;
            colorize("Executing the SQL query...", "cyan", "black", true);
            try {
                Model::database_execute($create_table);
                colorize("Table " . $table_name . " created successfully !! Enjoy the framework !!", "green", "black", true);
            } catch (Exception $e) {
                colorize("Error when we try to execute the query !! Check your function " . $function_name . " in the Migration.php file !!", "red", "black", true);
            }
        } elseif ($response === "N") {
            colorize("The table " . $table_name . " wasn't created !!", "yellow", "black", true);
            $ask++;
        } else {
            colorize("Tape N to refuse to create the table " .$table_name . " or Y to execute the query !!", "yellow", "black");
            colorize("[Y] [N]: ", "grey", "black", false);
            $ask = 0;
            $answer = fopen("php://stdin", "r");
            $response = fgets($answer);
            $response = trim($response);
            $response = mb_strtoupper(substr($response, 0, 1));
        }
    }
}
if (count($argv) === 1) {
    display_cmd();
} elseif (count($argv) === 2) {
    switch ($argv[1]) {
        case "-h":
            display_cmd();
            break;
        case "--help":
            display_cmd();
            break;
        case "-v":
            display_version();
            break;
        case "--version":
            display_version();
            break;
        case "--check";
            display_check();
            break;
        case "check:model":
            check_file("model");
            break;
        case "check:controller":
            check_file("controller");
            break;
        case "check:core":
            check_file("core");
            break;
        case "check:cmd":
            check_version("cmd");
            break;
        case "check:isma":
            check_version("framework");
            break;
        case "-f":
            fresh_start();
            break;
        case "--fresh":
            fresh_start();
            break;
    }
} elseif (count($argv) === 3) {
    switch ($argv[1]) {
        case "make:migration":
            create_table($argv[2]);
            break;
    }
}