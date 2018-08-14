<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url('assets/img/upload/' . $user->foto) ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $user->nama ?></h3>

              <p class="text-muted text-center"><?php echo $user->email ?></p>

              <a href="#" class="btn btn-danger btn-block btn_hapus"><b>Hapus Akun</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#akun" data-toggle="tab">Akun</a></li>
              <li><a href="#password" data-toggle="tab">Password</a></li>
              <li><a href="#foto" data-toggle="tab">Foto</a></li>
            </ul>
            <div class="tab-content">

              <div class="active tab-pane" id="akun">
                <form action="" id="edit_akun" class="form-horizontal" method="post">
                  <div class="form-group">
                    <label for="nama" class="col-sm-2 control-label">Nama</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $user->nama ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $user->email ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" id="simpan-akun" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="password">
                <form action="" id="edit_password" class="form-horizontal" method="post">
                  <div class="form-group">
                    <label for="pass_lama" class="col-sm-2 control-label">Password Sekarang</label>

                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="pass_lama" id="pass_lama" placeholder="Password Sekarang">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="pass_baru" class="col-sm-2 control-label">Password Baru</label>

                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="pass_baru" id="pass_baru" placeholder="Password Baru">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="konfir_pass" class="col-sm-2 control-label">Konfirmasi Password Baru</label>

                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="konfir_pass" id="konfir_pass" placeholder="Konfirmasi Password Baru">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" id="simpan-password" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="foto">

              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
