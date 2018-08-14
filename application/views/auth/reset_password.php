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
    <p class="login-box-msg">Masukkan email kamu</p>

    <form id="reset-form" action="<?php echo base_url('reset_password') ?>" method="post">
      <div class="form-group has-feedback">
        <input type="email" id="email" required name="email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
        </div>
        <div class="col-xs-4">
          <button type="submit" id="btn-reset" class="btn btn-primary btn-block btn-flat">Kirim</button>
        </div>
      </div>
    </form>
    <a href="<?php echo base_url('login') ?>" class="text-center">Kembali</a>
  </div>
</div>
<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/icheck.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jQuery.toast.js') ?>"></script>
<script type="text/javascript">
var url = '<?php echo base_url('api/reset_password') ?>';

function notifikasi(tipe, pesan) {
    $.toast({
        text: pesan,
        showHideTransition: 'slide',
        position: 'top-right',
        icon: tipe,
        loaderBg: '#f3675b'
    })
}

$("#reset-form").on('submit', (function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: url,
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('#btn-reset').html('<i class="fa fa-spin fa-spinner"></i>');
            $("#btn-reset").prop('disabled', true);
        }
    }).done(function(respon) {
        if (respon.status == true) {
            notifikasi('success', 'mengalihkan halaman...');
            setTimeout(' window.location.href = "' + respon.message + '"; ', 500);
        } else {
            $("#btn-reset").prop('disabled', false);
            $('#btn-reset').html('Kirim');
            notifikasi('error', respon.message)
        }
    }).fail(function(response) {
        $("#btn-reset").prop('disabled', false);
        $('#btn-reset').html('Kirim');
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
