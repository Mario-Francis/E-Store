$(document).ready(function(){
    //editbtn click
    $('#editbtn').click(function(){
        $(this).prop('disabled', true);
        $('#updatebtn').prop('disabled', false);
        $('#eform').prop('disabled', false);
    });

    //update btn click
    $('#updatebtn').click(function(){
        $mname = $.trim($('#mname').val());
        $adres1 = $.trim($('#adres1').val());
        $adres2 = $.trim($('#adres2').val());
        $phno1 = $.trim($('#phno1').val());
        $phno2 = $.trim($('#phno2').val());
        $email = $.trim($('#email').val());
        $bank = $.trim($('#bank').val());
        $acc_type = $.trim($('#acctype').val());
        $acc_name = $.trim($('#accname').val());
        $acc_no = $.trim($('#accno').val());

        if($mname==''||$adres1==''||$phno1==''||$email=='' || $bank=='' || $acc_type==''||$acc_name==''||$acc_no==''){
            $('#errsp').html('All relevant fields are required');
            $('#err').show();
        }else{
            $('#errsp').html('');
            $('#err').hide();
            $('#updatebtn').prop('disabled', true);
            $('#updatebtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Updating...');

            $url = $BASE + 'merchants/api_update_profile';
            $data={mname:$mname, adres1:$adres1, adres2:$adres2, phno1:$phno1, phno2:$phno2, email:$email, bank:$bank, acc_type:$acc_type, acc_name:$acc_name, acc_no:$acc_no};
            $.ajax({
                type:'POST',
                url:$url,
                data:$data,
                success:function(data){
                    $obj = JSON.parse(data);
                    if($obj.res=='false'){
                        $('#errsp').html('Error: '+$obj.err);
                        $('#err').show();
                        $('#updatebtn').prop('disabled', false);
                        $('#updatebtn').html('Update');
                    }else{
                        $('#updatebtn').html('<i class="fa fa-check-circle"></i> Updated successfully');
                        setTimeout(function(){
                            //clearFields();
                            $('#updatebtn').prop('disabled', true);
                            $('#editbtn').prop('disabled', false);
                            $('#eform').prop('disabled', true);
                            $('#updatebtn').html('Update');
                        }, 5000);
                    }
                },
                error:function(err){
                    alert('Poor/No network connection. Check your network settings and try again!');
                    console.log(err.responseText);
                    $('#updatebtn').prop('disabled', false);
                    $('#updatebtn').html('Update');
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
}