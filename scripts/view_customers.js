$(document).ready(function () {

});

function view(btn) {

    $cid = $(btn).attr('cid');

	//fetch detail with id
	$url = $BASE + 'admin/api_get_customer';
	$data = {
		cid: $cid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: function (data) {
			$obj = JSON.parse(data);
			
			$('#cname').html($obj.customer.fname+' '+$obj.customer.lname);
			$('#gender').html($obj.customer.gender);
			$('#adres').html($obj.customer.adres);
			$('#phno').html($obj.customer.phno);
            $('#email').html($obj.customer.email);
            $('#rdate').html($obj.customer.fdate);
			$('#status').html($obj.customer.status == 0 ? 'Not flagged' : 'Flagged');
			$('#vModal').modal('show');
		},
		error: function (err) {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}

function flag(btn) {
	$cid = $(btn).attr('cid');

	//fetch detail with id
	$url = $BASE + 'admin/api_flag_customer';
	$data = {
		cid: $cid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: function (data) {
			$obj = JSON.parse(data);

			if ($obj.res == 'false') {
				alert('Oops! Encountered a problem flagging the selected merchant.');
			} else {
				$(btn).html('<i class="fa fa-flag"></i> Unflag');
				$(btn).removeClass('btn-danger');
				$(btn).addClass('btn-outline-success');
				$(btn).attr('onclick', 'unflag(this);');
			}
		},
		error: function (err) {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}

function unflag(btn) {
	$cid = $(btn).attr('cid');

	//fetch detail with id
	$url = $BASE + 'admin/api_unflag_customer';
	$data = {
		cid: $cid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: function (data) {
			$obj = JSON.parse(data);

			if ($obj.res == 'false') {
				alert('Oops! Encountered a problem unflagging the selected merchant.');
			} else {
				$(btn).html('<i class="fa fa-flag"></i> Flag');
				$(btn).removeClass('btn-outline-success');
				$(btn).addClass('btn-danger');
				$(btn).attr('onclick', 'flag(this);');
			}
		},
		error: function (err) {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}
