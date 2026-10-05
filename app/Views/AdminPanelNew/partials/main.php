<!doctype html>
<html lang="<?php
            $session = \Config\Services::session();
            $lang = $session->get('lang');
            echo $lang;
            ?>">

<head>
    <script src="<?= base_url($_assets_path . 'assets/libs/jquery/jquery.min.js') ?>"></script>
    <?= view($_partials_path . 'title-meta') ?>
    <?= view($_partials_path . 'head-css') ?>
    <?= view($_partials_path . 'FirebaseMessagingNotification') ?>
    <?= view($_partials_path . 'head-js') ?>
</head>
<?= view($_partials_path . 'body') ?>
<div class="container-fluid">
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?= view($_partials_path . 'topbar') ?>
        <?= view($_partials_path . 'sidebar') ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <?= view($_partials_path . 'page-title') ?>
                <!-- main page -->
                <?php if (isset($_view_files) && is_array($_view_files)) : ?>
                    <?php foreach ($_view_files as $key => $view_file) : ?>
                        <?php if (is_string($view_file)) : ?>
                            <div class="view_file_<?= $key ?>">
                                <?= view($view_file) ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <!-- End Page-content -->
            <?= view($_partials_path . 'footer') ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
</div>
<!-- end container-fluid -->

<?= view($_partials_path . 'right-sidebar') ?>

<!-- JAVASCRIPT -->
<?= view($_partials_path . 'vendor-scripts') ?>
</body>
<?= view($_partials_path . 'script') ?>

</html>