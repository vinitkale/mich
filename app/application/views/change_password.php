<body>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WF7N6Q4"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		<!-- Start Navigation-->
		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="..navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo base_url() ?>"><img src="<?= base_url(); ?>/includes/img/logo.png" style="height:27px;"class="img-responsive" alt=""></a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li class="visible-xs"><a href="<?php echo base_url('login') ?>">Login</a></li>
						<li class="hidden-xs"><a href="<?php echo base_url('login') ?>" class="btn btn-main btn-sm btn-header">Login</a></li>
					</ul>
				</div>
			</div>
		</div>
       <!-- End Navigation-->
		
		<div class="container">
			<div class="login-box">
				<div class="login-header">
					<h4>Reset your password</h4>
				</div>
			     <?php if($this->session->flashdata('error')){ ?>
				<div class="alert alert-danger">
				  <?php echo $this->session->flashdata('error'); ?>
				</div>
				<?php }
				if($this->session->flashdata('success')){ ?>
			    <div class="alert alert-success">
				  <?php echo $this->session->flashdata('success'); ?>
				</div>
				<?php } ?>
				<div class="login-form">
					<form role="form" action="" method="post">
						<p>Please enter password and confirm password.</p>
						<input type="hidden" value="<?php echo $userid ;?>" name="userid">
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-key"></i></span>
							<input id="password" name="password" required="" class="form-control" type="password" placeholder="Password">
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-key"></i></span>
							<input id="passconf" name="passconf" required="" class="form-control" type="password" placeholder="Confrim Password">
						</div>
						<span class="text-danger"><?php echo form_error('password'); ?></span>
						<div class="row">
							<div class="col-sm-12 cta">
							    <button type="submit" class="btn btn-main btn-large">Reset Password</button>
							</div>
						</div>				
					</form>
				</div>
			</div>
		</div>
