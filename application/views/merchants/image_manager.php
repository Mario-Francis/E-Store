<div class="row mt-4">
	<div class="col-sm-12 offset-md-1 col-md-10 bg-white p-0 mcard" style="overflow:hidden;">
		<div class="bg-morange p-3">
			<h4 class="mb-0">Image Manager</h4>
		</div>
		<p class="text-center">
			<button type="button" class="btn vbtn txt-morange bg-white pt-2 pb-2 mt-3" data-toggle="modal" data-target="#nModal">
				<i class="fa fa-plus-circle"></i> &nbsp;New Image</button>
		</p>
		<div class="row mt-3">
			<div class="offset-sm-2 col-sm-8">
				<div class="myinfo p-3 small">
					<p>Note that the
						<b>maximum</b> number of images required for a product is
						<b>five(5)</b> and a minimum of
						<b>one(1)</b>. Therefore, you won't be able to delete an image if its the only image left for a product.</p>
				</div>
			</div>
		</div>
		<form class="form-group p-3 p-md-5 p-sm-4 txt-dark" style="padding-bottom:15px !important;">
			<p class="txtlab mt-2">Select Product to view images</p>
			<select class="form-control mtxtbx txtbx" id="cat" style="display:block !important;">
				<option value="0" selected>All</option>
				<?php foreach($products as $p){ ?>
				<option value="<?php echo $p['id']; ?>">
					<?php echo $p['pname']; ?>
				</option>
				<?php } ?>
			</select>
		</form>
		<hr class="ml-3 mr-3 mt-0 mb-0" />
		<div class="row">
			<div class="col-12 p-5">
				<div class="row" id="imagediv">
					<?php if(count($images) > 0){ 
                    foreach($images as $img){ ?>
					<div class="col-lg-2 col-md-3 col-sm-4 col-6 p-1 col">
						<div class="bg-morange p-2 mcard" style="padding-bottom:0 !important;">
							<div class="bg-white" style="height:auto;overflow:hidden;">
								<img src="<?php echo base_url($img['fpath']); ?>" alt="<?php echo $img['pname']; ?>" class="img-fluid pimg" />
							</div>
							<p class="text-center cap mt-1" title="<?php echo $img['pname']; ?>">
								<?php echo $img['pname']; ?>
							</p>
							<p class="text-center mt-auto">
								<button type="button" img-id="<?php echo $img['id']; ?>" class="btn btn-outline-white pt-1 pb-1 btn-sm text-capitalize rounded-0 <?php echo ($img['status']==1)?'disabled':''; ?>" onclick="delImage(this);" style="font-size:12px;">
									<i class="fa fa-times"></i> &nbsp;Delete</button>
							</p>
						</div>
					</div>
					<?php } ?>
					
					<?php }else{ ?>
					<div class="offset-sm-2 col-sm-8">
						<div class="myinfo p-3">
							<p class="text-center txt-sec">No images found!</p>
						</div>
					</div>
					<?php } ?>
				</div>
				<div class="row">
				<div class="col-12">
						<div class="row mt-5">
							<div class="col-12 col-sm-4 offset-sm-4">
								<div id="pagdiv">
									<?php echo $links; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12">	
						<div class="mspinner" id="loader">
  							<div class="bg-morange mcard"></div>
  							<div class="mcard"></div>
  							<div class="bg-morange mcard"></div>
  							<div class="mcard"></div>
						</div>
						<script>document.getElementById('loader').style.display='none';</script>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- New Modal -->
<div class="modal fade" id="nModal">
  <div class="modal-dialog rounded-0">
    <div class="modal-content rounded-0">

      <!-- Modal Header -->
      <div class="modal-header bg-morange rounded-0 px-3 py-2">
        <h5 class="modal-title">New Image</h5>
        <button type="button" class="close mclose p-0 pr-2 m-0" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-3">
            <p class="txtlab mt-2">Select Product</p>
			<select class="form-control mtxtbx txtbx" id="catdd" style="display:block !important;">
				<option value="" selected>-- Select Product --</option>
				<?php foreach($products as $p){ ?>
				<option value="<?php echo $p['id']; ?>">
					<?php echo $p['pname']; ?>
				</option>
				<?php } ?>
			</select>
			<div class="mt-3 p-4 dz-clickable" id="dzone">
				<div id="def" class="dz-clickable">
					<h5 class="text-center">Click or drop file here to upload</h5>
					<p class="text-center"><i class="fa fa-arrow-down" style="font-size:20px;"></i></p>
					<p class="text-center"><i class="fab fa-dropbox" style="font-size:60px;"></i></p>
				</div>
			</div>
			<div id="template" class="d-none">
			<div class="p-3 dzone">
				<center>
					<img src="<?php echo base_url('images/file.jpg'); ?>" class="img-fluid img-thumbnail" data-dz-thumbnail />
					<p class="text-center p-1 info font-weight-bold" data-dz-name>Michael Jackson-You are not alone.mp3</p>
				<p class="text-center p-1 info" data-dz-size>30.5Kb</p>
				</center>
				
				<p class="text-center"><button type="button" data-dz-remove class="btn btn-o-sec btn-sm text-capitalize pt-1 pb-1" style="font-size:12px;"><i class="fa fa-times" style="color:#555 !important;"></i> &nbsp;Clear</button></p>
			</div>
			</div>
            <p id="err" class="text-center mt-3 err text-danger">
				<i class="fa fa-info-circle"></i>
				<span id="errsp">Error message</span>
			</p>
			<script>
				document.getElementById('err').style.display = 'none';
			</script>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer pl-2 pr-2 pt-0 pb-0">
        <button type="button" id="upbtn" class="btn txt-morange bg-white rounded-0 vbtn pt-1 pb-1 text-capitalize"><i class="fa fa-upload"></i> Upload</button>
      </div>

    </div>
  </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="vModal">
  <div class="modal-dialog rounded-0 modal-sm">
    <div class="modal-content rounded-0">

      <!-- Modal Header -->
      <div class="modal-header bg-morange rounded-0 p-2">
        <h6 class="modal-title text-center">View Image</h6>
        <button type="button" class="close mclose p-0 pr-2 m-0" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-0">
			<img id="vimg" src="<?php echo base_url('images/default.png'); ?>" alt="" class="img-fluid w-100"/>
			<p id="vcap" class="text-center p-2 font-weight-bold txt-dark">Product Name</p>
      </div>

      <!-- Modal footer
      <div class="modal-footer pl-2 pr-2 pt-0 pb-0">
        <button type="button" id="updatebtn" class="btn btn-sm txt-morange bg-white rounded-0 vbtn pt-1 pb-1">Update</button>
        <button type="button" id="cancelbtn" class="btn btn-sm bg-morange text-white rounded-0 pt-1 pb-1" data-dismiss="modal">Cancel</button>
      </div> -->

    </div>
  </div>
</div>


<!-- Confirm Modal -->
<div class="modal fade" id="cModal">
  <div class="modal-dialog rounded-0">
    <div class="modal-content rounded-0">

      <!-- Modal Header -->
      <div class="modal-header bg-morange rounded-0 p-2">
        <h6 class="modal-title text-center">Confirm Delete</h6>
        <button type="button" class="close mclose p-0 pr-2 m-0" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-3">
			<p class="text-center p-2"><i class="fa fa-exclamation-triangle txt-sec" style="font-size:45px;"></i></p>
			<h6 class="text-center txt-dark open-sans">Are you sure you want to delete this image?</h6>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer pl-2 pr-2 pt-0 pb-0">
        <button type="button" id="yesbtn" class="btn btn-sm txt-morange rbord bg-white rounded-0 pt-1 pb-1">Yes</button>
        <button type="button" id="nobtn" class="btn btn-sm bg-morange text-white rounded-0 pt-1 pb-1" data-dismiss="modal">No</button>
      </div>

    </div>
  </div>
</div>