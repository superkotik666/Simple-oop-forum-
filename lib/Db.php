<?php

namespace lib;

use PDO;

class Db {

	protected $db;
	
	public function __construct() {
		$config = require 'config/db.php';
		$this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].'', $config['user'], $config['password']);
	}

	public function query($sql, $params = []) {
		$stmt = $this->db->prepare($sql);
		if (!empty($params)) {
			foreach ($params as $key => $val) {
				if (is_int($val)) {
					$type = PDO::PARAM_INT;
				} else {
					$type = PDO::PARAM_STR;
				}
				$stmt->bindValue(':'.$key, $val, $type);
			}
		}
		$stmt->execute();
		return $stmt;
	}

//ДЛЯ ВЫВОДА РЯДА ЗНАЧЕНИЙ ИЗ БД
    public function row($sql, $params = []) {
		$result = $this->query($sql, $params);
		return $result->fetchAll(PDO::FETCH_ASSOC);
	}
//ДЛЯ ВЫВОДА СТОЛБЦА ЗНАЧЕНИЙ ИЗ БД
	public function column($sql, $params = []) {
		$result = $this->query($sql, $params);
		return $result->fetchColumn();
	}


}
