<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Masuk | <?php echo pengaturan('nama_aplikasi') ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/AdminLTE.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/iCheck_square_blue.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/jQuery.toast.css') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo base_url() ?>"><?php echo pengaturan('nama_aplikasi') ?></a>
  </div>
  <?php if ($this->session->flashdata('info')): ?>
    <div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <?php echo $this->session->flashdata('info') ?>
    </div>
  <?php endif; ?>
  <?php if ($this->session->flashdata('sukses')): ?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <?php echo $this->session->flashdata('sukses') ?>
    </div>
  <?php endif; ?>
  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <?php echo $this->session->flashdata('error') ?>
    </div>
  <?php endif; ?>
  <div class="login-box-body">
    <p class="login-box-msg">Masuk untuk memulai session kamu</p>

    <form id="signin-form" action="<?php echo base_url('login') ?>" method="post">
      <div class="form-group has-feedback">
        <input type="email" id="email" required name="email" <?php if ($this->input->get('email')) { echo 'value="' . $this->input->get('email') . '"';} ?> class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" id="password" required name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input id="rememberme" name="rememberme" type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <div class="col-xs-4">
          <button type="submit" id="btn-signin" class="btn btn-primary btn-block btn-flat">Masuk</button>
        </div>
      </div>
      <?php if ($this->input->get('target')): ?>
        <input type="hidden" name="target" value="<?php echo urlencode($this->input->get('target')) ?>">
      <?php endif; ?>
    </form>
    <div class="social-auth-links text-center">
      <?php if (pengaturan('fb_login') == 1 || pengaturan('g_login') == 1 || pengaturan('git_login') == 1 || pengaturan('tw_login') == 1): ?>
        <p>- ATAU -</p>
      <?php endif; ?>
      <?php if (pengaturan('fb_login') == 1): ?>
        <button type="button" onClick="window.location = '<?php echo base_url('auth/facebook') ?>';" class="btn btn-block btn-social btn-facebook btn-flat">
          <i class="fa fa-facebook"></i> Masuk dengan
        Facebook</button>
      <?php endif; ?>
      <?php if (pengaturan('g_login') == 1): ?>
        <button type="button" onClick="window.location = '<?php echo base_url('auth/google') ?>';" class="btn btn-block btn-social btn-google btn-flat">
          <i class="fa fa-google-plus"></i>Masuk dengan
          Google+</button>
      <?php endif; ?>
      <?php if (pengaturan('git_login') == 1): ?>
        <button type="button" onClick="window.location = '<?php echo base_url('auth/github') ?>';" class="btn btn-block btn-social btn-github btn-flat">
          <i class="fa fa-github"></i>Masuk dengan
          GitHub</button>
      <?php endif; ?>
      <?php if (pengaturan('tw_login') == 1): ?>
        <button type="button" onClick="window.location = '<?php echo base_url('auth/twitter') ?>';" class="btn btn-block btn-social btn-twitter btn-flat">
          <i class="fa fa-twitter"></i>Masuk dengan
          Twitter</button>
      <?php endif; ?>

    </div>
    <a href="<?php echo base_url('daftar') ?>" class="text-center">Daftar member baru</a>
    <br>
    <a href="<?php echo base_url('reset_password') ?>" >Lupa password?</a>

  </div>

</div>
<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/icheck.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jQuery.toast.js') ?>"></script>
<script type="text/javascript">
var url = '<?php echo base_url('api/login') ?>';

function notifikasi(tipe, pesan) {
    $.toast({
        text: pesan,
        showHideTransition: 'slide',
        position: 'top-right',
        icon: tipe,
        loaderBg: '#f3675b'
    })
}

$("#signin-form").on('submit', (function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: url,
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('#btn-signin').html('<i class="fa fa-spin fa-spinner"></i>');
            $("#btn-signin").prop('disabled', true);
        }
    }).done(function(respon) {
        if (respon.status == true) {
            notifikasi('success', 'mengalihkan halaman...');
            setTimeout(' window.location.href = "' + respon.message + '"; ', 500);
        } else {
            $("#btn-signin").prop('disabled', false);
            $('#btn-signin').html('Masuk');
            $('#password').val('');
            notifikasi('error', respon.message)
        }
    }).fail(function(response) {
        $("#btn-signin").prop('disabled', false);
        $('#btn-signin').html('Masuk');
        notifikasi('error', 'Maaf sistem kami ada kesalahan :(')
    });
}));
</script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%'
    });
  });
</script>
</body>
</html>
