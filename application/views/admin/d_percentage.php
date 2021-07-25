<div class="row mt-4">
	<div class="offset-sm-3 col-sm-6 bg-white p-0 mcard">
		<div class="bg-morange p-3">
			<h4 class="mb-0">Set Delivery Percentage</h4>
		</div>

		<form class="form-group p-3 p-sm-4">
            <div class="myinfo p-3 txt-sec small">
                <p>This section allows you set the percentage of delivery fee that will be removed when ever a customer pays before delivery.</p>
            </div>
			<p class="txtlab mt-3">Percent (%)</p>
			<input type="number" max="100" min="0" id="rate" class="form-control mtxtbx" disabled value="<?php echo $rate; ?>" />

			<p id="err" class="text-center mt-2 err text-danger">
				<i class="fa fa-info-circle"></i>
				<span id="errsp">Error message</span>
			</p>
			<script>
				document.getElementById('err').style.display = 'none';
			</script>
			<p class=" mt-2">
                <button id="ebtn" type="button" class="btn vbtn txt-morange bg-white p-2 rounded-0 mcard text-capitalize" style="min-width:120px;">Edit</button>
                <button id="ubtn" type="button" class="btn vbtn bg-morange p-2 rounded-0 mcard text-capitalize" style="min-width:120px;" disabled>Update</button>
			</p>
		</form>
	</div>
</div>
