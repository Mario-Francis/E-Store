
		<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="<?php echo base_url('content/bootstrap.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('content/font-awesome.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('content/style.css'); ?>" />
	<title><?php echo $title; ?> | Ex-Gstores</title>
</head>

<body class="bg-light">
	<div class="container-fluid">
		
		<div class="row mcard mb-5 bg-white">
            <div class="col-12 p-3">
                <h5 class="font-weight-bold txt-morange fquicksand mb-0">Ex-Gstores</h5>
            </div>
        </div>
        <div class="row">
            <div class="offset-sm-3 col-sm-6 offset-md-4 col-md-4 mcard p-0 bg-white">
                <div class="p-3">
                    <p class="text-center mt-3"><span class="rounded-circle px-4 pt-1 pb-2 bord text-secondary fa-4x"><i class="fa fa-user-tie"></i></span></p>
                    <h6 class="text-center m-0 mt-2 text-dark" style="font-family:verdana;">Administrator</h6>
                </div>
                <div class="p-3 pl-md-4 pr-md-4">
                <form id="loginForm">
                    <p class="txtlab mt-4 text-center">Username</p>
                    <input type="text" id="uname" class="form-control rounded-0 mtxtbx text-center" required />
                    <p class="txtlab mt-3 text-center">Password</p>
                    <input type="password" id="pswd" class="form-control rounded-0 mtxtbx text-center" required />
                    <p id="err" class="text-center mt-2 err text-danger"><i class="fa fa-info-circle"></i> <span id="errsp">Error message</span></p>
                    <script>
                        document.getElementById('err').style.display='none';
                    </script>
                    <p class="text-center my-4"><button type="submit" id="lbtn" class="btn vbtn bg-white txt-morange rounded-0 mcard" style="min-width:120px;">Login <i class="fa fa-sign-in-alt"></i></button></p>
                </form>    
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="row bg-morange mt-5">
			<div class="col-12 p-3">
				<p class="text-center foot">&copy; <?php echo date('Y', time()); ?> Ex-Gstores . All Rights Reserved</p>
			</div>
		</div>
	</div>


	<script src="<?php echo base_url('scripts/jquery-3.2.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('scripts/bootstrap.min.js'); ?>"></script>
    <script>
        $BASE = '<?php echo base_url(); ?>';
    </script>
    <script src="<?php echo base_url('scripts/admin_login.js'); ?>"></script>
    
</body>

</html>
