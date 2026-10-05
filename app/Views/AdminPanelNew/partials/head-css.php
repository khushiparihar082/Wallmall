<style>
    <?= $_head_css_code ?>input,
    .tox-editor-container,
    .select2 {
        border: solid #0000000f !important;
    }

    .form-check-input {
        border: solid #00000033 !important;
    }

    .optgroup-header {
        color: red !important;
        font-weight: 600;
    }


    .custom-swal-popup {
        height: 70% !important;
        /* Adjust the height as needed */
        max-height: 70% !important;
        /* Ensure the popup does not exceed the viewport height */
        top: 0% !important;
        /* Adjust top positioning */
        bottom: auto !important;
        /* Adjust bottom positioning */
    }





    .table_btn_div button,
    .buttons-copy,
    .buttons-excel,
    .buttons-pdf,
    .buttons-colvis,
    .all_btn,
    .buttons-csv {
        margin-right: 10px;
        font-weight: 500;
        margin-right: 10px;
        border: none !important;
        border-radius: 3px !important;
        font-size: 12px;
        font-family: "Montserrat", sans-serif;
    }

    .buttons-copy,
    .add_form_btn {
        background: #f9f2cbb0 !important;
        color: #5d5a5a !important;
    }

    .buttons-excel {
        background: #e6faff !important;
        color: #5d5a5a !important;
    }

    .buttons-print {
        background: #5e96fd !important;
        color: #5d5a5a !important;
    }

    .buttons-pdf {
        background: #ffefef !important;
        color: #5d5a5a !important;
    }

    .buttons-colvis {
        background: #e5f7e2 !important;
        color: #5d5a5a !important;
    }

    .cke_notifications_area{
        display: none !important;
    }

    .buttons-copy:hover,
    .add_form_btn:hover {
        background: #fae98a !important;
        color: #5d5a5a !important;
    }

    .buttons-excel:hover {
        background: #a1e4f5 !important;
        color: #5d5a5a !important;
    }

    .buttons-print:hover {
        background: #1868fc !important;
        color: #5d5a5a !important;
    }

    .buttons-pdf:hover {
        background: #f9b2b2 !important;
        color: #5d5a5a !important;
    }


    .buttons-colvis:hover {
        background: #c7ffbe !important;
        color: #5d5a5a !important;
    }
</style>
<link href="<?= base_url($_assets_path . 'assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') ?>" rel="stylesheet" type="text/css" />
<!-- Bootstrap Css -->
<link href="<?= base_url($_assets_path . 'assets/css/bootstrap.min.css') ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- toastr -->
<link href="<?= base_url($_assets_path . 'assets/libs/toastr/toastr.min.css') ?>" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="<?= base_url($_assets_path . 'assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="<?= base_url($_assets_path . 'assets/css/app.min.css') ?>" id="app-style" rel="stylesheet" type="text/css" />
<!-- custom  css-->
<link href="<?= base_url($_assets_path . 'assets/css/custom.css') ?>" id="app-style" rel="stylesheet" type="text/css" />
<link href="<?= base_url($_assets_path . 'assets/css/new_app.css') ?>" id="app-style" rel="stylesheet" type="text/css" />
<!-- image upload css -->
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.css' integrity='sha512-Y+AaVWdRf6zsGm7eV+EGOIuqYZoi2wUQ7wF8oHbnLy8k2zdVGSxyjn2qDUMFkLRy/9mqOAE5BeyEqx1yxDTQIw==' crossorigin='anonymous' />
<!-- Dynamic Css Load -->
<?php if (isset($_head_css_files) && is_array($_head_css_files)) : ?>
    <?php foreach ($_head_css_files as $key => $_head_css_file) : ?>
        <?php if (is_string($_head_css_file)) : ?>
            <link href="<?= base_url($_head_css_file) ?>" id="app-style" rel="stylesheet" type="text/css" />
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<link href="<?= base_url($_assets_path . 'assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url($_assets_path . 'assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') ?>" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->

<link href="<?= base_url($_assets_path . 'assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
<link rel="shortcut icon" href="<?= base_url($_assets_path . 'assets/images/favicon.svg') ?>" type="image/x-icon">
