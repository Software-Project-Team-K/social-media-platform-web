$(document).ready(function() {

	

	//Button for profile post
	$('#submit_profile_post').click(function(){
		var formData = new FormData($("form.profile_post")[0]);

		$.ajax({
			type: "POST",
			url: "../includes/handlers/ajax_submit_profile_post.php",
			data: formData,
			processData: false,
			contentType: false,
			success: function(msg) {
				alert('Posted Successfully');
				location.reload();
			},
			error: function(e) {
				alert('Failed To Post');
			}
		});

	});


});












