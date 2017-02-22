<!--<div class="container">
			<div class="login-box">
				<div class="login-header">
					<h4>Sign In to your account</h4>
				</div>
				<?php if($this->session->flashdata('error')){ ?>
				<div class="alert alert-danger">
				  <?php echo $this->session->flashdata('error'); ?>
				</div>
				<?php } ?>
				<div class="login-form">
				    <form role="form" action="" method="post">
						<div class="input-group">
							<span class="input-group-addon">@</span>
							<input id="username" required="" class="form-control" type="email" placeholder="E-mail" name="username">
							<span class="text-danger"><?php echo form_error('username'); ?></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-pencil"></i></span>
							<input id="password" required="" name="password"  class="form-control" type="password" placeholder="Password">
							<span class="text-danger"><?php echo form_error('password'); ?></span>
						</div>
						<div class="row">
							<div class="col-sm-12 remember-me">
								 <label class="checkbox"><input type="checkbox"> Remember me</label>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 cta">
							    <button class="btn btn-main btn-large" type="submit"><i class="icon-signin"></i> Sign In</button>
							</div>
						</div>
						<div class="related-links">
							<a href="recover-password.html">Forgot your password?</a>
							<h5>Don't have an account? <a href="<?php echo base_url('register') ?>">Sign Up</a></h5>
						</div>					
					</form>
				</div>
				<div class="login-footer">
					<a class="btn btn-block btn-twitter">
						<i class="icon-twitter"></i>
						Sign in with Twitter
					</a>
					<a class="btn btn-block btn-facebook">
						<i class="icon-facebook"></i>
						Sign in with Facebook
					</a>
				</div>
			</div>
		</div>-->
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
		  			<a class="navbar-brand" href="<?php echo base_url() ?>"><img src="../includes/img/logo.png" style="height:27px;"class="img-responsive" alt=""></a>
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
					<h4>Sign In to your account</h4>
				</div>
			    <?php if($this->session->flashdata('error')){ ?>
				<div class="alert alert-danger">
				  <?php echo $this->session->flashdata('error'); ?>
				</div>
				<?php } ?>
				 <?php if($this->session->flashdata('success')){ ?>
				<div class="alert alert-success">
				  <?php echo $this->session->flashdata('success'); ?>
				</div>
				<?php } ?>
				<div class="login-form">
					<form role="form" action="" method="post">
						<div class="input-group">
							<span class="input-group-addon">@</span>
							<input id="username" class="form-control" name="username" type="email" placeholder="E-mail">
							<span class="text-danger"><?php echo form_error('username'); ?></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-pencil"></i></span>
							<input id="password" name="password" class="form-control" type="password" placeholder="Password">
							<span class="text-danger"><?php echo form_error('password'); ?></span>
						</div>
						<div class="row">
							<div class="col-sm-12 cta">
								<button class="btn btn-main btn-large"><i class="icon-signin"></i> Sign In</button>
							</div>
						</div>
						<div class="related-links">
							<a href="<?php echo base_url('login/forgotPass'); ?>">Forgot your password?</a>
							<h5>Don't have an account? <a href="<?php echo base_url('register') ?>">Sign Up</a></h5>
						</div>					
					</form>
				</div>
				<!--<div class="login-footer">
					<a class="btn btn-block btn-twitter">
						<i class="icon-twitter"></i>
						Sign in with Twitter
					</a>
					<a class="btn btn-block btn-facebook">
						<i class="icon-facebook"></i>
						Sign in with Facebook
					</a>
				</div>-->
			</div>
		</div>
     
		
