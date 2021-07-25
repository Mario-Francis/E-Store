$(document).ready(function(){
    //submit button click
    $('#sbtn').click(function(e){
		e.preventDefault();
        $cpswd = $('#cpswd').val();
        $npswd = $('#npswd').val();
        $npswd2 = $('#npswd2').val();
        
		if ($cpswd == '' || $npswd==''||$npswd2=='') {
			$('#errsp').html('All fields are required');
			$('#err').show();
		} else {
			$('#errsp').html('');
			$('#err').hide();
			$('#sbtn').prop('disabled', true);
			$('#sbtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Changing password...');

			$url = $BASE + 'api_change_password';
			$data = {
                cpswd:$cpswd,
                npswd:$npswd,
                npswd2:$npswd2
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
						$('#sbtn').prop('disabled', false);
						$('#sbtn').html('Submit');
					} else {
						$('#sbtn').html('<i class="fa fa-check-circle"></i> Changed successfully');
						setTimeout(function () {
                            $('#cpswd').val('');
                            $('#npswd').val('');
                            $('#npswd2').val('');
							$('#sbtn').prop('disabled', false);
							$('#sbtn').html('Submit');
						}, 3000);
					}
				},
				error: function (err) {
					alert('Poor/No network connection. Check your network settings and try again!');
					console.log(err.responseText);
					$('#sbtn').prop('disabled', false);
					$('#sbtn').html('Submit');
				}
			});
		}
    });
});