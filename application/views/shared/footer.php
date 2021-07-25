<!-- Footer -->
<div class="row bg-morange mt-4">
            <div class="col-sm-4 p-3 pl-4 mt-2">
                <h4 class="fhead">About</h4>
				<p class="mt-3 fp text-justify">
					Ex-Gstores is an online electronic store designed to ease your shopping experience. It allows you place orders for produucts of your choice and make payments using any one of the supported means of payment. Ordered products are delivered to destination specified by you. <br />Ex-Gstores also provides business owners with a platform for marketing and selling their products.
				</p>
            </div>
             <div class="col-sm-4 p-3 pl-4 mt-2">
                <h4 class="fhead">Contacts</h4>
				<p class="mt-3 fp"><span class="rounded-circle border ficon"><i class="fa fa-map-marker-alt"></i></span> &nbsp;&nbsp;<?php echo $admin['adres']; ?></p>
				<p class="mt-3 fp"><span class="rounded-circle border ficon"><i class="fa fa-phone"></i></span> &nbsp;&nbsp;<?php echo $admin['phno']; ?></p>
                <?php if($admin['phno2']!=null && $admin['phno2']!=''){ ?>
				<p class="mt-3 fp"><span class="rounded-circle border ficon" style="padding:5px 11px;"><i class="fa fa-mobile-alt"></i></span> &nbsp;&nbsp;<?php echo $admin['phno2']; ?></p>
                <?php } ?>
				<p class="mt-3 fp"><span class="rounded-circle border ficon" style="padding:3px 8px;"><i class="fa fa-envelope" style="font-size:12px;"></i></span> &nbsp;&nbsp;<?php echo $admin['email']; ?></p>
            </div>
             <div class="col-sm-4 p-3 pl-4 mt-2">
                <h4 class="fhead">Social Links</h4>
				<a class="text-white no-txt-dec" href="<?php echo $admin['facebook']!=null?$admin['facebook']:'#'; ?>"><p class="mt-3 fp"><span class="rounded-circle border ficon sicon"><i class="fab fa-facebook-f"></i></span> &nbsp;&nbsp;facebook</p></a>
				<a class="text-white no-txt-dec" href="<?php echo $admin['twitter']!=null?$admin['twitter']:'#'; ?>"><p class="mt-3 fp"><span class="rounded-circle border ficon sicon" style="padding:5px 8px;"><i class="fab fa-twitter"></i></span> &nbsp;&nbsp;twitter</p></a>
				<a class="text-white no-txt-dec" href="<?php echo $admin['whatsapp']!=null?$admin['whatsapp']:'#'; ?>"><p class="mt-3 fp"><span class="rounded-circle border ficon sicon" style="padding:4px 8px;"><i class="fab fa-whatsapp"></i></span> &nbsp;&nbsp;whatsapp</p></a>
				<a class="text-white no-txt-dec" href="<?php echo $admin['instagram']!=null?$admin['instagram']:'#'; ?>"><p class="mt-3 fp"><span class="rounded-circle border ficon sicon" style="padding:5px 8px;"><i class="fab fa-instagram"></i></span> &nbsp;&nbsp;instagram</p></a>
            </div>
            <div class="col-12">
                <br />
            </div>
        </div>
		<div class="row bg-white">
			<div class="col-12 p-3">
				<p class="text-center foot txt-dark mb-2">&copy; <?php echo date('Y', time()); ?> Ex-Gstores . All Rights Reserved</p>
				<center>
					<img src="<?php echo base_url('images/card.png'); ?>" />
				</center>
			</div>
		</div>

	</div>


	<script src="<?php echo base_url('scripts/jquery-3.6.0.min.js'); ?>"></script>
    <script src="<?php echo base_url('scripts/bootstrap.min.js'); ?>"></script>
    <script>
        $(document).ready(function(){
            $BASE = '<?php echo base_url(); ?>';
            <?php if (isset($cart)){ ?>
                $d123='<?php $e = str_replace("'", "\'", urldecode($cart)); echo str_replace('"', '\"', $e); ?>';
                //$cart123=decodeURIComponent($d123);
                $CART = JSON.parse($d123);
            <?php } ?>

            <?php if (isset($mcart) && $mcart['qty']!=0 ){ ?>
                $q='<?php echo $mcart['qty']; ?>';
                $('.cartno').html($q);
                $('.cartno').show();
            <?php } ?>

            // When the user scrolls the page, execute myFunction
            window.onscroll = function() {myFunction()};

            // Get the navbar
            var navbar = document.getElementById("nav2");

            // Get the offset position of the navbar
            var sticky = navbar.offsetTop;

            // Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
            function myFunction() {
                if (window.pageYOffset >= sticky) {
                    navbar.classList.add("msticky")
                    $('#nav1').addClass('mt-5');
                } else {
                    navbar.classList.remove("msticky");
                    $('#nav1').removeClass('mt-5');
                }
            } 
        });
    </script>
    <?php if($title=='Invoice'){  ?>
        <script src="https://js.paystack.co/v1/inline.js"></script>
    <?php } ?>    
    <?php if(isset($jfile)){ ?>
    <script src="<?php echo base_url('scripts/'.$jfile.'.js'); ?>"></script>
    <?php } ?>
    <?php if(isset($jfile2)){ ?>
    <script src="<?php echo base_url('scripts/'.$jfile2.'.js'); ?>"></script>
    <?php } ?>
    <?php if(isset($jfile3)){ ?>
    <script src="<?php echo base_url('scripts/'.$jfile3.'.js'); ?>"></script>
    <?php } ?>
    <?php if(isset($jfile4)){ ?>
    <script src="<?php echo base_url('scripts/'.$jfile4.'.js'); ?>"></script>
    <?php } ?>
</body>

</html>
