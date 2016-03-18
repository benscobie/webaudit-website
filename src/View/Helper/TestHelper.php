<?php

namespace App\View\Helper;

use Cake\View\Helper;
use App\Model\Entity\Test;

class TestHelper extends Helper
{
    public function getFriendlyName($name)
    {
		return (Test::getFriendlyName($name));
    }
}