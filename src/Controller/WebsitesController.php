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
		
		$this->paginate = [
			'limit' => 10,
			'conditions' => [
				'Websites.user_id' => $this->Auth->user('id')
			],
			'order' => [
				'Websites.hostname' => 'ASC',
			]
		];
		
		$websites = $this->paginate($this->Websites);
		
		$this->set(compact('website', 'websites'));
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
				$verified = $website->verifyOwnership();
				if (!$verified) {
					$this->Flash->error(__('Error verifying ownership.'));
				} else {
					$this->Flash->success('Ownership verified');
					return $this->redirect(['controller' => 'Websites', 'action' => 'index']);
				}
				
			}
		}
		
		$this->set(compact('website'));
	}
	
	public function scan($id) {
		$website = $this->Websites->get($id);
	
		if (!empty($website)) {
			if ($website->user_id != $this->Auth->user('id')) {
				$this->Flash->error(__('Unauthorised.'));
				return $this->redirect(['controller' => 'Websites', 'action' => 'index']);
			} elseif ($website->verifyOwnership() != true) {
				$this->Flash->error(__('The website needs to be verified before a scan can be scheduled.'));
				return $this->redirect(['controller' => 'Websites', 'action' => 'verify', $website->id]);
			}
			
			$usersTable = TableRegistry::get('Users');
			$user = $usersTable->get($this->Auth->user('id'));
			if ($user['credit_amount'] <= 0) {
				// Ensure that the credit amount shown to the user is up to date
				$this->Auth->setUser($user->toArray());
				
				$this->Flash->error(__('Insufficient credits to begin scan.'));
				return $this->redirect(['controller' => 'Websites', 'action' => 'index', $website->id]);
			} else {
				$scansTable = TableRegistry::get('Scans');
				$scan = $scansTable->newEntity();
				$scan->website = $website;

				if ($scansTable->save($scan)) {
					$user->credit_amount -= 1;
					$usersTable->save($user);
					
					// Update user session date to show new credit amount
					$this->Auth->setUser($user->toArray());
					
					return $this->redirect(['controller' => 'Scans', 'action' => 'view', $scan->id]);
				} else {
					return $this->redirect(['controller' => 'Websites', 'action' => 'index']);
				}
			}
		}
	}
	
	public function view($id) {
		$website = $this->Websites->get($id);
		$this->set(compact('website'));
	}
}
