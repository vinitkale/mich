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
                    <span>Contact</span>
                </li>
            </ul>
            <div class="page-toolbar">
            </div>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> Contact Us
        </h1>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-6">
                <div class="c-contact">
                    <div class="c-content-title-1">
                        <h3 class="uppercase">Get in Touch</h3>
                        <div class="c-line-left bg-dark"></div>
                        <p class="c-font-lowercase">Got any issues? Or you want to submit a feature request or other
                            inquiry. Just contact us through the form below or directly by email to <a
                                href="mailto:contact@azonsoftware.com">contact@azonsoftware.com.</a></p>
                    </div>
                    <form action="" method="post">
                        <div class="form-group">
                            <input  type="text" name="name" placeholder="Your Name"
                                   class="form-control input-md"></div>
                        <span class="text-danger"><?php echo form_error('name'); ?></span>
                        <div class="form-group">
                            <input  type="email" name="email" placeholder="Your Email"
                                   class="form-control input-md"></div>
                        <span class="text-danger"><?php echo form_error('email'); ?></span>
                        <div class="form-group">
                            <textarea  rows="8" name="message" placeholder="Write comment here ..."
                                      class="form-control input-md"></textarea>
                            <span class="text-danger"><?php echo form_error('message'); ?></span>
                        </div>
                        <button type="submit" class="btn green">Submit</button>
                        <span class="text-success"><?php echo $this->session->flashdata('message'); ?></span>
                    </form>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
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
</body>