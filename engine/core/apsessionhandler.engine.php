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
 * Apace Session handler
 *
 * Handles sessions which can be shared between applications
 */
class APSessionHandler {

    /**
     * Start a session
     */
    public function start($name = CURRENT_APPLICATION) {
        session_name($name);
        if (session_status() === 1) {
            session_start();
        }
        mt_rand(0, 4) === 0 ? session_regenerate_id() : true;
    }

    /**
     * Save a value to a session key
     */
    public static function put($key, $value) {
        $_SESSION[''.$key.''] = $value;
    }

    /**
     * Get value from key
     */
    public static function get($key) {
        return $_SESSION[''.$key.''];
    }

    /**
     * Destroy session
     * 
     * Never call session destroy if not yet started
     */
    public function destroy() {
    	session_destroy();
    }

    
    /**
     * Returns true if session is active
     */
    public function isActive() {
		if ( isset($_SESSION['userid']) && $_SESSION['loggedin'] === true) {
			return true;
		} else {
			return false;
		}
    }


}