<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class WebsitesController extends AppController {

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->deny();
	}

	public function index() {
		$website = $this->Websites->newEntity();
		
		if ($this->request->is('post')) {
			$websitesTable = TableRegistry::get('Websites');
			$this->request->data['user_id'] = $this->Auth->user('id');
			$websitesTable->patchEntity($website, $this->request->data);
			if ($websitesTable->save($website)) {
				return $this->redirect(['controller' => 'Websites', 'action' => 'verify', $website->id]);
			}
		}
		
		$this->set(compact('website'));
		$this->set('websites', $this->Websites->find('all'));
	}
	
	public function verify($id, $action = NULL) {
		$website = $this->Websites->get($id);
		
		if (!empty($website)) {
			$websitesTable = TableRegistry::get('Websites');
			
			if ($website->user_id != $this->Auth->user('id')) {
				$this->Flash->error(__('Unauthorised.'));
				return $this->redirect(['controller' => 'Websites', 'action' => 'index']);
			}
			
			if ($action == 'verify') {
				$website->verifyOwnership();
				if (!$website->verified) {
					$this->Flash->error(__('Error verifying ownership.'));
				} else {
					$websitesTable = TableRegistry::get('Websites');
					if ($websitesTable->save($website)) {
						$this->Flash->success('Ownership verified');
						return $this->redirect(['controller' => 'Websites', 'action' => 'index']);
					}
				}
				
			}
		}
		
		$this->set(compact('website'));
	}
	
	public function view($id) {
		$website = $this->Websites->get($id);
		$this->set(compact('website'));
	}
}
