$(document).ready(function() {
	$('#add-new-website select').change(function() {
		$(this).closest('form').find('input').focus();
	});
	
	$('input[name="creditOptionsRadios"]:radio').change(function() {
		var credit_amount = $(this).val();
		$('#creditPurchasePayPalForm').find('input[name="quantity"]').val(credit_amount);
	});
});

function initScanPageUpdater(scanID) {
	if ($('.scans').data('status') != 2) {
		updateScanProgress(scanID);
	}
}

function updateScanProgress(scanID) {
	$.getJSON('/scans/getprogress/' + scanID)
		.done(function(data) {
			var newStatus = data.scan.status;
			var currentStatus = $('.scans').data('status');

			$('.scans').data('status', newStatus);

			$.each(data.scan.tests, function(key,value) {
				var testID = value.id;
				var $test = $('.scan-test-row[data-test-id=' + testID + ']');
				var status = value.status;
				if (status == 1) {
					$test.find('.test-in-progress').removeClass('hide');
				} else {
					$test.find('.test-in-progress').removeClass('hide').addClass('hide');
				}
			});
			
			if (newStatus != 2) {
				setTimeout(function () {
					updateScanProgress(scanID)
				}, 1000);
			}
		})
		.fail(function() {

		})
		.always(function() {

		}, 'json');
}