<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'WebAudit';
?>
<!DOCTYPE html>
<html>
	<head>
		<?= $this->Html->charset() ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= $this->fetch('title') . ' - ' . $cakeDescription ?></title>
		<?= $this->Html->meta('icon') ?>

		<?= $this->Html->css('bootstrap.min.css') ?>
		<?= $this->Html->css('bootstrap-theme.css') ?>
		<?= $this->Html->css('font-awesome.min.css') ?>
		<?= $this->Html->css('main.css') ?>
		<?= $this->Html->script('jquery-1.12.0.min.js') ?>
		<?= $this->Html->script('bootstrap.min.js') ?>
		<?= $this->Html->script('handlebars.min.js') ?>
		<?= $this->Html->script('main.js') ?>

		<?= $this->fetch('meta') ?>
		<?= $this->fetch('css') ?>
		<?= $this->fetch('script') ?>
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/">WebAudit</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<?php
						if ($userLoggedIn) {
						?>
						<li><?= $this->Html->link('Websites', '/websites/'); ?></li>
						<li><?= $this->Html->link('Scans', '/scans/'); ?></li>
						<?php
						}
						?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<?php
						if ($userLoggedIn) {
						?>
						<li class="navbar-text">You have <?= $userLoggedIn['credit_amount']; ?> credits!</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Manage <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><?= $this->Html->link('Billing', '/users/billing'); ?></li>
								<li><?= $this->Html->link('Edit Profile', '/users/profile'); ?></li>
								<li><?= $this->Html->link('Logout', '/users/logout'); ?></li>
							</ul>
						</li>

						<?php } else { ?>
						<li><?= $this->Html->link('Register', '/users/register'); ?></li>
						<li><?= $this->Html->link('Login', '/users/login'); ?></li>
						<?php
						}
						?>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">
			<?= $this->Flash->render() ?>
			<?php if ($renderLayoutTitle) { ?>
			<h1><?= $this->fetch('title'); ?></h1>
			<?php } ?>
			<?= $this->fetch('content') ?>
		</div>
	</body>
</html>
