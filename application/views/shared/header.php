<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="<?php echo base_url('content/bootstrap.min.css'); ?>" />
	<?php if(isset($jfile4)){ ?>
		<!-- <link rel="stylesheet" href="<?php //echo base_url('content/mdb.min.css'); ?>" /> -->
	<?php } ?>
	<link rel="stylesheet" href="<?php echo base_url('content/font-awesome.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('content/style.css'); ?>" />
	<title><?php echo $title; ?> | Ex-Gstores</title>
</head>

<body class="bg-light">
	<div class="container-fluid">
		<!--Nav 1-->
		<div class="row bg-mblue nav1" id="nav1">
			<div class="col-sm-6 p-1 pl-4">
				<p><i class="fa fa-mobile-alt"></i>&nbsp;&nbsp; <?php echo $admin['phno']; ?></p>
			</div>
			<div class="col-sm-6 pr-4">
				<p class="text-right" style="line-height:32px;">
					<!-- <a href="#">Checkout</a> -->
					<a id="alogin" href="javascript:void(0)" class="ml-3" data-toggle="modal" data-target="#lModal">Login</a>
					<a id="asignup" href="javascript:void(0)" class="ml-3" data-toggle="modal" data-target="#sModal">Create Account</a>
					<?php if(isset($_SESSION['c_det'])){ ?>
						<script>
							document.getElementById('alogin').style.display='none';
							document.getElementById('asignup').style.display='none';
						</script>
                    <?php } ?>
				</p>
			</div>
		</div>
		<!--Nav 2-->
		<div id="nav2" class="row">
			<div class="col-12 p-0 mcard">
				<nav class="navbar navbar-expand-md bg-white navbar-light">
					<!-- Brand -->
					<a class="navbar-brand" href="<?php echo base_url(); ?>"><h5 class="txt-morange font-weight-bold fquicksand m-0 pb-1">Ex-Gstores</h5></a>

					<!-- Toggler/collapsibe Button -->
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
						<span class="navbar-toggler-icon"></span>
					</button>

					<!-- Navbar links -->
					<div class="collapse navbar-collapse" id="collapsibleNavbar">
						<ul class="navbar-nav">
							<li class="nav-item nav2">
								<a class="nav-link" href="<?php echo base_url(); ?>">Home</a>
							</li>
							<li class="nav-item dropdown nav2">
								<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
									Categories
								</a>
								<?php if(isset($cats)){ ?>
								<div class="dropdown-menu nav2">
										<?php foreach($cats as $c){ ?>
										<a class="dropdown-item" href="<?php echo base_url('search?searchtxt='.$c['cat']); ?>"><?php echo $c['cat']; ?></a>
										<?php } ?>
								</div>
								<?php } ?>
							</li>
							<li class="nav-item nav2">
								<a class="nav-link" href="<?php echo base_url('about'); ?>">About</a>
							</li>
							<li class="nav-item nav2">
								<a class="nav-link" href="<?php echo base_url('contact'); ?>">Contact Us</a>
							</li>
						</ul>

						<ul class="navbar-nav ml-auto">
							<li class="nav-item nav2">
								<a class="nav-link" href="<?php echo base_url('my_cart'); ?>">
									<i class="fa fa-shopping-cart" style="font-size:20px;"></i>
									&nbsp;
									<span class="cartno pl-1 pr-1 small bg-morange" style="display:none;">24</span>
								</a>
							</li>
                            
							<li id="notlogin" class="nav-item nav2">
								<p class="nav-link txt-morange" href="#">Not Logged In!</p>
							</li>
                            
                            
							<li id="islogin" class="nav-item dropdown nav2">
								<a id="cdd" class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
									<?php echo isset($_SESSION['c_det'])?$_SESSION['c_det']['c_name']:''; ?>
								</a>
								<input type="hidden" id="chd" value="<?php echo isset($_SESSION['c_det'])?$_SESSION['c_det']['c_id']:''; ?>"/>
								<div class="dropdown-menu nav2" style="right:0;left:auto;">
									<a class="dropdown-item" href="<?php echo base_url('my_orders'); ?>"><i class="fa fa fa-list-alt"></i>&nbsp; Track Your Order</a>
									<a class="dropdown-item" href="<?php echo base_url('my_profile'); ?>"><i class="fa fa fa-edit"></i>&nbsp; Edit Profile</a>
									<a class="dropdown-item" href="<?php echo base_url('change_password'); ?>"><i class="fa fa fa-lock"></i>&nbsp; Change Password</a>
									<a class="dropdown-item" href="<?php echo base_url('logout'); ?>"><i class="fa fa fa-sign-out-alt"></i>&nbsp; Log Out</a>
								</div>
							</li>
							
							<script>
								<?php if(isset($_SESSION['c_det'])){ ?>
									document.getElementById('notlogin').style.display='none';
								<?php }else{ ?>
									document.getElementById('islogin').style.display='none';
								<?php } ?>
							</script>
						</ul>
					</div>
				</nav>
			</div>
		</div>
		<?php if(!isset($hide_search)){ ?>
		<!--Search-->
		<div class="row">
			<div class="col-sm-12 p-4 bg-morange">
				<center>
					<form action="<?php echo base_url('search'); ?>" method="GET">
						<div class="txtbx">
							<input type="text" id="searchtxt" name="searchtxt" class="form-control float-left stxt rounded-0" placeholder="Search for products or categories" value="<?php echo isset($_REQUEST['searchtxt'])?$_REQUEST['searchtxt']:''; ?>" required />
							<button type="search" class="btn float-left rounded-0 bg-morange sbtn m-0 text-capitalize" style="padding:6px 12px;font-size:16px;">
							<i class="fa fa-search"></i>&nbsp;Search</button>
						</div>
					</form>
					<div class="clearfix"></div>
				</center>
			</div>
		</div>
		<?php } ?>