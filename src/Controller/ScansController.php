<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class ScansController extends AppController {

	public $paginate = [
		'limit' => 10,
		'order' => [
			'Scans.id' => 'DESC'
		],
		'contain' => ['Websites']
	];

	public function initialize() {
		parent::initialize();
		$this->loadComponent('Paginator');
	}

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->deny();
	}

	public function index() {
		$scans = $this->paginate($this->Scans);
		$this->set(compact('scans'));
	}

	public function view($id) {
		$scan = $this->Scans->get($id, [
			'contain' => ['Tests', 'Websites']
		]);
		
		if ($scan['website']['user_id'] != $this->Auth->user('id')) {
			$this->Flash->error(__('Unauthorised.'));
			return $this->redirect(['controller' => 'Websites', 'action' => 'index']);
		}
		
		$this->set(compact('scan'));
	}

}
