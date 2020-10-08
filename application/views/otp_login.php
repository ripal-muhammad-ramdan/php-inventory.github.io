<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="<?= base_url('assets/') ?>images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/util.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/main.css">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="<?= base_url('telegramBot/otpLog'); ?>">
                    <span class="login100-form-title p-b-26">
                        Authentication
                    </span>
                    <?= $this->session->flashdata('message'); ?>
                    <span class="login100-form-title p-b-48">
                        <i class="zmdi zmdi-font"></i>
                    </span>

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="username" value="<?= $this->session->userdata('username'); ?>" readonly>
                    </div>
                    <?php
                    form_error('username', '<small class="text-danger p-3">', '</small>');
                    ?>

                    <div class="wrap-input100 validate-input">
                        <div class="row">
                            <div class="col-sm-10">
                                <input class="input100" type="text" name="otpuser">
                                <span class="focus-input100 ml-3" data-placeholder="OTP"></span>
                            </div>
                            <div class="col-sm-2">
                                <a href="<?= base_url('telegramBot/reload') ?>"><i class="fa fa-refresh mt-3"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php
                    form_error('otpuser', '<small class="text-danger p-3">', '</small>');
                    ?>

                    <!-- <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="otpuser">
                        <span class="focus-input100" data-placeholder="OTP"></span>
                    </div>
                    <?php
                    form_error('otpuser', '<small class="text-danger p-3">', '</small>');
                    ?> -->

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="password" name="password">
                        <span class="focus-input100" data-placeholder="Password"></span>
                    </div>
                    <?php
                    form_error('password', '<small class="text-danger p-3">', '</small>');
                    ?>


                    <!-- <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="password">
                        <span class="focus-input100" data-placeholder="Password">
                        </span>
                    </div>
                    <?php
                    if (isset($_POST['password'])) {
                        form_error('password', '<small class="text-danger p-3">', '</small>');
                    } ?> -->
                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" type="submit">
                                Next
                            </button>
                        </div>
                    </div>

                    <div class="text-center p-t-50">
                        <div class="text-center">
                            <a class="small" href="<?= base_url('telegramBot/logOut'); ?>">Log Out</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="<?= base_url('assets/') ?>vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url('assets/') ?>vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/popper.js"></script>
    <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url('assets/') ?>vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url('assets/') ?>vendor/daterangepicker/moment.min.js"></script>
    <script src="<?= base_url('assets/') ?>vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url('assets/') ?>vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url('assets/') ?>js/main.js"></script>

</body>

</html>