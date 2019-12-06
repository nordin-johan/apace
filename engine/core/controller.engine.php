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
 * Controller class
 *
 * The super class that all controllers will extend
 *
 * @param	array	$data		Data set from inside the controller, most likely passed to view
 * @param	string	$model		Model which belongs to controller if set
 * @param	string	$layout		Layout to load if set, defaults to main 'layout'
 * @param	string	$view		View to load if set, defaults to folder=controllername/index/index
 * @param	bool	$cache		If cache is enabled
 */
class Controller {

	protected $data;

	protected $model;

	protected $layout;

	protected $view;

	protected $cache = FALSE;

    /**
     * Class constructor
     *
     * @param	array	$data	Controller data
     */
	public function __construct($data = array()) {
		$this->data = $data;
	}

    /**
     * Set view data
     *
     * @param   string  $var   Key to hold the value
     * @param   array   $data  Data which belongs to key
     */
	public function setViewData($var, $data) {

		if (is_array($data)) {
			if (!function_exists('filter')) {
				function filter(&$var) {
				  $var = htmlspecialchars($var, ENT_QUOTES,'UTF-8');
				}
			}
			array_walk_recursive($data, "filter");
			$this->data[$var] = $data;

		} else {
			$this->data[$var] = htmlspecialchars($data, ENT_QUOTES,'UTF-8');
		}

	}

    /**
     * Get post data from a form
     *
     * @param   string  $data   Post data to get
     * @return  string          Sanitized string
     */
    public function getPostData($data) {
        return filter_var($data, FILTER_SANITIZE_STRING);
    }

    /**
     * Get controller data
     *
     * @return   array  $data
     */
	public function getData() {
		return $this->data;
	}

    /**
     * Get model
     *
     * @return   string  $model
     */
	public function getModel() {
		return $this->model;
	}

    /**
     * Set layout for controller action
     *
     * @param	string	$layout
     */
	public function setLayout($layout) {
		$this->layout = $layout;
	}

    /**
     * Get layout for controller action
     *
     * @return	string	$layout
     */
	public function getLayout() {
		return $this->layout;
	}

	/**
     * Set view for controller action
     *
     * defaults to folder=controllername/index/index
     *
     * @param	string	$view	View lo connect to controller action
     */
	public function setView($view) {
		$this->view = $view;
	}

    /**
     * Get view
     *
     * @return	string	$view
     */
	public function getView() {
		return $this->view;
	}

	/**
     * Enable cache
     *
     * defaults to false
     *
     * @param	bool	$casheSet
     */
	public function enableCache($casheSet) {
		$this->cache = $casheSet;
	}

	/**
     * Check if cache is enabled
     *
     * @return	bool	$cache
     */
	public function isCacheEnabled() {
		return $this->cache;
	}

    /**
     * Return data as json from controller action
     *
     * @param	jsondata	Data to encode
     * @return	json		$jsondata
     */
	public function json($jsondata) {
		echo json_encode($jsondata);
	}

}