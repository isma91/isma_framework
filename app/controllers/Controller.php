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
		$tab_view = explode(":", $view);
		if (count($tab_view) === 2) {
			ucfirst($tab_view[0]);
			$view_path = constant("views_path") . $tab_view[0] . constant("DS") . $tab_view[1];
			if (file_exists($view_path)) {
				if (empty($array_values) || $array_values === null) {
					include_once $view_path;
				} else {
					$tab_values_keys = array_keys($array_values);
					$tab_values_values = array_values($array_values);
					if (count($tab_values_keys) === count($tab_values_values)) {
						ob_start();
						$tab_values = array();
						for ($i = 0; $i < count($tab_values_keys); $i = $i + 1) {
							echo $tab_values_keys[$i] . '#';
							echo $tab_values_values[$i];
							if ($i !== count($tab_values_keys) - 1) {
								echo '~';
							}
						}
						$content_values = ob_get_clean();
						$content_values = explode('~', $content_values);
						$content_values = implode('#', $content_values);
						$content_values = explode('#', $content_values);
						for ($j = 0; $j < count($content_values) - 1; $j = $j + 2) { 
							$tab_values[$content_values[$j]] = $content_values[$j + 1];
						}
						$view_content = file_get_contents($view_path);
						foreach ($tab_values as $value_to_find => $value_to_replace) {
							if (preg_match('/{# ' . $value_to_find . ' #}/', $view_content)) {
								$view_content = preg_replace("/{# " . $value_to_find . " #}/", $value_to_replace, $view_content);
								$view_content = preg_replace("/{#" . $value_to_find . "#}/", $value_to_replace, $view_content);
							}
						}
						echo $view_content;
					}
				}
			} else {
				var_dump("The file " . $tab_view[1] . " in the folder " . $tab_view[0] . " wasn't found !!");
				var_dump("file_name : " . $tab_view[1]);
				var_dump("folder path : " . constant("views_path") . $tab_view[0] . constant("DS"));
			}
		} else {
			var_dump("The view parameter must be like this :  folder_name:file_name");
		}
	}
}