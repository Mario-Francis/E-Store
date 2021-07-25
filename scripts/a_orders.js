$(document).ready(() => {
    setPageLinkClickEvent();
    //on search btn click
    $('#sbtn').click(function (e) {
        e.preventDefault();
        $stxt = $.trim($('#stxt').val());

        if ($stxt != '') {
            $('#err').hide();
            $('#shd').val($stxt);
            $url = $BASE + 'admin/api_get_orders';
            $data = {
                stxt:$stxt
            };
            $('#loader1').show();

            $.ajax({
                type: 'GET',
                url: $url,
                data: $data,
                success: function (data) {
                    //console.log(data);
                    $obj = JSON.parse(data);
                    //console.log($obj);
                    loadData($obj);
                    $('#loader1').hide();
                },
                error: function (err) {
                    alert('Poor/No network connection. Check your network settings and try again!');
                    console.log(err.responseText);
                    $('#loader1').hide();
                }
            });
        } else {
            $('#errsp').html('Enter search text');
            $('#err').show();
        }

    });
});

function loadData(data) {
    //console.log(Object.keys(data).length > 0)
    $tabdiv = '';
    if(Object.keys(data).length > 0){
        if (data.orders.length > 0) {
            $tabdiv += '<div class="table-responsive txt-dark mt-2">    <table class="table border mtable table-striped text-center"><thead class="bg-morange text-white roboto">    <tr><th class="py-2 font-weight-normal">#</th>               <th class="py-2 font-weight-normal">#ID</th><th class="py-2 font-weight-normal">Customer</th><th class="py-2 font-weight-normal">Items</th><th class="py-2 font-weight-normal">Total(&#8358;)</th><th class="py-2 font-weight-normal">&nbsp;&nbsp;Date&nbsp;&nbsp;</th>        <th class="py-2 font-weight-normal">Paid?</th><th class="py-2 font-weight-normal">Del.&nbsp;Status</th><th class="py-2 font-weight-normal">Cancel</th><th class="py-2 font-weight-normal">More</th></tr></thead><tbody class="lato">';
            $orders = data.orders;
            $count = parseInt(data.count);
            $orders.forEach($o => {
                $tabdiv += '<tr class="'+($o.status==1?'cancelled':'') +'"><td>'+$count+'</td><td>'+$o.tid+'</td><td>'+$o.cname+'</td><td class="p-0"><table class="table table-sm m-0"><tr><th class="f12">#</th><th class="f12">Product&nbsp;Name</th><th class="f12">Qty</th><th class="f12">Del.&nbsp;Fee</th><th class="f12">Sub.&nbsp;Total(&#8358;)</th></tr>';
                $cart = $o.cart.cart;
                $cart.forEach($p=>{
                    $tabdiv+='<tr><td class="f13">'+($cart.indexOf($p) + 1)+'</td><td class="f13">'+$p.pname+'</td><td class="f13">'+$p.qty+'</td><td class="f13">'+$p.fdfee+'</td><td class="f13">'+$p.fsub+'</td></tr>';
                });
                $tabdiv+='</table></td><td>'+$o.total+'</td><td>'+$o.fdate+'</td> <td class="'+($o.status==1?'disabled':'')+'">'+($o.pstatus==0?'<a href="javascript:void(0);" oid="'+$o.id+'" class="btn btn-info btn-sm f12 rounded-0 px-2 pady-2 m-0 text-capitalize '+($o.method==0?'disabled':'')+'" style="min-width:60px;box-shadow:none !important;" onclick="pay(this);">No &nbsp;<i class="fa fa-exclamation-circle"></i></a>':'<a href="javascript:void(0);" oid="'+$o.id+'" class="btn btn-success btn-sm f12 rounded-0 px-2 pady-2 m-0 text-capitalize '+($o.method==0?'disabled':'')+'" style="min-width:60px;box-shadow:none !important;" onclick="unpay(this);">Yes &nbsp;<i class="fa fa-check-circle"></i></a>')+'</td><td class="'+($o.status==1?'disabled':'')+'"><div class="btn-group btn-group-sm"><button type="button" class="btn '+($o.dstatus==0?'btn-sec':($o.dstatus==1?'btn-primary':'btn-success'))+' rounded-0 text-capitalize pady-2 f12">'+($o.dstatus==0?'Pending':($o.dstatus==1?'Transit':'Delivered'))+'</button> <button type="button" class="btn '+($o.dstatus==0?'btn-sec':($o.dstatus==1?'btn-primary':'btn-success'))+' dropdown-toggle dropdown-toggle-split rounded-0 pady-2" data-toggle="dropdown"><span class="caret"></span>         </button><div class="dropdown-menu rounded-0"><a class="dropdown-item small" href="javascript:void(0);" onclick="$dstatus(this, 0);" oid="'+$o.id+'">Pending</a> <a class="dropdown-item small" href="javascript:void(0);" onclick="$dstatus(this, 1);" oid="'+$o.id+'">Transit</a> <a class="dropdown-item small" href="javascript:void(0);" onclick="$dstatus(this, 2);" oid="'+$o.id+'">Delivered</a> </div> </div> </td><td>'+($o.status==0?'<a href="javascript:void(0);" oid="'+$o.id+'" class="btn btn-danger btn-sm rounded-0 px-2 py-1 m-0 text-capitalize '+($o.dstatus==2?'disabled':'')+'" style="font-size:11px;min-width:82px;box-shadow:none !important;" onclick="cancel(this, 1);">Cancel &nbsp;<i class="fa fa-times f13"></i></a>':'<a href="javascript:void(0);" oid="'+$o.id+'" class="btn btn-danger btn-lg rounded-0 px-2 py-1 m-0 text-capitalize '+($o.dstatus==2?'disabled':'')+'" style="font-size:11px;min-width:82px;box-shadow:none !important;" onclick="cancel(this, 0);">Cancelled &nbsp;<i class="fa fa-exclamation-circle f13"></i></a>')+' </td><td><a href="javascript:vod(0);" oid="'+$o.id+'" class="btn text-info btn-lg rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;box-shadow:none !important;" onclick="view(this);"><i class="fa fa-ellipsis-h"></i></a></td> </tr>';
                $count++;
            });
            $tabdiv += '</tbody></table></div><div class="row mt-4">   <div class="col-12"><div id="pagediv">' + data.links + '</div></div></div>';
        } else {
            $tabdiv += '<div class="myinfo p-3 txt-sec text-center">     <p><i class="fa fa-info-circle"></i> No records found</p></div>';
        }
    }else{
        $tabdiv += '<div class="myinfo p-3 txt-sec text-center">     <p><i class="fa fa-info-circle"></i> No records found</p></div>';
    }
    $('#tabdiv').fadeOut(500, () => {
        $('#tabdiv').html($tabdiv);
        setPageLinkClickEvent();
        $('#tabdiv').fadeIn(500);
    });
}

function setPageLinkClickEvent() {
    $('.jclick').click(function (e) {
        //$cid = $('#cat').val();
        $stxt = $('#shd').val();
        e.preventDefault();
        purl = $(this).attr('href');

        $arr = purl.split('/');
        $n = $arr[$arr.length - 1];
        $page = $.isNumeric($n) ? $n : 0;

        //$url = $BASE + 'merchants/api_get_page/' + $page;
        $url = purl;
        //alert($url);
        $data = { stxt: $stxt };
        $('#loader2').show();
        $.ajax({
            type: 'GET',
            url: $url,
            data: $data,
            success: function (data) {
                //console.log(data);
                $obj = JSON.parse(data);
                //console.log($obj);
                loadData($obj);
                $('#loader2').hide();
            },
            error: function (err) {
                alert('Poor/No network connection. Check your network settings and try again!');
                console.log(err.responseText);
                $('#loader2').hide();
            }
        });
    });
}

var pay = (btn) => {
    $oid = $(btn).attr('oid');

    $url = $BASE + 'admin/api_update_pstatus';
    $data = {
        oid: $oid,
        status: 1
    };
    $.ajax({
        type: 'POST',
        url: $url,
        data: $data,
        success: function (data) {
            $obj = JSON.parse(data);

            if ($obj.res == 'false') {
                alert('Oops! Encountered a problem updating status to "Paid".');
            } else {
                $(btn).html('Yes &nbsp;<i class="fa fa-check-circle"></i>');
                $(btn).removeClass('btn-info');
                $(btn).addClass('btn-success');
                $(btn).attr('onclick', 'unpay(this);');
            }
        },
        error: function (err) {
            alert('Poor/No network connection. Check your network settings and try again!');
            console.log(err.responseText);
        }
    });
}
var unpay = (btn) => {
    $oid = $(btn).attr('oid');

    $url = $BASE + 'admin/api_update_pstatus';
    $data = {
        oid: $oid,
        status: 0
    };
    $.ajax({
        type: 'POST',
        url: $url,
        data: $data,
        success: function (data) {
            $obj = JSON.parse(data);

            if ($obj.res == 'false') {
                alert('Oops! Encountered a problem updating status to "Not Paid".');
            } else {
                $(btn).html('No &nbsp;<i class="fa fa-exclamation-circle"></i>');
                $(btn).removeClass('btn-success');
                $(btn).addClass('btn-info');
                $(btn).attr('onclick', 'pay(this);');
            }
        },
        error: function (err) {
            alert('Poor/No network connection. Check your network settings and try again!');
            console.log(err.responseText);
        }
    });
}
$remove_classes = ($e) => {
    $e.removeClass('btn-sec');
    $e.removeClass('btn-primary');
    $e.removeClass('btn-success');
}
$change_cancel_state=($e, $state)=>{
    $td = $e.next();
    //console.log($e);
    $btn = $td.children().eq(0);
    if($state==0){
        $btn.removeClass('disabled');
    }else{
        $btn.addClass('disabled');
    }
}
$update_dd = (btn, status) => {
    $p = $(btn).parent();
    $prevs = $p.prevAll();
    $remove_classes($prevs);
    $prevs.eq(1).html($(btn).html());
    $d = $p.parent();
    if (status == 0) {
        $prevs.addClass('btn-sec');
        $change_cancel_state($d.parent(), 0);
    } else if (status == 1) {
        $prevs.addClass('btn-primary');
        $change_cancel_state($d.parent(), 0);
    } else if (status == 2) {
        $prevs.addClass('btn-success');
        $change_cancel_state($d.parent(), 1);
    }
}
$dstatus = (btn, status) => {
    $oid = $(btn).attr('oid');

    $url = $BASE + 'admin/api_update_dstatus';
    $data = {
        oid: $oid,
        status: status
    };
    $.ajax({
        type: 'POST',
        url: $url,
        data: $data,
        success: function (data) {
            $obj = JSON.parse(data);

            if ($obj.res == 'false') {
                alert('Oops! Encountered a problem updating delivery status.');
            } else {
                $update_dd(btn, status);
            }
        },
        error: function (err) {
            alert('Poor/No network connection. Check your network settings and try again!');
            console.log(err.responseText);
        }
    });
}
var cancel = (btn, status) => {
    $oid = $(btn).attr('oid');

    $url = $BASE + 'admin/api_update_status';
    $data = {
        oid: $oid,
        status: status
    };
    $.ajax({
        type: 'POST',
        url: $url,
        data: $data,
        success: function (data) {
            $obj = JSON.parse(data);

            if ($obj.res == 'false') {
                alert('Oops! Encountered a problem updating order status.');
            } else {
                $p = $(btn).parent();
                $p = $p.parent();
                $td = $(btn).parent();
                $prevs = $td.prevAll();
                if(status==0){
                    $(btn).html('Cancel &nbsp;<i class="fa fa-times f13"></i>');
                    $(btn).attr('onclick', 'cancel(this, 1);');
                    $p.removeClass('cancelled');
                    $prevs.removeClass('disabled');
                }else{
                    $(btn).html('Cancelled &nbsp;<i class="fa fa-exclamation-circle f13"></i>');
                    $(btn).attr('onclick', 'cancel(this, 0);');
                    $p.addClass('cancelled');
                    $prevs.eq(0).addClass('disabled');
                    $prevs.eq(1).addClass('disabled');
                }
            }
        },
        error: function (err) {
            alert('Poor/No network connection. Check your network settings and try again!');
            console.log(err.responseText);
        }
    });
}
function view(btn) {
    $oid = $(btn).attr('oid');
    //$('#vModal').modal('show');
	//fetch order detail with id
	$url = $BASE + 'admin/api_get_order';
	$data = {
		oid: $oid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: function (data) {
            //console.log(data);
			$obj = JSON.parse(data);
            
            if($obj.discount==0){
                $('#d').hide();
            }else{
                $('#discount').html($obj.fdiscount);
                $('#d').show();
            }

            if($obj.vat==0){
                $('#v').hide();
            }else{
                $('#vat').html($obj.fvat);
                $('#v').show();
            }
			$('#adres').html($obj.adres);
			$('#method').html($obj.method==0?'Paystack':($obj.method==1?'Online Transfer':'Pay on Delivery'));
            $('#pstatus').html($obj.pstatus==0?'Not Paid':'Paid');
            $('#dstatus').html($obj.dstatus==0?'Pending':($obj.dstatus==1?'Transit':'Delivered'));
            $('#status').html($obj.status == 0 ? 'Active' : 'Cancelled');
            $c = $obj.customer;
            $('#cname').html($c.fname+' '+$c.lname);
            $('#cemail').html($c.email);
            $('#cphno').html($c.phno);
            
            $ms = $obj.merchants;
            $msdiv = '';
            $ms.forEach(m => {
                $msdiv+='<div class="col-1 px-0 py-2"><p class="text-right">'+($ms.indexOf(m)+1)+'.</p></div><div class="col-11 px-0"><div class="p-1"><p class="txt-dark mt-1"><b class="font-weight-bold">Name:</b> '+m.mname+'</p><p class="txt-dark mt-1"><b class="font-weight-bold">Email:</b> '+m.email+'</p><p class="txt-dark mt-1"><b class="font-weight-bold">Phone Number:</b> '+m.phno1+'</p><p class="txt-dark mt-1"><b class="font-weight-bold">Products:</b> ';
                $prods='';
                $pnames=m.pnames;
                $pnames.forEach(p=>{
                    $prods+=p+', ';
                });
                $prods = $prods.substring(0, ($prods.length)-2);
                $msdiv+=$prods+'</p></div></div>';
            });
            $('#mdiv').html($msdiv);
			$('#vModal').modal('show');
		},
		error: function (err) {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}