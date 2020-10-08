<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LINEARICONS -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>fonts/linearicons/style.css">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/style.css">
</head>

<body>

    <div class="wrapper">
        <div class="inner">
            <img src="<?= base_url('assets/') ?>images/image-1.png" alt="" class="image-1">
            <form method="POST" action="<?= base_url('telegramBot/register') ?>">
                <h3>New Account?</h3>
                <?= $this->session->flashdata('message'); ?>
                <div class="form-holder">
                    <span class="lnr lnr-user"></span>
                    <input type="text" class="form-control" name="username" placeholder="Username">
                    <?= form_error('username', '<small class="text-danger p-3">', '</small>'); ?>
                </div>
                <div class="form-holder">
                    <span class="lnr lnr-pencil"></span>
                    <input type="text" class="form-control" name="chat_id" placeholder="Chat ID">
                    <?= form_error('chat_id', '<small class="text-danger p-3">', '</small>'); ?>
                </div>
                <div class="form-holder">
                    <span class="lnr lnr-book"></span>
                    <input type="text" class="form-control" name="token" placeholder="Token API Bot Telegram">
                    <?= form_error('token', '<small class="text-danger p-3">', '</small>'); ?>
                </div>
                <div class="form-holder">
                    <span class="lnr lnr-envelope"></span>
                    <input type="text" class="form-control" name="email" placeholder="Email">
                    <?= form_error('email', '<small class="text-danger p-3">', '</small>'); ?>
                </div>
                <div class="form-holder">
                    <span class="lnr lnr-lock"></span>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <?= form_error('password', '<small class="text-danger p-3">', '</small>'); ?>
                </div>
                <button type="submit">
                    <span>Register</span>
                </button>
                <a style="margin-left: 135px;" href="<?= base_url(); ?>">Login ?</a><br>

            </form>
            <a style="margin-left: 135px;color: white;" href="https://dion90.blogspot.com/2017/11/cara-mengetahui-id-chat-telegram.html">Belum tau chat ID nya?</a><br>
            <a style="color: white;" href="https://langsungviral.com/2019/12/04/cara-mendapatkan-api-key-atau-token-bot-telegram-dan-chat-id-telegram/">Belum punya bot Telegram yuk bikin!</a>
            <img src="<?= base_url('assets/') ?>images/image-2.png" alt="" class="image-2">
        </div>


    </div>

    <script src="<?= base_url('assets/') ?>js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>