(function() {
	$(document).ready(function() {
		$('#submit-note').click(function() {
			var postData = {};
			postData.team = parseInt($('#note-team').val());
			postData.text = $('#note-area').val();
			$.post('/?controller=notes&action=submit', postData, function() {
				alertify.success('ok');
			}).fail(function(dat) {
				alertify.error(dat.responseText);
			});
		});
	});
})();