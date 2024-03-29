<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Core\Configure;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;

class Website extends Entity {

	// Make all fields mass assignable except for primary key field "id".
	protected $_accessible = [
		'*' => true,
		'id' => false
	];
	
	public function generateVerificationContent() {
		$this->verification_content = hash('sha512', Security::randomBytes(16), false);
	}
	
	public function getVerificationFileUploadFileName() {
		return ("webaudit_" . $this->getShortVerificationString() . ".html");
	}
	
	public function getShortVerificationString() {
		return (substr(md5($this->verification_content), 0, 16));
	}
	
	public function getFullUrl($trailingSlash = FALSE) {
		$url = $this->protocol . "://" . $this->hostname;
		return $trailingSlash ? $url . "/": $url;
	}
	
	public function getVerificationFileUploadUrl() {
		return ($this->getFullUrl() . "/" . $this->getVerificationFileUploadFileName()	);
	}
	
	public function verifyOwnership() {
		$verified = false;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->getVerificationFileUploadUrl());
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$useragent = Configure::read('WebAudit.UserAgent');
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$response = curl_exec($ch);
		if ($response !== FALSE) {
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($httpCode == 200) {
				$body = substr($response, $header_size);
				if (strcmp($body, $this->verification_content) === 0) {
					$verified = true;
				}
			}
		}
		curl_close($ch);
		
		if ($this->verified == $verified) {
			return $verified;
		} else {
			$this->verified = $verified;
			$websitesTable = TableRegistry::get('Websites');
			if ($websitesTable->save($this)) {
				return $verified;
			} else {
				return false;
			}
		}
	}
	
	public static function hasScans($websiteID) {
		$scansTable = TableRegistry::get('Scans');
		
		$query = $scansTable->find('all')
			->where([
				'Scans.website_id =' => $websiteID,
			]);
		
		$website = $query->first();
		return (!empty($website));
	}
	
}
