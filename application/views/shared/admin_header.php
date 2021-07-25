<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo base_url('content/font-awesome.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('content/bootstrap.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('content/mdb.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('content/style.css'); ?>" />
	<title><?php echo $title; ?> | Ex-Gstores</title>
</head>

<body class="fixed-sn bg-light txt-dark">


<!--Double navigation-->
<header>
        <!-- Sidebar navigation -->
        <div id="slide-out" class="side-nav fixed bg-morange">
            <ul class="custom-scrollbar">
                <!-- Logo -->
                <li>
                    <div class="logo-wrapper waves-light p-3 bg-morange">
						<!-- <a href="#"><img src="https://mdbootstrap.com/img/logo/mdb-transparent.png" class="img-fluid flex-center"></a> -->
						<h4 class="mb-0 mt-2 fquicksand font-weight-bold text-center">Ex-Gstores</h4>
                    </div>
                </li>
                <!--/. Logo -->
                <!--Social-->
                <li>
                    <ul class="social bg-white">
                        <li><a href="<?php echo $admin['facebook']!=null?$admin['facebook']:'#'; ?>" class="icons-sm fb-ic"><i class="fab fa-facebook-f txt-morange"> </i></a></li>
                        <li><a href="<?php echo $admin['twitter']!=null?$admin['twitter']:'#'; ?>" class="icons-sm tw-ic"><i class="fab fa-twitter txt-morange"> </i></a></li>
                        <li><a href="<?php echo $admin['whatsapp']!=null?$admin['whatsapp']:'#'; ?>" class="icons-sm gplus-ic"><i class="fab fa-whatsapp txt-morange"> </i></a></li>
                        <li><a href="<?php echo $admin['instagram']!=null?$admin['instagram']:'#'; ?>" class="icons-sm tw-ic"><i class="fab fa-instagram txt-morange"> </i></a></li>
                    </ul>
                </li>
                <!--/Social-->
                <!--Search Form-->
                <!-- <li>
                    <form class="search-form" role="search">
                        <div class="form-group md-form mt-0 pt-1 waves-light">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                    </form>
                </li> -->
                <!--/.Search Form-->
                <!-- Side navigation links -->
                <li>
                    <ul class="collapsible collapsible-accordion">
                        <li><a href="<?php echo base_url('admin/home'); ?>"  class="waves-effect arrow-r"><i class="fa fa-home"></i> Home</a>
                        </li>
                        <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-university"></i> Merchants<i class="fa fa-angle-down rotate-icon"></i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="<?php echo base_url('admin/create_merchant'); ?>" class="waves-effect">Create</a>
                                    </li>
                                    <li><a href="<?php echo base_url('admin/view_merchants'); ?>" class="waves-effect">View</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-list"></i> Categories<i class="fa fa-angle-down rotate-icon"></i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="<?php echo base_url('admin/create_category'); ?>" class="waves-effect">Add</a>
                                    </li>
                                    <li><a href="<?php echo base_url('admin/view_categories'); ?>" class="waves-effect">View</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li><a class="collapsible-header waves-effect arrow-r"><i class="fab fa-product-hunt mr-3"></i> Products<i class="fa fa-angle-down rotate-icon"></i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="<?php echo base_url('admin/view_products'); ?>" class="waves-effect">View</a>
                                    </li>
                                </ul>
                            </div>
						</li>
						<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-users"></i> Customers<i class="fa fa-angle-down rotate-icon"></i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="<?php echo base_url('admin/view_customers'); ?>" class="waves-effect">View Profile</a>
									</li>
									<!-- <li><a href="#" class="waves-effect">View Order Records</a>
									</li> -->
                                </ul>
                            </div>
                        </li>
                        <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-list-alt"></i> Orders<i class="fa fa-angle-down rotate-icon"></i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="<?php echo base_url('admin/orders'); ?>" class="waves-effect">Views</a>
									</li>
                                </ul>
                            </div>
						</li>
						<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-money-check"></i> Payments and Debts<i class="fa fa-angle-down rotate-icon"></i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="<?php echo base_url('admin/customer_payments'); ?>" class="waves-effect">Customer Payments</a>
									</li>
									<li><a href="<?php echo base_url('admin/payments_to_merchants'); ?>" class="waves-effect">Payments/Debts to Marchants</a>
                                </ul>
                            </div>
						</li>
						<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-cogs"></i> Settings<i class="fa fa-angle-down rotate-icon"></i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="<?php echo base_url('admin/percentage'); ?>" class="waves-effect">Sale Price Percentage</a>
                                    </li>
                                    <li><a href="<?php echo base_url('admin/d_percentage'); ?>" class="waves-effect">Delivery Discount Percentage</a>
                                    </li>
                                    <li><a href="<?php echo base_url('admin/d_days'); ?>" class="waves-effect">Delivery Days</a>
									</li>
                                </ul>
                            </div>
						</li>
                    </ul>
                </li>
                <!--/. Side navigation links -->
            </ul>
            <div class="sidenav-bg mask-strong"></div>
        </div>
        <!--/. Sidebar navigation -->
        <!-- Navbar -->
        <nav class="navbar navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav bg-white">
            <!-- SideNav slide-out button -->
            <div class="float-left">
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars txt-morange"></i></a>
			</div>
			
			<ul class="nav navbar-nav nav-flex-icons mr-auto">
				<li class="nav-item">
                    <h5 class="mb-0 ml-3 fquicksand txt-morange font-weight-bold">Ex-Gstores</h5>
                </li>
			</ul>
            <ul class="nav navbar-nav nav-flex-icons ml-auto">
                <!-- <li class="nav-item">
                    <a class="nav-link"><i class="fa fa-envelope"></i> <span class="clearfix d-none d-sm-inline-block">Contact</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"><i class="fa fa-comments-o"></i> <span class="clearfix d-none d-sm-inline-block">Support</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"><i class="fa fa-user"></i> <span class="clearfix d-none d-sm-inline-block">Account</span></a>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle txt-morange open-sans" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user-tie"></i> Administrator
                    </a>
                    <div class="dropdown-menu dropdown-menu-right open-sans" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item dd-item text-dark f13 py-1" href="<?php echo base_url('admin/edit_profile'); ?>"><i class="fa fa-edit"></i> &nbsp;Edit Profile</a>
                        <a class="dropdown-item dd-item text-dark f13 py-1" href="<?php echo base_url('admin/change_password'); ?>"><i class="fa fa-lock"></i> &nbsp;Change Password</a>
                        <a class="dropdown-item dd-item text-dark f13 py-1" href="<?php echo base_url('admin/logout'); ?>"><i class="fa fa-sign-out-alt"></i> &nbsp;Log Out</a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.Navbar -->
    </header> 
    <!--/.Double navigation-->

    <!--Main Layout-->
    <main class="m-0 pt-4">
        <div class="container-fluid">