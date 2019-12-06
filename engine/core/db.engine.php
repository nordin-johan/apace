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
 * Database class
 *
 * @param	object	$connection		Connection object
 */
class DB {

	protected $connection;

    /**
     * Class constructor
     *
     * @param   string      $host		db host
     * @param   string      $user       db user
     * @param   string      $password	db password
     * @return  string		$db       	database
     */
	public function __construct($host, $user, $password, $db) { 

		try {
			$this->connection = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}

		catch(PDOException $e) {
	    	echo "Connection failed: " . $e->getMessage();
	    }

	}

    /**
     * Perform a database query
     *
     * @param   string      $sql	Sql statement
     * @param   string      $binds	Bind sql statement
     * @return  array    	$data 	Array of results from query
     */
	public function query($sql, $binds = null) {

		// If no connection, return false
		if ( !$this->connection ) {
			return false;
		}

		$data = $this->connection->prepare($sql);

		// Bind params if exists
		if ($binds) {
			foreach ($binds as $key => $value) {
				$data->bindValue($key, $value);
			}
		}

		$data->execute();

		return $data;

	}

}