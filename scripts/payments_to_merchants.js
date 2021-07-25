$(document).ready(() => {

});

var pay = (btn, status) => {
    $oid = $(btn).attr('oid');
    $mid = $(btn).attr('mid');
    $amt = $(btn).attr('amt');

    $url = $BASE + 'admin/api_mpay';
    $data = {
        oid: $oid,
        mid: $mid,
        amt: $amt,
        status: status
    };
    $.ajax({
        type: 'POST',
        url: $url,
        data: $data,
        success: function (data) {
            $obj = JSON.parse(data);
            if ($obj.res == 'false') {
                alert('Oops! Encountered a problem updating payment status.');
            } else {
                if (status == 0) {
                    $(btn).html('No &nbsp;<i class="fa fa-exclamation-circle"></i>');
                    $(btn).removeClass('btn-success');
                    $(btn).addClass('btn-info');
                    $(btn).attr('onclick', 'pay(this, 1);');
                } else {
                    $(btn).html('Yes &nbsp;<i class="fa fa-check-circle"></i>');
                    $(btn).removeClass('btn-info');
                    $(btn).addClass('btn-success');
                    $(btn).attr('onclick', 'pay(this, 0);');
                }
            }
        },
        error: function (err) {
            alert('Poor/No network connection. Check your network settings and try again!');
            console.log(err.responseText);
        }
    });
}

var view=(btn)=> {
    $oid = $(btn).attr('oid');
    $mid = $(btn).attr('mid');

	$url = $BASE + 'admin/api_get_mpayments';
	$data = {
        oid: $oid,
        mid: $mid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: function (data) {
            console.log(data);
			$obj = JSON.parse(data);
            console.log($obj);
            
            $cart = $obj.cart;
            $cartdiv = '';
            $cart.forEach(p => {
                $cartdiv+='<div class="row"><div class="col-1 px-0 py-2"><p class="text-center">'+($cart.indexOf(p)+1)+'.</p></div><div class="col-11 px-0"><div class="p-1"><p class="txt-dark mt-1"><b class="font-weight-bold">Name:</b> '+p.pname+'</p><p class="txt-dark mt-1"><b class="font-weight-bold">Price:</b> &#8358;'+p.fmprice+'</p><p class="txt-dark mt-1"><b class="font-weight-bold">Quantity:</b> '+p.qty+'</p><p class="txt-dark mt-1"><b class="font-weight-bold">Sub. Total:</b> &#8358;'+p.fstotal+'</p></div></div></div>';
            });
            $('#cartdiv').html($cartdiv);
            $('#total').html($obj.total);
            
            $m = $obj.merchant;
            $('#mname').html($m.mname);
            $('#email').html($m.email);
            $('#phno').html($m.phno1);
            if($m.phno2==''||$m.phno==null){
                $('.phno').hide();
            }else{
                $('.phno').show();
                $('#phno2').html($m.phno2);
            }
            if($m.bank==''||$m.bank==null){
                $('.bank').hide();
            }else{
                $('.bank').show();
                $('#bank').html($m.bank);
                $('#acctype').html($m.acc_type);
                $('#accname').html($m.acc_name);
                $('#accno').html($m.acc_no);
            }
            
			$('#vModal').modal('show');
		},
		error: function (err) {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}