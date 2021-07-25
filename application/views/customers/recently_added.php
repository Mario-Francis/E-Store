<!--Recently Added-->
<div class="row mt-3 mb-4">
	<div class="offset-sm-1 col-12 col-sm-10 p-3">
		<h5 class="shd text-dark">Recently Added Products</h5>
		<hr class="hr mt-2 mb-3" />
		<?php if(count($products) > 0){ ?>
		<div class="row">
			<?php foreach($products as $p){ ?>
			<div class="col-lg-2 col-md-3 col-sm-4 col-6 p-2">
				<div class="p-2 bg-morange mcard prod" pid="<?php echo $p['id']; ?>" onclick="nav(this);">
					<div class="bg-white" style="overflow:hidden;">
						<img src="<?php echo base_url($p['image']['fpath']); ?>" class="img-fluid pimg" />
					</div>
					<p class="text-center pname p-1 mcap"><?php echo $p['pname']; ?></p>
					<p class="pprice mb-1" style="line-height:0.8em;">
						<span class="new">&#8358;<?php echo $p['fcprice']; ?></span>
						<?php if($p['avail']==1){ ?>
							<span class="badge badge-sm badge-info lato font-weight-normal bg-mblue float-right mt-1 small">Available</span>
						<?php }else{ ?>
							<span class="badge badge-sm badge-info lato font-weight-normal bg-mblue float-right mt-1 small">Not Available</span>
						<?php } ?>
						<br />
						<?php if($p['fpprice']!='0.00'){ ?>
						<span class="old">
							<strike>&#8358;<?php echo $p['fpprice']; ?></strike>
						</span>
						<?php }else{ ?>
							<span>&nbsp;</span>
						<?php } ?>
					</p>
					<div class="clearfix"></div>
					<p class="small lato mb-3">
						<span class="small">
							<i class="fa fa-tag"></i> <?php echo $p['cat']['cat']; ?></span>
						<span class="float-right small mt-1 d-sm-none d-md-block">
							<?php 
							$rate=(int)$p['rating'];
							$r = 5-$rate;
							for($i=0;$i<$rate;$i++){
							?>
							<i class="fa fa-star"></i>
							<?php } ?>
							<?php for($i=0;$i<$r;$i++){
							?>
							<i class="far fa-star"></i>
							<?php } ?>
						</span>
					</p>
				</div>
				<center>
					<div class="cartbtn bg-white rounded-circle mcard" data="<?php echo $p['data']; ?>" onclick="addToCart(this);" <?php echo $p['avail']!=1?'style="display:none;"':''; ?> >
						<div class="bg-mblue rounded-circle">
							<img src="<?php echo base_url('images/cart.png'); ?>" class="img-fluid" />
						</div>
					</div>
				</center>
			</div>
			<?php } ?>
		</div>
		<?php }else{ ?>
		<div class="row">
			<div class="offset-sm-1 col-sm-10 col-12">
				<div class="myinfo p-3">
					<p class="txt-sec text-center">No products found!</p>
				</div>
			</div>
		</div>
		<?php } ?>
        <div class="row mt-4">
            <div class="col-12">
                <div id="pagediv">
                    <?php echo $links; ?>
                </div>
            </div>
        </div>
	</div>
</div>