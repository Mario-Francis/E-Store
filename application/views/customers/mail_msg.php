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
            <p style="margin-top: 10px;">Thank you for shopping with us. Your order has been placed with transaction <b>ID# <?php echo $tid; ?></b>. A pdf file which contains information about the items you ordered is attached to this mail.</p>
        </div>
        <!-- If pay now -->
        <?php if($method==0){ ?>
        <div class="text-left" style="padding: 0px 15px;font:normal 14px verdana;line-height: 22px;">
            <p>To complete your transaction, follow the below steps</p>
            <ul>
                <li>Login to your account</li>
                <li>On the right-most side of the navigation bar, click on the dropdown option <i><b>Track Your Order</b></i></li>
                <li>Select from the list of your orders the one whose transaction id corressponds with the above transaction id</li>
                <li>Click on <i><b>Pay Now</b></i> to proceed with your payment</li>
            </ul>
        </div>
        <?php }else if($method==1){ ?>
        <!-- If transfer -->
        <div class="text-left" style="padding: 0px 15px;font:normal 14px verdana;line-height: 22px;">
            <p>To complete your transaction, make a transfer to our bank account and contact us for verification of payment using the information provided below</p>

            <div style="float:left;min-width: 300px;width:49%;padding: 3px;">
                <h3 class="trebuchet mt mb txt-morange" style="border-bottom: 1px solid #aaa;">Account Information</h3>
                <div style="padding-left: 15px;">
                    <p><b class="trebuchet">Bank: </b> Diamond Bank</p>
					<p><b class="trebuchet">Account Name: </b> Exceeding Grace Farm</p>
					<p><b class="trebuchet">Account Number: </b> 8789654654</p>
                </div>
            </div>

            <div style="float:left;min-width: 300px;width:49%;padding: 3px;">
                <h3 class="trebuchet mt mb txt-morange" style="border-bottom: 1px solid #aaa;">Contact Information</h3>
                <div style="padding-left: 15px;">
                    <p><b>Email: </b> <?php echo $admin['email']; ?></p>
					<p><b>Phone 1: </b> <?php echo $admin['phno']; ?></p>
					<?php if($admin['phno2']!=null && $admin['phno2']!=''){ ?>
					<p><b>Phone 2: </b> <?php echo $admin['phno2']; ?></p>
				    <?php } ?>
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
        <?php }else{ ?>
        <!-- If delivery -->
        <div class="text-left" style="padding: 0px 15px;font:normal 14px verdana;line-height: 22px;">
            <p>Your ordered products will be delivered to you in less than 7 working days and you are to make a complete payment on receiving your products.</p>
        </div>
        <?php } ?>

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