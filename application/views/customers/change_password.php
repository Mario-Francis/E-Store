<div class="row mt-4">
	<div class="offset-sm-3 col-sm-6 bg-white p-0 mcard">
		<div class="bg-morange px-3 py-2">
			<h4 class="mb-0 open-sans font-weight-light">Change Password</h4>
		</div>

		<form class="form-group p-3 p-sm-4 m-0">
			<p class="txtlab mt-3">Current Password</p>
            <input type="password" id="cpswd" class="form-control mtxtbx" required />
            
            <p class="txtlab mt-3">New Password</p>
            <input type="password" id="npswd" class="form-control mtxtbx" required />
            
            <p class="txtlab mt-3">Confirm New Password</p>
			<input type="password" id="npswd2" class="form-control mtxtbx" required />

			<p id="err" class="mt-2 err text-danger">
				<i class="fa fa-info-circle"></i>
				<span id="errsp">Error message</span>
			</p>
			<script>
				document.getElementById('err').style.display = 'none';
			</script>
			<p class="mt-2">
                <button id="sbtn" type="submit" class="btn vbtn txt-morange bg-white p-2 rounded-0 mcard text-capitalize" style="min-width:120px;">Submit</button>
			</p>
		</form>
	</div>
</div>
