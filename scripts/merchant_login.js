$(document).ready(function () {

	//login btn click
	$('#lbtn').click(function (e) {
		e.preventDefault();
		let form = $('#loginForm')[0];
		$email = $.trim($('#email').val());
        $pswd = $('#pswd').val();
        
		if ($email == '' || $pswd == '') {
			if (form.reportValidity) 
			form.reportValidity();
			$('#errsp').html('Both fields are required');
			$('#err').show();
		} else {
			$('#errsp').html('');
			$('#err').hide();
			$('#lbtn').prop('disabled', true);
			$('#lbtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Logging in...');

			$url = $BASE + 'merchants/api_login';
			$data = {
				email: $email,
				pswd: $pswd
            };
            
			$.ajax({
				type: 'POST',
				url: $url,
				data: $data,
				success: function (data) {
					$obj = JSON.parse(data);
					if ($obj.res == 'false') {
						$('#errsp').html('Error: ' + $obj.err);
						$('#err').show();
						$('#lbtn').prop('disabled', false);
						$('#lbtn').html('Submit');
					} else {
						$('#lbtn').html('<i class="fa fa-check-circle"></i> Logged in successfully');
						setTimeout(function () {
							$('#email').val('');
							$('#pswd').val('');

                            $('#lbtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Redirecting...');
							
							setTimeout(function () {
                                $('#lbtn').prop('disabled', false);
                                $('#lbtn').html('Submit');
                                window.location.assign($BASE + 'merchant/home');
							}, 1000);
						}, 2500);
					}
				},
				error: function (err) {
					alert('Poor/No network connection. Check your network settings and try again!');
					console.log(err.responseText);
					$('#lbtn').prop('disabled', false);
					$('#lbtn').html('Submit');
				}
			});
		}
	});
});
