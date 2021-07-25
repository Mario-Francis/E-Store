$(document).ready(()=>{
    //disable closing on focus loosed
    $('#aModal').modal({ backdrop: 'static', keyboard: false, show: false });
    $('#cModal').modal({ backdrop: 'static', keyboard: false, show: false });

    //print invoice
    $('#printbtn').click(function(){
        $mode='iframe';//popup
        $close=$mode=='popup';
        $options={mode:$mode, popClose:$close};
        $('#printdiv').printArea($options); 
    });

    $('#vbtn').click(()=>{
        // $('#cModal').modal('show');
        $malert('success', 'Transaction failed');
    });

    $('#sokbtn').click(()=>{
        window.location.replace($BASE+'customers');
    });
});

function payWithPaystack(btn){
    $oid=$(btn).attr('oid');
    $tid=$(btn).attr('tid');
    $email=$(btn).attr('email');
    $amt=parseInt($(btn).attr('amt'));
    $phno=$(btn).attr('phno');

    var handler = PaystackPop.setup({
      key: 'pk_test_df6a8eefb7a8e41643083cd2ca83f2a78c102d39',
      email: $email,
      amount: $amt,
      //ref:$tid,
      //ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      metadata: {
        order_id:$oid,
         custom_fields: [
            {
                display_name: "Mobile Number",
                variable_name: "mobile_number",
                value: $phno
            }
         ]
      },
      callback: function(response){
          //alert('success. transaction ref is ' + response.reference);
          console.log(response);
          $malert('load');
          $verifyPayment(response.reference, $oid);
      },
      onClose: function(){
          //alert('window closed');//ckick on pay now to try agian
          $('#cModal').modal('show');
      }
    });
    handler.openIframe();
  }

  $verifyPayment=($ref, $oid)=>{
      $url=$BASE+'customers/api_verify_payment';
      $data={ref:$ref, oid:$oid};
      $.ajax({
        type:'GET',
        url:$url,
        data:$data,
        success:(data)=>{
            console.log(data);
            $obj = JSON.parse(data);
            if($obj.res=='false'){
                $malert('fail', $obj.msg);
            }else{
                $malert('success');
            }
        },
        error:(err)=>{
            alert('Poor/No network connection. Check your network settings and try again!');
			console.log(err.responseText);
        }
      });
  }

  $malert=($type, $msg='')=>{
    if($type=='load'){
        $('#verifydiv').show();
        $('#faildiv').hide();
        $('#sucdiv').hide();
    }else if($type=='success'){
        $('#verifydiv').hide();
        $('#faildiv').hide();
        $('#sucdiv').show();
    }else if($type=='fail'){
        $('#fspan').html($msg);
        $('#verifydiv').hide();
        $('#faildiv').show();
        $('#sucdiv').hide();
    }
    $('#aModal').modal('show');
  }