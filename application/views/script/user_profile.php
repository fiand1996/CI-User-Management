<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
$("#edit_akun").on('submit', (function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: API_URL + 'edit_akun',
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function() {
            $("#simpan-akun").prop('disabled', true);
        }
    }).done(function(respon) {
        if (respon.status == true) {
            notifikasi('success', respon.message);
            location.reload();
        } else {
            $("#simpan-akun").prop('disabled', false);
            notifikasi('error', respon.message)
        }
    }).fail(function(response) {
        $("#simpan-akun").prop('disabled', false);
        notifikasi('error', 'Maaf sistem kami ada kesalahan :(')
    });
}));

$("#edit_password").on('submit', (function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: API_URL + 'edit_password',
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function() {
            $("#simpan-password").prop('disabled', true);
        }
    }).done(function(respon) {
        if (respon.status == true) {
            notifikasi('success', respon.message);
            location.reload();
        } else {
            $("#simpan-password").prop('disabled', false);
            notifikasi('error', respon.message)
        }
    }).fail(function(response) {
        $("#simpan-password").prop('disabled', false);
        notifikasi('error', 'Maaf sistem kami ada kesalahan :(')
    });
}));

$(function() {
  $(".btn_hapus").click(function(){

      swal({
        title: 'Apakah kamu yakin?',
        text: "Data yang sudah dihapus tidak dapat dikembalikan",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        confirmButtonText: 'Yakin!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
           type: "POST",
           url: API_URL + 'hapus_akun',
           }).done(function(respon) {
               notifikasi('success', respon.message);
               location.reload();
           }).fail(function() {
               notifikasi('error', 'Maaf sistem kami ada kesalahan :(')
           });
        }
      })
		});
});
</script>
