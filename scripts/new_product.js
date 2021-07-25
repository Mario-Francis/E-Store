$(document).ready(function () {
	// Initialize Material Select
    $('.mdb-select').material_select();

    //preview image
    $('#fileup').change(function(){
        prevImg(this, $('#pimg')[0]);
    });

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

    //submit btn click
    $('#sbtn').click(function(e){
        e.preventDefault();
        $cat = $('#cat').val();
        $pname = $.trim($('#pname').val());
        $pprice = $.trim($('#pprice').val());
        $cprice = $.trim($('#cprice').val());
        $descrip = $.trim($('#descrip').val());
        $file = $('#fileup')[0];

        if($cat==''||$pname==''||$cprice==''||$descrip==''){
            $('#errsp').html('All fields are required');
            $('#err').show();
        }else if($file.files.length < 1){
            $('#errsp').html('No image selected');
            $('#err').show();
        }else{
            $('#errsp').html('');
            $('#err').hide();
            $('#sbtn').prop('disabled', true);
            $('#sbtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Submitting...');

            $url = $BASE + 'merchants/api_new_product';
            var fd = new FormData();
			fd.append('cid', $cat);
            fd.append('pname', $pname);
            fd.append('pprice', $pprice);
            fd.append('cprice', $cprice);
            fd.append('descrip', encodeURI($descrip));
			fd.append('file', $file.files[0]);
            $.ajax({
                type:'POST',
                url:$url,
                data:fd,
                cache: false,
				contentType: false,
				processData: false,
                success:function(data){
                    $obj = JSON.parse(data);
                    if($obj.res=='false'){
                        $('#errsp').html('Error: '+$obj.err);
                        $('#err').show();
                        $('#sbtn').prop('disabled', false);
                        $('#sbtn').html('Submit');
                    }else{
                        $('#sbtn').html('<i class="fa fa-check-circle"></i> Product added successfully');
                        setTimeout(function(){
                            clearFields();
                            $('#sbtn').prop('disabled', false);
                            $('#sbtn').html('Submit');
                        }, 5000);
                    }
                },
                error:function(err){
                    alert('Poor/No network connection. Check your network settings and try again!');
                    console.log(err.responseText);
                    $('#sbtn').prop('disabled', false);
                    $('#sbtn').html('Submit');
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
    $('#fileup')[0].files=null;
    $('#fileup').val('');
    $('#pimg').attr('src', $BASE + 'images/default.png');
}

//preview image
function prevImg(input, img) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(img).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}