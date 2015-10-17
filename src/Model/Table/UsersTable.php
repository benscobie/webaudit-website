<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table {

	public function validationDefault(Validator $validator) {
		return $validator->notEmpty('email', 'An email is required')
						 ->notEmpty('password', 'A password is required');
	}

}