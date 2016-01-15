<?php

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\Validation\Validator;
use Cake\Database\Expression\QueryExpression;

class User extends Entity {

	// Make all fields mass assignable except for primary key field "id".
	protected $_accessible = [
		'*' => true,
		'id' => false
	];
    
	protected function _setPassword($password) {
		if (strlen($password) > 0) {
			return (new DefaultPasswordHasher)->hash($password);
		}
	}
	
	public function addCredits($amount) {
		if (empty($this->id)) {
			return false;
		}
		
		$this->credit_amount += $amount;
		
		return $this->save();
	}

}
