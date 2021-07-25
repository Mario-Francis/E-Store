$(document).ready(() => {
    setPageLinkClickEvent();
    
});

function loadData(data) {
    //console.log(Object.keys(data).length > 0)
    $tabdiv = '';
    if(Object.keys(data).length > 0){
        if (data.orders.length > 0) {
            $tabdiv += '<div class="table-responsive txt-dark mt-2">    <table class="table border mtable table-striped text-center f14"><thead class="bg-morange text-white roboto"><tr><th class="py-2 font-weight-normal">#</th><th class="py-2 font-weight-normal">#Transaction&nbsp;ID</th><th class="py-2 font-weight-normal">Items</th><th class="py-2 font-weight-normal">Total(&#8358;)</th><th class="py-2 font-weight-normal">&nbsp;&nbsp;Date&nbsp;&nbsp;</th>        <th class="py-2 font-weight-normal">Paid?</th><th class="py-2 font-weight-normal">Status</th><th class="py-2 font-weight-normal">Cancel</th><th class="py-2 font-weight-normal">More</th></tr></thead><tbody class="lato">';
            $orders = data.orders;
            $count = parseInt(data.count);
            $orders.forEach($o => {
                $tabdiv += '<tr><td>'+$count+'</td><td>'+$o.tid+'</td><td class="p-0"><table class="table table-sm m-0"><tr><th class="f12">#</th><th class="f12">Product&nbsp;Name</th><th class="f12">Qty</th><th class="f12">Del.&nbsp;Fee</th><th class="f12">Sub.&nbsp;Total(&#8358;)</th></tr>';
                $cart = $o.cart.cart;
                $cart.forEach($p=>{
                    $tabdiv+='<tr><td class="f13">'+($cart.indexOf($p) + 1)+'</td><td class="f13">'+$p.pname+'</td><td class="f13">'+$p.qty+'</td><td class="f13">'+$p.fdfee+'</td><td class="f13">'+$p.fsub+'</td></tr>';
                });
                $tabdiv+='</table></td><td>'+$o.total+'</td><td>'+$o.fdate+'</td> <td>'+($o.pstatus==0?'<span class="badge badge-sm badge-info font-weight-light rounded-0 f12 py-1 px-3">No &nbsp;<i class="fa fa-exclamation-circle"></i></span>':'<span class="badge badge-sm badge-success font-weight-light rounded-0 f12 py-1 px-3">Yes &nbsp;<i class="fa fa-check-circle"></i></span>')+'</td><td>'+($o.dstatus==0?'<span class="badge btn-sec badge-info font-weight-light rounded-0 f12 py-1 px-3">Pending</span>':($o.dstatus==1?'<span class="badge badge-sm badge-primary font-weight-light rounded-0 f12 py-1 px-3">Transit</span>':'<span class="badge badge-sm badge-success font-weight-light rounded-0 f12 py-1 px-3">Delivered</span>'))+'</td><td><a href="javascript:void(0);" oid="'+$o.id+'" class="btn btn-danger btn-sm rounded-0 px-2 py-1 m-0 text-capitalize '+($o.dstatus==2?'disabled':'')+'" style="font-size:11px;min-width:82px;box-shadow:none !important;" onclick="cancel(this, 1);">Cancel &nbsp;<i class="fa fa-times f13"></i></a> </td><td><a href="javascript:vod(0);" oid="'+$o.id+'" class="btn text-info btn-lg rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;box-shadow:none !important;" onclick="view(this);"><i class="fa fa-ellipsis-h"></i></a></td> </tr>';
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
        e.preventDefault();
        purl = $(this).attr('href');

        // $arr = purl.split('/');
        // $n = $arr[$arr.length - 1];
        // $page = $.isNumeric($n) ? $n : 0;

        //$url = $BASE + 'merchants/api_get_page/' + $page;
        $url = purl;

        $('#loader2').show();
        $.ajax({
            type: 'GET',
            url: $url,
            success: function (data) {
                console.log(data);
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


var cancel = (btn) => {
    $oid = $(btn).attr('oid');

    $url = $BASE + 'customers/api_cancel_order';
    $data = {
        oid: $oid
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
                $p.fadeOut(700);
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
	$url = $BASE + 'customers/api_get_order';
	$data = {
		oid: $oid
	};
	$.ajax({
		type: 'GET',
		url: $url,
		data: $data,
		success: function (data) {
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
			$('#vModal').modal('show');
		},
		error: function (err) {
			alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
		}
	});
}