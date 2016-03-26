<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Network\Exception\NotFoundException;
use \App\Model\Entity\Test;

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

	public function index($websiteID = null) {
		if (!empty($websiteID)) {
			$websitesTable = TableRegistry::get('Websites');
			$website = $websitesTable->get($websiteID);
			if (!empty($website)) {
				if ($website->user_id != $this->Auth->user('id')) {
					throw new NotFoundException();
				}
			}
			
			$this->set(compact('website'));
			
			$query = $this->Scans->find('all')->where(['website_id' => $websiteID]);
			$scans = $this->paginate($query);
		} else {
			$query = $this->Scans->find('all')->where(['user_id' => $this->Auth->user('id')]);
			$scans = $this->paginate($query);
		}

		$this->set(compact('scans'));
	}

	public function view($id) {
		$this->renderLayoutTitle = false;
		
		$scan = $this->Scans->get($id, [
			'contain' => ['Tests', 'Websites']
		]);
		
		if ($scan['website']['user_id'] != $this->Auth->user('id')) {
			throw new NotFoundException();
		}
		
		// Load single test to show
		if (!empty($scan['tests'])) {
			foreach ($scan['tests'] as $test) {
				if ($test['status'] == Test::STATUS_COMPLETED) {
					$testsTable = TableRegistry::get('Tests');
					$test = $testsTable->get($test['id'], [
						'contain' => ['Scans' => ['Websites'], 'TestData']
					]);
					$this->set('test', $test);
					break;
				}
			}
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
				throw new NotFoundException();
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
