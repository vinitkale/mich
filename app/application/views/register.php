<!--<div class="container">
			<div class="login-box">
				<div class="login-header">
					<h4>Create Account</h4>
				</div>
				<div class="login-form">
					<form role="form" action="" method="post">
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-user"></i></span>
							<input id="name" name="full_name" required="" class="form-control" type="text" placeholder="Full Name">
						</div>
							<span class="text-danger"><?php echo form_error('full_name'); ?></span>
						<div class="input-group">
							<span class="input-group-addon">@</span>
							<input id="email" name="email" required="" class="form-control" type="email" placeholder="E-mail">
						</div>
							    <span class="text-danger"><?php echo form_error('email'); ?></span>
						<div class="row">
							<div class="col-sm-12 cta">
							    <button class="btn btn-main btn-large" type="submit"><i class="icon-plus"></i> Sign Up</button>
							</div>
						</div>
						<div class="related-links">
							<h5>Already registered? <a href="<?php echo base_url('login') ?>">Sign In</a></h5>
						</div>					
					</form>
				</div>
			        <?php if($this->session->flashdata('success')){ ?>
    
				<div class="alert alert-success">
				  <?php echo $this->session->flashdata('success'); ?>
				</div>
				<?php } ?>
			        <?php if($this->session->flashdata('error')){ ?>
    
				<div class="alert alert-danger">
				  <?php echo $this->session->flashdata('error'); ?>
				</div>
				<?php } ?>
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
					<h4>Create your account</h4>
				</div>
				<div class="login-form">
					<form role="form" action="" method="post">
						
						<div class="input-group">
							<span class="input-group-addon">@</span>
							<input id="username" name="email" value="<?php echo set_value('email'); ?>" class="form-control" type="email" placeholder="E-mail">
							
						</div>
					    <span class="text-danger"><?php echo form_error('email'); ?></span>
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-pencil"></i></span>
							<input id="password" name="password" class="form-control" type="password" placeholder="Password">
							
						</div>
					    <span class="text-danger"><?php echo form_error('password'); ?></span>
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-pencil"></i></span>
							<input id="password2" name="password2" class="form-control" type="password" placeholder="Repeat Password">
							
						</div>
					    <span class="text-danger"><?php echo form_error('password2'); ?></span>
						
						<div class="row">
							<div class="col-sm-12 cta">
								<button class="btn btn-main btn-large"><i class="icon-plus"></i> Sign Up</button>
							</div>
						</div>
						<div class="related-links">
							<h5>Already registered? <a href="<?php echo base_url('login') ?>">Login</a></h5>
						</div>					
					</form>
				</div>
			    <?php if($this->session->flashdata('success')){ ?>
    
				<div class="alert alert-success">
				  <?php echo $this->session->flashdata('success'); ?>
				</div>
				<?php } ?>
			        <?php if($this->session->flashdata('error')){ ?>
    
				<div class="alert alert-danger">
				  <?php echo $this->session->flashdata('error'); ?>
				</div>
				<?php } ?>
			</div>
		</div>