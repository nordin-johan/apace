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

require_once(APP_PATH.DS.'configuration'.DS.'routes.php');

/**
 * Router class
 *
 * All incoming requests goes through the router object
 *
 * @param	string	$uri			Contains the full uri
 * @param	string	$controller		Current controller
 * @param	string	$action			Current action
 * @param	string	$params			What will be left of the uri after language, controller and action is parsed
 * @param	string	$language		Selected language, default to default from applications config file
 */

class Router {
		
	protected $uri;

	protected $controller;

	protected $action;

	protected $params;

	protected $language;

	/**
	 * Get uri
	 *
	 * @return	string	$uri	Contains the full uri
	 */
	public function getUri() {
		return $this->uri;
	}

	/**
	 * Get controller
	 *
	 * @return	string	$uri	Curent controller
	 */
	public function getController() {
		return $this->controller;
	}

	/**
	 * Get action
	 *
	 * @return	string	$uri	Curent action
	 */
	public function getAction() {
		return $this->action;
	}

	/**
	 * Get params
	 *
	 * @return	array	$params		Exploded uri
	 */
	public function getParams() {
		return $this->params;
	}

	/**
	 * Get a single param
	 *
	 * @param	int		$param	Param in order from left to right to retrieve
	 * @return	string	$param
	 */
	public function getParam($param) {
		if (count($this->params) >= $param)
			return $this->params[$param-1];
	}
	
	/**
	 * Get language
	 *
	 * @return	array	$language	Selected language
	 */
	public function getLanguage() {
		return $this->language;
	}

	/**
     * Class constructor
     *
     * @param   string	$uri	Full uri
     */
	public function __construct($uri) {

		$this->uri = urldecode(trim($uri, '/'));

		// Load app configuration settings
		$sc = Config::parseSystemConfig();
		$ac = Config::parseAppConfig();
		$config = new Config();

		if ( defined('SUBDOMAIN_MAPPED') ) {
			$this->uri = $config->processUri(strtolower($this->uri), constant('SUBDOMAIN_MAPPED'));
		}

		// --------------------------------------------------------------------------------------------------

		// ------ Get defaults
		
		$this->language   = $ac['application']['default_language'];
		$this->controller = $ac['application']['default_controller'];
		$this->action     = $ac['application']['default_action'];

		$uri_parts = explode('?', $this->uri); $path = $uri_parts[0]; $path_parts = explode('/', $path);

		$routes = new Routes(); $routes = $routes->registerRoutes();
		
		if (count($path_parts)) {

			// lang
			if (in_array(strtolower(current($path_parts)), $ac['languages'])) {
				$this->language = strtolower(current($path_parts));
				array_shift($path_parts);
			}

			// controller & action
			if (current($path_parts)) {
				$this->controller = strtolower(current($path_parts));

				if ( array_key_exists(strtolower(current($path_parts)), $routes )) {
					$this->action = strtolower($routes[$this->controller]['action']);
					$this->controller = strtolower($routes[$this->controller]['controller']);
					array_shift($path_parts);

				} else {
					array_shift($path_parts);
					if (current($path_parts)) {
						$this->action = strtolower(current($path_parts));
						array_shift($path_parts);
					}
				}
			}

			// params
			$this->params = $path_parts;

		}

	}

}