$(document).ready(function () {

    //edit percentage
    $('#ebtn').click(function(){
        $('#rate').prop('disabled', false);
        $('#ubtn').prop('disabled', false);
        $('#ebtn').prop('disabled', true);
    });

	//update percentage
	$('#ubtn').click(function (e) {
		e.preventDefault();
        $rate = $.trim($('#rate').val());
        
		if ($rate == '') {
			$('#errsp').html('Field can\'t be left empty');
			$('#err').show();
		} else {
			$('#errsp').html('');
			$('#err').hide();
			$('#ubtn').prop('disabled', true);
			$('#ubtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Updating...');

			$url = $BASE + 'admin/api_update_days';
			$data = {
				rate: $rate
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
						$('#ubtn').prop('disabled', false);
						$('#ubtn').html('Update');
					} else {
						$('#ubtn').html('<i class="fa fa-check-circle"></i> Updated successfully');
						setTimeout(function () {
                            $('#rate').val($rate);
                            $('#rate').prop('disabled', true);
							$('#ebtn').prop('disabled', false);
							$('#ubtn').prop('disabled', true);
							$('#ubtn').html('Update');
						}, 3000);
					}
				},
				error: function (err) {
					alert('Poor/No network connection. Check your network settings and try again!');
					console.log(err.responseText);
					$('#ubtn').prop('disabled', false);
					$('#ubtn').html('Update');
				}
			});
		}
	});
});