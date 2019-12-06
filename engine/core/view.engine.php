<?php
/**
 * Apace
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	  Apace
 * @author	  Apace Dev Team | apacedev@gmail.com
 * @copyright Copyright (c) 2014 - 2017, Apace
 * @license	  http://opensource.org/licenses/MIT	MIT License
 * @link	  https://github.com/apacedev/apace
 * @since	  Version 1.0.0
 * @filesource
 */

/**
 * View class
 *
 * The main view engine for the mvc
 *
 * @param	array	$data		Array of view data passed from controller and then passed via 'new View(dataArray)' from Apace engine
 * @param	string	$path		Path to the view to load
 */
class View {

	protected $data;
	protected $path;

    /**
     * Class constructor
     *
     * @param   array	$data
     * @param   string	$path
     */
	public function __construct($data = array(), $path = null) {

		// If no viewpath is specified, look for the default viewpath
		if (!$path) {
			$path = self::getDefaultViewPath();
		}

		// If the viewpath (specified or default) can not be found, nothing more to do.
		if (!file_exists($path)) {
			throw new Exception('Template file is not found in path: '. $path);
		}

		$this->path = $path;
		$this->data = $data;
	}

    /**
     * Get default view path
     *
     * @return	string	Path to default view following folder structure 'view\controllername\actionname'
     */
	protected static function getDefaultViewPath() {
		$router = Apace::getRouter();

		if (!$router) {
			return false;
		}

		$controllerName = $router->getController();
		$viewName = $router->getAction().'.php';

		return VIEW_PATH.DS.$controllerName.DS.$viewName;
	}

    /**
     * Render view
     *
     * Starts output buffering, includes path to viewfile and returns the rendered content 
     *
     * @return	string	$content	Rendered view
     */
	public function renderView() {

		$data = $this->data;

		ob_start();
		include($this->path);
		$content = ob_get_clean();

		return $content;
		
	}

    /**
     * Add final data
     *
     * After the view has been rendered, add plugin data to the view and a closing body tag
     *
     * @return	string	$content	Final rendered view
     */
	public static function addFinalData($finalView) {

		ob_start();
		echo $finalView;
		Plugin::getPluginCss(); // Add registered plugin css
		Plugin::getPluginJs();  // Add registered plugin js
		echo '</body>';
        echo '</html>';
		$content = ob_get_clean();
		return self::compressHTML($content);
	}

    /**
     * Compress html
     *
     * @return	string	$data	Compressed html
     */
	private static function compressHTML($data)
    {
        $data = preg_replace(
            array(
                '/ {2,}/',
                '/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'
            ),
            array(
                ' ',
                ''
            ),
            $data
        );

        return $data;
    }

}