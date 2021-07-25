<div class="row mt-4 p-2">
	<div class="col-sm-12 offset-md-1 col-md-10 offset-lg-2 col-lg-8 bg-white mcard">
		<div class="bg-morange p-2" style="margin:0 -15px;">
			<h4 class="text-white p-2 m-0" style="font-family:open_sans;">
				<i class="fa fa-file-invoice"></i> &nbsp;Invoice</h4>
		</div>
		<div class="row">
			<div class="col-12 p-4 text-dark">

				<div class="myinfo p-3">
					<h6 class="trebuchet text-dark m-0" style="line-height:25px;font-size:16px;">Hi <?php echo $cfname; ?>, your order has been placed successfully and your <b>transaction ID#</b> is <b><?php echo $tid; ?></b>. We've also sent you a mail with the below invoice as an attachment.</h6>
				</div>
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
                                        <p><b>Delivery Address: </b> <?php echo $adres; ?></p>
                                        <p><b>Mobile: </b> <?php echo $cphno; ?></p>
                                    </div>
                                </td>
                            </tr>
							<tr>
								<th>Sno</th>
								<th>Product</th>
								<th>Qty</th>
								<th>Price&nbsp;(&#8358;)</th>
								<th>Del.&nbsp;Fee&nbsp;(&#8358;)</th>
								<th>Subtotal&nbsp;(&#8358;)</th>
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

				<p class="text-center mt-3"><button type="button" id="printbtn" class="btn cbtn rounded-0"><i class="fa fa-print"></i> Print</button></p>
				
				<hr />
				<?php if($method==0){ ?>
				<!-- if Paystack -->
				<div class="myinfo p-3 small">
					<p class="text-center font-italic font-weight-bold">To complete your transaction, click on the button below</p>
					<p class="text-center"><button type="button" class="btn vbtn bg-morange rounded-0 mt-2" oid="<?php echo $oid; ?>" tid="<?php echo $tid; ?>" email="<?php echo $cemail; ?>" amt="<?php echo $amt; ?>" phno="<?php echo $cphno; ?>" onclick="payWithPaystack(this);">Pay Now</button></p>
					<p class="mt-3 text-center"><i class="fa fa-info-circle"></i> Note that your order won't be processed until your payment has been verified and confirmed!</p>
				</div>
				<?php }else if($method==1){ ?>
				<!-- if transfer -->
				<div class="row mt-1">
					<div class="col-12">
						<div class="myinfo p-3 small">
							<p class="font-italic font-weight-bold">To complete your transaction, make a transfer to our bank account and contact us for verification of payment using the information provided below</p>
							
							<div class="row">
								<div class="col-lg-6">
									<h6 class="mt-3 txt-morange trebuchet">Account Info</h6>
									<hr class="my-2" />
										<div class="pl-3">
											<p><b>Bank: </b> <?php echo $admin['bank']; ?></p>
											<p><b>Account Name: </b> <?php echo $admin['acc_name']; ?></p>
											<p><b>Account Number: </b> <?php echo $admin['acc_no']; ?></p>
									</div>
								</div>
								<div class="col-lg-6">
									<h6 class="mt-3 txt-morange trebuchet">Contact Info</h6>
									<hr class="my-2" />
										<div class="pl-3">
											<p><b>Email: </b> <?php echo $admin['email']; ?></p>
											<p><b>Phone 1: </b> <?php echo $admin['phno']; ?></p>
											<?php if($admin['phno2']!=null && $admin['phno2']!=''){ ?>
											<p><b>Phone 2: </b> <?php echo $admin['phno2']; ?></p>
											<?php } ?>
									</div>
								</div>
							</div>
							<p class="mt-3"><i class="fa fa-info-circle"></i> Note that your order won't be processed until your payment has been verified and confirmed!</p>
						</div>
					</div>
				</div>
				<?php }else{ ?>
				<!-- if pay on delivery -->
				<div class="myinfo p-3 small mt-1">
					<p class="text-center font-italic font-weight-bold">Your ordered products will be delivered to you in less than <?php echo (int)$days; ?> working days and you are to make a complete payment on receiving your products.</p>
					<h5 class="text-center open-sans mt-2"><span class="badge bg-morange rounded-0 mt-2 py-2 px-3 font-weight-normal"><i class="fa fa-info-circle"></i> Thanks for shopping with us</span></h5>
				</div>
				<?php } ?>
			</div>
		</div>

	</div>
</div>

<!-- custom alert -->
<div class="modal" id="aModal" style="padding-right:0;">
  <div class="modal-dialog rounded-0" style="margin-top:20vh;transition:0.5s;">
    <div class="modal-content rounded-0">

      <!-- Modal Header -->
      <!-- <div class="modal-header rounded-0 p-2">
        <h6 class="modal-title text-center"></h6>
        <button type="button" class="close p-0 pr-2 m-0" data-dismiss="modal">&times;</button>
      </div> -->

      <!-- Modal body -->
      <div class="modal-body p-3">
		  <!-- verifying view -->
		  <div id="verifydiv" class="p-3 txt-morange" style="display:none;">
			  <p class="text-center p-2"><i class="fa fa-circle-notch fa-spin" style="font-size:30px;"></i></p>
			  <h5 class="text-center roboto">Verifying payment...</h5>
		  </div>
		  <div id="faildiv" class="p-3 txt-morange" style="display:none;">
			  <p class="text-center p-2"><i class="fa fa-exclamation-circle" style="font-size:40px;"></i></p>
			  <h5 class="text-center roboto"><span id="fspan">Transaction was not successful</span>. Please try again.</h5>

			  <p class="text-center mt-4"><button type="button" id="fokbtn" class="btn btn-sm txt-morange bg-white rounded-0 vbtn py-1 pl-3 pr-3" data-dismiss="modal">OK</button></p>
		  </div>
		  <div id="sucdiv" class="p-3 txt-morange">
			  <p class="text-center p-2"><i class="fa fa-check-circle" style="font-size:40px;"></i></p>
			  <h5 class="text-center roboto">Your transaction was successful</h5>
			  
			  <div class="myinfo p-2 mt-2 text-dark">
				  <h6 class="text-center m-0 small">Thanks for shopping with us </h6>
			  </div>

			  <p class="text-center mt-4"><button type="button" id="sokbtn" class="btn btn-sm txt-morange bg-white rounded-0 vbtn py-1 pl-3 pr-3">OK</button></p>
		  </div>
			<!-- <p class="text-center p-2"><i class="fa fa-warning txt-sec" style="font-size:30px;"></i></p>
			<h6 class="text-center txt-dark">Are you sure you want to remove this item from cart?</h5> -->
      </div>

      <!-- Modal footer -->
      <div class="modal-footer pl-2 pr-2 pt-1 pb-1" id="footdiv" style="display:none;">
        <button type="button" id="ryesbtn" class="btn btn-sm txt-morange bg-white rounded-0 rbord pt-0 pb-0 pl-3 pr-3">Yes</button>
        <button type="button" id="rnobtn" class="btn btn-sm bg-morange text-white rounded-0 pt-0 pb-0 pl-3 pr-3" data-dismiss="modal">No</button>
      </div>

    </div>
  </div>
</div>

<!-- custom alert 2 -->
<div class="modal" id="cModal">
  <div class="modal-dialog rounded-0" style="margin-top:20vh;transition:0.5s;">
    <div class="modal-content rounded-0">

      <!-- Modal Header -->
      <div class="modal-header rounded-0 p-2">
        <h6 class="modal-title text-center txt-morange">Alert</h6>
        <button type="button" class="close p-0 pr-2 m-0" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-3">
		  <div class="txt-morange">
			  <p class="text-center p-2"><i class="fa fa-info-circle text-secondary" style="font-size:40px;"></i></p>
			  <h6 class="text-center roboto text-dark pt-3">Click on <i><b>Pay Now</b></i> to try again.</h6>
		  </div>
		  
      </div>

    </div>
  </div>
</div>