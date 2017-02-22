<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="HTML5 Business Template Powered By Twitter Bootstrap 3.0">
		<meta name="author" content="Anuj Kumar">

		<link rel="shortcut icon" href="../../assets/ico/favicon.png">

		<title>QuickSite - Bootstrap Business Template</title>

		<link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/includes/css/bootstrap-social-3.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/dataTables.bootstrap.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/includes/themes/default/style.css'); ?>" rel="stylesheet">
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="./includes/js/html5shiv.js"></script>
			<script src="./includes/js/respond.min.js"></script>
		<![endif]-->
		<script src="<?php echo base_url('assets/js/jquery-3.1.1.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/dataTables.bootstrap.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
	</head>
	<body>
		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
		  			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					    <span class="icon-bar"></span>
					    <span class="icon-bar"></span>
					    <span class="icon-bar"></span>
		  			</button>
		  			<a class="navbar-brand" href="./">QUICK<span class="strap">SITE</span></a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
					    <?php if($this->session->userdata('logged_in')){ ?>
						<li><a href="<?php echo base_url('home/customers'); ?>">Customers</a></li>
						<li><a href="<?php echo base_url('home'); ?>">MWS Details</a></li>
					    <li><a href="<?php echo base_url('login/logout'); ?>">Logout</a></li>
						<?php }else{ ?>
						<li><a href="./">Home</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Pages <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="services.html">Services</a></li>
								<li><a href="portfolio.html">Portfolio</a></li>
								<li><a href="portfolio-item.html">Portfolio Item</a></li>
								<li><a href="features.html">Features</a></li>
								<li><a href="pricing.html">Pricing</a></li>
								<li><a href="team.html">Team</a></li>
								<li><a href="careers.html">Careers</a></li>
								<li><a href="clients.html">Clients</a></li>
								<li><a href="faq.html">FAQ</a></li>
								<li><a href="blog.html">Blog</a></li>
								<li><a href="blog-post.html">Blog Single Post</a></li>
								<li><a href="gallery.html">Gallery</a></li>
								<li><a href="register.html">Sign Up</a></li>
								<li><a href="login.html">Sign In</a></li>
								<li><a href="recover-password.html">Recover Password</a></li>
								<li><a href="coming-soon.html">Coming Soon Page</a></li>
								<li><a href="error-404.html">404 Error Page</a></li>		
							</ul>
						</li>
						<li><a href="about.html">About</a></li>
						<li><a href="contact.html">Contact</a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
		
		
		


