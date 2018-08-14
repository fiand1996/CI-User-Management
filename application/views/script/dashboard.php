<script type="text/javascript">

window.onload = function(){

  setInterval(function(){muat_chat(); }, 3000);
};

$("#form-chat").on('submit', (function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: API_URL + 'kirim_chat',
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function() {
            $("#btn-chat").prop('disabled', true);
        }
    }).done(function(respon) {

        muat_chat();
        $("#pesan").val('');
        $("#btn-chat").prop('disabled', false);
    }).fail(function(response) {
        $("#btn-chat").prop('disabled', false);

    });
}));

function muat_chat() {
  $.ajax({
      type: "POST",
      url: API_URL + 'muat_chat'
  }).done(function(respon) {
      $('.direct-chat-messages').html(respon);

  }).fail(function(response) {
      $('#lihat_data').html('Maaf sistem kami ada kesalahan :(');
      $('#modal-detail-sesi').modal('show');
  });
}
</script>
