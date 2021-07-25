$(document).ready(function () {
    setPageLinkClickEvent();
    //on dropdown change
    $('#cat').change(function () {
        $cid = $(this).val();

        $url = $BASE + 'admin/api_get_cproducts';
        $data = {
            cid: $cid
        };

        $('#loader1').show();
        $('#stxt').val('');
        $('#shd').val('');
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
    });

    //on search btn click
    $('#sbtn').click(function (e) {
        e.preventDefault();
        $cid = $('#cat').val();
        $stxt = $.trim($('#stxt').val());

        if ($stxt != '') {
            $('#err').hide();
            $('#shd').val($stxt);
            $url = $BASE + 'admin/api_get_csproducts';
            $data = {
                cid: $cid,
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


// function refreshTable() {
// 	$url = $BASE + 'merchants/api_get_products';
// 	$.ajax({
// 		type: 'GET',
// 		url: $url,
// 		success: function (data) {
//             $obj = JSON.parse(data);
//             console.log($obj);
// 			loadData($obj);
// 		},
// 		error: function (err) {
// 			alert('Poor/No network connection. Check your network settings and try again!');
// 			console.log(err.responseText);
// 		}
// 	});
// }

function loadData(data) {
    //console.log(Object.keys(data).length > 0)
    $tabdiv = '';
    if(Object.keys(data).length > 0){
        if (data.products.length > 0) {
            $tabdiv += '<div class="table-responsive mt-2"><table class="table border mtable table-striped text-center"><thead class="bg-morange text-white"><tr style="font-size:14px;"><th class="py-2 pt-3 font-weight-normal">#</th><th class="py-2 pt-3 font-weight-normal">Product&nbsp;Name</th><th class="py-2 pt-3 font-weight-normal">Category</th><th class="py-2 pt-3 font-weight-normal">Price&nbsp;(&#8358;)</th><th class="py-2 pt-3 font-weight-normal">Sale&nbsp;Price&nbsp;(&#8358;)</th><th class="py-2 pt-3 font-weight-normal">Add&nbsp;Date</th><th class="py-2 pt-3 font-weight-normal">View</th><th class="py-2 pt-3 font-weight-normal">Status</th></tr></thead><tbody id="tbody" class="lato txt-dark">';
            $products = data.products;
            $count = parseInt(data.count);
            $products.forEach($p => {
                $tabdiv += '<tr class="font-weight-bold"><td>' + $count + '</td><td>' + $p.pname + '</td><td>' + $p.cat + '</td>  <td>' + $p.price + '</td><td>' + $p.sprice + '</td><td>' + $p.date + '</td><td><button type="button" pid="' + $p.id + '" class="btn btn-primary btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="view(this);"><i class="fa fa-eye"></i>&nbsp;&nbsp; View</button></td><td>' + ($p.status == 0 ? '<button type="button" pid="' + $p.id + '" class="btn btn-danger btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="flag(this);"><i class="fa fa-flag"></i>&nbsp;&nbsp; Flag</button>' : '<button type="button" pid="' + $p.id + '" class="btn btn-outline-success btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="unflag(this);"><i class="fa fa-flag-checkered"></i>&nbsp; Unflag</button>') + '</td></tr>';
                $count++;
            });
            $tabdiv += '</tbody></table></div><div class="row mt-4">   <div class="col-12"><div id="pagediv">' + data.links + '</div></div></div>';
        } else {
            $tabdiv += '<div class="myinfo p-3"><p class="text-center txt-sec">No products found!</p></div>';
        }
    }else{
        $tabdiv += '<div class="myinfo p-3"><p class="text-center txt-sec">No products found!</p></div>';
    }
    $('#tabdiv').fadeOut(500, () => {
        $('#tabdiv').html($tabdiv);
        setPageLinkClickEvent();
        $('#tabdiv').fadeIn(500);
    });
}

//edit
function view(btn) {
    $pid = $(btn).attr('pid');
    //$('#eModal').modal('show');
    //fetch detail with id
    $url = $BASE + 'admin/api_get_product';
    $data = {
        pid: $pid
    };
    $.ajax({
        type: 'GET',
        url: $url,
        data: $data,
        success: function (data) {
            $obj = JSON.parse(data);
            $('#dcat').html($obj.cat);
            $('#pname').html($obj.pname);
            $('#price').html($obj.fprice);
            $('#descrip').val(decodeURI($obj.descrip));
            $('#avail').html($obj.avail == 1 ? 'Yes' : 'No');
            $('#date').html($obj.date);
            $('#status').html($obj.status == 1 ? 'Flagged' : 'Not Flagged');
            $('#mname').html($obj.merchant.mname);
            $('#adres').html($obj.merchant.adres1);
            $('#email').html($obj.merchant.email);
            $('#phno').html($obj.merchant.phno1);
            $('#eModal').modal('show');
        },
        error: function (err) {
            alert('Poor/No network connection. Check your network settings and try again!');
            console.log(err.responseText);
        }
    });
}


//flag
function flag(btn) {
    $pid = $(btn).attr('pid');

    //fetch detail with id
    $url = $BASE + 'admin/api_flag_product';
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
                $(btn).html('<i class="fa fa-flag-checkered"></i>&nbsp; Unflag');
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
function unflag(btn) {
    $pid = $(btn).attr('pid');

    //fetch detail with id
    $url = $BASE + 'admin/api_unflag_product';
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
                $(btn).html('<i class="fa fa-flag"></i>&nbsp;&nbsp; Flag');
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

function setPageLinkClickEvent() {
    $('.jclick').click(function (e) {
        $cid = $('#cat').val();
        $stxt = $('#shd').val();
        e.preventDefault();
        purl = $(this).attr('href');

        $arr = purl.split('/');
        $n = $arr[$arr.length - 1];
        $page = $.isNumeric($n) ? $n : 0;

        //$url = $BASE + 'merchants/api_get_page/' + $page;
        $url = purl;
        //alert($url);
        $data = { cid: $cid, stxt: $stxt };
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