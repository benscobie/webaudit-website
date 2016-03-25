<?php
$testData = [];

foreach($test['test_data'] as $testdata) {
	$testData[$testdata['key']] = $testdata['value'];
}
?>
<h2>Authentication</h2>
<table class="table">
	<tr>
		<td class="col-md-3"><strong>Common Name</strong></td>
		<td><?= isset($testData['COMMON_NAME']) ? $testData['COMMON_NAME'] : 'Unknown'; ?></td>
	</tr>
	<tr>
		<td class="col-md-3"><strong>Valid From</strong></td>
		<td><?= isset($testData['VALID_FROM']) ? $testData['VALID_FROM'] : 'Unknown'; ?></td>
	</tr>
	<tr>
		<td class="col-md-3"><strong>Valid To</strong></td>
		<td><?= isset($testData['VALID_TO']) ? $testData['VALID_TO'] : 'Unknown'; ?></td>
	</tr>
	<tr>
		<td class="col-md-3"><strong>Key Strength</strong></td>
		<td><?= isset($testData['KEY_STRENGTH']) ? $testData['KEY_STRENGTH'] : 'Unknown'; ?></td>
	</tr>
	<tr>
		<td class="col-md-3"><strong>Issuer</strong></td>
		<td><?= isset($testData['ISSUER']) ? $testData['ISSUER'] : 'Unknown'; ?></td>
	</tr>
	<tr>
		<td class="col-md-3"><strong>Signature algorithm</strong></td>
		<td><?= isset($testData['SIGNATURE_ALGORITHM']) ? $testData['SIGNATURE_ALGORITHM'] : 'Unknown'; ?></td>
	</tr>
	<tr>
		<td class="col-md-3"><strong>Certificate Trusted</strong></td>
		<td><?= isset($testData['VALID_CERTIFICATE']) ? (($testData['VALID_CERTIFICATE'] == 1) ? '<strong class="text-success">Yes</strong>' : '<strong class="text-danger">No</strong>') : 'Unknown'; ?></td>
	</tr>
</table>

<h2>Protocols <small class="scan-status"><a href="#" class="scan-help-link" data-test="ssl">Help</a></small></h2>
<table class="table">
	<tr>
		<td class="col-md-3"><strong>SSL 2.0 Enabled</strong></td>
		<td>
			<?php
			switch ($testData['SSLV2_ENABLED']) {
				case 0:
					echo '<strong class="text-success">No</strong>';
					break;
				case 1:
					echo '<strong class="text-danger">Yes</strong>';
					break;
				case 2:
					echo '<strong class="text-warning">Unsure</strong>';
					break;
			}
			?>
		</td>
	</tr>
	<tr>
		<td class="col-md-3"><strong>SSL 3.0 Enabled</strong></td>
		<td>
			<?php
			switch ($testData['SSLV3_ENABLED']) {
				case 0:
					echo '<strong class="text-success">No</strong>';
					break;
				case 1:
					echo '<strong class="text-danger">Yes</strong>';
					break;
				case 2:
					echo '<strong class="text-warning">Unsure</strong>';
					break;
			}
			?>
		</td>
	</tr>
	<tr>
		<td class="col-md-3"><strong>TLS 1.0 Enabled</strong></td>
		<td>
			<?php
			switch ($testData['TLSV1_ENABLED']) {
				case 0:
					echo '<strong class="text-success">No</strong>';
					break;
				case 1:
					echo '<strong class="text-danger">Yes</strong>';
					break;
				case 2:
					echo '<strong class="text-warning">Unsure</strong>';
					break;
			}
			?>
		</td>
	</tr>
	<tr>
		<td class="col-md-3"><strong>TLS 1.1 Enabled</strong></td>
		<td>
			<?php
			switch ($testData['TLSV11_ENABLED']) {
				case 0:
					echo '<strong class="text-danger">No</strong>';
					break;
				case 1:
					echo '<strong class="text-success">Yes</strong>';
					break;
				case 2:
					echo '<strong class="text-warning">Unsure</strong>';
					break;
			}
			?>
		</td>
	</tr>
	<tr>
		<td class="col-md-3"><strong>TLS 1.2 Enabled</strong></td>
		<td>
			<?php
			switch ($testData['TLSV12_ENABLED']) {
				case 0:
					echo '<strong class="text-danger">No</strong>';
					break;
				case 1:
					echo '<strong class="text-success">Yes</strong>';
					break;
				case 2:
					echo '<strong class="text-warning">Unsure</strong>';
					break;
			}
			?>
		</td>
	</tr>
</table>
