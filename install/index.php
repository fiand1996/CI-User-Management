<?php
// if (file_exists('../application/config/config.php') OR
// 		file_exists('../application/config/database.php')
// ) {
//     header('Location:../');
// }
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Instalasi</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="http://localhost/user-management/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://localhost/user-management/assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="http://localhost/user-management/assets/css/AdminLTE.min.css">
  <link rel="stylesheet" href="http://localhost/user-management/assets/css/iCheck_square_blue.css">
  <link rel="stylesheet" href="http://localhost/user-management/assets/css/jQuery.toast.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <form class="" action="" method="post">
  <div class="box box-widget widget-user-2 no-margin flat">
    <div class="widget-user-header bg-blue flat">
      <h3 class="widget-user-username no-margin">Selamat datang di halaman instalasi :)</h3>
      <h5 id="judul" class="widget-user-desc no-margin"></h5>
    </div>
    <div class="info-box bg-red no-margin flat">
            <span class="info-box-icon"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">User Management System</span>
              <span class="info-box-number">Versi 1.0</span>
              <span class="progress-description">fiand@programmer.net</span>
            </div>

            <!-- /.info-box-content -->
          </div>
          <button type="button" id="btn_mulai" class="btn bg-blue btn-primary btn-block btn-flat">MULAI</button>
    </form>
</div>
</div>

<script src="http://localhost/user-management/assets/js/jquery.min.js"></script>
<script src="http://localhost/user-management/assets/js/bootstrap.min.js"></script>
<script src="http://localhost/user-management/assets/js/icheck.min.js"></script>
<script src="http://localhost/user-management/assets/js/jQuery.toast.js"></script>
<script type="text/javascript">
var url = 'http://localhost/user-management/api/login';

function notifikasi(tipe, pesan) {
    $.toast({
        text: pesan,
        showHideTransition: 'slide',
        position: 'top-right',
        icon: tipe,
        loaderBg: '#f3675b'
    })
}

function ganti_badge(nama, status){

  if (status == false) {
    var i = '<i class="fa fa-close"></i>';
    var w = 'bg-red';
  }
  else {
    var i = '<i class="fa fa-check"></i>';
    var w = 'bg-green';
  }
  $('#' + nama).html(i);
  $('#' + nama).removeClass('bg-grey').addClass(w);
}

$("#halaman-database").hide();
$("#btn_lanjut1").hide();
$("#btn_database").hide();
$("#halaman-tambahadmin").hide();

$('#btn_mulai').click(function(){
  $.ajax({
      type: "POST",
      url: 'install.php',
      data: {'halaman_requirement' : true},
      beforeSend: function() {
            $('#btn_mulai').html('<i class="fa fa-spin fa-spinner"></i>');
            $("#btn_mulai").prop('disabled', true);
        }


  }).done(function(respon) {

    $('.login-box').html(respon);


  }).fail(function(response) {

  });
});

$('#btn_lanjut1').click(function(){
  $("#halaman-database").show();
  $("#btn_database").show();
  $("#btn_lanjut1").hide();
  $("#halaman-requirements").hide();
  $("#judul").html('Koneksi database');
});



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
