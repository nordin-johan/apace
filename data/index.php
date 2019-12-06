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
 * @package	    Apace
 * @author      Johan Nordin
 * @copyright   Copyright (c) 2014
 * @license     http://opensource.org/licenses/MIT
 * @link        https://github.com/nordin-johan/apace
 * @since       Version 1.0.0
 */

ini_set("display_errors", "1");
error_reporting(E_ALL);

define('DS', DIRECTORY_SEPARATOR);
define ('ROOT', dirname(dirname(__FILE__)));
define ('ENGINE_PATH', ROOT.DS.'engine');

require_once(ENGINE_PATH.DS.'core'.DS.'config.php');

$sc = Config::parseSystemConfig();
$uri = explode('/', $_SERVER['REQUEST_URI']); $uri1 = isset($uri[1]) ? strtolower($uri[1]) : '';
$rootURL = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
$rootUrlUri = $rootURL.$uri[1].'/'; $map = false;

if ( array_key_exists($rootURL, $sc['domainmapping']) && !array_key_exists($rootUrlUri, $sc['subdomainmapping']) ) { 

	$map = $sc['domainmapping'][$rootURL]; 
	
} else if ( array_key_exists($rootUrlUri, $sc['subdomainmapping']) ) {

	$map = $sc['subdomainmapping'][$rootUrlUri]; 
	define('SUBDOMAIN_MAPPED', $uri[1]);

} 

if ($map != false) {  define ('CURRENT_APPLICATION', $map); } else { define ('CURRENT_APPLICATION', 'app'); };

define ('APP_PATH', ROOT.DS.'application'.DS.CURRENT_APPLICATION); define ('VIEW_PATH', APP_PATH.DS.'view');
define ('CACHE_PATH', APP_PATH.DS.'cache'); define ('DATA_FOLDER', CURRENT_APPLICATION.'data' );
date_default_timezone_set($sc['server']['timezone']);

require_once(ENGINE_PATH.DS.'core/init.php');
Apace::instantiate($_SERVER['REQUEST_URI']);