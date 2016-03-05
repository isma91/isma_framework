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
    colorize("  check:htaccess           ", null, "green", false);
    colorize("Check if the .htaccess in the frmework has been edited", null, null, true);
}
function check_model () {
    colorize("Checking your core model file ...", "cyan", "black", true);
    $model_content_url = file_get_contents("http://framework.ismaydogmus.fr/lib/Model.php");
    if (file_exists(constant("lib_path") . "Model.php")) {
        $model_content_local = file_get_contents(constant("lib_path") . "Model.php");
        if ($model_content_url === $model_content_local) {
            colorize("Model.php has not been changed !!", "green", "black", true);
        } else {
            colorize("Your Model.php has been changed !!", "red", "black", true);
            colorize("Did you want to overwride your local Model.php by the original ?", "grey", "black", true);
            colorize("[Y] [N]: ", "grey", "black", false);
            $ask = 0;
            $answer = fopen("php://stdin", "r");
            $response = fgets($answer);
            $response = trim($response);
            $response = mb_strtoupper(substr($response, 0, 1));
            var_dump($response);
            while ($ask === 0) {
                if ($response === "Y") {
                    $ask++;
                    colorize("Overwrite the the local model to the original one ...", "cyan", "black", true);
                    try {
                        file_put_contents(constant("lib_path") . "Model.php", $model_content_url);
                    } catch (Exception $e) {
                        colorize("We overwrite but it looks like it wasn't successful...", "red", "black", true);
                        colorize("Create a new issue in https://github.com/isma91/isma_framework/issues and we gonna do our best to fix your problem", "red", "black", true);
                    }
                    colorize("We successfully overwrite your local Model.php enjoy the framework !!", "green", "black", true);
                } elseif ($response === "N") {
                    colorize("Your Model.php has been edited !! If it's you, it's at your own risk !!", "yellow", "black", true);
                    $ask++;
                } else {
                    colorize("Tape N to refuse the overwrite or Y to get Model.php to the original one !!", "yellow", "black");
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
        colorize("There is not Model.php in the lib directory !!", "red", "black", true);
        colorize("We can create a new Model.php in the lib directory if you want...", "grey", "black", true);
        colorize("[Y] [N]: ", "grey", "black", false);
        $ask = 0;
        $answer = fopen("php://stdin", "r");
        $response = fgets($answer);
        $response = trim($response);
        $response = mb_strtoupper(substr($response, 0, 1));
        var_dump($response);
        while ($ask === 0) {
            if ($response === "Y") {
                $ask++;
                colorize("Creation of Model.php in the lib directory...", "cyan", "black", true);
                try {
                    file_put_contents(constant("lib_path") . "Model.php", $model_content_url);
                } catch (Exception $e) {
                    colorize("It looks like we can't create Model.php in the lib directory...", "red", "black", true);
                    colorize("Create a new issue in https://github.com/isma91/isma_framework/issues and we gonna do our best to fix your problem", "red", "black", true);
                }
                colorize("We successfully create Model.php enjoy the framework !!", "green", "black", true);
            } elseif ($response === "N") {
                colorize("You don't have Model.php in the lib directory !!", "red", "black", true);
                colorize("The framework don't gonna work properly !!", "red", "black", true);
                $ask++;
            } else {
                colorize("Tape N to refuse to create or Y to get a new Model.php in the lib directory !!", "yellow", "black");
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
var_dump($argv);
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
            check_model();
            break;
    }
}