$(document).ready(function(){
    
    //submit btn click
    $('#sbtn').click(function(e){
        e.preventDefault();
        $cat = $.trim($('#cat').val());
        $dfee = $.trim($('#dfee').val());
        $dmode=$('input[name=rd]:checked').val();
        //alert($dmode);
        if($cat==''){
            $('#errsp').html('Category name field is required');
            $('#err').show();
        }else{
            $('#errsp').html('');
            $('#err').hide();
            $('#sbtn').prop('disabled', true);
            $('#sbtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Creating...');

            $url = $BASE + 'admin/api_create_category';
            $data={cat:$cat, dfee:$dfee, dmode:$dmode};
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
                        $('#sbtn').html('<i class="fa fa-check-circle"></i> Created successfully');
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
    $('#cat').val('');
    $('#dfee').val('');
}