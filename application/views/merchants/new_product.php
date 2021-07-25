<div class="row mt-4">
	<div class="offset-sm-2 col-sm-8 offset-md-3 col-md-6 bg-white p-0 mcard">
		<div class="bg-morange p-3">
			<h4 class="mb-0">New Product</h4>
		</div>

		<form class="form-group p-3 p-sm-4 txt-dark">
			<input type="hidden" id="rate" value="<?php echo $rate; ?>" />
            <p class="txtlab mt-2">Product Category</p>
			<select class="form-control mtxtbx" id="cat" style="display:block !important;" required>
                <option value="" selected>Select Category</option>
                <?php for($i=0;$i<count($cats);$i++){ ?>
                <option value="<?php echo $cats[$i]['id']; ?>"><?php echo $cats[$i]['cat']; ?></option>
                <?php } ?>
            </select>

            <p class="txtlab mt-2">Product Name</p>
			<input type="text" id="pname" class="form-control mtxtbx" required />

            <p class="txtlab mt-2">Previous Price <span class="txt-sec">(Optional)</span></p>
			<input type="number" max="999999999" min="0" id="pprice" class="form-control mtxtbx" />

            <p class="txtlab mt-2">Current Price</p>
			<input type="number" max="999999999" min="0" id="cprice" class="form-control mtxtbx" required />
			<div class="myinfo p-3 small mt-2">
				<p>Note that you will be charged <?php echo $rate ?>% on each product sold! <br /><b class="font-weight-bold txt-morange">Sale Price: </b>&#8358;<span id="sprice">0</span>
				</p>
			</div>
            
            <p class="txtlab mt-2">Description</p>
			<textarea id="descrip" class="form-control mtxtbx" style="resize:none;" rows="3" required></textarea>

            <p class="txtlab mt-2">Product Image</p>
            <input type="file" id="fileup" class="form-control mtxtbx" accept=".jpg,.png,.gif,.jpeg" required />
            <p class="txtlab mt-3">Image Preview</p>
            <img alt="product image" id="pimg" src="<?php echo base_url('images/default.png'); ?>" class="img-fluid mcard" style="max-width:300px" />

			<p id="err" class="mt-2 err text-danger">
				<i class="fa fa-info-circle"></i>
				<span id="errsp">Error message</span>
			</p>
			<script>
				document.getElementById('err').style.display = 'none';
			</script>
			<p class=" mt-2">
				<button id="sbtn" type="submit" class="btn vbtn txt-morange bg-white p-2 rounded-0 mcard text-capitalize" style="min-width:120px;">Submit</button>
			</p>
		</form>
	</div>
</div>
