$(document).ready(function () {
	$open = ($elem) => {
		setTimeout(function () {
			$elem.addClass('rot90-1');

			setTimeout(() => {
				$elem.html('<i class="fa fa-minus"></i>');
				$elem.addClass('rot90-2');
			}, 150);
		}, 150);
	};
	$close = ($elem) => {
		setTimeout(function () {
			$elem.removeClass('rot90-2');

			setTimeout(() => {
				$elem.html('<i class="fa fa-plus"></i>');
				$elem.removeClass('rot90-1');
			}, 150);
		}, 150);
	};

	$('.collapse').on('show.bs.collapse', function () {
		$id = $(this).attr('id');
		$elem = $('#' + $id + 'i');
		$open($elem);
	});
	$('.collapse').on('hide.bs.collapse', function () {
		$id = $(this).attr('id');
		$elem = $('#' + $id + 'i');
		$close($elem);
	});

	//rate star click
	$('#s1').click(() => {
		$('#s2, #s3, #s4, #s5').removeClass('fa fa-star');
		$('#s2, #s3, #s4, #s5').addClass('far fa-star');
		if ($('#s1').hasClass('far fa-star')) {
			$('#s1').removeClass('far fa-star');
			$('#s1').addClass('fa fa-star');
		}
		$('#rate').val('1');
		$('#rem').html('Poor');
	});
	$('#s2').click(() => {
		$('#s3, #s4, #s5').removeClass('fa fa-star');
		$('#s3, #s4, #s5').addClass('far fa-star');
		if ($('#s2').hasClass('far fa-star')) {
			$('#s2').removeClass('far fa-star');
			$('#s2').addClass('fa fa-star');
		}
		if ($('#s1').hasClass('far fa-star')) {
			$('#s1').removeClass('far fa-star');
			$('#s1').addClass('fa fa-star');
		}
		$('#rate').val('2');
		$('#rem').html('Fair');
	});
	$('#s3').click(() => {
		$('#s4, #s5').removeClass('fa fa-star');
		$('#s4, #s5').addClass('far fa-star');
		if ($('#s3').hasClass('far fa-star')) {
			$('#s3').removeClass('far fa-star');
			$('#s3').addClass('fa fa-star');
		}
		if ($('#s1').hasClass('far fa-star')) {
			$('#s1').removeClass('far fa-star');
			$('#s1').addClass('fa fa-star');
		}
		if ($('#s2').hasClass('far fa-star')) {
			$('#s2').removeClass('far fa-star');
			$('#s2').addClass('fa fa-star');
		}
		$('#rate').val('3');
		$('#rem').html('Good');
	});
	$('#s4').click(() => {
		$('#s5').removeClass('fa fa-star');
		$('#s5').addClass('far fa-star');
		if ($('#s4').hasClass('far fa-star')) {
			$('#s4').removeClass('far fa-star');
			$('#s4').addClass('fa fa-star');
		}
		if ($('#s1').hasClass('far fa-star')) {
			$('#s1').removeClass('far fa-star');
			$('#s1').addClass('fa fa-star');
		}
		if ($('#s2').hasClass('far fa-star')) {
			$('#s2').removeClass('far fa-star');
			$('#s2').addClass('fa fa-star');
		}
		if ($('#s3').hasClass('far fa-star')) {
			$('#s3').removeClass('far fa-star');
			$('#s3').addClass('fa fa-star');
		}
		$('#rate').val('4');
		$('#rem').html('Very Good');
	});
	$('#s5').click(() => {

		if ($('#s5').hasClass('far fa-star')) {
			$('#s5').removeClass('far fa-star');
			$('#s5').addClass('fa fa-star');
		}
		if ($('#s1').hasClass('far fa-star')) {
			$('#s1').removeClass('far fa-star');
			$('#s1').addClass('fa fa-star');
		}
		if ($('#s2').hasClass('far fa-star')) {
			$('#s2').removeClass('far fa-star');
			$('#s2').addClass('fa fa-star');
		}
		if ($('#s3').hasClass('far fa-star')) {
			$('#s3').removeClass('far fa-star');
			$('#s3').addClass('fa fa-star');
		}
		if ($('#s4').hasClass('far fa-star')) {
			$('#s4').removeClass('far fa-star');
			$('#s4').addClass('fa fa-star');
		}
		$('#rate').val('5');
		$('#rem').html('Excellent');
	});

	//cancel butotn click
	$('#cancelbtn').click(() => {
		$('#s1, #s2, #s3, #s4, #s5').removeClass('fa fa-star');
		$('#s1, #s2, #s3, #s4, #s5').addClass('far fa-star');
		$('#rem').html('');
	});
	//submit rate button click
	$('#ratebtn').click(function () {
        $mode = parseInt($('#smode').val());
        //alert($mode);
		$rate = $('#rate').val();
		$pid = $('#ratebtn').attr('pid');
		if ($rate == '') {
			$('#rem').html('You\'ve not made any ratings <i class="fa fa-exclamation-circle"></i>');
		} else {
			$('#cancelbtn').prop('disabled', true);
			$('#ratebtn').prop('disabled', true);
			$('#ratebtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Submitting...');

			if ($mode == 0) {
				$url = $BASE + 'customers/api_insert_rating';
			} else {
				$url = $BASE + 'customers/api_update_rating';
			}
			$data = {
				pid: $pid,
				rate: $rate
			};
			$.ajax({
				type: 'POST',
				url: $url,
				data: $data,
				success: function (data) {
                    //console.log(data);
					$obj = JSON.parse(data);
					if ($obj.res == 'false') {
						$('#rem').html('We encountered problem submitting your ratings. Please try again!');
						$('#cancelbtn').prop('disabled', false);
						$('#ratebtn').prop('disabled', false);
						$('#ratebtn').html('Submit');
					} else {
						$('#ratebtn').html('<i class="fa fa-check-circle"></i> Submitted successfully');
						setTimeout(function () {
							$('#cancelbtn').click();
							$('#cancelbtn').prop('disabled', false);
							$('#ratebtn').prop('disabled', false);
							$('#ratebtn').html('Submit');

							//update product rating
							$updateRating($obj.rate);

							$('#rModal').modal('hide');
						}, 3000);
					}
				},
				error: function (err) {
					alert('Poor/No network connection. Check your network settings and try again!');
					console.log(err.responseText);
					$('#cancelbtn').prop('disabled', false);
					$('#updatebtn').prop('disabled', false);
					$('#updatebtn').html('Update');
				}
			});
		}
	});
});

$frate = (btn) => {
	$pid = $(btn).attr('pid');
	$('#ratebtn').attr('pid', $pid);
	//fetch rate if already exist for the logged in customer
	$url = $BASE + 'customers/api_get_single_rating';
	$data = {
		pid: $pid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: (data) => {
			console.log(data);
			$obj = JSON.parse(data);
			if ($obj.res == 'false') {
				$('#cancelbtn').click();
				$('#smode').val('0'); //insert
			} else {
				$r = $obj.rate;
				if ($r == 1) {
					$('#s1').click();
				} else if ($r == 2) {
					$('#s2').click();
				} else if ($r == 3) {
					$('#s3').click();
				} else if ($r == 4) {
					$('#s4').click();
				} else if ($r == 5) {
					$('#s5').click();
                }
                $('#smode').val('1'); //update
			}
			$('#rModal').modal('show');
		},
		error: (err) => {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
};

$updateRating=(rate)=>{
    $r = 5-rate;
    $ratecon='';
    for($i=0;$i<rate;$i++){
        $ratecon+='<i class="fa fa-star txt-morange"></i>';
    }
    for($i=0;$i<$r;$i++){
        $ratecon+='<i class="far fa-star txt-morange"></i>';
    }
    $('#prating').html($ratecon);
};
