<div class="row mt-4">
	<div class="offset-sm-2 col-sm-8 offset-md-3 col-md-6 bg-white p-0 mcard">
		<div class="bg-morange p-3">
			<h4 class="mb-0">My Profile</h4>
		</div>

		<form>
		<fieldset class="form-group px-3 py-2 txt-dark m-0" id="eform" disabled>
			<p class="text-center txt-sec"><i class="fa fa-user-circle" style="font-size:100px;"></i></p>
			<h5 class="m-0 mt-3 txt-morange">Personal Information</h5>
			<hr class="mt-1" />
			<p class="txtlab mt-2">Merchant Name</p>
			<input type="text" id="mname" class="form-control mtxtbx" value="<?php echo $merchant['mname']; ?>" required />

			<p class="txtlab mt-2">Address 1</p>
			<textarea id="adres1" class="form-control mtxtbx" row="2" style="resize:none;"  required><?php echo $merchant['adres1']; ?></textarea>

			<p class="txtlab mt-2">Address 2
				<span class="font-weight-normal txt-sec">(Optional)</span>
			</p>
			<textarea id="adres2" class="form-control mtxtbx" row="2" style="resize:none;"><?php echo $merchant['adres2']==null?'':$merchant['adres2']; ?></textarea>

			<p class="txtlab mt-2">Phone Number 1</p>
			<input type="text" id="phno1" class="form-control mtxtbx" value="<?php echo $merchant['phno1']; ?>" required />

			<p class="txtlab mt-2">Phone Number 2
				<span class="font-weight-normal txt-sec">(Optional)</span>
			</p>
			<input type="text" id="phno2" class="form-control mtxtbx" value="<?php echo $merchant['phno2']==null?'':$merchant['phno2']; ?>"
			/>

			<p class="txtlab mt-2">Email</p>
			<input type="text" id="email" class="form-control mtxtbx" value="<?php echo $merchant['email']; ?>" required />

			<h5 class="m-0 mt-3 txt-morange">Bank Account Information</h5>
			<hr class="mt-1" />
			<p class="txtlab mt-2">Bank</p>
			<input type="text" id="bank" class="form-control mtxtbx" value="<?php echo $merchant['bank']; ?>" required />

			<p class="txtlab mt-2">Account Type</p>
			<input type="text" id="acctype" class="form-control mtxtbx" value="<?php echo $merchant['acc_type']; ?>" required />

			<p class="txtlab mt-2">Account Name</p>
			<input type="text" id="accname" class="form-control mtxtbx" value="<?php echo $merchant['acc_name']; ?>" required />

			<p class="txtlab mt-2">Account Number</p>
			<input type="text" id="accno" class="form-control mtxtbx" value="<?php echo $merchant['acc_no']; ?>" required />
		</fieldset>
		
		<p id="err" class="err text-danger px-4">
			<i class="fa fa-info-circle"></i>
			<span id="errsp">Error message</span>
		</p>
		<script>
			document.getElementById('err').style.display = 'none';
		</script>
		<p class=" mt-2 text-center mb-3">
			<button id="editbtn" type="button" class="btn vbtn txt-morange bg-white p-2 rounded-0 mcard text-capitalize" style="min-width:120px;">Edit</button>
			<button id="updatebtn" disabled type="submit" class="btn bg-morange text-white p-2 rounded-0 mcard text-capitalize" style="min-width:120px;">Update</button>
		</p>
		</form>
	</div>
</div>
