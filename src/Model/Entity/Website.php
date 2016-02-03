<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Website extends Entity {

	// Make all fields mass assignable except for primary key field "id".
	protected $_accessible = [
		'*' => true,
		'id' => false
	];
	
	public function generateVerificationContent() {
		$this->verification_content = sha1(random_bytes4(0));
	}

}
