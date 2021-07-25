<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="<?php echo base_url('content/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('content/font-awesome.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('content/style.css'); ?>" />
    <title>Ex-Gstores</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row p-2">
            <div class="col-12 bg-white">
                
                <div class="row">
                    <div class="col-12 p-4 text-dark">

                        <div id="printdiv">
                            <!-- Invoice -->
                            <div class="table-responsive mt-3 text-dark lato card">
                                <table class="table table-striped" style="font-size:15px;">
                                    <thead>
                                        <tr>
                                            <td colspan="3">
                                                <h4 class="m-0 txt-morange verdana">INVOICE</h4>
                                            </td>
                                            <td colspan="3" style="font-size:12px;" class="font-weight-bold border border-right-0 border-bottom-0">
                                                <p>ID#: <?php echo $tid; ?></p>
                                                <p>Date: <?php echo date('M d, Y', time()); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <h6 class="m-0 txt-morange">Ex-Gstores</h6>
                                                <div class="mt-2 font-weight-bold " style="font-size:13px;">
                                                    <p><?php echo $admin['adres']; ?></p>
                                                </div>
                                            </td>
                                            <td colspan="3" class="border border-right-0 border-bottom-0">
                                                <h6 class="m-0 txt-morange">Bill To</h6>
                                                <div class="mt-2" style="font-size:13px;line-height:20px;">
                                                    <p><b>Name: </b> <?php echo $_SESSION['c_det']['c_name']; ?></p>
                                                    <p><b>Delivery Address: </b> <?php echo $adres; ?>
                                                    </p>
                                                    <p><b>Mobile: </b> <?php echo $cphno; ?></p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Sno</th>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Price&nbsp;(N)</th>
                                            <th>Del.&nbsp;Fee&nbsp;(N)</th>
                                            <th>Subtotal&nbsp;(N)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for($i=0;$i < count($mcart['cart']); $i++){ $c = $mcart['cart'][$i]; ?>
                                        <tr>
                                            <td><?php echo ($i+1); ?></td>
                                            <td><?php echo $c['pname']; ?></td>
                                            <td><?php echo $c['qty']; ?></td>
                                            <td><?php echo $c['fprice']; ?></td>
                                            <td><?php echo $c['fdfee']; ?></td>
                                            <td><?php echo $c['fsub']; ?></td>
                                        </tr>
                                        <?php } ?>
                                        
                                        <?php if($discount!=0){ ?>
                                        <tr>
                                            <td colspan="5">
                                                <p class="text-right font-weight-bold">Discount: </p>
                                            </td>
                                            <td><?php echo $fdiscount; ?></td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="5">
                                                <p class="text-right font-weight-bold">VAT: </p>
                                            </td>
                                            <td><?php echo $fvat; ?></td>
                                        </tr>
                                        <tr class="font-weight-bold txt-morange txt-shd">
                                            <td colspan="5">
                                                <p class="text-right">TOTAL: </p>
                                            </td>
                                            <td>&#8358;<?php echo $ftotal; ?></td>
                                        </tr>
                                        <tr class="">
                                            <td colspan="5">
                                                <p class="text-right">Transaction Status: </p>
                                            </td>
                                            <td>
                                                <?php if($pstatus==0){ ?>    
									            <span style="font-size:14px;" class="badge bg-info text-white rounded-0 mt-1 py-2 px-3 font-weight-normal">Not Paid &nbsp;&nbsp;<i class="fa fa-exclamation-circle"></i></span>
                                                <?php }else{ ?>
									            <span style="font-size:14px;" class="badge bg-success text-white rounded-0 mt-1 py-2 px-3 font-weight-normal">Paid &nbsp;&nbsp;<i class="fa fa-check-circle"></i></span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>