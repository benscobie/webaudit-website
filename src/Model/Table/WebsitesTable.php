<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\ORM\Rule\IsUnique;

class WebsitesTable extends Table {

	public function initialize(array $config) {
		$this->hasMany('Scans', [
			'className' => 'Scans',
		]);
	}
	
	public function validationDefault(Validator $validator) {
		$validator->add('hostname', 'custom', [
			'rule' => function ($value, $context) {
				// http://stackoverflow.com/a/4694816
				return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $value) //valid chars check
						&& preg_match("/^.{1,253}$/", $value) //overall length check
						&& preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $value)); //length of each label
			},
			'message' => 'Invalid hostname entered'
		]);
			
		$validator->add('protocol', 'custom', [
			'rule' => function ($value, $context) {
				$validProtocols = ["http", "https"];
				return (in_array($value, $validProtocols));
			},
			'message' => 'Invalid protocol selected'
		]);
		
		$validator->add('hostname', [
			'unique' => [
				'rule' => ['validateUnique', ['scope' => ['protocol', 'user_id']]],
				'provider' => 'table',
				'message' => 'This website already exists'
			]
		]);
		
		return $validator;
	}
	
	public function buildRules(RulesChecker $rules) {
		$rules->add($rules->isUnique(['protocol', 'hostname', 'user_id'], 'This website already exists'));
		return $rules;
	}
	
	public function beforeSave($event, $entity, $options)  {
		if (empty($entity->verification_content)) {
			$entity->generateVerificationContent();
		}
	}

}
