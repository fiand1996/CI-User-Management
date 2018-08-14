<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo base_url('assets/img/upload/' . $user->foto) ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $user->nama ?></p>
        <a href="#"> <?php echo $user->email ?></a>
      </div>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">NAVIGASI UTAMA</li>
      <li>
        <a href="<?php echo base_url('dashboard') ?>">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <?php if ($this->session->userdata('u_level') === "1"): ?>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Users</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo base_url('user/tambah') ?>"><i class="fa fa-circle-o"></i> Tambah</a></li>
          <li><a href="<?php echo base_url('user') ?>"><i class="fa fa-circle-o"></i> List</a></li>
          <li><a href="<?php echo base_url('user/sesi_tersimpan') ?>"><i class="fa fa-circle-o"></i> Sesi Tersimpan</a></li>
          <li><a href="<?php echo base_url('user/log') ?>"><i class="fa fa-circle-o"></i> User log</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-cogs"></i>
          <span>Pengaturan</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo base_url('pengaturan/aplikasi') ?>"><i class="fa fa-circle-o"></i> Aplikasi</a></li>
          <li><a href="<?php echo base_url('pengaturan/facebook') ?>"><i class="fa fa-circle-o"></i> Autentifikasi Facebook</a></li>
          <li><a href="<?php echo base_url('pengaturan/google') ?>"><i class="fa fa-circle-o"></i> Autentifikasi Google</a></li>
          <li><a href="<?php echo base_url('pengaturan/github') ?>"><i class="fa fa-circle-o"></i> Autentifikasi GitHub</a></li>
          <li><a href="<?php echo base_url('pengaturan/twitter') ?>"><i class="fa fa-circle-o"></i> Autentifikasi Twitter</a></li>
          <li><a href="<?php echo base_url('pengaturan/email') ?>"><i class="fa fa-circle-o"></i> Sistem Email</a></li>
        </ul>
      </li>
      <?php endif; ?>
    </ul>
  </section>
</aside>
