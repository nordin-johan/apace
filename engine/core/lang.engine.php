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
 * @package   Apace
 * @author    Apace Dev Team
 * @copyright Copyright (c) 2014 - 2017, Apace
 * @license   http://opensource.org/licenses/MIT    MIT License
 * @link      https://apacegithub.com
 * @since     Version 1.0.0
 * @filesource
 */

/**
 * Language class
 *
 * Loads a language and gets a language
 *
 * @param	array	$data	Array of language keys and value
 */
class Lang {

	protected static $data;

	/**
	 * Load language file
	 *
	 * @param	string	$lang_code	Language file to load
	 */
	public static function load($lang_code) {
		$langFile = APP_PATH.DS.'lang'.DS.strtolower($lang_code).'.php';

		if (file_exists($langFile)) {
			self::$data = include($langFile);
		}
	}

	/**
	 * Get language key value
	 *
	 * @param	string	$key			Key to load
	 * @param	string	$default_value	Default value if key is not found
	 */
	public static function get($key, $default_value = '') {
		return isset(self::$data[strtolower($key)]) ? self::$data[strtolower($key)] : $default_value;
	}
	
}