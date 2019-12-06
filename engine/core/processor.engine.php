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
 * Processor class
 *
 * Processes a request and serves requested data and content
 *
 * @param	string	$extension	File extension of view
 */
class Processor {

	protected $extension = '.php';

	/**
	 * Process
	 *
	 * Processes a request and serves requested data and content
	 *
	 * @param	object	$Co		Controller object
	 * @param	object	$Cm		Controller method
	 */
	public function process($Co, $Cm) {

		// Default view path based on router
		$defaultViewPath = VIEW_PATH.DS.Apace::$router->getController().DS.Apace::$router->getAction().$this->extension;

		// If the viewpath if set from inside controller
		$setViewPath = $Co->$Cm();
		$setViewPath = empty( $Co->getView() ) ? $setViewPath = $setViewPath : $setViewPath = VIEW_PATH.DS.$Co->getView().$this->extension;

		$layout = empty( $Co->getLayout() ) ? 'layout' : $Co->getLayout();

		// If either the defaultViewPath based on route exists or the setViewPath based on setView exists
		if (file_exists($defaultViewPath) || file_exists($setViewPath)) {

			$cacheFile = CACHE_PATH.DS.Apace::$router->getLanguage().'.'.Apace::$router->getController().'.'.Apace::$router->getAction().$this->extension;
			if (file_exists( $cacheFile )) {
				readfile( $cacheFile );
			} else {

				// Generate view
				$viewObject = new View($Co->getData(), $setViewPath);
				$content = $viewObject->renderView();

				// Generate layout
				$layoutPath = VIEW_PATH.DS.$layout.$this->extension;
				if (file_exists($layoutPath)) {
					$layoutViewObject = new View(compact('content'), $layoutPath);
					$renderedView = $layoutViewObject->renderView();
				} else {
					$renderedView = $content;
				}
				
				// Save to cache if enabled
				if ($Co->isCacheEnabled() === TRUE) {
					$cacheView = fopen($cacheFile, "w");
					fwrite($cacheView, $renderedView);
					fclose($cacheView);
				}

				// Echo compressed and data generated view
				echo $renderedView;
			}

		}

	}

}