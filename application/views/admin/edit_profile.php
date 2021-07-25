<div class="row mt-4 txt-dark">
	<div class="offset-sm-3 col-sm-6 bg-white p-0 mcard">
		<div class="bg-morange p-3">
			<h4 class="mb-0">Edit Profile</h4>
		</div>

		<form class="form-group p-3 p-sm-4">
			<p class="txtlab mt-3">Username</p>
            <input type="text" id="uname" class="form-control mtxtbx" value="<?php echo $admin['uname']; ?>" />

            <p class="txtlab mt-3">Email</p>
            <input type="email" id="email" class="form-control mtxtbx" value="<?php echo $admin['email']; ?>" />

            <p class="txtlab mt-3">Mobile 1</p>
            <input type="text" id="phno" class="form-control mtxtbx" value="<?php echo $admin['phno']; ?>" />
            
            <p class="txtlab mt-3">Mobile 2 <span class="text-secondary">(Optional)</span></p>
            <input type="text" id="phno2" class="form-control mtxtbx" value="<?php echo ($admin['phno2']==null||$admin['phno2']==''?'':$admin['phno2']); ?>" />

            <p class="txtlab mt-3">Address</p>
            <textarea id="adres" class="form-control mtxtbx" rows="3" ><?php echo $admin['adres']; ?></textarea>

            <h6 class="mt-3 font-weight-bold">Bank Account Information</h6>
            <hr class="mt-1" />
            <p class="txtlab mt-3">Bank</p>
            <input type="text" id="bank" class="form-control mtxtbx" value="<?php echo $admin['bank']; ?>" />
            <p class="txtlab mt-3">Account Type</p>
            <select id="acctype" class="form-control mtxtbx" style="display:block !important;">
                <option value="" <?php echo $admin['acc_type']==''?'selected':''; ?>>-- Select Account Type --</option>
                <option value="Savings" <?php echo $admin['acc_type']=='Savings'?'selected':''; ?>>Savings</option>
                <option value="Current" <?php echo $admin['acc_type']=='Current'?'selected':''; ?>>Current</option>
                <option value="Fixed Deposit" <?php echo $admin['acc_type']=='Fixed Deposit'?'selected':''; ?>>Fixed Deposit</option>
                <option value="Corporate" <?php echo $admin['acc_type']=='Corporate'?'selected':''; ?>>Corporate</option>
            </select>
            <p class="txtlab mt-3">Account Name</p>
            <input type="text" id="accname" class="form-control mtxtbx" value="<?php echo $admin['acc_name']; ?>" />
            
            <p class="txtlab mt-3">Account Number</p>
            <input type="text" id="accno" class="form-control mtxtbx" value="<?php echo $admin['acc_no']; ?>" />

			<p id="err" class="mt-2 err text-danger" style="display:none;">
				<i class="fa fa-info-circle"></i>
				<span id="errsp">Error message</span>
			</p>
			<!-- <script>
				document.getElementById('err').style.display = 'none';
			</script> -->
			<p class=" mt-2">
                <button id="ubtn" type="button" class="btn vbtn txt-morange bg-white p-2 rounded-0 mcard text-capitalize" style="min-width:120px;">Update</button>
                <button id="cbtn" type="button" class="btn cbtn bg-white  p-2 rounded-0 mcard text-capitalize" style="min-width:120px;">Cancel</button>
			</p>
		</form>
	</div>
</div>
