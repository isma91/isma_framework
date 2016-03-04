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
     * Render
     *
     * Display the file 
     * Replace {# #} by the required values in the called controller who are in $array_values
     *
     * @param string; $view         file name
     * @param array;  $array_values values to change
     *
     * @return Response
     */
	public function render ($view = null, $array_values = null)
	{
		$array_view = explode(":", $view);
		if (count($array_view) === 2) {
			ucfirst($array_view[0]);
			$view_path = constant("views_path") . $array_view[0] . constant("DS") . $array_view[1];
			if (file_exists($view_path)) {
				if (empty($array_values) || $array_values === null) {
					include_once $view_path;
				} else {
					$array_values_keys = array_keys($array_values);
					$array_values_values = array_values($array_values);
					if (count($array_values_keys) === count($array_values_values)) {
						ob_start();
						$array_values = array();
						$array_css = array();
						$array_js = array();
						$array_img = array();
						for ($i = 0; $i < count($array_values_keys); $i = $i + 1) {
							echo $array_values_keys[$i] . '#';
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
						preg_match_all('/(?<={# css:)(.*)(?= #})/', $view_content, $array_css);
						preg_match_all('/(?<={# js:)(.*)(?= #})/', $view_content, $array_js);
						preg_match_all('/(?<={# img:)(.*)(?= #})/', $view_content, $array_img);
						foreach ($array_css[0] as $css) {
							$view_content = preg_replace('/{# css:' . $css . ' #}/', '<link media="all" type="text/css" rel="stylesheet" href="css/' . $css . '">', $view_content);
						}
						foreach ($array_js[0] as $js) {
							$view_content = preg_replace('/{# js:' . $js . ' #}/', '<script src="js/' . $js . '"></script>', $view_content);
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
									$the_full_img = $the_full_img . "src". '="img/' . $value . '" ';
								} else {
									$the_full_img = $the_full_img . $attribute . '="' . $value . '" ';
								}
							}
							$the_full_img = $the_full_img . "/>";
							$array_img["{# img:" . $full_img . " #}"] = $the_full_img;
						}
						foreach ($array_img as $value_to_find => $value_to_replace) {

							$value_to_find = str_replace('|', '\|', $value_to_find);
							$view_content = preg_replace("/" . $value_to_find . "/", $value_to_replace, $view_content);
						}
						foreach ($array_values as $value_to_find => $value_to_replace) {
							if (preg_match("/{# " . $value_to_find . " #}/", $view_content)) {
								$view_content = preg_replace("/{# " . $value_to_find . " #}/", $value_to_replace, $view_content);
								$view_content = preg_replace("/{#" . $value_to_find . "#}/", $value_to_replace, $view_content);
							}
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