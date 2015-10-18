<?php $this->assign('title', 'Login'); ?>
<div class="users form">
	<?= $this->Flash->render('auth') ?>
	<?= $this->Form->create($user, ['class' => 'form-signin']) ?>
		<fieldset>
			<div class="form-group">
				<?= $this->Form->label('email', 'Email', ['class' => 'sr-only']); ?>
				<?= $this->Form->input('email', ['class' => 'form-control', 'placeholder' => 'Email address', 'required', 'autofocus'] ) ?>
			</div>
			<div class="form-group">
				<?= $this->Form->label('password', 'Password', ['class' => 'sr-only']); ?>
				<?= $this->Form->input('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required']); ?>
			</div>
		</fieldset>
	<?= $this->Form->button(__('Login'), ['class' => 'btn btn-lg btn-primary btn-block']); ?>
	<?= $this->Form->end() ?>
</div>