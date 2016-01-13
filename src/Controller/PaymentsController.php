<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use wadeshuler\paypalipn\IpnListener;

class PaymentsController extends AppController {

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow('paypalIpn');
	}

	public function index() {
		$payments = $this->Payments->find('all');
		$userID = $this->Auth->user('id');

		$this->set('payments', $payments);
		$this->set('userID', $userID);
	}

	public function paypalIpn() {
		$this->autoRender = false;
		// https://developer.paypal.com/developer/ipnSimulator/

		$listener = new IpnListener();

		$listener->use_sandbox = true;
		$listener->use_curl = true;
		$listener->follow_location = false;
		$listener->timeout = 30;
		$listener->verify_ssl = true;

		if ($verified = $listener->processIpn()) {
			$transactionData = $listener->getPostData();
			file_put_contents('../logs/ipn_success.log', print_r($transactionData, true) . PHP_EOL, LOCK_EX | FILE_APPEND);

			$paymentsTable = TableRegistry::get('Payments');
			$payment = $paymentsTable->newEntity();

			if ($this->request->data['payment_status'] == "Completed") {
				$payment->gross_amount = $this->request->data['payment_status'];
			}

			$payment->provider = 'PayPal';
			$payment->transaction_id = $this->request->data['txn_id'];
			$payment->transaction_type = $this->request->data['payment_type'];
			$payment->gross_amount = $this->request->data['mc_gross'];
			$payment->tax_amount = $this->request->data['tax'];
			$payment->fee_amount = $this->request->data['mc_fee'];
			$payment->currency = $this->request->data['mc_currency'];
			$payment->received_amount = $payment->gross_amount - $payment->fee_amount;
			$payment->quantity = floor($payment->gross_amount / Configure::read('WebAudit.CreditPrice'));

			if ($this->request->data['payment_status'] == "Completed") {
				$payment->status = 1;
			} else {
				$payment->status = 0;
			}
			
			$duplicatePayments = $paymentsTable->find('all')
					->where(['transaction_id' => $payment->transaction_id])
					->andWhere(['provider' => 'PayPal']);

			if (empty($duplicatePayments)) {
				if (!empty($this->request->data['custom'])) {
					$usersTable = TableRegistry::get('Users');
					$userID = $this->request->data['custom'];
					$user = $usersTable->get($userID);
					if (!empty($user)) {
						$payment->user_id = $user->id;
					}
				}
				
				if ($paymentsTable->save($payment)) {
					$id = $payment->id;
					if (!empty($payment->user_id)){
						$user->addCredits($payment->quantity);
					}
				}
			}
		} else {
			$errors = $listener->getErrors();
			file_put_contents('../logs/ipn_errors.log', print_r($errors, true) . PHP_EOL, LOCK_EX | FILE_APPEND);
		}
	}

	public function paymentCancel() {
		
	}

	public function paymentComplete() {
		
	}

}
