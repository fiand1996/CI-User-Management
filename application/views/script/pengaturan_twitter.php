<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
$('#toggle_google').change(function() {
  var active;
  if ($(this).prop('checked') == true) {
    active = '1';
    $("#tw_api_key").prop('readonly', false);
    $("#tw_secret_key").prop('readonly', false);
  }
  else {
    active = '0';
    $("#tw_api_key").prop('readonly', true);
    $("#tw_secret_key").prop('readonly', true);
  }
    $('#tw_login').val(active);
})

$("#pengaturan_twitter").on('submit', (function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: API_URL + 'pengaturan_twitter',
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function() {
            $("#btn_simpan_pengaturan").prop('disabled', true);
        }
    }).done(function(respon) {
        if (respon.status == true) {
            notifikasi('success', respon.message)
        } else {
            notifikasi('error', respon.message)
        }
        $("#btn_simpan_pengaturan").prop('disabled', false);
    }).fail(function(response) {
        $("#btn_simpan_pengaturan").prop('disabled', false);
        notifikasi('error', 'Maaf sistem kami ada kesalahan :(')
    });
}));
</script>
