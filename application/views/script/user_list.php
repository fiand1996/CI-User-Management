<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">

$(function() {
  $(".btn_hapus").click(function(){

    	var element = $(this);

    	var id = element.attr("id");

    	var parent = $(this).parent().parent();

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
           url: API_URL + 'hapus_user',
           data: {id:id},
           }).done(function(respon) {
               parent.fadeOut('slow', function() {$(this).remove();});
               notifikasi('success', respon.message)
           }).fail(function() {
               notifikasi('error', 'Maaf sistem kami ada kesalahan :(')
           });
        }
      })
		});
});
</script>
