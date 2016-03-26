<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\ORM\Rule\IsUnique;

class UsersTable extends Table {

	public function initialize(array $config) {
		$this->hasMany('Payments', [
			'className' => 'Payments',
			'foreignKey' => 'user_id',
		]);
		
		$this->hasMany('Websites', [
			'className' => 'Websites',
			'foreignKey' => 'user_id',
		]);
	}
	
	public function validationDefault(Validator $validator) {
		return $validator->notEmpty('email', 'An email is required')
						->add('email', [
							'maxLength' => [
								'rule' => ['maxLength', 320],
								'message' => 'Email can be a maximum of 320 characters long',
							]])
						->notEmpty('password', 'A password is required')
						->add('password', [
							'minLength' => [
								'rule' => ['minLength', 6],
								'message' => 'Password needs to be at least 6 characters long',
							],
							'maxLength' => [
								'rule' => ['maxLength', 160],
								'message' => 'Password can be a maximum of 160 characters long',
							]])
						->add('first_name', [
							'maxLength' => [
								'rule' => ['maxLength', 255],
								'message' => 'First name can be a maximum of 255 characters long',
							]])
						->add('last_name', [
							'maxLength' => [
								'rule' => ['maxLength', 255],
								'message' => 'Last name can be a maximum of 255 characters long',
							]])
						->add('credit_amount', [
							'naturalNumber' => [
								'rule' => ['naturalNumber', false],
							]]);
	}
	
	public function buildRules(RulesChecker $rules) {
		$rules->add($rules->isUnique(['email'], 'An account with this email address already exists'));
		return $rules;
	}

}
