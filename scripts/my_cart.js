$(document).ready(() => {
	//alert('hello');
	$disableQtyTyping();
	$bindEventToQtyInput();
	$bindEventToRemoveButton();

	//yesbtn on confirm remove
	$('#ryesbtn').click(() => {
		$rid = $('#ryesbtn').attr('rid');
		$id = '#' + $rid;

		$url = $BASE + 'customers/api_remove_from_cart';
		$data = {
			rowid: $rid
		};
		$('#ryesbtn').prop('disabled', true);
		$('#rnobtn').prop('disabled', true);
		$.ajax({
			type: 'POST',
			url: $url,
			data: $data,
			success: (data) => {
				$obj = JSON.parse(data);
				if ($obj.res == 'false') {
					alert('Encountered problem removing this item! Try again.')
				} else {
					setTimeout(() => {
						if ($obj.qty != 0) {
							$('#gtotal').html($obj.total);
							$('.cartno').html($obj.qty);
						} else {
							$('#gtotal').html('0.00');
							$('.cartno').hide();
							$('#mcart').hide();
							$('#empty').show();
						}
						$animateRemove($id);
					}, 1000);
					$('#cModal').modal('hide');
				}
				$('#ryesbtn').prop('disabled', false);
				$('#rnobtn').prop('disabled', false);
			},
			error: (err) => {
				alert('Poor/No network connection. Check your network settings and try again!');
				console.log(err.responseText);
				$('#ryesbtn').prop('disabled', false);
				$('#rnobtn').prop('disabled', false);
			}
		});
    });
    
    //check out button
    $('#checkout').click(()=>{
        $mode = $('#checkout').attr('login');
        if($mode=='false'){
            $('#checkout').attr('send', 'yes');
            $('#lModal').modal('show');
        }else{
            window.location.assign($BASE+'checkout');
        }
    });

});

//=============functions=====================
//disable typing into quantity input
$disableQtyTyping = () => {
	if (!detectmob()) {
		$('.qty').keydown((e) => {
			e.preventDefault();
		});
	}
};

//bind event to quantity input
$bindEventToQtyInput = () => {
	$('.qty').change((e) => {
		$elem = e.currentTarget;
		$rid = $($elem).attr('rid');
		$qty = $($elem).val();

		$url = $BASE + 'customers/api_update_cart';
		$data = {
			rowid: $rid,
			qty: $qty
		};
		$($elem).prop('disabled', true);
		$.ajax({
			type: 'POST',
			url: $url,
			data: $data,
			success: (data) => {
				//console.log(data);
				$obj = JSON.parse(data);
				if ($obj.res == 'false') {
					$($elem).val(parseInt($qty) - 1);
					alert('Encountered problem updating the quantity of this product! Try again.')
				} else {
					$('#' + $rid + ' span').html($obj.fsub);
					$('#gtotal').html($obj.total);
					$('.cartno').html($obj.qty);
				}
				$($elem).prop('disabled', false);
			},
			error: (err) => {
				alert('Poor/No network connection. Check your network settings and try again!');
				console.log(err.responseText);
				$($elem).prop('disabled', false);
			}
		});
	});
};

//bind event to remove button
$bindEventToRemoveButton = () => {
	$('.tab-rem').click((e) => {
		$elem = e.currentTarget;
		$rid = $($elem).attr('rid');
		$('#ryesbtn').attr('rid', $rid);
		$('#cModal').modal('show');
	});
};

//animate remove
$animateRemove = (id) => {
	$(id).fadeOut(1200, () => {
		$(id).hide();
		$($id).remove(); // remove target from the DOM
	});
};

function detectmob() {
	if (navigator.userAgent.match(/Android/i) ||
		navigator.userAgent.match(/webOS/i) ||
		navigator.userAgent.match(/iPhone/i) ||
		navigator.userAgent.match(/iPad/i) ||
		navigator.userAgent.match(/iPod/i) ||
		navigator.userAgent.match(/BlackBerry/i) ||
		navigator.userAgent.match(/Windows Phone/i)
	) {
		return true;
	} else {
		return false;
	}
}
