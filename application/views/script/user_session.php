<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
  $(document).on('click', '.btn_lihat', function(){
    var id = $(this).attr('id');
    $.ajax({
        type: "POST",
        url: API_URL + 'sesi_tersimpan',
        data: {id:id}
    }).done(function(respon) {
        $('#lihat_data').html(respon.message);
        $('#modal-detail-sesi').modal('show');
    }).fail(function(response) {
        $('#lihat_data').html('Maaf sistem kami ada kesalahan :(');
        $('#modal-detail-sesi').modal('show');
    });

  })
</script>
