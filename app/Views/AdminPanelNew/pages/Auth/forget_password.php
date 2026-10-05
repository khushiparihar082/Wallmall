<!doctype html>
<html lang="<?php
            $session = \Config\Services::session();
            $lang = $session->get('lang');
            echo $lang;
            ?>">

</html>

<head>
    <title>Forget Password</title>
    <!-- Include necessary CSS and JS files -->
    <link href="AdminPanelNew/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="AdminPanelNew/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="AdminPanelNew/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="AdminPanelNew/assets/css/custom.css" id="app-style" rel="stylesheet" type="text/css" />
    <script src="AdminPanelNew/assets/libs/jquery/jquery.min.js"></script>
    <link href="AdminPanelNew/assets/libs/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
    <script src="AdminPanelNew/assets/libs/toastr/toastr.min.js"></script>
    <script src="AdminPanelNew/assets/js/comman.js"></script>
    <style>
        .error-message {
            color: red;
        }

        .error-message-box,
        .success-message-box {
            padding: 12px 0;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            font-variant: all-small-caps;
            box-shadow: 0px -2px 5px #98bf98 inset;
        }

        .error-message-box {
            background-color: #ff1c1c47;
            color: #851616;
        }

        .success-message-box {
            background-color: #c0edc0;
            color: #16852a;
        }
    </style>
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-login text-center">
                            <div class="bg-login-overlay"></div>
                            <div class="position-relative">
                                <h5 class="text-white font-size-20">Forget Password</h5>
                                <a href="/" class="logo logo-admin mt-4">
                                    <img src="AdminPanelNew/assets/images/hillmen-icon.png" alt="logo-sm-dark" height="30">
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="p-2">
                                <div class="error-message-box d-none">
                                    <p id="error-message"></p>
                                </div>
                                <div class="success-message-box d-none">
                                    <p id="success-message"></p>
                                </div>
                                <form id="form" name="form" class="form-horizontal" enctype="multipart/form-data" method="post">
                                    <div class="mb-3" id="username-div">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" value="<?= @$username ?>">
                                        <span class="error-message" id="error-username"></span>
                                    </div>

                                    <div class="d-none" id="otp-password-section">
                                        <div class="mb-3">
                                            <label class="form-label" for="otp">OTP</label>
                                            <input type="text" class="form-control" name="otp" id="otp" placeholder="Enter OTP">
                                            <span class="error-message" id="error-otp"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="password">New Password</label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter new password">
                                            <span class="error-message" id="error-password"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="confirm_password">Confirm Password</label>
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm new password">
                                            <span class="error-message" id="error-confirm_password"></span>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button id="otp-btn" class="btn btn-primary w-100 waves-effect waves-light" type="button" onclick="sendOtp()">Send Otp</button>
                                        <button id="password-btn" class="btn btn-primary w-100 waves-effect waves-light d-none" type="button" onclick="passwordChange()">Update Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include necessary JS files -->
    <script src="AdminPanelNew/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="AdminPanelNew/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="AdminPanelNew/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="AdminPanelNew/assets/libs/node-waves/waves.min.js"></script>
    <script src="AdminPanelNew/assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="AdminPanelNew/assets/js/app.js"></script>
    <script>
        function sendOtp() {
            $('#form').attr('action', '<?= base_url(route_to('UserForgetPasswordOtpSend')) ?>');
            submitFormWithAjax('form', true, true, successCallbackOtp, errorCallbackOtp)
        }

        function successCallbackOtp(response) {
            if (response.status == 200) {
                $('#otp-password-section').removeClass('d-none');
                $('#otp-btn').addClass('d-none');
                $('#password-btn').removeClass('d-none');
                $('#username-div').addClass('d-none');
            }
        }

        function errorCallbackOtp(response) {

        }

        function passwordChange() {
            $('#form').attr('action', '<?= base_url(route_to('UserForgetPasswordUpdate')) ?>');
            submitFormWithAjax('form', true, true, successCallbackPassword, errorCallbackPassword)
        }

        function successCallbackPassword(response) {
            if (response.status == 200) {
                window.location.href = "<?= base_url(route_to('admin_login_page')) ?>";
            }
        }

        function errorCallbackPassword(response) {}
    </script>
</body>

</html>