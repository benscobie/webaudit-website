<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class Test extends Entity {

	// Make all fields mass assignable except for primary key field "id".
	protected $_accessible = [
		'*' => true,
		'id' => false
	];

	const TEST_MAP = [
		"SSL" => "SSL/TLS",
		"HEADERS" => "HTTP Headers"
	];

	public static function getFriendlyName($name) {
		return (self::TEST_MAP[$name]);
	}
	
}