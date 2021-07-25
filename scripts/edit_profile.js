$(document).ready(()=>{
    //cancel button
    $('#cbtn').click(()=>{
        history.back();
    });

    //update button
    $('#ubtn').click((e)=>{
        e.preventDefault();
        $uname=$.trim($('#uname').val());
        $email=$.trim($('#email').val());
        $phno=$.trim($('#phno').val());
        $phno2=$.trim($('#phno2').val());
        $adres=$.trim($('#adres').val());
        $bank=$.trim($('#bank').val());
        $acctype=$.trim($('#acctype').val());
        $accname=$.trim($('#accname').val());
        $accno=$.trim($('#accno').val());

        if($uname==''||$email==''||$phno==''||$bank=='' || $acctype==''||$accname==''||$accno==''||$adres==''){
            $('#errsp').html('All fields are required');
			$('#err').show();
        }else{
            $('#errsp').html('');
			$('#err').hide();
			$('#ubtn').prop('disabled', true);
			$('#ubtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Updating profile...');

			$url = $BASE + 'admin/api_update_profile';
			$data = {
                uname:$uname,
                email:$email,
                phno:$phno,
                phno2:$phno2,
                adres:$adres,
                bank:$bank,
                acc_type:$acctype,
                acc_name:$accname,
                acc_no:$accno
            };
            $.ajax({
				type: 'POST',
				url: $url,
				data: $data,
				success: function (data) {
                    console.log(data);
					$obj = JSON.parse(data);
					if ($obj.res == 'false') {
						$('#errsp').html('Error: ' + $obj.err);
						$('#err').show();
						$('#ubtn').prop('disabled', false);
						$('#ubtn').html('Update');
					} else {
						$('#ubtn').html('<i class="fa fa-check-circle"></i> Updated successfully');
						setTimeout(function () {
                            //$clearFields();
							$('#ubtn').prop('disabled', false);
							$('#ubtn').html('Update');
						}, 3500);
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

    //clear fields
    $clearFields = ()=>{
        $('#uname').val('');
        $('#email').val('');
        $('#phno').val('');
        $('#phno2').val('');
        $('#bank').val('');
        $('#accname').val('');
        $('#accno').val('');
    }
});