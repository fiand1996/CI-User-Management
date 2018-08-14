<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
      <section class="content">
      <div class="row">
        <?php if ($this->session->userdata('u_level') === "1"): ?>
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?php echo $jumlah_user ?></h3>

                <p>Jumlah User</p>
              </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3>44</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
        <?php else: ?>
          <div class="col-md-12">
            <div class="callout callout-success alert-dismissible">
              <h4>Selamat datang!</h4>
              Hallo sekarang kamu berada di halaman user :)
            </div>
          </div>
        <?php endif; ?>

      </div>


      <div class="row">
            <div class="col-md-6">
              <!-- DIRECT CHAT -->
              <div class="box box-warning direct-chat direct-chat-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Chat Room</h3>

                  <div class="box-tools pull-right">
                    <span id="jumlah_chat" data-toggle="tooltip" title="" class="badge bg-yellow" data-original-title="3 New Messages"> <?php echo $this->db->count_all('chat_room') ?> </span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <!-- Conversations are loaded here -->
                  <div class="direct-chat-messages">

                  </div>
                  <!--/.direct-chat-messages-->

                  <!-- Contacts are loaded here -->

                  <!-- /.direct-chat-pane -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <form action="#" id="form-chat" method="post">
                    <div class="input-group">
                      <input name="pesan" id="pesan" required placeholder="Tulis sesuatu ..." class="form-control" type="text">
                      <span class="input-group-btn">
                            <button id="btn-chat" type="submit" class="btn btn-warning btn-flat">Kirim</button>
                          </span>
                    </div>
                  </form>
                </div>
                <!-- /.box-footer-->
              </div>
              <!--/.direct-chat -->
            </div>
            <!-- /.col -->
            <?php if ($this->session->userdata('u_level') === "1"): ?>
            <div class="col-md-6">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Member baru</h3>

                  <div class="box-tools pull-right">
                    <span class="label label-danger"><?php echo count($semua_user->result()) ?> Member baru</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    <?php foreach ($semua_user->result() as $key => $value): ?>
                      <li>
                        <img width="80px" src="<?php echo base_url('assets/img/upload/' . $value->foto) ?>" alt="User Image">
                        <a class="users-list-name" href="#"><?php echo $value->nama ?></a>
                        <?php echo motode_login($value->provider_oauth) ?>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
                <div class="box-footer text-center">
                  <a href="javascript:void(0)" class="uppercase">View All Users</a>
                </div>
              </div>
            </div>
            <?php endif; ?>
          </div>

    </section>
