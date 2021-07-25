$(document).ready(()=>{

});

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