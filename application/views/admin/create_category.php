<div class="row mt-4">
	<div class="offset-sm-3 col-sm-6 bg-white p-0 mcard">
		<div class="bg-morange p-3">
			<h4 class="mb-0">Create Category</h4>
		</div>

		<form class="form-group p-3 p-sm-4">
			<p class="txtlab mt-2">Category Name</p>
			<input type="text" id="cat" class="form-control mtxtbx" />
			<div class="myinfo p-3 small mt-2">
				<p>Delivery fee specifies the amount that will be charged for each product under this category. If not set, default of
					<b>&#8358;500</b> will be used.</p>
			</div>
			<p class="txtlab mt-2">Delivery Fee
				<span class="txt-sec">(Optional)</span>
			</p>
			<input type="number" max="10000" min="0" id="dfee" class="form-control mtxtbx" />

			<p class="txtlab mt-2">Delivery Mode</p>
			<div class="mt-3">

				<div class="form-check radio-orange-gap">
					<input class="form-check-input with-gap" name="rd" type="radio" id="rd1" checked="checked" value="0" />
					<label class="form-check-label txt-dark" style="font-family:hind;" for="rd1">Both pre-payment and post-payment</label>
				</div>

				<div class="form-check radio-orange-gap">
					<input class="form-check-input with-gap" name="rd" type="radio" id="rd2" value="1" />
					<label class="form-check-label txt-dark" style="font-family:hind;" for="rd2">Only pre-payment</label>
				</div>

			</div>

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
