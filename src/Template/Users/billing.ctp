<?php $this->assign('title', 'Billing'); ?>
<div class="users">
	<?php
	if (!empty($payments)) {
	?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Payment ID</th>
				<th>Transaction ID</th>
				<th>Provider</th>
				<th>Paid</th>
				<th>Currency</th>
				<th>Credits Purchased</th>
				<th>Credit Price</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($payments as $payment) { ?>
			<tr>
				<th scope="row">#<?= $payment['id'] ?></th>
				<td><?= $payment['transaction_id'] ?></td>
				<td><?= $payment['provider'] ?></td>
				<td><?= number_format($payment['gross_amount'], 2) ?></td>
				<td><?= $payment['currency'] ?></td>
				<td><?= $payment['quantity'] ?></td>
				<td><?= number_format($payment['gross_amount'] / $payment['quantity'], 2) ?></td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	<?php } ?>
</div>