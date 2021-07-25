
$(document).ready(function(){
    //editbtn click
    $('#editbtn').click(function(){
        $(this).prop('disabled', true);
        $('#updatebtn').prop('disabled', false);
        $('#eform').prop('disabled', false);
    });

    //update btn click
    $('#updatebtn').click(function(e){
        e.preventDefault();
        $fname = $.trim($('#fname').val());
        $lname = $.trim($('#lname').val());
        $gender = $.trim($('#gender').val());
        $adres = $.trim($('#adres').val());
        $phno = $.trim($('#phno').val());
        $email = $.trim($('#email').val());

        if($fname==''||$lname==''||$gender==''||$adres=='' || $phno=='' || $email==''){
            $('#errsp').html('All fields are required');
            $('#err').show();
        }else{
            $('#errsp').html('');
            $('#err').hide();
            $('#updatebtn').prop('disabled', true);
            $('#updatebtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Updating...');

            $url = $BASE + 'api_update_profile';
            $data={fname:$fname, lname:$lname, gender:$gender, adres:$adres, phno:$phno, email:$email};
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
    $('#fname').val('');
    $('#lname').val('');
    $('#gender').val('');
    $('#adres').val('');
    $('#phno').val('');
    $('#email').val('');
}