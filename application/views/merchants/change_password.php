<div class="row mt-4">
	<div class="offset-sm-3 col-sm-6 bg-white p-0 mcard">
		<div class="bg-morange p-3">
			<h4 class="mb-0">Change Password</h4>
		</div>

		<form class="form-group p-3 p-sm-4">
			<p class="txtlab mt-3">Current Password</p>
            <input type="password" id="cpswd" class="form-control mtxtbx" />
            
            <p class="txtlab mt-3">New Password</p>
            <input type="password" id="npswd" class="form-control mtxtbx" />
            
            <p class="txtlab mt-3">Confirm New Password</p>
			<input type="password" id="npswd2" class="form-control mtxtbx" />

			<p id="err" class="text-center mt-2 err text-danger">
				<i class="fa fa-info-circle"></i>
				<span id="errsp">Error message</span>
			</p>
			<script>
				document.getElementById('err').style.display = 'none';
			</script>
			<p class=" mt-2">
                <button id="sbtn" type="button" class="btn vbtn txt-morange bg-white p-2 rounded-0 mcard text-capitalize" style="min-width:120px;">Submit</button>
			</p>
		</form>
	</div>
</div>
