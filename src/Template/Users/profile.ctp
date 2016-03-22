<?php $this->assign('title', 'Profile'); ?>
<div class="users form">
<?= $this->Form->create($user); ?>
    <fieldset>
    	<div class="form-group">
			<?= $this->Form->input('current_password', ['label' => 'Current password', 'type' => 'password', 'class' => 'form-control', 'placeholder' => 'Password', 'required', 'autofocus']); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->input('first_name', ['class' => 'form-control', 'placeholder' => 'First name', 'required', 'autofocus']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->input('last_name', ['class' => 'form-control', 'placeholder' => 'Last name', 'required', 'autofocus']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->input('email', ['class' => 'form-control', 'placeholder' => 'Email address', 'required', 'autofocus']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->input('new_password', ['label' => 'New password', 'type' => 'password', 'class' => 'form-control', 'placeholder' => 'New password']); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->input('new_password_confirm', ['label' => 'Re-enter new password', 'type' => 'password', 'class' => 'form-control', 'placeholder' => 'Re-enter new Password']); ?>
		</div>
	</fieldset>
<?= $this->Form->button(__('Update'), ['class' => 'btn btn-lg btn-primary btn-block']); ?>
<?= $this->Form->end() ?>
</div>