<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Table Data User</h3>
              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input name="table_search" class="form-control pull-right" placeholder="Search" type="text">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-body table-responsive no-padding">
              <?php if (empty($semua_user->result())): ?>
               <center> Tidak ada data ditemukan</center>
              <?php else: ?>
              <table class="table table-hover">
                <tbody>
                  <tr>
                  <th>ID</th>
                  <th>Foto</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Oauth</th>
                  <th>Alat</th>
                </tr>
                  <?php foreach ($semua_user->result() as $value): ?>
                  <tr>
                    <td><?php echo $value->id ?></td>
                    <td><img style="width: 30px;" src="<?php echo base_url('assets/img/upload/' . $value->foto) ?>" class="img-circle" alt="User Image"></td>
                    <td><?php echo $value->nama ?></td>
                    <td><?php echo $value->email ?></td>
                    <td><?php echo span_label($value->status) ?></td>
                    <td><?php echo provider_oauth($value->provider_oauth) ?></td>
                    <td>
                      <input type="button" id="<?php echo $value->id ?>" class="btn btn-danger btn-xs btn_hapus" value="hapus" name="hapus">
                      <a href="#" class="btn btn-warning btn-xs"> Edit</a>
                      <a href="#" class="btn btn-primary btn-xs"> Lihat</a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
              </tbody>
            </table>
            <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
