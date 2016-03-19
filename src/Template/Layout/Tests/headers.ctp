<?php
$headers = [];
foreach ($test['test_data'] as $testdata) {
	$headers[strtolower($testdata['key'])] = $testdata['value'];
}

$supportedHeaders = [
	'server' => 'Server',
];

$supportedSecurityHeaders = [
	'strict-transport-security' => 'Strict-Transport-Security',
	'x-frame-options' => 'X-Frame-Options',
	'x-xss-protection' => 'X-XSS-Protection',
	'x-content-type-options' => 'X-Content-Type-Options',
	'content-security-policy' => 'Content-Security-Policy',
	'public-key-pins' => 'Public-Key-Pins'
];

$supportedHeaders = array_merge($supportedHeaders, $supportedSecurityHeaders);

$missingSecurityHeaders = [];
$existingSecurityHeaders = [];

foreach ($supportedSecurityHeaders as $header => $friendlyHeader) {
	if(empty($headers[$header])) {
		$missingSecurityHeaders[$header] = '';
	} else {
		$existingSecurityHeaders[$header] = $headers[$header];
	}
}

if (!empty($headers)) {
	?>
	<h2>Headers</h2>
	<table class="table">
	<?php
	foreach ($test['test_data'] as $testdata) {
		?>
		<tr>
			<td class="col-md-3"><strong><?= $supportedHeaders[strtolower($testdata['key'])]; ?></strong></td>
			<td><?= $testdata['value']; ?></td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
}

if (!empty($missingSecurityHeaders)) {
	?>
	<h2>Missing Headers</h2>
	<table class="table">
	<?php
	foreach ($missingSecurityHeaders as $header => $value) {
		?>
		<tr>
			<td class="col-md-3"><strong class="text-danger"><?= $supportedHeaders[$header]; ?></strong></td>
			<td><?= $this->element('Tests/Headers/' . $header); ?></td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
}

if (!empty($existingSecurityHeaders)) {
	?>
	<h2>Existing Headers</h2>
	<table class="table">
	<?php
	foreach ($existingSecurityHeaders as $header => $value) {
		?>
		<tr>
			<td class="col-md-3"><strong class="text-success"><?= $supportedHeaders[$header]; ?></strong></td>
			<td><?= $this->element('Tests/Headers/' . $header); ?></td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
}