<?php

class routes{

	public function registerRoutes() {

		$routes = array (
			'home' => array(
				'controller' => 'index',
				'action' => 'index',
			),
		);

		return $routes;
	}

}