$(document).ready(function () {

	//login btn click
	$('#lbtn').click(function (e) {
		e.preventDefault();
		let form = $('#loginForm')[0];
		$uname = $.trim($('#uname').val());
		$pswd = $('#pswd').val();

		if ($uname == '' || $pswd == '') {
			if (form.reportValidity)
				form.reportValidity();
			$('#errsp').html('Both fields are required');
			$('#err').show();
		} else {
			$('#errsp').html('');
			$('#err').hide();
			$('#lbtn').prop('disabled', true);
			$('#lbtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Logging in...');

			$url = $BASE + 'admin/api_login';
			$data = {
				uname: $uname,
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
						$('#lbtn').html('Login <i class="fa fa-sign-in-alt"></i>');
					} else {
						$('#lbtn').html('<i class="fa fa-check-circle"></i> Logged in successfully');
						setTimeout(function () {
							$('#uname').val('');
							$('#pswd').val('');

							$('#lbtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Redirecting...');

							setTimeout(function () {
								$('#lbtn').prop('disabled', false);
								$('#lbtn').html('Login <i class="fa fa-sign-in-alt"></i>');
								window.location.assign($BASE + 'admin/home');
							}, 1000);
						}, 2500);
					}
				},
				error: function (err) {
					alert('Poor/No network connection. Check your network settings and try again!');
					console.log(err.responseText);
					$('#lbtn').prop('disabled', false);
					$('#lbtn').html('Login <i class="fa fa-sign-in-alt"></i>');
				}
			});
		}
	});
});
