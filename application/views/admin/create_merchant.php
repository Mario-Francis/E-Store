<div class="row mt-4">
	<div class="offset-sm-2 col-sm-8 offset-lg-3 col-lg-6 bg-white p-0 mcard">
		<div class="bg-morange p-3">
			<h4 class="mb-0">Create Merchant</h4>
		</div>

		<form class="form-group p-3 p-sm-4">
			<p class="txtlab mt-2">Merchant Name</p>
			<input type="text" id="mname" class="form-control mtxtbx rounded-0" required />

			<p class="txtlab mt-2">Address 1</p>
			<textarea id="adres1" class="form-control mtxtbx rounded-0" required row="2" style="resize:none;"></textarea>

			<p class="txtlab mt-2">Address 2
				<span class="font-weight-normal txt-sec">(Optional)</span>
			</p>
			<textarea id="adres2" class="form-control mtxtbx rounded-0" row="2" style="resize:none;"></textarea>

			<p class="txtlab mt-2">Phone Number 1</p>
			<input type="text" id="phno1" class="form-control mtxtbx rounded-0" required />

			<p class="txtlab mt-2">Phone Number 2
				<span class="font-weight-normal txt-sec">(Optional)</span>
			</p>
			<input type="text" id="phno2" class="form-control mtxtbx rounded-0" />

			<p class="txtlab mt-2">Email</p>
			<input type="text" id="email" class="form-control mtxtbx rounded-0" required />

			<p class="txtlab mt-2">Password</p>
			<input type="password" id="pswd" class="form-control mtxtbx rounded-0" required />

			<p class="txtlab mt-2">Confirm Password</p>
			<input type="password" id="cpswd" class="form-control mtxtbx rounded-0" required />

			<p id="err" class="text-center mt-2 err text-danger">
				<i class="fa fa-info-circle"></i>
				<span id="errsp">Error message</span>
			</p>
			<script>
				document.getElementById('err').style.display = 'none';
			</script>
			<p class="text-center mt-2">
				<button id="sbtn" type="submit" class="btn vbtn txt-morange bg-white p-2 rounded-0 mcard text-capitalize" style="min-width:120px;">Submit</button>
			</p>
		</form>
	</div>
</div>
