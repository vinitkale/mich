<div class="container">
			<div class="login-box">
				<div class="login-header">
					<h4>Enter MWS Access Details</h4>
				</div>
				<div class="login-form">
					<form role="form" action="" method="post">
						<span class="text-danger"><?php echo $this->session->flashdata('error'); ?></span>
						<span class="text-success"><?php echo $this->session->flashdata('success'); ?></span>
						<p>&nbsp;</p>
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-pencil"></i></span>
							<input id="seller_id" name="seller_id" class="form-control" type="text" placeholder="Seller ID">
						</div>
							<span class="text-danger"><?php echo form_error('seller_id'); ?></span>
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-pencil"></i></span>
							<input id="marketplace_id" name="marketplace_id" class="form-control" type="text" placeholder="Marketplace ID">
						</div>
							<span class="text-danger"><?php echo form_error('marketplace_id'); ?></span>
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-pencil"></i></span>
							<input id="dev_account_no" name="aws_auth_token" class="form-control" type="text" placeholder="AWS auth token">
						</div>
							<span class="text-danger"><?php echo form_error('aws_auth_token'); ?></span>
							
						<div class="row">
							<div class="col-sm-12 cta">
							    <button class="btn btn-main btn-large" type="submit"><i class="icon-plus"></i> Submit</button>
								<a class="btn btn-main btn-large" href="<?php echo $strFacebookUrl; ?>"><i class="icon-facebook"></i> Facebook Auth</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>