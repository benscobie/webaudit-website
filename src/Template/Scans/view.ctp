<?php
$this->assign('title', 'Scan report');
?>
<div class="page-header">
	<h1><?= $this->fetch('title'); ?></h1>
</div>
<div class="scans" data-scan-status="<?= $scan['status']; ?>">
	<div class="row">
		<div id="scan-test-container" class="col-md-4">
			<div id="scan-test-row-header">
				Tests
			</div>
			<?php
				foreach ($scan['tests'] as $test) {
					?>
					<div class="scan-test-row <?= $test['status'] != 2 ? 'disabled' : ''; ?>" data-test-id="<?= $test['id']; ?>" data-test-status=<?= $test['status']; ?>>
						<div class="row">
							<div class="col-xs-8">
								<?= $test['friendly_name']; ?>
							</div>
							<div class="col-xs-4">
								<i class="fa fa-circle-o-notch fa-spin fa-pull-right test-progress-indicator <?= $test['status'] == 1 ? '' : 'hide' ?>"></i>
							</div>
						</div>
					</div>
					<?php
				}
			?>
		</div>
		<div id="scan-test-result-container" class="col-md-8">
			
		</div>
	</div>

</div>
<script id="scan-test-row-template" type="text/x-handlebars-template">
<div class="scan-test-row {{row_classes}}" data-test-id="{{test_id}}" data-test-status="{{test_status}}" style="display: none;">
	<div class="row">
		<div class="col-xs-8">
			{{test_friendly_name}}
		</div>
		<div class="col-xs-4">
			<i class="fa fa-circle-o-notch fa-spin fa-pull-right test-progress-indicator {{progress_classes}}"></i>
		</div>
	</div>
</div>
</script>
<script>
bindScanTestRows();
initScanPageUpdater(<?= $scan['id']; ?>);

function initScanPageUpdater(scanID) {
	var source = $("#scan-test-row-template").html();
	var template = Handlebars.compile(source);

	if (parseInt($('.scans').data('scan-status')) !== 2) {
		updateScanProgress(scanID, template);
	}
}

function bindScanTestRows() {
	$('.scan-test-row').click( function() {
		if (!$(this).hasClass('disabled')) {
			var testID = $(this).data('test-id');
			getTestResult(testID);
		}
	});
}

var ajaxCount = 0;
function getTestResult(testID) {
	var seqNumber = ++ajaxCount;
	$.get('/tests/view/' + testID)
	.done(function(data) {
		if (seqNumber === ajaxCount) {
			$('#scan-test-result-container').html(data);
		}
	})
	.fail(function() {

	})
	.always(function() {

	});
}

function updateScanProgress(scanID, template) {
	$.getJSON('/scans/getprogress/' + scanID)
	.done(function(data) {
		var newStatus = data.scan.status;
		$('.scans').data('status', newStatus);

		$.each(data.scan.tests, function(key, test) {
			var testID = test.id;
			var testRow = $('.scan-test-row[data-test-id=' + testID + ']');

			if (!testRow.length) {
				var context = {
					test_id: test.id,
					test_status: test.status,
					test_friendly_name: test.friendly_name
				};

				if (test.status !== 1) {
					context.progress_classes = "hide";
				}
				
				if (test.status !== 2) {
					context.row_classes = "disabled"
				}

				var newTestRowHtml = template(context);
				$(newTestRowHtml).appendTo('#scan-test-container').fadeIn('slow');
			} else {
				var status = test.status;
				if (status !== 2) {
					testRow.addClass('disabled');
				} else {
					testRow.removeClass('disabled');
				}
				
				if (status === 1) {
					testRow.find('.test-progress-indicator').removeClass('hide');
				} else {
					testRow.find('.test-progress-indicator').addClass('hide');
				}
			}
		});
		
		bindScanTestRows();

		if (newStatus !== 2) {
			setTimeout(function () {
				updateScanProgress(scanID, template);
			}, 1000);
		}
	})
	.fail(function() {

	})
	.always(function() {

	}, 'json');
}
</script>