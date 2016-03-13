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
namespace Ismaspace;
if (!defined("framework_version") || !defined("framework_date_version")) {
    die("Access not allowed !!");
}
/**
 * Class Controller
 *
 * An abstract class where you have all important method for every controller
 * 
 * PHP Version 5.6.17
 *
 * @category Controller
 * @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://www.gnu.org/licenses/agpl-3.0.fr.html
 * @link     https://github.com/isma91/isma_framework/blob/master/app/controllers/controller.php
 */
abstract class Controller
{
    /**
     * Change_media_render
     *
     * Replace {% %} by the required css, js or img
     *
     * @param string;  $view_content the file to change
     *
     * @return string; $view_content
     */
    public function change_media_render ($view_content)
    {
        $array_request_uri = explode("/", ltrim($_SERVER["REQUEST_URI"], "/"));
        $path_count = count($array_request_uri) - 3;
        $css_path = "";
        if ($path_count === 0) {
            $css_path = "css" . constant("DS");
        } elseif ($path_count > 0) {
            for ($i = 0; $i < $path_count; $i = $i + 1) {
                $css_path = $css_path . ".." . constant("DS");
            }
            $css_path = $css_path . "css" . constant("DS");
        }
        $js_path = "";
        if ($path_count === 0) {
            $js_path = "js" . constant("DS");
        } elseif ($path_count > 0) {
            for ($j = 0; $j < $path_count; $j = $j + 1) {
                $js_path = $js_path . ".." . constant("DS");
            }
            $js_path = $js_path . "js" . constant("DS");
        }
        $img_path = "";
        if ($path_count === 0) {
            $img_path = "js" . constant("DS");
        } elseif ($path_count > 0) {
            for ($k = 0; $k < $path_count; $k = $k + 1) {
                $img_path = $img_path . ".." . constant("DS");
            }
            $img_path = $img_path . "js" . constant("DS");
        }
        $array_css = array();
        $array_js = array();
        $array_img = array();
        $array_img_array_img = array();
        preg_match_all('/(?<={% css:)(.*)(?= %})/', $view_content, $array_css);
        preg_match_all('/(?<={% js:)(.*)(?= %})/', $view_content, $array_js);
        preg_match_all('/(?<={% img:)(.*)(?= %})/', $view_content, $array_img);
        foreach ($array_css[0] as $css) {
            $view_content = preg_replace('/{% css:' . $css . ' %}/', '<link media="all" type="text/css" rel="stylesheet" href="' . $css_path . $css . '">', $view_content);
        }
        foreach ($array_js[0] as $js) {
            $view_content = preg_replace('/{% js:' . $js . ' %}/', '<script src="' . $js_path . $js . '"></script>', $view_content);
        }
        foreach ($array_img[0] as $img) {
            $array_img_array[$img] = explode("|", $img);
            foreach ($array_img_array[$img] as $img_array) {
                $array_img_array_img[$img][] = explode(':', $img_array);
            }
        }
        $array_img = $array_img_array_img;
        $array_img_array_img = array();
        foreach ($array_img as $full_img => $img_array) {
            foreach ($img_array as $last_array_img) {
                if (count($last_array_img) === 2) {
                    $array_img_array_img[$full_img][$last_array_img[0]] = $last_array_img[1];
                }
            }
        }
        $array_img = array();
        foreach ($array_img_array_img as $full_img => $id_value) {
            $the_full_img = "<img ";
            foreach ($id_value as $attribute => $value) {
                if ($attribute === "src") {
                    $the_full_img = $the_full_img . "src". '="' . $img_path . $value . '" ';
                } else {
                    $the_full_img = $the_full_img . $attribute . '="' . $value . '" ';
                }
            }
            $the_full_img = $the_full_img . "/>";
            $array_img["{% img:" . $full_img . " %}"] = $the_full_img;
        }
        foreach ($array_img as $value_to_find => $value_to_replace) {
            $value_to_find = str_replace('|', '\|', $value_to_find);
            $view_content = preg_replace("/" . $value_to_find . "/", $value_to_replace, $view_content);
        }
        return $view_content;
    }
    /**
     * Change_loop_render
     *
     * Replace {% for in  %} by the required value
     *
     * @param string;  $view_content         the file to change
     * @param array;   $array_array_endarray the array to use
     * @param boolean; $array_without_key    if the array is without key
     *
     * @return string; $view_content
     */
    public function change_loop_render ($view_content, $array_array_endarray, $array_without_key = false)
    {
        //array with field => value
        $array = array();
        //array with exemples in exemple
        $array_for = array();
        //array with exemple => exemples
        $array_loop = array();
        //array with exemples => field to use on view
        $array_loop_view = array();
        //template {% for %} in the view
        $array_loop_to_replace = array();
        // users => 0 => replaced view, 1 => replaced view ...
        $array_loop_replace = array();
        foreach ($array_array_endarray as $loop_name => $array_) {
            $array_ = substr($array_, strlen("array("));
            $array_ = substr($array_, 0, -strlen("endarray)"));
            $array_ = explode("|*BLOCK*|", $array_);
            $array_ = implode("=>", $array_);
            $array_ = explode("=>", $array_);
            for ($k = 0; $k < count($array_) - 1; $k = $k + 2) {
                $array["$loop_name"][$array_[$k]] = explode("|*SEPARATOR*|", $array_[$k + 1]);
            }
        }
        preg_match_all("/(?<={% for )(.*?)(?= %})/", $view_content, $array_for);
        if ($array_without_key === false) {
            if (!empty($array_for)) {
                foreach ($array_for[0] as $table_name) {
                    $table_name = explode(" in ", $table_name);
                    $array_loop[$table_name[0]] = $table_name[1];
                }
                foreach ($array_loop as $array_name_to_put => $array_name_to_use) {
                    preg_match("/(?<={% for " . $array_name_to_put . " in " . $array_name_to_use . " %})(.*?)(?={% endfor %})/s", $view_content, $array_loop_match);
                    preg_match_all("/(?<=\* {{ )(.*?)(?= }})/s", $array_loop_match[0], $field_match);
                    $array_loop_view[$array_name_to_use] = $field_match[0];
                    $array_loop_to_replace[$array_name_to_put] = "{% for " . $array_name_to_put . " in " . $array_name_to_use . " %}" . $array_loop_match[0] . "{% endfor %}";
                }
                foreach ($array_loop as $array_name_to_put => $array_name_to_use) {
                    foreach ($array as $array_name => $array_table) {
                        if ($array_name_to_use === $array_name) {
                            foreach ($array_loop_view as $array_field) {
                                foreach ($array_field as $field) {
                                    foreach ($array_table as $field_name => $value_field) {
                                        if (substr($field, strlen($array_name_to_put) + 1) === $field_name) {
                                            for ($l = 0; $l < count($value_field); $l = $l + 1) {
                                                $array_loop_replace[$array_name_to_put][$l] = $array_loop_to_replace[$array_name_to_put];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                foreach ($array_loop as $array_name_to_put => $array_name_to_use) {
                    foreach ($array as $array_name => $array_table) {
                        if ($array_name_to_use === $array_name) {
                            foreach ($array_loop_view as $array_field) {
                                foreach ($array_field as $field) {
                                    foreach ($array_table as $field_name => $value_field) {
                                        if (substr($field, strlen($array_name_to_put) + 1) === $field_name) {
                                            for ($m = 0; $m < count($value_field); $m = $m + 1) {
                                                $array_loop_replace[$array_name_to_put][$m] = preg_replace("/\* {{ " . $array_name_to_put . "." . $field_name . " }}/", $value_field[$m], $array_loop_replace[$array_name_to_put][$m]);
                                                $array_loop_replace[$array_name_to_put][$m] = preg_replace("/{% for " . $array_name_to_put . " in " . $array_name_to_use . " %}/s", "", $array_loop_replace[$array_name_to_put][$m]);
                                                $array_loop_replace[$array_name_to_put][$m] = preg_replace("/{% else %}(.*)/s", "", $array_loop_replace[$array_name_to_put][$m]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                foreach ($array_loop_replace as $name => $value) {
                    $array_loop_replace[$name] = implode("\n", $value);
                }
                foreach ($array_loop_to_replace as $name_match => $view) {
                    foreach ($array_loop_replace as $name_find => $final_loop_view) {
                        if (!isset($array_loop_replace[$name_match])) {
                            preg_match("/(?<={% else %})(.*?)(?={% endfor %})/s", $view, $array_loop_replace[$name_match]);
                            $array_loop_replace[$name_match] = $array_loop_replace[$name_match][0];
                        }
                    }
                }
                foreach ($array_loop as $name => $array) {
                    $view_content = str_replace($array_loop_to_replace[$name], $array_loop_replace[$name], $view_content);
                }
            }
        } else {
            foreach ($array_for[0] as $name) {
                preg_match("/(?<={% for " . $name . " %})(.*?)(?={% endfor %})/s", $view_content, $array_loop[$name]);
                $array_loop[$name] = $array_loop[$name][0];
            }
            foreach ($array as $name => $array_item) {
                foreach ($array_item as $array_loop_replace) {
                    for ($i = 0; $i < count($array_loop_replace); $i = $i + 1) {
                        $array_loop_to_replace[$name][rtrim($name, "s")][$i] = $array_loop_replace[$i];
                        $array_loop_view[$name][rtrim($name, "s")][$i] = $array_loop[$name];
                    }
                }
            }
            foreach ($array_loop as $name => $array_loop_to_view) {
                foreach ($array_loop_to_replace as $name_to_find => $array_name_to_replace) {
                    if ($name === $name_to_find) {
                        for ($j = 0; $j < count($array_name_to_replace[rtrim($name, "s")]); $j = $j + 1) {
                            $array_loop_view[$name][rtrim($name, "s")][$j] = preg_replace("/\* {{ " . rtrim($name, "s") . " }}/s", $array_name_to_replace[rtrim($name, "s")][$j], $array_loop_view[$name][rtrim($name, "s")][$j]);
                        }
                    }
                }
            }
            foreach ($array_loop as $name => $array_to_finish) {
                $array_loop[$name] = "{% for " . $name . " %}" . $array_to_finish . "{% endfor %}";
            }
            foreach ($array_loop_view as $names => $array_name) {
                foreach ($array_name as $item) {
                    $array_loop_view[$names] = $item;
                }
            }
            foreach ($array_loop_view as $names => $array_to_implode) {
                $array_loop_view[$names] = implode("\n", $array_to_implode);
            }
            foreach ($array_loop as $names => $array) {
                $view_content = str_replace($array_loop[$names], $array_loop_view[$names], $view_content);
            }
        }
        return $view_content;
    }
	/**
     * Render
     *
     * Display the file 
     * Replace {{ }} by the required values in the called controller who are in $array_values
     *
     * @param string;  $view         file name
     * @param  array;  $array_values values to change
     * @param string;  $path         values to change
     *
     * @return string; $view_content
     */
	static public function render ($view = null, $array_values = null, $path = "views_path")
	{
		$array_view = explode(":", $view);
		if (count($array_view) === 2) {
			ucfirst($array_view[0]);
			$view_path = constant($path) . $array_view[0] . constant("DS") . $array_view[1];
			if (file_exists($view_path)) {
				if (empty($array_values) || $array_values === null) {
					include_once $view_path;
				} else {
                    $array_values_keys = array_keys($array_values);
                    $array_values_values = array_values($array_values);
                    if (count($array_values_keys) === count($array_values_values)) {
                        ob_start();
                        $array_values = array();
                        $array_array_endarray = array();
                        for ($i = 0; $i < count($array_values_keys); $i = $i + 1) {
                            echo $array_values_keys[$i] . '#';
                            if (is_array($array_values_values[$i])) {
                                $array_array_value = "array(";
                                $count = 0;
                                foreach ($array_values_values[$i] as $key => $val) {
                                    $array_array_value = $array_array_value . $key .  "=>";
                                    $count++;
                                    for ($j = 0; $j < count($val); $j = $j + 1) {
                                        $array_array_value = $array_array_value . $val[$j];
                                        if ($j !== count($val) - 1 ) {
                                            $array_array_value = $array_array_value . "|*SEPARATOR*|";
                                        } elseif ($j === count($val) - 1 && $count !== count($array_values_values[$i])) {
                                            $array_array_value = $array_array_value . "|*BLOCK*|";
                                        }
                                    }
                                }
                                $array_array_value = $array_array_value . ")endarray";
                                $array_values_values[$i] = $array_array_value;
                            }
                            echo $array_values_values[$i];
                            if ($i !== count($array_values_keys) - 1) {
                                echo '~';
                            }
                        }
                        $content_values = ob_get_clean();
                        $content_values = explode('~', $content_values);
                        $content_values = implode('#', $content_values);
                        $content_values = explode('#', $content_values);
                        for ($j = 0; $j < count($content_values) - 1; $j = $j + 2) {
                            $array_values[$content_values[$j]] = $content_values[$j + 1];
                        }
                        $view_content = file_get_contents($view_path);
                        $view_content = self::change_media_render($view_content);
                        foreach ($array_values as $value_to_find => $value_to_replace) {
                            if (preg_match("/{{ " . $value_to_find . " }}/", $view_content)) {
                                $view_content = preg_replace("/{{ " . $value_to_find . " }}/", $value_to_replace, $view_content);
                                $view_content = preg_replace("/{{" . $value_to_find . "}}/", $value_to_replace, $view_content);
                            }
                            if (preg_match_all("/array\((.*)\)endarray/s", $value_to_replace, $array_array)) {
                                $array_array_endarray[$value_to_find] = $array_array[0][0];
                            }
                        }
                        //Check if we take the array without key for the error traces
                        if ($path === "public_path") {
                            $view_content = self::change_loop_render($view_content, $array_array_endarray, true);
                        } else {
                            $view_content = self::change_loop_render($view_content, $array_array_endarray, false);
                        }
                        echo $view_content;
                    }
                }
            } else {
                var_dump("The file " . $array_view[1] . " in the folder " . $array_view[0] . " wasn't found !!");
                var_dump("file_name : " . $array_view[1]);
                var_dump("folder path : " . constant("views_path") . $array_view[0] . constant("DS"));
            }
        } else {
            var_dump("The view parameter must be like this :  folder_name:file_name");
		}
	}
}