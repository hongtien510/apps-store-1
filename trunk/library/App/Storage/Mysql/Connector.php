<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Connector
 *
 * @author anhlh
 */
class App_Storage_Mysql_Connector {

	private $flag;
	private static $_instance;
	public $pageSize = 5;

	public static function getInstance() {
		if (self::$_instance == NULL) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	function __construct() {
		$this->flag = NULL;
		$this->connect();
	}

	function __destruct() {
		$this->close();
	}

	private function connect() {
		$config = Zend_Registry::get(APPLICATION_CONFIG);
		try {
			$this->flag = mysql_connect($config->storage->db->mysql->host, $config->storage->db->mysql->user, $config->storage->db->mysql->pass);
			if (!$this->flag) {
				return false;
			} else {
				if (!mysql_select_db($config->storage->db->mysql->dbname)) {
					return false;
				} else {
					mysql_query("SET NAMES 'utf8'");
//					$this->pageSize = $config->paging->mysql->size;
					return true;
				}
			}
		} catch (Exception $err) {
			return false;
		}
	}

	private function close() {
		if ($this->flag)
			mysql_close($this->flag);
	}

	function executeNonQuery($question) {
		$result = NULL;
		try {
			$result = mysql_query($question);
		} catch (Exception $err) {
			return NULL;
		}
		return $result;
	}

	function executeReader($question) {
		$data = $this->executeNonQuery($question);
		$result = NULL;
		if ($data != NULL) {
			$result = array();
			try {
				while ($row = @mysql_fetch_array($data, MYSQL_ASSOC)) {
					$result[] = $row;
				}
				@mysql_free_result($data);
			} catch (Exception $err) {

				$result = NULL;
			}
		}
		return $result;
	}

	function getNearIndex() {
		try {
			return mysql_insert_id();
		} catch (Exception $err) {
			return 0;
		}
	}

	function safeParams($values, $option=0) {
		if (is_numeric($values))
			return (string)$values;
		if (!isset($values) || $values == '') {
			if ($option == 0) {
				return '';	 // $value is string
			} else {
				return 'null'; // $valuse is number
			}
		}
		try {
			$values = mysql_real_escape_string($values);
		} catch (Exception $err) {

			if ($option == 0)
				return '';
			else {
				return 'null';
			}
		}
		return $values;
	}

	function testconnect() {
		$result = $this->connect();
		$this->close();
		return $result;
	}

}

