<?php

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\Validation\Validator;

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
		
		$validator = new Validator();
		$validator
				->notEmpty('credit_amount')
				->add('credit_amount', 'naturalNumber', [
					'rule' => ['naturalNumber', false]
				]);
				
		$errors = $validator->errors(['credit_amount' => $amount]);
		
		if (empty($errors)) {
			$expression = new QueryExpression('credit_amount = credit_amount + ' . $amount);
			return $this->updateAll([$expression]);
		}
		
		return false;
	}

}
