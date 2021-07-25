$(document).ready(function () {

	//update category
	$('#updatebtn').click(function () {
		$cat = $.trim($('#cat').val());
		$dfee = $.trim($('#dfee').val());
		$dmode=$('input[name=rd]:checked').val();

		$cid = $('#updatebtn').attr('cid');
		if ($cat == '') {
			$('#errsp').html('Category name field is required');
			$('#err').show();
		} else {
			$('#errsp').html('');
			$('#err').hide();
			$('#cancelbtn').prop('disabled', true);
			$('#updatebtn').prop('disabled', true);
			$('#updatebtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Updating...');

			$url = $BASE + 'admin/api_update_category';
			$data = {
				cid: $cid,
				cat: $cat,
				dfee:$dfee,
				dmode:$dmode
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
						$('#cancelbtn').prop('disabled', false);
						$('#updatebtn').prop('disabled', false);
						$('#updatebtn').html('Update');
					} else {
						$('#updatebtn').html('<i class="fa fa-check-circle"></i> Updated successfully');
						setTimeout(function () {
							$('#cat').val('');
							$('#cancelbtn').prop('disabled', false);
							$('#updatebtn').prop('disabled', false);
							$('#updatebtn').html('Update');

							//load table
							refreshTable();

							$('#eModal').modal('hide');
						}, 4000);
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

//edit category
function edit(btn) {
	$cid = $(btn).attr('cid');

	$('#updatebtn').attr('cid', $cid);
	//fetch detail with id
	$url = $BASE + 'admin/api_get_category';
	$data = {
		cid: $cid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: function (data) {
			$obj = JSON.parse(data);
			$('#cat').val($obj.cat.cat);
			$('#dfee').val($obj.cat.dfee);
			if($obj.cat.dmode==0){
				$('#rd1').prop('checked', true);
				$('#rd2').prop('checked', false);
			}else{
				$('#rd1').prop('checked', false);
				$('#rd2').prop('checked', true);
			}
			$('#eModal').modal('show');
		},
		error: function (err) {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}

function refreshTable() {
	$url = $BASE + 'admin/api_get_categories';
	$.ajax({
		type: 'GET',
		url: $url,
		success: function (data) {
			$obj = JSON.parse(data);
			loadData($obj.cats);
		},
		error: function (err) {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}

function loadData(data) {
    console.log(data);
	$tbody = '';
	for ($x in data) {
		$tbody += '<tr><td>' + (parseInt($x) + 1) + '</td><td>' + data[$x].cat + '</td><td><button type="button" cid="' + data[$x].id + '" class="btn btn-outline-info btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="edit(this);"><i class="fa fa-edit"></i>&nbsp;Edit</button></td>';
		if (data[$x].status == 0) {
			$tbody += '<td><button type="button" cid="' + data[$x].id + '" class="btn btn-danger btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="flag(this);"><i class="fa fa-flag"></i> Flag</button></td>';
		} else {
			$tbody += '<td><button type="button" cid="' + data[$x].id + '" class="btn btn-outline-success btn-sm rounded-0 pl-3 pr-3 pt-2 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="unflag(this);"><i class="fa fa-flag"></i> Unflag</button></td>';
		}
		$tbody += '</tr>';
	}
    $('#tbody').html($tbody);
}
//flag category
function flag(btn) {
	$cid = $(btn).attr('cid');

	//fetch detail with id
	$url = $BASE + 'admin/api_flag_category';
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

//unflag category
function unflag(btn) {
    $cid = $(btn).attr('cid');

	//fetch detail with id
	$url = $BASE + 'admin/api_unflag_category';
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
