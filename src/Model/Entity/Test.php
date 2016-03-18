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
	
	protected $_virtual = ['friendly_name'];

	const TEST_MAP = [
		"SSL" => "SSL/TLS",
		"HEADERS" => "HTTP Headers"
	];
	
	protected function _getFriendlyName()
    {
        return (self::TEST_MAP[$this->name]);
    }
	
}