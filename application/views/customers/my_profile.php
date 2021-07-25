<div class="row mt-4">
	<div class="offset-sm-2 col-sm-8 offset-md-3 col-md-6 bg-white p-0 mcard">
		<div class="bg-morange px-3 py-2">
			<h4 class="mb-0 open-sans font-weight-light">My Profile</h4>
		</div>

		<form>
		<fieldset class="form-group px-3 py-2 txt-dark m-0" id="eform" disabled>
			<p class="text-center txt-sec mt-3"><i class="fa fa-user-circle" style="font-size:100px;"></i></p>
			<p class="txtlab mt-2">First Name</p>
                <input type="text" id="fname" class="form-control mtxtbx" value="<?php echo $customer['fname']; ?>" required />
                
                <p class="txtlab mt-2">Last Name</p>
                <input type="text" id="lname" class="form-control mtxtbx" value="<?php echo $customer['lname']; ?>" required />
                
                <p class="txtlab mt-2">Gender</p>
			    <select id="gender" class="form-control mtxtbx" required>
                    <option value="">Select Gender</option>
                    <option value="Male" <?php echo $customer['gender']=='Male'?'selected':''; ?>>Male</option>
                    <option value="Female" <?php echo $customer['gender']=='Female'?'selected':''; ?>>Female</option>
                </select>

                <p class="txtlab mt-2">Address</p>
                <textarea id="adres" class="form-control mtxtbx" style="resize:none;" row="2" required><?php echo $customer['adres']; ?></textarea>

                <p class="txtlab mt-2">Phone Number</p>
                <input type="text" id="phno" class="form-control mtxtbx" value="<?php echo $customer['phno']; ?>" required />

                <p class="txtlab mt-2">Email</p>
                <input type="text" id="email" class="form-control mtxtbx" value="<?php echo $customer['email']; ?>" required />
		</fieldset>
		
		<p id="err" class="err text-danger px-4">
			<i class="fa fa-info-circle"></i>
			<span id="errsp">Error message</span>
		</p>
		<script>
			document.getElementById('err').style.display = 'none';
		</script>
		<p class=" mt-2 text-center mb-3">
			<button id="editbtn" type="button" class="btn btn-sm rbord txt-morange bg-white py-1 rounded-0 mcard text-capitalize open-sans" style="min-width:120px;">Edit</button>
			<button id="updatebtn" disabled type="submit" class="btn btn-sm bg-morange text-white py-1 rounded-0 mcard text-capitalize open-sans" style="min-width:120px;font-weight:normal;">Update</button>
		</p>
		</form>
	</div>
</div>
