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
                                    <span>Settings</span>
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
                        <h1 class="page-title">Settings
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
                                                        <span class="caption-subject font-blue-madison bold uppercase">API Settings</span>
                                                    </div>
                                                   <ul class="nav nav-tabs">
                                                        <li class="active">
                                                            <a href="#tab_1_1" data-toggle="tab">MWS North America</a>
                                                        </li>
                                                        <!--<li>
                                                            <a href="#tab_1_2" data-toggle="tab">MWS Europe</a>
                                                        </li>-->
                                                     <li>
                                                            <a href="#tab_1_3" data-toggle="tab">Facebook API</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="tab-content">
                                                        <!-- MWS NORTH AMERICA TAB -->
                                                        <div class="tab-pane active" id="tab_1_1">
                                                            <p class="pull-right"><a href="<?= base_url('home/step1'); ?>">Show me How</a></p>
                                                            <form role="form" action="#">
                                                                <div class="form-group">
                                                                    <label class="control-label">Seller ID</label>
                                                                    <input value="<?php if(!empty($mwsInfo)){ echo $mwsInfo['seller_id'];} ?>" type="text" placeholder="Your Seller ID" class="form-control" /> </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Market Place ID</label>
                                                                    <input value="<?php if(!empty($mwsInfo)){ echo $mwsInfo['marketplace_id'];} ?>" type="text" placeholder="Market Place ID" class="form-control" /> </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">MWS Auth Token</label>
                                                                    <input value="<?php if(!empty($mwsInfo)){ echo $mwsInfo['aws_auth_token'];} ?>" type="text" placeholder="Your MWS Token" class="form-control" /> </div>
                                                                <!--<div class="margiv-top-10">
                                                                    <a href="javascript:;" class="btn green"> Save Changes </a>
                                                                    <a href="javascript:;" class="btn default"> Cancel </a>
                                                                </div>-->
                                                            </form>
                                                        </div>
                                                        <!-- END MWS NORTH AMERICA TAB -->
                                                        <!-- MWS EUROPE TAB -->
                                                        <!--<div class="tab-pane" id="tab_1_2">
                                                            <p class="pull-right"><a href="setup.html">Show me How</a></p>
                                                             <form role="form" action="#">
                                                                <div class="form-group">
                                                                    <label class="control-label">Seller ID</label>
                                                                    <input type="text" placeholder="Your Seller ID" class="form-control" /> </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">MWS Auth Token</label>
                                                                    <input type="text" placeholder="Your MWS Token" class="form-control" /> </div>
                                                            </form>
                                                        </div>-->
                                                        <!-- END MWS EUROPE TAB -->
                                                        <!-- FACEBOOK API TAB -->
                                                        <div class="tab-pane" id="tab_1_3">
                                                            <!-- <p class="pull-right"><a href="setup4.html">Show me How</a></p> -->
                                                           
                                                                <div class="form-group">
                                                                   <strong>Go To Facebook Tutorial:</strong>
                        <a class="btn green"  href="<?php echo base_url('home/step4'); ?>"><i class="icon-facebook"></i> FB Tutorial</a> 
                                                                    </div>
                                                          
                                                        </div>
                                                        <!-- END CFACEBOOK API TAB -->
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