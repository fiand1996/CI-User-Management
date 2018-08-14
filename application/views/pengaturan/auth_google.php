<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content">
  <div class="row">


    <div class="col-md-4">
       <div class="list-group">
          <a href="<?php echo base_url('pengaturan/aplikasi') ?>" class="list-group-item <?php echo menu_aktif('pengaturan/aplikasi') ?>">
          <em class="fa fa-fw fa-gear text-white"></em>&nbsp;&nbsp;&nbsp;Aplikasi</a>
          <a href="<?php echo base_url('pengaturan/facebook') ?>" class="list-group-item <?php echo menu_aktif('pengaturan/facebook') ?>">
          <em class="fa fa-fw fa-facebook text-white"></em>&nbsp;&nbsp;&nbsp;Autentifikasi Facebook</a>
          <a href="<?php echo base_url('pengaturan/google') ?>" class="list-group-item <?php echo menu_aktif('pengaturan/google') ?>">
          <em class="fa fa-fw fa-google text-white"></em>&nbsp;&nbsp;&nbsp;Autentifikasi Google</a>
          <a href="<?php echo base_url('pengaturan/github') ?>" class="list-group-item <?php echo menu_aktif('pengaturan/github') ?>">
          <em class="fa fa-fw fa-github text-white"></em>&nbsp;&nbsp;&nbsp;Autentifikasi GitHub</a>
          <a href="<?php echo base_url('pengaturan/twitter') ?>" class="list-group-item <?php echo menu_aktif('pengaturan/twitter') ?>">
          <em class="fa fa-fw fa-twitter text-white"></em>&nbsp;&nbsp;&nbsp;Autentifikasi twitter</a>
          <a href="<?php echo base_url('pengaturan/email') ?>" class="list-group-item <?php echo menu_aktif('pengaturan/email') ?>">
          <em class="fa fa-fw fa-envelope text-white"></em>&nbsp;&nbsp;&nbsp;Sistem Email</a>
       </div>
    </div>

<div class="col-md-8">
  <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Autentifikasi Google</h3>
              <div class="box-tools">
                  <input <?php if (pengaturan('g_login') == '1') { echo 'checked'; } ?> id="toggle_google" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" type="checkbox">
              </div>
            </div>
            <form action="" role="form" method="post" id="pengaturan_google">
              <div class="box-body">
                <input type="hidden" name="g_login" id="g_login" value="<?php echo pengaturan('g_login')?>">
                <div class="form-group">
                  <label for="g_client_id">ID Client</label>
                  <input class="form-control" <?php echo nonaktifkan_input('g_login') ?> name="g_client_id" id="g_client_id" type="text" value="<?php echo pengaturan('g_client_id')?>">
                </div>
                <div class="form-group">
                  <label for="g_client_secret">Kunci Rahasia Client</label>
                  <input class="form-control" <?php echo nonaktifkan_input('g_login') ?> name="g_client_secret" id="g_client_secret" type="text" value="<?php echo pengaturan('g_client_secret')?>">
                </div>
              <input type="hidden" name="simpan_pengaturan" value="true">
              </div>
              <div class="box-footer">
                <button type="submit" id="btn_simpan_pengaturan" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>

          <div class="callout callout-info">
            <h4>Info</h4>
            <p> Buat project di <a href="https://developers.google.com/console">https://developers.google.com/console/</a> untuk mendapatkan ID Client dan Kunci Rahasia Client</p>
          </div>
</div>


  </div>
</section>
