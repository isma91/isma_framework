<?php
require_once('../config.php');
require_once($path_array["framework"] . $path_array["lib"] . "Ismaspace" . DIRECTORY_SEPARATOR . "Core.php");
var_dump($path_array);
\Ismaspace\Core::run();