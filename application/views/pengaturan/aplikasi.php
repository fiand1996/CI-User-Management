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
              <h3 class="box-title">Aplikasi</h3>
            </div>
            <form action="" role="form" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="fb_app_id">Nama Aplikasi</label>
                  <input class="form-control" name="nama_aplikasi" id="nama_aplikasi" type="text" value="<?php echo pengaturan('nama_aplikasi')?>">
                </div>
              <input type="hidden" name="simpan_pengaturan" value="true">
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
</div>


  </div>
</section>
