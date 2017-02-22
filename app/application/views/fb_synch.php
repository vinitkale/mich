<div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="<?= base_url('dashboard') ?>">Home</a> 
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Dashboard</span>
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
                        <h1 class="page-title">Dashboard
                        </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <?php if($this->session->flashdata('success')){ ?>
                                <div class="alert alert-success">
                                    <?= $this->session->flashdata('success'); ?>
                                </div>
                            <?php } ?>
                            <?php if($this->session->flashdata('error')){ ?>
                                <div class="alert alert-error">
                                    <?= $this->session->flashdata('error'); ?>
                                </div>
                            <?php } ?>
                            <div class="col-md-6">
                                <!-- BEGIN SAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                   <!--  <div class="portlet-title">
                                         <div class="caption">
                                            <span class="caption-subject sbold uppercase">Sync Status</span>
					    <a class="btn green" target='_blank' href="<?php echo $strFacebookUrl; ?>"><i class="icon-facebook"></i> Facebook Auth</a>
                                        </div> 
                                         <div class="actions">
                                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                                                <label class="btn btn-transparent red btn-outline btn-circle btn-sm active">
                                                    <input type="radio" name="options" class="toggle" id="option1">Actions</label>
                                                <label class="btn btn-transparent red btn-outline btn-circle btn-sm">
                                                    <input type="radio" name="options" class="toggle" id="option2">Settings</label>
                                            </div>
                                        </div> 
                                    </div>
 -->                                    <div class="portlet-body">
                                        <div class="table-scrollable">
                                            <table class="table table-hover table-light">
                                                <thead>
                                                    <tr>
                                                        <th> # </th>
                                                        <th> Marketplace </th>
                                                        <th> Contacts Synced </th>
                                                        <th> Status </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td> 1 </td>
                                                        <td> United States </td>
                                                        <td> <?php echo $usaOrderCount; ?> </td>
                                                        <td>
                                                        <?php ?>
                                                            <!-- <span class="label label-sm label-success"> Finished </span> -->
                                                            <?php if($usaOrderCount > 0){ ?>
                                                            <span class="label label-sm label-info"> Finished </span>
                                                            <?php }elseif(($arrRes['audience_id'] == '' || $arrRes['access_token'] == '')) { ?>
                                                            <span class="label label-sm label-danger"> Add FB</span>
                                                            <?php }elseif(FALSE == $mwsInfo){ ?>
                                                            <span class="label label-sm label-danger"> Add MWS </span>
                                                            <?php }elseif($usaOrderCount == 0){ ?>
                                                            <span class="label label-sm label-danger"> No Order </span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                   <?php if($caOrderCount > 0){ ?>
                                                    <tr>
                                                        <td> 2 </td>
                                                        <td> Canada </td>
                                                        <td> <?php echo $caOrderCount; ?> </td>
                                                                <td>
                                                        <?php ?>
                                                            <!-- <span class="label label-sm label-success"> Finished </span> -->
                                                            <?php if($caOrderCount > 0){ ?>
                                                            <span class="label label-sm label-info"> Finished </span>
                                                            <?php }elseif(($arrRes['audience_id'] == '' || $arrRes['access_token'] == '')) { ?>
                                                            <span class="label label-sm label-info"> Add FB</span>
                                                            <?php }elseif(FALSE == $mwsInfo){ ?>
                                                            <span class="label label-sm label-danger"> Add MWS </span>
                                                            <?php }elseif($caOrderCount == 0){ ?>
                                                            <span class="label label-sm label-danger"> No Order </span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                      <?php } ?>
                                                      <?php if($mxOrderCount > 0){ ?>
                                                    <tr>
                                                        <td> 3 </td>
                                                        <td> Maxico </td>
                                                        <td> <?php echo $mxOrderCount; ?> </td>
                                                                <td>
                                                        <?php ?>
                                                            <!-- <span class="label label-sm label-success"> Finished </span> -->
                                                            <?php if($mxOrderCount > 0){ ?>
                                                            <span class="label label-sm label-success"> Finished </span>
                                                            <?php }elseif(($arrRes['audience_id'] == '' || $arrRes['access_token'] == '')) { ?>
                                                            <span class="label label-sm label-danger"> Add FB</span>
                                                            <?php }elseif(FALSE == $mwsInfo){ ?>
                                                            <span class="label label-sm label-danger"> Add MWS </span>
                                                            <?php }elseif($mxOrderCount == 0){ ?>
                                                            <span class="label label-sm label-danger"> No Order </span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                      <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- END SAMPLE TABLE PORTLET-->
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