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
 * Config class
 *
 * Main configuration options for the framework
 */
class Config {

	/**
	 * Parse system config
	 *
	 * Parse the systemconfig masterfile (LOCAL OR LIVE dynamically by deployment status OR specific file provided)
	 *
	 * @param	string	$specfile	Specified file to parse
	 * @return	array	$config		Array of config settings
	 */
	public static function parseSystemConfig($specfile = null) {
		if ($specfile == null) {
			$deployment = parse_ini_file(ENGINE_PATH.DS.'settings'.DS.'deployment.ini', true);
			$config = parse_ini_file(ENGINE_PATH.DS.'settings'.DS.$deployment['deployment'].'.ini', true);
		} else {
			$config = parse_ini_file(ENGINE_PATH.DS.'settings'.DS.$specfile.'.ini', true);
		}

		return $config;
	}

	/**
	 * System config path
	 *
	 * Get the current systemconfigpath (LOCAL OR LIVE dynamically by deployment status OR specific file provided)
	 *
	 * @param	string	$specfile	Specified file to get path to
	 * @return	string	$path		Path to file
	 */
	public static function getSystemConfigPath($specfile = null) {
		if ($specfile == null) {
			$deployment = parse_ini_file(ENGINE_PATH.DS.'settings'.DS.'deployment.ini', true);
			$path = ENGINE_PATH.DS.'settings'.DS.$deployment['deployment'].'.ini';
		} else {
			$path = ENGINE_PATH.DS.'settings'.DS.$specfile.'.ini';
		}
		return $path;
	}

	/**
	 * Parse app config
	 *
	 * Get the current applications configuration file
	 *
	 * @return	array	$config		Array of config settings
	 */
	public static function parseAppConfig() {
		$config = parse_ini_file(APP_PATH.DS.'configuration'.DS.'config.ini', true);
		return $config;
	}

	/**
	 * Get deployment status
	 *
	 * @return	string	Value of deployment key
	 */
	public static function getDeploymentStatus() {
		$deployment = parse_ini_file(ENGINE_PATH.DS.'settings'.DS.'deployment.ini', true);
		return $deployment['deployment'];
	}

	/**
	 * Process URI
	 *
	 * Remove an uri segment from the beginning of the uri
	 * This makes is possible to use the framework without a virtual host
	 * For example http://localhost/apace will remove 'apace' as the $subject and so the correct controller can be called.
	 *
	 * @param	string	$uri		Uri to process
	 * @param	string	$subject	String to remove from uri
	 */
	public function processUri($uri, $subject) {

		if (strncmp( $uri, $subject, strlen($subject) ) === 0) {
			$array = explode("/", $uri );
			if($array[0] == $subject) array_shift($array); 
			$uri = implode("/", $array);
		}

		return $uri;

	}
	
}