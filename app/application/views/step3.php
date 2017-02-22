<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
    <div class="page-wrapper">
	<!-- BEGIN HEADER -->
	<div class="page-header navbar navbar-fixed-top">
	    <!-- BEGIN HEADER INNER -->
	    <div class="page-header-inner ">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
		    <a href="<?php echo base_url('dashboard') ?>">
			<img src="../admin-assets/layouts/layout/img/logo.png" alt="logo" class="logo-default" /> </a>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		    <span></span>
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<div class="top-menu">
		    <ul class="nav navbar-nav pull-right">
			<!-- END USER LOGIN DROPDOWN -->
		    </ul>
		</div>
		<!-- END TOP NAVIGATION MENU -->
	    </div>
	    <!-- END HEADER INNER -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN HEADER & CONTENT DIVIDER -->
	<div class="clearfix"> </div>
	<!-- END HEADER & CONTENT DIVIDER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container">
	    <!-- BEGIN CONTENT -->
	    <div class="page-content-wrapper">
		<!-- BEGIN CONTENT BODY -->
		<div class="page-content setup-page-content">
                    <!-- SETUP CONTAINER -->
                    <div class="setup-container">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title setup-page-title">Account Setup
                        </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN PROGRESS BARS PORTLET-->
				<div class="portlet-body">
				    <div class="progress progress-striped active">
					<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
					    <span class="sr-only"> 60% Complete (success) </span>
					</div>
				    </div>
				</div>
                                <!-- END PROGRESS BARS PORTLET-->
                            </div>
                        </div>
			<img src="../admin-assets/pages/img/tut3.jpg" alt="tutorial1" width="600px"/>
			<p><strong>Step 3: </strong>Enter your MWS credentials:</p>
			<form role="form" action="" method="post">
			    <div class="form-group">
				<label class="control-label">Seller ID</label>
				<input type="text" id="seller_id" name="seller_id"  placeholder="Your Seller ID" class="form-control" value="<?php if(!empty($mwsInfo)){ echo $mwsInfo['seller_id'];} ?>" />
			    </div>
			    <span class="text-danger"><?php echo form_error('seller_id'); ?></span>
			    <div class="form-group">
				<label class="control-label">Marketplace ID</label>
				<input type="text" value="<?php if(!empty($mwsInfo)){ echo $mwsInfo['marketplace_id'];} ?>" id="marketplace_id"  name="marketplace_id"  class="form-control" placeholder="Marketplace ID" />
			    </div>
			    <span class="text-danger"><?php echo form_error('marketplace_id'); ?></span>
			    <div class="form-group">
				<label class="control-label">MWS Auth Token</label>
				<input value="<?php if(!empty($mwsInfo)){ echo $mwsInfo['aws_auth_token'];} ?>" id="aws_auth_token" name="aws_auth_token" type="text" placeholder="Your MWS Token" class="form-control" />
				<span class="text-danger"><?php echo form_error('aws_auth_token'); ?></span>
			    </div>
			    <div class="margin-top-10">
				<a href="<?php echo base_url('home/step2'); ?>" class="btn default"> Back </a>
				<button class="btn green"> Next </button>
			    </div>
			</form>

                    </div>
                    <!-- SETUP CONTAINER -->
                    <!-- END CONTENT BODY -->
		    <!-- END CONTENT -->
		</div>
		<!-- END CONTAINER -->
		<!-- BEGIN FOOTER -->
		<div class="page-footer">
		    <div class="page-footer-inner"> 2017 &copy; Azon Software. All rights reserved.
		    </div>
		    <div class="scroll-to-top">
			<i class="icon-arrow-up"></i>
		    </div>
		</div>
		<!-- END FOOTER -->
	    </div>
	    <!--[if lt IE 9]>
    <script src="../admin-assets/global/plugins/respond.min.js"></script>
    <script src="../admin-assets/global/plugins/excanvas.min.js"></script> 
    <script src="../admin-assets/global/plugins/ie8.fix.min.js"></script> 
    <![endif]-->