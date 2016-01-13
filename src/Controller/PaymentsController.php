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
			file_put_contents('ipn_success.log', print_r($transactionData, true) . PHP_EOL, LOCK_EX | FILE_APPEND);
			
			// Valid IPN
			/*
			  1. Check that $_POST['payment_status'] is "Completed"
			  2. Check that $_POST['txn_id'] has not been previously processed
			  3. Check that $_POST['receiver_email'] is your Primary PayPal email
			  4. Check that $_POST['payment_amount'] and $_POST['payment_currency'] are correct
			 */

			$paymentsTable = TableRegistry::get('Payments');
			$payment = $paymentsTable->newEntity();

			if ($transactionData['payment_status'] == "Completed") {
				$payment->gross_amount = $transactionData['payment_status'];
			}

			$payment->provider = 'PayPal';
			$payment->transaction_id = $transactionData['txn_id'];
			$payment->transaction_type = $transactionData['payment_type'];
			$payment->gross_amount = $transactionData['mc_gross'];
			$payment->tax_amount = $transactionData['tax'];
			$payment->fee_amount = $transactionData['mc_fee'];
			$payment->currency = $transactionData['mc_currency'];
			$payment->received_amount = $payment->gross_amount - $payment->fee_amount;
			$payment->quantity = floor($payment->gross_amount / Configure::read('WebAudit.CreditPrice'));

			if ($transactionData['payment_status'] == "Completed") {
				$payment->status = 1;
			} else {
				$payment->status = 0;
			}

			if ($paymentsTable->save($payment)) {
				$id = $payment->id;

				if (!empty($transactionData['custom'])) {
					$usersTable = TableRegistry::get('Users');
					$userID = $transactionData['custom'];
					$user = $usersTable->get($userID);
					
					$duplicatePayments = $paymentsTable->find('all')
						->where(['transaction_id' => $payment->transaction_id])
						->andWhere(['provider' => 'PayPal']);

					if (empty($duplicatePayments)) {
						$user->addCredits($payment->quantity);
					} else {
						// Inform the user?
					}
				} else {
					// Somebody paid, and we don't know who they are
				}
			}
		} else {
			$errors = $listener->getErrors();
			file_put_contents('ipn_errors.log', print_r($errors, true) . PHP_EOL, LOCK_EX | FILE_APPEND);
		}
	}

	public function paymentCancel() {
		
	}

	public function paymentComplete() {
		
	}

}
