<?php
$versi_minimal = '5.5';
$versi_php = phpversion();

$error = false;

function buat_badge($status, $pesan = NULL) {
  $badge = '<i class="fa fa-question-circle" data-toggle="tooltip" title="'.$pesan.'" ></i><span id="versi_php" class="pull-right badge bg-red"><i class="fa fa-times-circle"></i></span>';
  if ($status == TRUE) {
    $badge = '<span id="versi_php" class="pull-right badge bg-green"><i class="fa fa-check-circle"></i></span>';
  }
  return $badge;
}

if(version_compare($versi_minimal, $versi_php, '>')) {
  $php_version = buat_badge(FALSE, 'Minimal Versi PHP adalah '.$versi_minimal.'.');
  $error = true;
}
else{
  $php_version = buat_badge(TRUE);
}

if(!extension_loaded('mysqli')) {
  $MySQLi = buat_badge(FALSE, 'Extensi MySQLi belum terinstall di server Anda.');
  $error = true;
}
else {
  $MySQLi = buat_badge(TRUE);
}

if(!extension_loaded('pdo')) {
  $PDO = buat_badge(FALSE, 'Extensi PDO belum terinstall di server Anda.');
  $error = true;
}
else {
  $PDO = buat_badge(TRUE);
}

if(!extension_loaded('curl')) {
  $cURL = buat_badge(FALSE, 'Extensi cURL belum terinstall di server Anda.');
  $error = true;
}
else {
  $cURL = buat_badge(TRUE);
}

if(!extension_loaded('openssl')) {
  $openSSL = buat_badge(FALSE, 'Extensi openSSL belum terinstall di server Anda.');
  $error = true;
}
else {
  $openSSL = buat_badge(TRUE);
}

 ?>

<form class="" action="" method="post">
<div class="box box-widget widget-user-2 no-margin flat">
  <div class="widget-user-header bg-blue flat">
    <h3 class="widget-user-username no-margin">Instalasi step 1</h3>
    <h5 id="judul" class="widget-user-desc no-margin">System Requirements</h5>
  </div>
      <div id="halaman-requirements" class="box-footer">
        <ul class="nav nav-stacked">
          <li><a href="#">Versi PHP <?php echo $versi_php. ' ' .$php_version ?></a></li>
          <li><a href="#">Extensi MySQLi <?php echo $MySQLi ?></a></li>
          <li><a href="#">Extensi PDO <?php echo $PDO ?></a></li>
          <li><a href="#">Extensi cURL <?php echo $cURL ?></a></li>
          <li><a href="#">Extensi OpenSSL <?php echo $openSSL ?></a></li>
        </ul>
      </div>
    </div>
  </form>
  <?php if ($error == TRUE): ?>
    <button type="button" id="btn_reload" class="btn bg-blue btn-primary btn-block btn-flat">Reload</button>
    <br>
    <div class="callout callout-danger">
      <p>Server anda harus memenuhi persyaratan diatas untuk dapat melanjutkan ke langkah selanjutnya.</p>
    </div>
    <?php else: ?>
      <button type="button" id="btn_next1" class="btn bg-blue btn-primary btn-block btn-flat">Lanjutkan</button>
  <?php endif; ?>

  <script type="text/javascript">
  $(document).ready(function(){
   $('[data-toggle="tooltip"]').tooltip({
       placement : 'top'
   });
 });

  $('#btn_next1').click(function(){
    $.ajax({
        type: "POST",
        url: 'install.php',
        data: {'halaman_database' : true},
        beforeSend: function() {
              $('#btn_mulai').html('<i class="fa fa-spin fa-spinner"></i>');
              $("#btn_mulai").prop('disabled', true);
          }


    }).done(function(respon) {

      $('.login-box').html(respon);


    }).fail(function(response) {

    });
  });


  $('#btn_reload').click(function(){
    $.ajax({
        type: "POST",
        url: 'install.php',
        data: {'halaman_requirement' : true},
        beforeSend: function() {
              $('#btn_reload').html('<i class="fa fa-spin fa-spinner"></i>');
          }


    }).done(function(respon) {

      $('.login-box').html(respon);


    }).fail(function(response) {

    });
  });
  </script>
