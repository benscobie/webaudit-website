<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Core\Configure;

class Website extends Entity {

	// Make all fields mass assignable except for primary key field "id".
	protected $_accessible = [
		'*' => true,
		'id' => false
	];
	
	public function generateVerificationContent() {
		$this->verification_content = sha1(random_bytes(40));
	}
	
	public function getVerificationTXTRecord() {
		return ('webaudit-site-verification=' . $this->verification_content);
	}
	
	public function getVerificationFileUploadFileName() {
		return ("webaudit_" . substr(md5($this->verification_content), 0, 16) . ".html");
	}
	
	public function getFullUrl($trailingSlash = FALSE) {
		$url = $this->protocol . "://" . $this->hostname;
		return $trailingSlash ? $url . "/": $url;
	}
	
	public function getVerificationFileUploadUrl() {
		return ($this->getFullUrl() . "/" . $this->getVerificationFileUploadFileName()	);
	}
	
	public function verifyOwnership() {
		$this->verified = 0;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->getVerificationFileUploadUrl());
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$useragent = Configure::read('WebAudit.UserAgent');
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		$response = curl_exec($ch);
		
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($httpCode == 200) {
			$body = substr($response, $header_size);

			if (strcmp($body, $this->verification_content) === 0) {
				
				$this->verified = 1;
			}
		}
		
		curl_close($ch);
		
		if (!$this->verified) {
			if (checkdnsrr($this->getVerificationTXTRecord() . "." . $this->hostname,"TXT")) {
				
			}
		}
		
		return $this->verified;
	}

}
