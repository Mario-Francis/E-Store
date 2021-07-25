$(document).ready(function(){

    //create account
    $('#cbtn').click(function(e){
        e.preventDefault();
        let form = $('#signupForm')[0];
        $fname = $.trim($('#fname').val());
        $lname = $.trim($('#lname').val());
        $gender = $.trim($('#gender').val());
        $adres = $.trim($('#adres').val());
        $phno = $.trim($('#phno').val());
        $email = $.trim($('#email').val());
        $pswd = $('#pswd').val();
        $cpswd = $('#cpswd').val();

        if($fname==''||$lname==''||$gender==''||$adres==''||$phno==''||$email==''||$pswd==''||$cpswd==''){
            if (form.reportValidity) 
                form.reportValidity();
            $('#err1sp').html('All fields are required');
            $('#err1').show();
        }else if($pswd.length < 8){
            $('#err1sp').html('Password must be up to eight(8) characters in length');
            $('#err1').show();
            $('#pswd').val('');
            $('#cpswd').val('');
        }else if($pswd != $cpswd){
            $('#err1sp').html('Passwords do not match');
            $('#err1').show();
            $('#pswd').val('');
            $('#cpswd').val('');
        }else{
            $('#err1sp').html('');
            $('#err1').hide();
            $('#cbtn').prop('disabled', true);
            $('#cbtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Creating account...');

            $url = $BASE + 'api_create_account';
            $data={fname:$fname, lname:$lname, gender:$gender, adres:encodeURI($adres), phno:$phno, email:$email, pswd:$pswd, cpswd:$cpswd};
            $.ajax({
                type:'POST',
                url:$url,
                data:$data,
                success:function(data){
                    $obj = JSON.parse(data);
                    if($obj.res=='false'){
                        $('#err1sp').html('Error: '+$obj.err);
                        $('#err1').show();
                        $('#cbtn').prop('disabled', false);
                        $('#cbtn').html('Submit');
                    }else{
                        $('#cbtn').html('<i class="fa fa-check-circle"></i> Account created successfully');
                        setTimeout(function(){
                            clearFields();
                            $('#cbtn').prop('disabled', false);
                            $('#cbtn').html('Submit');

                            $('#sModal').modal('hide');
                            setTimeout(function(){
                                $('#lModal').modal('show');
                            }, 1500);
                        }, 3500);
                    }
                },
                error:function(err){
                    alert('Poor/No network connection. Check your network settings and try again!');
                    console.log(err.responseText);
                    $('#cbtn').prop('disabled', false);
                    $('#cbtn').html('Submit');
                }
            });
        }
    });

    //login
    $('#lbtn').click(function(e){
        e.preventDefault();
        let form = $('#loginForm')[0];
        $email = $.trim($('#lemail').val());
        $pswd = $('#lpswd').val();
        $keep = $('#keep').prop('checked');
        if($keep){
            $kep='true';
        }else{
            $kep='false';
        }

        if($email==''||$pswd==''){
            if (form.reportValidity) 
                form.reportValidity();
            $('#err2sp').html('Email and password fields are required');
            $('#err2').show();
        }else{
            $('#err2sp').html('');
            $('#err2').hide();
            $('#lbtn').prop('disabled', true);
            $('#lbtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Logging in...');

            $url = $BASE + 'api_login';
            $data={email:$email, pswd:$pswd, keep:$kep};
            $.ajax({
                type:'POST',
                url:$url,
                data:$data,
                success:function(data){
                    //console.log(data);
                    $obj = JSON.parse(data);
                    if($obj.res=='false'){
                        $('#err2sp').html('Error: '+$obj.err);
                        $('#err2').show();
                        $('#lbtn').prop('disabled', false);
                        $('#lbtn').html('Submit');
                    }else{
                        $('#lbtn').html('<i class="fa fa-check-circle"></i> Logged in successfully');
                        setTimeout(function(){
                            $('#lemail').val('');
                            $('#lpswd').val('');

                            $('#lbtn').prop('disabled', false);
                            $('#lbtn').html('Submit');

                            //update navbar
                            $('#alogin').hide();
                            $('#asignup').hide();
                            $('#notlogin').hide();
                            $('#islogin').show();
                            $('#cdd').html($obj.c_name);
                            $('#chd').val($obj.c_id);
                            $updateRateBtn();

                            setTimeout(function(){
                                $('#lModal').modal('hide');
                                setTimeout(()=>{
                                   if($('#checkout').length){
                                       if($('#checkout').attr('send')=='yes'){
                                            $('#checkout').attr('send', 'no');
                                            window.location.assign($BASE+'checkout');
                                       }
                                   } 
                                }, 500);
                            }, 500);
                        }, 2500);
                    }
                },
                error:function(err){
                    alert('Poor/No network connection. Check your network settings and try again!');
                    console.log(err.responseText);
                    $('#lbtn').prop('disabled', false);
                    $('#lbtn').html('Submit');
                }
            });
        }
    });

    //show login modal
    $('#slog').click(()=>{
        $('#sModal').modal('hide');
        setTimeout(()=>{
            $('#lModal').modal('show');
        }, 1200);
    });

    //show signup modal
    $('#lcreate').click(()=>{
        $('#lModal').modal('hide');
        setTimeout(()=>{
            $('#sModal').modal('show');
        }, 1200);
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
    $('#pswd').val('');
    $('#cpswd').val('');
}

$updateRateBtn = ()=>{
    if($('#c3').length){
        $('.rat').removeClass('bg-mblue');
        $('.rat').addClass('bg-morange');
        $('.rat').attr('data-target', '');
        $('.rat').attr('onclick', '$rate(this);');
        $('.rat').html('Rate this product');
    }
}