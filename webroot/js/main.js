$(document).ready(function() {
	$('#add-new-website select').change(function() {
		$(this).closest('form').find('input').focus();
	});
});