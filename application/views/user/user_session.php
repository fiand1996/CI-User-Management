<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Table Sesi Tersimpan</h3>
              <div class="box-tools">
                  <button type="submit" class="btn btn-default"><i class="fa fa-refresh"></i></button>
              </div>
            </div>
            <div class="box-body table-responsive no-padding">
              <?php if (empty($sesi_user->result())): ?>
               <center> Tidak ada data ditemukan</center>
              <?php else: ?>
              <table class="table table-hover">
                <tbody>
                  <tr>
                  <th>ID User</th>
                  <th>IP</th>
                  <th>Waktu</th>
                  <th>Alat</th>
                </tr>
                  <?php foreach ($sesi_user->result() as $value): ?>
                  <tr>
                    <td><?php echo $value->id_user ?></td>
                    <td><?php echo $value->ip ?></td>
                    <td><?php echo $value->time ?></td>
                    <td>
                      <?php if ($value->id_user !== $this->session->userdata('u_id')): ?>
                        <a href="#" class="btn btn-danger btn-xs"> Akhiri</a>
                      <?php endif; ?>
                      <input type="button" id="<?php echo $value->id ?>" class="btn btn-primary btn-xs btn_lihat" value="lihat" name="lihat">
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

    <div class="modal modal-default fade" id="modal-detail-sesi">
         <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header bg-blue">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title">Detail Sesi</h4>
             </div>
             <div class="modal-body">
               <table class="table table-bordered  no-padding no-margin">
                <tbody id="lihat_data">
              </tbody>
            </table>
             </div>
             <div class="modal-footer">
               <button type="button" class="btn btn-success pull-right" data-dismiss="modal">Tutup</button>
             </div>
           </div>
           <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
       </div>
