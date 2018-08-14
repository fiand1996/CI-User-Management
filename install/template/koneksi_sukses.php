<form class="" action="" method="post">
<div class="box box-widget widget-user-2 no-margin flat">
  <div class="widget-user-header bg-blue flat">
    <h3 class="widget-user-username no-margin">Instalasi step 3</h3>
    <h5 id="judul" class="widget-user-desc no-margin">Membuat database dan file config</h5>
    <h5 id="judul" class="widget-user-desc no-margin"></h5>
  </div>
  <div class="info-box bg-navy no-margin flat">
          <span class="info-box-icon"><i class="fa fa-check"></i></span>

          <div class="info-box-content">
            <p id="msg">Koneksi database sukses. Silahkan klik "install" untuk menginstall :)</p>
          </div>

          <!-- /.info-box-content -->
        </div>
        <button type="button" id="btn_install" class="btn bg-blue btn-primary btn-block btn-flat">Install</button>
  </form>
</div>

  <br> <div id="pesan"> </div>

<script type="text/javascript">
$('#btn_install').click(function(){
  var dbhost = $("#dbhost").val();
  var dbusername = $("#dbusername").val();
  var dbpassword = $("#dbpassword").val();
  var dbname = $("#dbname").val();
  $("#pesan").html('');

  $.ajax({
      type: "POST",
      url: 'install.php',
      data: {'install' : true },
      beforeSend: function() {
            $("#btn_install").prop('disabled', true);
            $("#msg").html('Instalasi sedang berlangsung, mohon untuk tidak memuat ulang halaman');
            $(".info-box-icon").html('<i class="fa fa-spin fa-spinner"></i>');
        }

  }).done(function(respon) {

    if (respon.status == false) {
        $("#pesan").html('<div class="callout callout-danger"><p>'+respon.pesan+'</p></div>');

    } else {
      $('.login-box').html(respon);
      $('#btn_install').html('Cek Koneksi');
      $("#btn_install").prop('disabled', false);
      $("#msg").html('Script berhasil diinstal :) Gunakan <strong>admin@admin.com</strong> sebagai email dan <strong>password</strong> sebagai password');
      $(".info-box-icon").html('<i class="fa fa-check"></i>');

    }



  }).fail(function(response) {

  });
  });
</script>
