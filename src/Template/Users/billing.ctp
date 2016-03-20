<?php $this->assign('title', 'Billing'); ?>
<div class="users">
	<p>Credits are currently <?= $creditPrice; ?> <?= $creditCurrency; ?> each. You can choose the amount you want to purchase below.</p>
	<div class="radio">
		<label>
			<input type="radio" name="creditOptionsRadios" id="creditOptionsRadios1" value="10" checked>
			10 Credits for <?= number_format(10 * $creditPrice, 2); ?> <?= $creditCurrency; ?>
		</label>
	</div>
	<div class="radio">
		<label>
			<input type="radio" name="creditOptionsRadios" id="creditOptionsRadios2" value="25">
			25 Credits for <?= number_format(25 * $creditPrice, 2); ?> <?= $creditCurrency; ?>
		</label>
	</div>
	<div class="radio">
		<label>
			<input type="radio" name="creditOptionsRadios" id="creditOptionsRadios3" value="50">
			50 Credits for <?= number_format(50 * $creditPrice, 2); ?> <?= $creditCurrency; ?>
		</label>
	</div>
	<div class="radio">
		<label>
			<input type="radio" name="creditOptionsRadios" id="creditOptionsRadios4" value="100">
			100 Credits for <?= number_format(100 * $creditPrice, 2); ?> <?= $creditCurrency; ?>
		</label>
	</div>
	<div class="radio">
		<label>
			<input type="radio" name="creditOptionsRadios" id="creditOptionsRadios5" value="250">
			250 Credits for <?= number_format(250 * $creditPrice, 2); ?> <?= $creditCurrency; ?>
		</label>
	</div>
	<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="creditPurchasePayPalForm" name="PayPalForm"  target="_top">
		<input type="hidden" name="cmd" value="_xclick">   
		<input type="hidden" name="business" value="admin@benscobie.com">
		<input type="hidden" name="amount" value="<?= $creditPrice; ?>">
		<input type="hidden" name="item_name" value="Web Audit Scanning Credits">
		<input type="hidden" name="quantity" value="10">
		<input type="hidden" name="currency_code" value="<?= $creditCurrency; ?>">
		<input type="hidden" name="lc" value="GB">
		<input type="hidden" name="custom" value="<?= $userID; ?>" >
		<input type="hidden" name="notify_url" value="http://webaudit.benscobie.com/payments/paypal_ipn">
		<input type="hidden" name="cancel_return" value="http://webaudit.benscobie.com/payments/payment_cancel">
		<input type="hidden" name="return" value="http://webaudit.benscobie.com/payments/payment_complete">
		<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
	</form>
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