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
 * Autoload classes
 *
 * Autoloads all classes including plugin classes
 *
 * @param   string   $class     Class to autoload
 */
if(!function_exists('classAutoLoader')){

    function classAutoLoader($class){

        $engine_core_path        = ENGINE_PATH.DS.'core'.DS.strtolower($class).'.engine.php';
        $controller_path         = APP_PATH.DS.'controller'.DS.$class.'.php';
        $model_path              = APP_PATH.DS.'model'.DS.$class.'.php';

        if (file_exists($engine_core_path)) {
        	require_once($engine_core_path);
        }
        elseif (file_exists($controller_path)) {
        	require_once($controller_path);
        }
        elseif (file_exists($model_path)) {
            require_once($model_path);
        }
	    else {
			throw new Exception('Failed to include class: '.$class);
		}
    }

}

spl_autoload_register('classAutoLoader');

/**
 * Load language function
 *
 * Loads a specified language if key exists, else defaults to default value provided
 *
 * @param   string   $key               Language key to load
 * @param   string   $default_value     Default value
 * @return  string                      Value of key
 */
function __($key, $default_value) {
    return Lang::get($key, $default_value);
}