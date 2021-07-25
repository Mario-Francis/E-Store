<div class="row mt-4 text-dark">
	<div class="col-sm-12 offset-md-1 col-md-10 bg-white mcard">
		<div class="bg-morange p-3" style="margin-left:-15px;margin-right:-15px">
			<h4 class="mb-0 open-sans font-weight-light">Contact Us</h4>
		</div>
        <div class="row">
            <div class="col-sm-5 pr-sm-1">
                <div class="py-3">
                <h6 class="m-0 open-sans txt-morange font-weight-bold">Follow Us</h6>
                <p class="mt-1">&nbsp;<a href="<?php echo $admin['facebook']!=null?$admin['facebook']:'#'; ?>" class="txt-dark"><i class="fab fa-facebook-f"></i></a>&nbsp;&nbsp;<a href="<?php echo $admin['twitter']!=null?$admin['twitter']:'#'; ?>" class="txt-dark"><i class="fab fa-twitter"></i></a>&nbsp;&nbsp;<a href="<?php echo $admin['whatsapp']!=null?$admin['whatsapp']:'#'; ?>" class="txt-dark"><i class="fab fa-whatsapp"></i></a>&nbsp;&nbsp;<a href="<?php echo $admin['instagram']!=null?$admin['instagram']:'#'; ?>" class="txt-dark"><i class="fab fa-instagram"></i></a></p>

                <h6 class="m-0 open-sans txt-morange font-weight-bold mt-3">Address</h6>
                <p class="mt-1"><i class="fa fa-map-marker-alt"></i> &nbsp;<?php echo $admin['adres']; ?></p>

                <h6 class="m-0 open-sans txt-morange font-weight-bold mt-3">Phone Contact</h6>
                <p class="mt-1"><i class="fa fa-phone"></i> &nbsp;<?php echo $admin['phno']; ?></p>
                <?php if($admin['phno2']!=null && $admin['phno2']!=''){ ?>
                    <p><i class="fa fa-phone"></i> &nbsp;<?php echo $admin['phno2']; ?></p>
                <?php } ?>
                <h6 class="m-0 open-sans txt-morange font-weight-bold mt-3">Email</h6>
                <p class="mt-1"><i class="fa fa-envelope"></i>&nbsp;<?php echo $admin['email']; ?></p>
                </div>
            </div>
            <div class="col-sm-7 pl-sm-0">
                <div class="py-2 pt-3 pt-sm-2 pb-4">
                <h4 class="open-sans txt-morange">Get in Touch</h4>
                <p class="mt-1 f14" style="line-height:20px;">Please complete and submit this form and one of our representatives will reply promptly</p>
                <form>
                    <input type="text" id="name" class="form-control mtxtbx mt-2 rounded-0"  placeholder="Name" required />
                    <input type="text" id="email" class="form-control mtxtbx mt-2 rounded-0" placeholder="Email" required />
                    <input type="text" id="subject" class="form-control mtxtbx mt-2 rounded-0" placeholder="Subject" required />
                    <textarea id="msg" class="form-control mtxtbx mt-2 rounded-0" placeholder="Message" required style="resize:none;"></textarea>
                    <p id="err" class="err text-danger py-1" style="display:none;">
			            <i class="fa fa-info-circle"></i>
			            <span id="errsp">Error message</span>
		            </p>
                    <button type="submit" class="btn btn-sm rbord txt-morange rounded-0 mt-2 bg-white px-4">Submit</button>
                </form>
                </div>
            </div>
        </div>
		
	</div>
</div>
