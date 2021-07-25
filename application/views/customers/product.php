<div class="row mt-4 mb-4">
	<div class="offset-sm-2 col-sm-8 bg-white mcard">
		<h4 class="text-center p-2 txt-dark text-uppercase m-0"><?php echo $product['pname']; ?></h4>
		<div class="row bg-sec" style="border-bottom:1px solid #ccc;">
			<div class="col-6 p-2 pl-4">
				<p class="pinfo">
					<i class="fa fa-tag"></i> <?php echo $product['cat']['cat']; ?></p>
			</div>
			<div class="col-6 p-2 pr-4">
				<p class="pinfo text-right">
				<?php if($product['avail']==1){ ?>	
				Available
					<i class="fa fa-check-circle"></i>
				<?php }else{ ?>
					Not Available
					<i class="fa fa-info-circle"></i>
				<?php } ?>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="offset-md-2 col-md-8 offset-lg-3 col-lg-6 border p-0 mcard">
				<div id="demo" class="carousel slide" data-ride="carousel">

					<!-- Indicators -->
					<ul class="carousel-indicators">
						<li data-target="#demo" data-slide-to="0" class="active"></li>
						<?php if(count($product['images']) > 1){ ?>
						<?php for($i=1;$i<count($product['images']);$i++){ ?>
							<li data-target="#demo" data-slide-to="<?php echo $i; ?>"></li>
						<?php }} ?>
						<!-- <li data-target="#demo" data-slide-to="2"></li> -->
					</ul>

					<!-- The slideshow -->
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img src="<?php echo base_url($product['images'][0]['fpath']); ?>" alt="<?php $product['pname']; ?>" class="img-fluid simg" />
						</div>
						<?php if(count($product['images']) > 1){ ?>
						<?php for($i=1;$i<count($product['images']);$i++){ ?>
							<div class="carousel-item">
								<img src="<?php echo base_url($product['images'][$i]['fpath']); ?>" alt="<?php $product['pname']; ?>" class="img-fluid simg" />
							</div>
						<?php }} ?>
						<!-- <div class="carousel-item">
							<img src="<?php //echo base_url('images/3.jpg'); ?>" alt="Chicago" class="img-fluid simg" />
						</div>
						<div class="carousel-item">
							<img src="<?php //echo base_url('images/4.jpg'); ?>" alt="New York" class="img-fluid simg" />
						</div> -->
					</div>

					<!-- Left and right controls -->
					<a class="carousel-control-prev" href="#demo" data-slide="prev">
						<span class="carousel-control-prev-icon"></span>
					</a>
					<a class="carousel-control-next" href="#demo" data-slide="next">
						<span class="carousel-control-next-icon"></span>
					</a>

				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<h3 class="text-center mt-3 ppr">
					<span class="font-weight-bold txt-morange">&#8358; <?php echo $product['fcprice']; ?></span>
					<br />
					<span class="txt-dark small">
						<strike>&#8358; <?php echo $product['fpprice']; ?></strike>
					</span>
				</h3>
				<p class="text-center">
					<a href="javascript:void(0)" class="btn vbtn btn-lg txt-morange rounded-0 pl-md-4 pr-md-4 mcard" style="font-family:roboto;" data="<?php echo $product['data']; ?>" onclick="addToCart(this);">
						<i class="fa fa-cart-plus"></i> Add to Cart</a>
				</p>
			</div>
		</div>
		<div class="row mt-3 mb-4">
			<div class="col-12">
				<div id="accordion">

					<div class="card rounded-0 ahd mcard">
						<div class="card-header bg-morange rounded-0">
							<a class="card-link" data-toggle="collapse" href="#c1">
								<p class="text-white">Description <span id="c1i" class="float-right"><i class="fa fa-minus"></i><span></p>
							</a>
						</div>
						<div id="c1" class="collapse show abd" data-parent="#accordion">
							<div class="card-body p-4">
								<p class="txt-dark"><?php echo urldecode($product['descrip']); ?></p>
							</div>
						</div>
					</div>

					<div class="card rounded-0 ahd mcard">
						<div class="card-header bg-morange rounded-0">
							<a class="collapsed card-link" data-toggle="collapse" href="#c2">
								<p class="text-white">Delivery Info <span id="c2i" class="float-right"><i class="fa fa-plus"></i><span></p>
							</a>
						</div>
						<div id="c2" class="collapse abd" data-parent="#accordion">
							<div class="card-body">
								<div class="row">
									<div class="col-2">
										<p class="p-2 txt-morange" style="font-size:20px;"><i class="fa fa-truck"></i></p>
									</div>
									<div class="col-10">
										<p class="txt-dark p-1">This product will be delivered within <b><?php echo (int)$product['days']['rate']; ?></b> working days</p>
									</div>
								</div>
								<hr class="mt-1 mb-1" />
								<div class="row">
									<div class="col-2">
										<p class="p-2 txt-morange" style="font-size:20px;"><i class="fa fa-credit-card"></i></p>
									</div>
									<div class="col-10">
										<?php if($product['cat']['dmode']==0){ ?>
										<p class="txt-dark p-1 text-justify"> Both <b>Payment before delivery</b> and <b>Payment after delivery</b> is available for this product. <br /> <?php echo $product['dpercent']['rate']==0?'':'Note that you\'ll be given <b>' . $product['dpercent']['rate'] . '% discount</b> on payment before delivery.'; ?> </p>
										<?php }else{ ?>
											<p class="txt-dark p-1"> <b>Only</b> Payment before delivery is available for this product. Note that <b>cancelation</b> is not allowed after order of this product!</p>
										<?php } ?>
										<p class="txt-dark px-1 text-justify"><?php echo ($product['cat']['dfee']==0.00)?'Delivery of this product is <b>free of charge</b>':''; ?></p>
									</div>
								</div>
								<hr class="mt-1 mb-1" />
								<div class="row">
									<div class="col-2">
										<p class="p-2 txt-morange" style="font-size:20px;"><i class="fa fa-undo"></i></p>
									</div>
									<div class="col-10">
										<p class="txt-dark p-1"> Return allowed only for <b>defective</b> and <b>wrong</b> items.</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card rounded-0 ahd mcard">
						<div class="card-header bg-morange rounded-0">
							<a class="collapsed card-link" data-toggle="collapse" href="#c3">
							<p class="text-white">Ratings <span id="c3i" class="float-right"><i class="fa fa-plus"></i><span></p>
							</a>
						</div>
						<div id="c3" class="collapse abd" data-parent="#accordion">
							<div class="card-body">
								<h4 class="text-center">
								<span id="prating">
									<?php 
									$rate = $product['rating'];
									$r = 5 - $rate;
									for($i=0;$i<$rate;$i++){ ?>
										<i class="fa fa-star txt-morange"></i>
									<?php }
									for($i=0;$i<$r;$i++){ ?>
										<i class="far fa-star txt-morange"></i>
									<?php } ?>
								</span>
								</h4>
								<?php if($product['login']['status']=='true'){ ?>
									<p class="text-center"><button type="button" class="mt-3 btn rounded-0 bg-morange mcard rat" pid="<?php echo $product['id']; ?>" onclick="$frate(this);">Rate this product</button></p>
								<?php }else{ ?>
									<p class="text-center"><button type="button" class="mt-3 btn rounded-0 bg-mblue mcard rat" pid="<?php echo $product['id']; ?>" data-toggle="modal" data-target="#lModal">Log in to rate this product</button></p>
								<?php } ?>
							</div>
						</div>
					</div>

					<div class="card rounded-0 ahd mcard">
						<div class="card-header bg-morange rounded-0">
							<a class="collapsed card-link" data-toggle="collapse" href="#c4">
							<p class="text-white">Seller Information <span id="c4i" class="float-right"><i class="fa fa-plus"></i><span></p>
							</a>
						</div>
						<div id="c4" class="collapse abd" data-parent="#accordion">
							<div class="card-body p-4">
								<div class="row">
									<div class="col-2">
										<p class="p-2 txt-morange" style="font-size:20px;"><i class="fa fa-university"></i></p>
									</div>
									<div class="col-10">
										<p class="txt-dark p-1 mt-2"><b><?php echo $product['merchant']['mname']; ?></b></p>
									</div>
								</div>
								<div class="row">
									<div class="col-2">
										<p class="p-2 txt-morange" style="font-size:20px;"><i class="far fa-clock"></i></p>
									</div>
									<div class="col-10">
										<p class="txt-dark p-1 mt-2">Been selling on this platform for about <b><?php echo $product['how_long']; ?></b> </p>
									</div>
								</div>
								<?php if($product['suc'] > 5){ ?>
								<div class="row">
									<div class="col-2">
										<p class="p-2 txt-morange" style="font-size:20px;"><i class="fa fa-check-circle"></i></p>
									</div>
									<div class="col-10">
										<p class="txt-dark p-1 mt-2">Has over <?php echo $product['suc']; ?> successful sales </p>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!-- <button type="button" class="btn btn-primary" id="anim">animate</button> -->

<!-- Rate Modal -->
<div class="modal fade" id="rModal">
  <div class="modal-dialog rounded-0">
    <div class="modal-content rounded-0">

      <!-- Modal Header -->
      <div class="modal-header bg-morange rounded-0 p-2">
        <h6 class="modal-title text-center">Product Rating</h6>
        <button type="button" class="close mclose p-0 pr-2 m-0" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-3">
		  <div class="myinfo p-3 small">
			  <p>The stars below depicts the rate you wish to give this product. kindly click to select.</p>
		  </div>
			<h2 class="text-center mt-3">
				<span>
					<i id="s1" class="txt-morange txt-shd r-icon far fa-star"></i>
					<i id="s2" class="txt-morange txt-shd r-icon far fa-star"></i>
					<i id="s3" class="txt-morange txt-shd r-icon far fa-star"></i>
					<i id="s4" class="txt-morange txt-shd r-icon far fa-star"></i>
					<i id="s5" class="txt-morange txt-shd r-icon far fa-star"></i>
				</span>
			</h2>
			<p id="rem" class="text-center txt-morange font-weight-bold"></p>
			<input type="hidden" id="rate" />
			<input type="hidden" id="smode" />
      </div>

      <!-- Modal footer -->
      <div class="modal-footer p-2">
        <button type="button" id="ratebtn" class="btn btn-sm txt-morange bg-white rounded-0 vbtn pt-1 pb-1">Submit</button>
        <button type="button" id="cancelbtn" class="btn btn-sm bg-morange text-white rounded-0 pt-1 pb-1" data-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>