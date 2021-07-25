$(document).ready(function () {
	//initialize basket
	$initBasket();

	$disableQtyTyping();
	//$bindEventToQtyInput();

	//basket click
	$('#basket').click(function () {
		if ($('#basket_div').hasClass('basket-open')) {
			$('#basket_div').removeClass('basket-open');
			$('#basket_div').addClass('basket-closed');

			$('#basket p i').removeClass('fa-times');
			$('#basket p i').addClass('fa-shopping-basket');

			$('#bcon').removeClass('basket-con-open');
			$('#bcon').addClass('basket-con-closed');

			$('.bbody').hide();
			$('#parr').hide();
			$('#overdiv').hide();

			$('#basket_no').removeClass('sbno');
		} else {
			$('#basket_div').removeClass('basket-closed');
			$('#basket_div').addClass('basket-open');

			$('#basket p i').removeClass('fa-shopping-cart');
			$('#basket p i').addClass('fa-times');

			$('#bcon').removeClass('basket-con-closed');
			$('#bcon').addClass('basket-con-open');

			setTimeout(function () {
				$('.bbody').show();
				$('#parr').show();
			}, 500);
			$('#overdiv').show();

			$('#basket_no').addClass('sbno');
		}
		if ($CART.qty == 0) {
            $('#basket_no').hide();
            $('.cartno').hide();
			setTimeout(() => {
				$slideDownBasket();
			}, 800);
		}
	});

	//basket footer hover
	$('#basket_div .total').mouseenter(function () {
		//$('#arr').removeClass('hiden');
		//$('#arr').fadeIn(500);
		$('#arr').css('opacity', '0');
		$('#arr').removeClass('hiden');
		$('#parr').removeClass('exp');
		setTimeout(() => {
			$('#arr').animate({
				opacity: '1'
			}, 80);
		}, 120);
	});
	$('#basket_div .total').mouseleave(function () {
		//$('#arr').addClass('hiden');
		//$('#arr').fadeOut(500);
		$('#arr').animate({
			opacity: '0'
		}, 20, () => {

		});
		$('#arr').addClass('hiden');
		$('#parr').addClass('exp');

	});

	$('#overdiv').click(() => {
		//console.log($CART);
		$('#basket').click();
		

	});
	// $('#anim').click(() => {
	// 	$slideDownBasket();
	// });

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
				//console.log(data);
				//console.log($CART);
				$obj = JSON.parse(data);
				if ($obj.res == 'false') {
					alert('Encountered problem removing this item! Try again.')
				} else {
					setTimeout(() => {
						if ($obj.qty != 0) {
							$('#gtotal').html($obj.total);
                            $('#qno').html($obj.qty);
                            $('.cartno').html($obj.qty);
						} else {
							$('#gtotal').html('0.00');
							$('#qno').html('0');
                            $('#qno').hide();
                            $('.cartno').hide();
						}
						$animateRemove($id);
						$CART = $obj;
					}, 1200);
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

	//basket checkout
	$('#bcheckout').click(()=>{
		window.location.assign($BASE+'my_cart');
	});
});

//functions
addToCart = (btn) => {
	$dat = $(btn).attr('data');
	$d = decodeURIComponent($dat);
	$ob = JSON.parse($d); //product object
	$pid = $ob.id;
	//alert($pid);
	$url = $BASE + 'customers/api_add_to_cart';
	$data = {
		pid: $pid
	};
	$.ajax({
		type: 'POST',
		url: $url,
		data: $data,
		cache: false,
		success: (data) => {
			$obj = JSON.parse(data);
			//console.log($obj);
			$loadBasket($obj.cart);
			$disableQtyTyping();
			$bindEventToQtyInput();
			$bindEventToRemoveButton();
			$incrementQuantity($obj.qty);
			$('#gtotal').html($obj.total);
			if ($CART.qty == 0) {
				$slideUpBasket();
			}
			$CART = $obj;
		},
		error: (err) => {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}
$slideDownBasket = () => {
	$('#bcon').css('bottom', '-80px');
	setTimeout(() => {
		$('#bcon').hide();
	}, 500);
}
$slideUpBasket = () => {
	$('#basket_no').show();
	$('#qno').show();
    $('.cartno').show();
	$('#bcon').css('bottom', '-80px');
	$('#bcon').show();
	$('#bcon').animate({
		bottom: '0px'
	}, 200);
}
$loadBasket = (items) => {
	$bbody = '';
	$.each(items, (id, item) => {
		$bbody += '<div id="' + item.rowid + '" class="row mb-2 mt-2"><div class="col-3"><img src="' + $BASE + item.fpath + '" class="img-fluid" /></div><div class="col-8 p-0"><p class="bpname">' + item.pname + '</p><div class="row mt-1" style="font-size:13px;"><div class="col-6"><p>&#8358; <span>' + item.fsub + '</span></p></div><div class="col-6"><input type="number" class="float-right ml-1 mr-2 txt-dark p-0 qty" rid="' + item.rowid + '" value="' + item.qty + '" min="1" max="500" style="width:50px"/><p class="float-right">Qty</p></div></div></div><div class="col-1 p-2" style="border-left:1px solid #ccc;"><p class="text-center text-dark" style="font-size:20px;"><i class="fa fa-times bclose iremove" rid="' + item.rowid + '"></i></p></div></div>';
	});
	$('.bbody').html($bbody);
};
$incrementQuantity = (qty) => {
	$('#qno').animate({
		'margin-top': '-20px'
	}, 70, () => {
		$('#qno').css('margin-top', '20px');
        $('#qno').html(qty);
        $('.cartno').html(qty);
		$('#qno').animate({
			'margin-top': '0px'
		}, 70);
	});
};
$decrementQuantity = (qty) => {
	$('#qno').animate({
		'margin-top': '20px'
	}, 70, () => {
		$('#qno').css('margin-top', '-20px');
        $('#qno').html(qty);
        $('.cartno').html(qty);
		$('#qno').animate({
			'margin-top': '0px'
		}, 70);
	});
};

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
                    $('#qno').html($obj.qty);
                    $('.cartno').html($obj.qty);
					$CART = $obj;
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
	$('.iremove').click((e) => {
		$elem = e.currentTarget;
		$rid = $($elem).attr('rid');
		$('#ryesbtn').attr('rid', $rid);
		$('#cModal').modal('show');
	});
};

//animate remove
$animateRemove = (id) => {
	$(id).animate({
		'margin-left': '300px',
		opacity: '0'
	}, 500, () => {
		$(id).hide();
		$($id).remove(); // remove target from the DOM
	});
};
//initialize basket
$initBasket = () => {
	if ($CART.qty != 0) {
		//$obj=JSON.parse($CART);
		$oj = $CART;
		$loadBasket($oj.cart);
		$disableQtyTyping();
		$bindEventToQtyInput();
		$bindEventToRemoveButton();
        $('#qno').html($oj.qty);
        $('.cartno').html($oj.qty);
		$('#gtotal').html($oj.total);
		$slideUpBasket();
	} else {
		$('#bcon').hide();
		$('#bcon').css('bottom', '-80px');
	}
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
