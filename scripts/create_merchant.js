$(document).ready(function(){
    
    //submit btn click
    $('#sbtn').click(function(e){
        e.preventDefault();
        $mname = $.trim($('#mname').val());
        $adres1 = $.trim($('#adres1').val());
        $adres2 = $.trim($('#adres2').val());
        $phno1 = $.trim($('#phno1').val());
        $phno2 = $.trim($('#phno2').val());
        $email = $.trim($('#email').val());
        $pswd = $('#pswd').val();
        $cpswd = $('#cpswd').val();

        if($mname==''||$adres1==''||$phno1==''||$email==''||$pswd==''||$cpswd==''){
            $('#errsp').html('All relevant fields are required');
            $('#err').show();
        }else if($pswd.length < 8){
            $('#errsp').html('Password must be up to eight(8) characters in length');
            $('#err').show();
            $('#pswd').val('');
            $('#cpswd').val('');
        }else if($pswd != $cpswd){
            $('#errsp').html('Passwords do not match');
            $('#err').show();
            $('#pswd').val('');
            $('#cpswd').val('');
        }else{
            $('#errsp').html('');
            $('#err').hide();
            $('#sbtn').prop('disabled', true);
            $('#sbtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Submitting...');

            $url = $BASE + 'admin/api_create_merchant';
            $data={mname:$mname, adres1:$adres1, adres2:$adres2, phno1:$phno1, phno2:$phno2, email:$email, pswd:$pswd, cpswd:$cpswd};
            $.ajax({
                type:'POST',
                url:$url,
                data:$data,
                success:function(data){
                    $obj = JSON.parse(data);
                    if($obj.res=='false'){
                        $('#errsp').html('Error: '+$obj.err);
                        $('#err').show();
                        $('#sbtn').prop('disabled', false);
                        $('#sbtn').html('Submit');
                    }else{
                        $('#sbtn').html('<i class="fa fa-check-circle"></i> Submitted successfully');
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

//clear fields
function clearFields(){
    $('#mname').val('');
    $('#adres1').val('');
    $('#adres2').val('');
    $('#phno1').val('');
    $('#phno2').val('');
    $('#email').val('');
    $('#pswd').val('');
    $('#cpswd').val('');
}