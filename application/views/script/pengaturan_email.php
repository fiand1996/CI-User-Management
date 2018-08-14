<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
$("#btn_test_email").click(function(e){
    e.preventDefault();
    var test_email = $("#test_email").val();

    if (test_email != '') {
      $.ajax({
          dataType: 'json',
          type:'POST',
          url: API_URL + 'test_email',
          data:{test_email:test_email},
          beforeSend: function() {
              $("#btn_test_email").prop('disabled', true);
          }
      }).done(function(respon){
        if (respon.status == true) {
          notifikasi('success', respon.message)
        }
        else {
          notifikasi('error', respon.message)
        }
        $("#btn_test_email").prop('disabled', false);

      });
    }else {
      notifikasi('error', 'masukkan email tujuan Anda')
    }
});
</script>
