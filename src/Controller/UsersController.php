<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;

class UsersController extends AppController {
	
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow(['register', 'logout']);
	}
	
	public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

	public function index() {
		$this->set('users', $this->Users->find('all'));
	}

	public function profile() {
		if (!$this->Auth->user()) {
			return $this->redirect(['controller' => 'Users', 'action' => 'login']);
		}

		$user = $this->Users->get($this->Auth->user('id'));
		if ($this->request->is('put')) {
			$usersTable = TableRegistry::get('Users');
			
			$currentPassword = $this->request->data['current_password'];
			$newPassword = $this->request->data['new_password'];
			$newPasswordConfirm = $this->request->data['new_password_confirm'];
			
			unset($this->request->data['current_password']);
			unset($this->request->data['new_password']);
			unset($this->request->data['new_password_confirm']);
				
			$verify = (new DefaultPasswordHasher)->check($currentPassword, $user->password);
			if ($verify) {
				$passwordUpdate = (strlen($newPassword) > 0);
				
				if ($passwordUpdate && strcmp($newPassword, $newPasswordConfirm) !== 0) {
					$this->Flash->error(__('New passwords do not match.'));
				} else {
					if ($passwordUpdate) {
						$this->request->data['password'] = $newPassword;
					}
					
					$usersTable->patchEntity($user, $this->request->data);
					if ($usersTable->save($user)) {
						if ($passwordUpdate) {
							$this->Flash->success(__('Profile and password updated'));
						} else {
							$this->Flash->success(__('Profile updated'));
						}
						return $this->redirect($this->Auth->redirectUrl());
					}
				}
			} else {
				$this->Flash->error(__('Incorrect current password entered.'));
			}
		}

		$this->set(compact('user'));
	}

	public function register() {
		if ($this->Auth->user()) {
			return $this->redirect(['controller' => 'Users', 'action' => 'profile']);
		}

		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			if ($this->Users->save($user)) {
				$newUser = $this->Users->get($user['id']);
				$this->Auth->setUser($newUser->toArray());
				$this->Flash->success(__('Registration successful.'));
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error(__('Error registering.'));
		}
		$this->set('user', $user);
	}

	public function login() {
		if ($this->Auth->user()) {
			return $this->redirect($this->Auth->redirectUrl());
		}

		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);
				if ($this->Auth->authenticationProvider()->needsPasswordRehash()) {
					$user = $this->Users->get($this->Auth->user('id'));
					$user->password = $this->request->data('password');
					$this->Users->save($user);
				}
				return $this->redirect($this->Auth->redirectUrl());
			}
			unset($this->request->data['password']);
			$this->Flash->error(__('Invalid username or password, try again'));
		}
		$this->set('user', $user);
	}

	public function logout() {
		return $this->redirect($this->Auth->logout());
	}

	public function billing() {
		$userID = $this->Auth->user('id');
		
		$paymentsTable = TableRegistry::get('Payments');
		$payments = $paymentsTable->find()->where(['Payments.user_id =' => $userID]);
		
		$paginateConfig = [
			'limit' => 10,
			'order' => [
				'Payments.id' => 'desc'
			]
		];
		
		$creditPrice = number_format(Configure::read('WebAudit.CreditPrice'), 2);
		$creditCurrency = Configure::read('WebAudit.CreditCurrency');

		$this->set(compact('userID', 'creditPrice', 'creditCurrency'));
		$this->set('payments', $this->Paginator->paginate($payments, $paginateConfig));
	}

}
