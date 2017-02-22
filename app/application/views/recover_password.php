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
		  			<a class="navbar-brand" href="../"><img src="../includes/img/logo.png" style="height:27px;"class="img-responsive" alt=""></a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li class="visible-xs"><a href="<?php echo base_url('login'); ?>">Login</a></li>
                    				<li class="hidden-xs"><a href="<?php echo base_url('login'); ?>" class="btn btn-main btn-sm btn-header">Login</a></li>
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
						<p>Enter your email address below and we'll send a special reset password link to your inbox.</p>
						<div class="input-group">
							<span class="input-group-addon">@</span>
							<input id="username" name="email" class="form-control" type="text" placeholder="E-mail">
						</div>
							<span class="text-danger"><?= form_error('email'); ?></span>
						<div class="row">
							<div class="col-sm-12 cta">
							    <button type="submit" class="btn btn-main btn-large">Reset Password</button>
							</div>
						</div>				
					</form>
				</div>
			</div>
		</div>
