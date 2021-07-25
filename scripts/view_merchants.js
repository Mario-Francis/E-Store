$(document).ready(function () {

});

function view(btn) {
	$mid = $(btn).attr('mid');

	//fetch detail with id
	$url = $BASE + 'admin/api_get_merchant';
	$data = {
		mid: $mid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: function (data) {
			$obj = JSON.parse(data);
			if ($obj.merch.adres2 == null) {
				$('#adres2p').hide();
			}
			if ($obj.merch.phno2 == null) {
				$('#phno2p').hide();
			}
			$('#mname').html($obj.merch.mname);
			$('#adres1').html($obj.merch.adres1);
			$('#adres2').html($obj.merch.adres2);
			$('#phno1').html($obj.merch.phno1);
			$('#phno2').html($obj.merch.phno2);
			$('#email').html($obj.merch.email);
			$('#status').html($obj.merch.status == 0 ? 'Unflagged' : 'Flagged');
			$('#vModal').modal('show');
		},
		error: function (err) {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}

function flag(btn) {
	$mid = $(btn).attr('mid');

	//fetch detail with id
	$url = $BASE + 'admin/api_flag_merchant';
	$data = {
		mid: $mid
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
	$mid = $(btn).attr('mid');

	//fetch detail with id
	$url = $BASE + 'admin/api_unflag_merchant';
	$data = {
		mid: $mid
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
