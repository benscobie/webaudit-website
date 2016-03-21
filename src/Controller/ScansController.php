<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\UnauthorizedException;

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
		$this->loadComponent('RequestHandler');
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
		$this->renderLayoutTitle = false;
		
		$scan = $this->Scans->get($id, [
			'contain' => ['Tests', 'Websites']
		]);
		
		if ($scan['website']['user_id'] != $this->Auth->user('id')) {
			$this->Flash->error(__('Unauthorised.'));
			return $this->redirect(['controller' => 'Websites', 'action' => 'index']);
		}
		
		
		// Load single test to show
		if (!empty($scan['tests']) && isset($scan['tests'][0]['id'])) {
			$testsTable = TableRegistry::get('Tests');
			$test = $testsTable->get($scan['tests'][0]['id'], [
				'contain' => ['Scans' => ['Websites'], 'TestData']
			]);
			
			$this->set('test', $test);
		}
		
		$this->set('queuePosition', $scan->queuePosition());
		
		$this->set(compact('scan'));
	}
	
	public function getprogress($id) {
		if ($this->request->is('ajax')) {
			$this->response->disableCache();
			$scan = $this->Scans->get($id, [
				'contain' => ['Tests', 'Websites']
			]);

			if ($scan['website']['user_id'] != $this->Auth->user('id')) {
				throw new UnauthorizedException(__('Unauthorised'));
			}
			
			unset($scan['website']);
			$scan['position_in_queue'] = $scan->queuePosition();

			$this->set(compact('scan'));
			$this->set('_serialize', ['scan']);
		} else {
			throw new NotFoundException();
		}
	}

}
