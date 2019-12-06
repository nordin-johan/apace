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
 * Engine class
 *
 * The main core engine for the mvc
 *
 * @param	object	$router		The router class
 * @param	array	$sc			Global accesible system configuration
 * @param	array	$ac			Global accesible application configuration
 */
class Apace {

	public static $router;

	public static $sc;

	public static $ac;

	/**
	 * Instantiate
	 *
	 * Runs the main engine
	 *
	 * @param	array	$uri	The current uri	
	 * @return	string			Echo rendered view from processor object
	 */
	public static function instantiate($uri) {

		self::$router = new Router($uri);

		self::$sc = Config::parseSystemConfig();
		self::$ac = Config::parseAppConfig();
		
		Lang::load(self::$router->getLanguage());

		$Cc = ucfirst(self::$router->getController()).'Controller';
		$Cm = strtolower(self::$router->getAction());
		
		$Co = new $Cc();

		if (method_exists($Co, $Cm)) {
			$processor = new Processor();
			$processor->process($Co, $Cm);
		}

		else {
			throw new Exception ('Method '.$Cm.' of class '.$Cc.' does not exist');
		}
		
	}

	/* ------------------------------------------------------------------ 
	Collection of user related operations ---------------------------- \\
	--------------------------------------------------------------------*/
	
	/**
	 * Get the current router object
	 *
	 * Gives access to the router object operations
	 *
	 * @return	object	Router object
	 */
	public static function getRouter() {
		return self::$router;
	}

	/**
	 * Db connection
	 *
	 * @return	object	New db connection object
	 */
	public static function db() {
		if (self::$sc['database']['db'])
		return new DB(self::$sc['database']['host'], self::$sc['database']['user'], self::$sc['database']['password'], self::$sc['database']['db']);
	}

	/**
	 * Load a controller
	 *
	 * Loads a given controller class
	 *
	 * @param	string 	$controller		Controller to be loaded			
	 * @return	object	Controller
	 */	
	public static function loadController($controller) {
		$controller = ucfirst($controller).'Controller';
		return new $controller();
	}

	/**
	 * Load a model
	 *
	 * Loads a given model class
	 *
	 * @param	string 	$model	Model to be loaded			
	 * @return	object	model
	 */	
	public static function loadModel($model) {
		$model = ucfirst($model).'Model';
		return new $model();
	}

	/**
	 * Get base url from config file include language
	 *
	 * Gets the full base http:// or https:// domain url including the currently set language, 
	 * Example for use: Links in the view where language is set automatically
	 *
	 * @return	string	Url including the language
	 */	
	public static function fullBaseUrl() {
		if ( defined('SUBDOMAIN_MAPPED') ) {
			return self::$ac['application']['baseurl'].constant('SUBDOMAIN_MAPPED').'/'.self::getRouter()->getLanguage().'/';
		} else {
			return self::$ac['application']['baseurl'].self::getRouter()->getLanguage().'/';
		}
	}

	/**
	 * Get base url from config file without language
	 *
	 * Gets the full base http:// or https:// domain url without the currently set language
	 *
	 * @return	string	Url
	 */	
	public static function baseUrl() {
		if ( defined('SUBDOMAIN_MAPPED') ) {
			return self::$ac['application']['baseurl'].constant('SUBDOMAIN_MAPPED').'/';
		} else {
			return self::$ac['application']['baseurl'];
		}
	}

	/**
	 * Redirect to another url
	 *
	 * @param 	string	$url	Url to redirect to
	 * @return	function		redirect to given url
	 */	
	public static function redirect($url) {
		return header('Location: '.$url);
	}

	/**
	 * Get the referer url
	 *
	 * Gets the full referer url
	 *
	 * @return	string	Referer Url
	 */	
	public static function getRefererUrl() {
		$referer = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : self::baseUrl();
		return $referer;
	}

	/**
	 * Get Url for assets such as images, javascript and css 
	 *
	 * @param 	string 	$folder		The folder to be retrieved
	 * @return	string	Full url including the given folder
	 */	
	public static function getDataUrl($folder) {
		return self::$ac['application']['baseurl'].DATA_FOLDER.'/'.$folder.'/';
	}

}