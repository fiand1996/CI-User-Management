<form id="db-form" class="" action="" method="post">
<div class="box box-widget widget-user-2 no-margin flat">
  <div class="widget-user-header bg-blue flat">
    <h3 class="widget-user-username no-margin">Instalasi step 2</h3>
    <h5 id="judul" class="widget-user-desc no-margin">Koneksi Database</h5>
  </div>
      <div id="halaman-database" class="box-footer">
        <div class="form-group">
             <label for="dbhost">Host</label>
             <input class="form-control" required id="dbhost" placeholder="Host" type="text">
           </div>
           <div class="form-group">
             <label for="dbusername">Username</label>
             <input class="form-control" required id="dbusername" placeholder="Username" type="text">
           </div>
           <div class="form-group">
             <label for="dbpassword">Password</label>
             <input class="form-control" id="dbpassword" placeholder="Password" type="password">
           </div>
           <div class="form-group">
             <label for="dbname">Nama Database</label>
             <input class="form-control" required id="dbname" placeholder="Nama Database" type="text">
           </div>
      </div>
    </div>
        <button type="submit" id="btn_database" class="btn bg-blue btn-primary btn-block btn-flat">Cek Koneksi</button>
  </form>

  <br> <div id="pesan"> </div>

<script type="text/javascript">
$("#db-form").on('submit', (function(e) {
  e.preventDefault();
  var dbhost = $("#dbhost").val();
  var dbusername = $("#dbusername").val();
  var dbpassword = $("#dbpassword").val();
  var dbname = $("#dbname").val();
  $("#pesan").html('');

  $.ajax({
      type: "POST",
      url: 'install.php',
      data: {
        'cek_koneksi' : true,
        dbhost : dbhost,
        dbusername : dbusername,
        dbpassword : dbpassword,
        dbname : dbname
      },
      beforeSend: function() {
            $('#btn_database').html('<i class="fa fa-spin fa-spinner"></i>');
            $("#btn_database").prop('disabled', true);
        }

  }).done(function(respon) {

    if (respon.status == false) {
        $("#pesan").html('<div class="callout callout-danger"><p>'+respon.pesan+'</p></div>');

    } else {
      $('.login-box').html(respon);
    }

    $('#btn_database').html('Cek Koneksi');
    $("#btn_database").prop('disabled', false);

  }).fail(function(response) {

  });
}));
</script>
