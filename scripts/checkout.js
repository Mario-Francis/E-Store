$(document).ready(()=>{
    //proceedbtn click
    $('#proceedbtn').click(()=>{
        $ard = $('input[type="radio"][name="adresrd"]:checked').val();
        $adres= $ard=='0'?$.trim($('#cadres').html()):$.trim($('#adres').val());
        $pay_mode=$('input[type="radio"][name="payrd"]:checked').val();

        if($ard==1 && $adres==''){
            $('#errsp').html('Specify destination address');
			$('#err').show();
        }else{
            $('#errsp').html('');
			$('#err').hide();

			$('#proceedbtn').prop('disabled', true);
			$('#proceedbtn').html('<i class="fa fa-circle-notch fa-spin"></i> Generating invoice...');
			
			$url = $BASE + 'customers/api_generate_invoice';
			$data = {
                adres:$adres,
                pay_mode:$pay_mode
            };
            $.ajax({
				type: 'POST',
				url: $url,
				data: $data,
				success: function (data) {
                    console.log(data);
					$obj = JSON.parse(data);
					if ($obj.res == 'false') {
						window.location.replace($BASE+'customers/my_cart');
					} else {
						window.location.replace($BASE+'customers/invoice');
					}
				},
				error: function (err) {
					alert('Poor/No network connection. Check your network settings and try again!');
					console.log(err.responseText);
				}
			});
        }
    });
});