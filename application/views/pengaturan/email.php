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
              <h3 class="box-title">Email</h3>
            </div>
            <form action="" role="form" method="post">
              <div class="box-body">
                <div class="form-group">
                  <div class="form-group">
                    <select name="sistem_email" id="sistem_email" class="form-control">
                      <option value="1" <?php if (pengaturan('sistem_email') == '1') { echo 'selected=""'; } ?>>Aktif</option>
                      <option value="0" <?php if (pengaturan('sistem_email') == '0') { echo 'selected=""'; } ?>>Tidak Aktif</option>
                    </select>
                  </div>
                  <label for="email_protocol">Protokol Email</label>
                  <div class="radio">
                    <label>
                      <input name="email_protocol" id="email_protocol" value="smtp" <?php if (pengaturan('email_protocol') == 'smtp') { echo 'checked=""'; } ?> type="radio">
                      SMTP
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input name="email_protocol" id="email_protocol" value="sendmail" <?php if (pengaturan('email_protocol') == 'sendmail') { echo 'checked=""'; } ?> type="radio">
                      SendMail
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input name="email_protocol" id="email_protocol" value="mail" <?php if (pengaturan('email_protocol') == 'mail') { echo 'checked=""'; } ?> type="radio">
                      Mail
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label for="smtp_encryption">Enkripsi Email</label>
                  <select name="smtp_encryption" id="smtp_encryption" class="form-control">
                    <option value="">Tidak Ada</option>
                    <option value="ssl" <?php if (pengaturan('smtp_encryption') == 'ssl') { echo 'selected=""'; } ?>>SSL</option>
                    <option value="tls" <?php if (pengaturan('smtp_encryption') == 'tls') { echo 'selected=""'; } ?>>TLS</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Host SMTP</label>
                  <input class="form-control" name="smtp_host" id="smtp_host" type="text" value="<?php echo pengaturan('smtp_host')?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Port SMTP</label>
                  <input class="form-control" name="smtp_port" id="smtp_port" type="text" value="<?php echo pengaturan('smtp_port')?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input class="form-control" name="smtp_email" id="smtp_email" type="text" value="<?php echo pengaturan('smtp_email')?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Username SMTP</label>
                  <input class="form-control" name="smtp_username" id="smtp_username" type="text" value="<?php echo pengaturan('smtp_username')?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Password SMTP</label>
                  <input class="form-control" name="smtp_password" id="smtp_password" type="password" value="<?php echo pengaturan('smtp_password')?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Charset SMTP</label>
                  <input class="form-control" name="smtp_email_charset" id="smtp_email_charset" type="text" value="<?php echo pengaturan('smtp_email_charset')?>">
                </div>
                <div class="form-group">
                  <label for="test_email">Test Kirim Email</label>
                <div class="input-group">
                <input class="form-control" name="test_email" id="test_email" type="email">
                    <span class="input-group-btn">
                      <button type="button"  name="btn_test_email"  id="btn_test_email" class="btn btn-info btn-flat">Kirim</button>
                    </span>
                  </div>
                  <span class="help-block">Kirim email percobaan untuk memastikan bahwa pengaturan SMTP Anda sudah diatur dengan benar.</span>
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
