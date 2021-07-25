<div class="row mt-4 p-2">
	<div class="offset-sm-1 col-sm-10 offset-md-2 col-md-8 offset-lg-3 col-lg-6 bg-white mcard">
		<div class="bg-morange p-2" style="margin:0 -15px;">
			<h4 class="text-white p-2 m-0" style="font-family:open_sans;">
				<span class="pt-2 pb-2 pr-1 pl-2 rounded-circle bg-white txt-morange small">
					<i class="fa fa-shopping-cart"></i> <i class="fa fa-angle-double-right"></i>
				</span> &nbsp;Checkout</h4>
		</div>
		<div class="row">
			<div class="col-12 p-4 text-dark">
				<!-- Confirm Address -->
				<h5 class="p-1 m-0 roboto">Confirm Destination Address</h5>
				<hr class="mt-1 mb-2" />
				<div class="ml-2">
					<div class="radio" style="font-family:hind;">
						<label class="font-weight-bold txtlab">
							<input type="radio" name="adresrd" value="0" checked /> &nbsp;Current Address
						</label>
					</div>
					<p id="cadres" class="ml-4 text-dark" style="font-family:acme;"><?php echo urldecode($adres); ?></p>
					<div class="myinfo p-3 small ml-4 mt-2">
						<p><i class="fa fa-info-circle"></i> Note that you can edit the above address when making changes to your profile</p>
					</div>
				</div>
				<div class="ml-2 mt-3">
					<div class="radio" style="font-family:hind;">
						<label class="font-weight-bold txtlab">
							<input type="radio" name="adresrd" value="1" /> &nbsp;Specify Address
						</label>
					</div>
					<textarea id="adres" class="form-control mtxtbx ml-4" rows="3" style="resize:none;width:90%;" placeholder="Address"></textarea>
					
				</div>

				<!-- Cart Summary -->
				<h5 class="p-1 m-0 mt-4 roboto">Cart Summary</h5>
				<hr class="mt-1 mb-2" />
				<?php foreach($mcart['cart'] as $p){ ?>
				<div class="p-2 border border-top-0 border-left-0 border-right-0">
					<div class="row">
						<div class="col-4">
							<img src="<?php echo base_url($p['fpath']); ?>" class="img-fluid mcard" />
						</div>
						<div class="col-8">
							<h6 class="mt-2 text-dark"><?php echo $p['pname']; ?></h6>
							<div class="row small" style="font-family:'trebuchet ms';">
								<div class="col-sm-6 text-dark">
									<p class=""><b>Price: </b>&#8358;<?php echo $p['fprice']; ?></p>
									<p class="mt-1"><b>Delivery Fee: </b><?php echo ($p['dfee']!=0)?'&#8358;'.$p['fdfee']:'<span class="badge bg-mblue rounded-0 p-1 pl-2 pr-2">Free</span>'; ?></p>
								</div>
								<div class="col-sm-6">
									<p class=""><b>Quantity: </b><?php echo $p['qty']; ?></p>
									<p class="mt-1"><b>Sub. Total: <span class="txt-morange">&#8358;<?php echo $p['fsub']; ?></span></b></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<!-- <div class="p-2 border border-top-0 border-left-0 border-right-0">
					<div class="row">
						<div class="col-4">
							<img src="<?php //echo base_url('images/3.jpg'); ?>" class="img-fluid mcard" />
						</div>
						<div class="col-8">
							<h6 class="mt-2 text-dark">Women's wears - Black Blouse with cream skirt</h6>
							<div class="row small" style="font-family:'trebuchet ms';">
								<div class="col-sm-6 text-dark">
									<p class=""><b>Price: </b>&#8358;12,500.00</p>
									<p class="mt-1"><b>Delivery Fee: </b><span class="badge bg-mblue rounded-0 p-1 pl-2 pr-2">Free</span></p>
								</div>
								<div class="col-sm-6">
									<p class=""><b>Quantity: </b>4</p>
									<p class="mt-1"><b>Sub. Total: <span class="txt-morange">&#8358;34,500.00</span></b></p>
								</div>
							</div>
						</div>
					</div>
				</div> -->
				<div class="row">
					<div class="offset-sm-5 col-sm-7 p-2 pr-4">
						<h6 class="text-dark font-weight-bold">Total: <span class="float-right txt-shd">&#8358;<?php echo $mcart['ftotal']; ?></span></h6>
					</div>
				</div>

				<!-- Choose Payment Method -->
				<h5 class="p-1 m-0 mt-4 roboto">Choose Payment Method</h5>
				<hr class="mt-1 mb-2" />
				<div class="ml-2">
					<div class="radio" style="font-family:raleway_b;font-size:16px;color:#555;">
						<label class="font-weight-bold">
							<input type="radio" name="payrd" value="paystack" checked /> &nbsp;&nbsp;<span class="paystack"></span> &nbsp;Pay via Paystack
						</label>
					</div>
				</div>
				<div class="ml-2 mt-2">
					<div class="radio" style="font-family:raleway_b;font-size:16px;color:#555;">
						<label class="font-weight-bold">
							<input type="radio" name="payrd" value="transfer" /> &nbsp;&nbsp;<span class="fa fa-exchange-alt fa-fw"></span> &nbsp;Pay via Online Transfer
						</label>
					</div>
				</div>
				<?php if($mcart['mode']=='false'){ ?>
				<div class="ml-2 mt-2">
					<div class="radio" style="font-family:raleway_b;font-size:16px;color:#555;">
						<label class="font-weight-bold">
							<input type="radio" name="payrd" value="delivery" /> &nbsp;&nbsp;<span class="deliver"></span>&nbsp;&nbsp;Pay on Delivery
						</label>
					</div>
				</div>
				<?php } ?>
				
				<hr class="mt-2 mb-2" />
				<p id="err" class="text-center mt-2 err text-danger" style="display:none;">
				<i class="fa fa-info-circle"></i>
				<span id="errsp">Error message</span>
				</p>
				<p class="text-right"><button id="proceedbtn" type="button" class="btn vbtn bg-morange mcard rounded-0 pl-sm-4 pr-sm-4">Proceed &nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button></p>

			</div>
		</div>
		
	</div>
</div>
