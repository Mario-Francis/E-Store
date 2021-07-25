<!-- Footer -->
<div class="row bg-morange mt-5">
	<div class="col-12 p-3">
		<p class="text-center foot f13">&copy;
			<?php echo date('Y', time()); ?> Ex-Gstores . All Rights Reserved</p>
	</div>
</div>
</div>
</main>
<!--Main Layout-->



<script src="<?php echo base_url('scripts/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?php echo base_url('scripts/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('scripts/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('scripts/mdb.min.js'); ?>"></script>
<script>
	$(document).ready(function () {
		$BASE = '<?php echo base_url(); ?>';

		// SideNav Button Initialization
		$(".button-collapse").sideNav();
		// SideNav Scrollbar Initialization
		var sideNavScrollbar = document.querySelector('.custom-scrollbar');
		Ps.initialize(sideNavScrollbar);
	});

</script>
<?php if (isset($jfile)) {?>
<script src="<?php echo base_url('scripts/' . $jfile . '.js'); ?>"></script>
<?php }?>
<?php if (isset($jfile2)) {?>
<script src="<?php echo base_url('scripts/' . $jfile2 . '.js'); ?>"></script>
<?php }?>
<?php if (isset($jfile3)) {?>
<script src="<?php echo base_url('scripts/' . $jfile3 . '.js'); ?>"></script>
<?php }?>
</body>

</html>
