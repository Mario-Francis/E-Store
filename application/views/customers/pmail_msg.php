<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ex-Gstores</title>
    <style>
        html, body{
            padding: 0;
            margin: 0;
            color:#444;
            background-color: #fff;
        }
        p{
            margin: 0;
        }
        h1,h2,h3,h4,h5{
            margin: 0;
        }
        .bg-morange {
            background-color: #ee6123 !important;
            color: #fff !important;
        }
        .txt-morange {
            color: #ee6123 !important;
        }
        .con {
            margin: 5px;
            border:1px solid #aaa;
            max-width:700px;
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left;
        }
        .pad{
            padding: 10px 15px;
        }
        .trebuchet{
            font-family: 'trebuchet ms';
        }
        .verdana{
            font-family: verdana;
        }
        .mt{
            margin-top: 15px;
        }
        .mb{
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <center>
    <div class="con">
        <div class="bg-morange pad">
            <h3 class="text-center" style="font-family:'trebuchet ms';font-weight:normal;margin:0;">Ex-Gstores</h3>
        </div>
        <!-- <hr style="border:0;border-top:1px solid #aaa;" /> -->
        <div class="text-left" style="padding: 15px;font:normal 14px verdana;line-height: 22px;">
            <p>Dear <?php echo $cfname; ?>,</p>
            <p style="margin-top: 10px;">Thank you for shopping with us. We have received and confirmed your payment for order with transaction <b>ID# <?php echo $tid; ?></b>. Your order is been processed and will be delivered to you in less than <?php echo (int)$days; ?> working days. A pdf file which contains information about the items you ordered is attached to this mail.</p>
        </div>
        

        <div class="text-left" class="mt" style="padding: 0px 15px;font:normal 14px 'trebuchet ms';line-height: 22px;">
            <p><b>Happy Shopping!</b></p>
        </div>

        <!-- Footer -->
        <div class="bg-morange pad mt">
            <h6 class="text-center" style="font-family:'trebuchet ms';font-weight:normal;margin:0;">Thanks for shopping with us!</h6>
        </div>
    </div>
    </center>
</body>

</html>