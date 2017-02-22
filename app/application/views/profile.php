<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="<?= base_url('fbSynch'); ?>">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Profile</span>
                </li>
            </ul>
            <div class="page-toolbar">
                <!--<div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                    <i class="icon-calendar"></i>&nbsp;
                    <span class="thin uppercase hidden-xs"></span>&nbsp;
                    <i class="fa fa-angle-down"></i>
                </div>-->
            </div>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title">Profile
        </h1>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PROFILE SIDEBAR -->
                <div class="profile-sidebar">
                </div>
                <!-- END BEGIN PROFILE SIDEBAR -->
                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span
                                            class="caption-subject font-blue-madison bold uppercase">Account Profile</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_2" data-toggle="tab">Change Password</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <!-- PERSONAL INFO TAB -->
                                        <div class="tab-pane active" id="tab_1_1">
					    <?php if($this->session->flashdata('success')){ ?>
					    <div class="alert alert-success">
						<?= $this->session->flashdata('success'); ?>
					    </div>
					    <?php } ?>
                                            <form role="form" action="" method="post">
                                                <div class="form-group">
                                                    <label class="control-label">First Name</label>
                                                    <input name="first_name" value="<?php if (!empty($userInfo)) {
                                                        echo $userInfo['first_name'];
                                                    } ?>" type="text" placeholder="Your First Name"
                                                           class="form-control"/></div>
                                                <div class="form-group">
                                                    <label class="control-label">Last Name</label>
                                                    <input name="last_name" value="<?php if (!empty($userInfo)) {
                                                        echo $userInfo['last_name'];
                                                    } ?>" type="text" placeholder="Your Last Name"
                                                           class="form-control"/></div>
                                                <div class="form-group">
                                                    <label class="control-label">Email</label>
                                                    <input name="email" value="<?php if (!empty($userInfo)) {
                                                        echo $userInfo['email'];
                                                    } ?>" type="email" placeholder="Your Email" class="form-control"/>
						    <span class="text-danger"><?= form_error('email'); ?></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Company</label>
                                                    <input name="company" value="<?php if (!empty($userInfo)) {
                                                        echo $userInfo['company'];
                                                    } ?>" type="text" placeholder="Company Name" class="form-control"/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Website Url</label>
                                                    <input name="website_url" value="<?php if (!empty($userInfo)) {
                                                        echo $userInfo['website_url'];
                                                    } ?>" type="text" placeholder="http://www.company.com"
                                                           class="form-control"/></div>
                                                <div class="margiv-top-10">
                                                    <button class="btn green" type="submit"> Save Changes </button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- END PERSONAL INFO TAB -->
                                        <!-- CHANGE PASSWORD TAB -->
                                        <div class="tab-pane" id="tab_1_2">
                                            <form action="<?php echo base_url('home/changePassword'); ?>" method="post">
                                                <div class="form-group">
                                                    <label class="control-label">Current Password</label>
                                                    <input name="old_password" type="password" class="form-control"/>
						    <span class="text-danger"><?= form_error('old_password'); ?></span>
						</div>
                                                <div class="form-group">
                                                    <label class="control-label">New Password</label>
                                                    <input name="new_password" type="password" class="form-control"/>
						    <span class="text-danger"><?= form_error('new_password'); ?></span>
						</div>
                                                <div class="form-group">
                                                    <label class="control-label">Re-type New Password</label>
                                                    <input name="confirm_password" type="password" class="form-control"/>
						    <span class="text-danger"><?= form_error('confirm_password'); ?></span>
						</div>
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green"> Change Password </button>
                                                    <button type="reset" class="btn default"> Cancel </button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- END CHANGE PASSWORD TAB -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
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
</body>