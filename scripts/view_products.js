$(document).ready(function(){

	//price input change
    $('#cprice').keyup(()=>{
        $cprice=parseFloat(($('#cprice').val())==''?0:$('#cprice').val());
        $rate = parseFloat($('#rate').val());
        $sprice = $cprice+(($rate/100)*$cprice);
        $('#sprice').html($sprice);
    });
    $('#cprice').change(()=>{
        $cprice=parseFloat($('#cprice').val());
        $rate = parseFloat($('#rate').val());
        $sprice = $cprice+(($rate/100)*$cprice);
        $('#sprice').html($sprice);
	});
	
    //update product
	$('#updatebtn').click(function () {
        $cat = $('#cat').val();
        $pname = $.trim($('#pname').val());
        $pprice = $.trim($('#pprice').val());
        $cprice = $.trim($('#cprice').val());
        $descrip = $.trim($('#descrip').val());
        $pid = $('#updatebtn').attr('pid');

        if($cat==''||$pname==''||$cprice==''||$descrip==''){
            $('#errsp').html('All fields are required');
			$('#err').show();
			//console.log($cat+', '+$pname+', '+$cprice+', '+$descrip);
        }else {
			$('#errsp').html('');
			$('#err').hide();
			$('#cancelbtn').prop('disabled', true);
			$('#updatebtn').prop('disabled', true);
			$('#updatebtn').html('<i class="fa fa-circle-o-notch fa-spin" style="color:#ee6123 !important;"></i> Updating...');

			$url = $BASE + 'merchants/api_update_product';
			$data = {
				pid: $pid,
                cat: $cat,
                pname:$pname,
                pprice:$pprice,
                cprice:$cprice,
                descrip:encodeURI($descrip)
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
						$('#updatebtn').html('<i class="fa fa-check-circle" style="color:#ee6123 !important;"></i> Updated successfully');
						setTimeout(function () {
							$('#cat').val('');
							$('#cancelbtn').prop('disabled', false);
							$('#updatebtn').prop('disabled', false);
							$('#updatebtn').html('Update');

							//load table
							refreshTable();
                            clearFields();
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

function clearFields(){
    $('#cat').val('');
    $('#pname').val('');
    $('#pprice').val('');
    $('#cprice').val('');
    $('#descrip').val('');
}

function refreshTable() {
	$page_url=window.location.href;
	$page=$page_url.substring($page_url.length-1, $page_url.length);
	$page=  $.isNumeric($page)?$page:'1';
	//console.log($page);
	$url = $BASE + 'merchants/api_get_products';
	$.ajax({
		type: 'GET',
		url: $url,
		data:{page:$page},
		success: function (data) {
            $obj = JSON.parse(data);
			loadData($obj);
		},
		error: function (err) {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}

function loadData(pdata) {
	var data = pdata.products;
	var count=parseInt(pdata.count);
	$tbody = '';
	for ($x in data) {
        $tbody += '<tr><td>' + count + '.</td><td>' + data[$x].pname + '</td><td>' + data[$x].cat + '</td><td>' + data[$x].price + '</td><td>' + data[$x].date + '</td><td><button type="button" pid="' + data[$x].id + '" class="btn btn-outline-info btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="edit(this);"><i class="fa fa-edit"></i>&nbsp;Edit</button></td>';
        if (data[$x].avail == 1) {
			$tbody += '<td><button type="button" pid="' + data[$x].id + '" class="btn btn-success btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="unavail(this);"><i class="fa fa-check-circle"></i> &nbsp;Yes</button></td>';
		} else {
			$tbody += '<td><button type="button" pid="' + data[$x].id + '" class="btn btn-info btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="avail(this);"><i class="fa fa-info-circle"></i> &nbsp;No</button></td>';
        }
        if (data[$x].status == 0) {
			$tbody += '<td><button type="button" pid="' + data[$x].id + '" class="btn btn-danger btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="flag(this);"><i class="fa fa-flag"></i> Flag</button></td>';
		} else {
			$tbody += '<td><button type="button" pid="' + data[$x].id + '" class="btn btn-outline-success btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="unflag(this);"><i class="fa fa-flag"></i> Unflag</button></td>';
		}
		if (data[$x].special == 0) {
			$tbody += '<td><button type="button" pid="' + data[$x].id + '" class="btn btn-primary btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:86px;" onclick="mark(this);"><i class="fa fa-check"></i> Mark</button></td>';
		} else {
			$tbody += '<td><button type="button" pid="' + data[$x].id + '" class="btn btn-outline-primary btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:86px;" onclick="unmark(this);"><i class="fa fa-times"></i> Unmark</button></td>';
		}
		$tbody += '</tr>';
		count++;
	}
    $('#tbody').html($tbody);
}

//edit
function edit(btn){
    $pid = $(btn).attr('pid');

	$('#updatebtn').attr('pid', $pid);
	//fetch detail with id
	$url = $BASE + 'merchants/api_get_product';
	$data = {
		pid: $pid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: function (data) {
			$obj = JSON.parse(data);
			//console.log($obj);
            $('#cat').val($obj.cat_id);
            $('#pname').val($obj.pname);
            $('#pprice').val($obj.pprice);
            $('#cprice').val($obj.cprice);
			$('#descrip').val(decodeURI($obj.descrip));
			$('#cprice').change();
			$('#eModal').modal('show');
		},
		error: function (err) {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}

//mark available
function avail(btn){
    $pid = $(btn).attr('pid');

	//fetch detail with id
	$url = $BASE + 'merchants/api_avail_product';
	$data = {
		pid: $pid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: function (data) {
			$obj = JSON.parse(data);

			if ($obj.res == 'false') {
				alert('Oops! Encountered a problem marking the selected product "available".');
			} else {
				$(btn).html('<i class="fa fa-check-circle"></i> Yes');
				$(btn).removeClass('btn-info');
				$(btn).addClass('btn-success');
				$(btn).attr('onclick', 'unavail(this);');
			}
		},
		error: function (err) {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}

//mark unavailable
function unavail(btn){
    $pid = $(btn).attr('pid');

	//fetch detail with id
	$url = $BASE + 'merchants/api_unavail_product';
	$data = {
		pid: $pid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: function (data) {
			$obj = JSON.parse(data);

			if ($obj.res == 'false') {
				alert('Oops! Encountered a problem marking the selected product "unavailable".');
			} else {
				$(btn).html('<i class="fa fa-info-circle"></i> No');
				$(btn).removeClass('btn-success');
				$(btn).addClass('btn-info');
				$(btn).attr('onclick', 'avail(this);');
			}
		},
		error: function (err) {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}

//flag
function flag(btn){
    $pid = $(btn).attr('pid');

	//fetch detail with id
	$url = $BASE + 'merchants/api_flag_product';
	$data = {
		pid: $pid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: function (data) {
			$obj = JSON.parse(data);

			if ($obj.res == 'false') {
				alert('Oops! Encountered a problem flagging the selected product.');
			} else {
				$(btn).html('<i class="fa fa-flag-checkered"></i> Unflag');
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

//unflag
function unflag(btn){
    $pid = $(btn).attr('pid');

	//fetch detail with id
	$url = $BASE + 'merchants/api_unflag_product';
	$data = {
		pid: $pid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: function (data) {
			$obj = JSON.parse(data);

			if ($obj.res == 'false') {
				alert('Oops! Encountered a problem unflagging the selected product.');
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

//mark special
function mark(btn){
    $pid = $(btn).attr('pid');

	//fetch detail with id
	$url = $BASE + 'merchants/api_mark_special';
	$data = {
		pid: $pid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: function (data) {
			$obj = JSON.parse(data);

			if ($obj.res == 'false') {
				alert('Oops! Encountered a problem marking the selected product as special. Try again.');
			} else {
				$(btn).html('<i class="fa fa-times"></i> Unmark');
				$(btn).removeClass('btn-primary');
				$(btn).addClass('btn-outline-primary');
				$(btn).attr('onclick', 'unmark(this);');
			}
		},
		error: function (err) {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}

//unmark special
function unmark(btn){
    $pid = $(btn).attr('pid');

	//fetch detail with id
	$url = $BASE + 'merchants/api_unmark_special';
	$data = {
		pid: $pid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: function (data) {
			$obj = JSON.parse(data);

			if ($obj.res == 'false') {
				alert('Oops! Encountered a problem unmarking the selected product as special. Try again.');
			} else {
				$(btn).html('<i class="fa fa-check"></i> Mark');
				$(btn).removeClass('btn-outline-primary');
				$(btn).addClass('btn-primary');
				$(btn).attr('onclick', 'mark(this);');
			}
		},
		error: function (err) {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}