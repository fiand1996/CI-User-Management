<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.slimscroll.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/fastclick.js') ?>"></script>
<script src="<?php echo base_url('assets/js/adminlte.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jQuery.toast.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/sweetalert2.all.min.js') ?>"></script>

<script type="text/javascript">
  var url = window.location;
  var API_URL = '<?php echo base_url('api/'); ?>';
  $('ul.sidebar-menu a').filter(function() {
   return this.href == url;
  }).parent().addClass('active');
  $('ul.treeview-menu a').filter(function() {
   return this.href == url;
  }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');

  if (window.location.hash == '#_=_') {
    window.location.hash = '';
    history.pushState('', document.title, window.location.pathname);
    e.preventDefault();
  }

  function notifikasi(tipe, pesan) {
      $.toast({
          text: pesan,
          showHideTransition: 'slide',
          position: 'top-right',
          icon: tipe,
          loaderBg: '#f3675b'
      })
  }
</script>
