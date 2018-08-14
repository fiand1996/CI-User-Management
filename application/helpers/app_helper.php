<?php

defined('BASEPATH') or exit('No direct script access allowed');

function pengaturan($nama)
{
    $CI = & get_instance();

    $val  = '';
    $nama = trim($nama);

    $CI->db->select('nilai');
    $CI->db->where('nama', $nama);
    $row = $CI->db->get('pengaturan')->row();

    if ($row) {
        $val = $row->nilai;
    }

    return $val;
}

function update_pengaturan($nama, $nilai)
{
    $CI = & get_instance();
    $CI->db->where('nama', $nama);

    $data = [
        'nilai' => $nilai,
        ];

    $CI->db->update('pengaturan', $data);

    if ($CI->db->affected_rows() > 0) {
        return true;
    }

    return false;
}

function ini_admin($level)
{
  $admin = '';

  if ($level == 1) {
     $admin = '<span class="text-yellow"><i class="fa fa-fw fa-star"></i></span>';
  }

  return $admin;
}

function kirim_pemberitahuan($tipe, $isi)
{
  $CI = & get_instance();
  return  $CI->session->set_flashdata($tipe, $isi);
}

function nonaktifkan_input($nama)
{
  $input = '';
  if (pengaturan($nama) == 0) {
     $input = 'readonly=""';
  }
  return $input;
}

function span_label($kondisi)
{
  $span = '<span class="label label-danger">Tidak Aktif</span>';
  if ($kondisi == 1) {
      $span = '<span class="label label-success">Aktif</span>';
  }
  return $span;
}

function provider_oauth($nama)
{
  switch ($nama) {
    case 'facebook':
      $ikon = '<button class="btn btn-social-icon btn-xs btn-facebook"><i class="fa fa-facebook"></i></button>';
      break;
    case 'google':
      $ikon = '<button class="btn btn-social-icon btn-xs btn-google"><i class="fa fa-google-plus"></i></button>';
      break;
    case 'twitter':
      $ikon = '<button class="btn btn-social-icon btn-xs btn-twitter"><i class="fa fa-twitter"></i></button>';
      break;
    case 'github':
      $ikon = '<button class="btn btn-social-icon btn-xs btn-github"><i class="fa fa-github"></i></button>';
      break;
    default:
      $ikon = '';
      break;
  }
  return $ikon;
}

function motode_login($nama)
{
  switch ($nama) {
    case 'facebook':
      $ikon = '<span class="label bg-blue">Facebook</span>';
      break;
    case 'google':
      $ikon = '<span class="label bg-red">Google</span>';
      break;
    case 'twitter':
      $ikon = '<span class="label label-info">Twitter</span>';
      break;
    case 'github':
      $ikon = '<span class="label bg-navy">GitHub</span>';
      break;
    default:
      $ikon = '<span class="label bg-gray">Email</span>';
      break;
  }
  return $ikon;
}

function tampil_pesan_json($status, $pesan, $code)
{
  $data = [
    'status' => $status,
    'message'  => $pesan,
  ];

  $CI = & get_instance();

  $CI->output->set_status_header($code)
             ->set_content_type('application/json', 'utf-8')
             ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
             ->_display();
  exit;
}

function menu_aktif($link)
{
  if (base_url($link) == current_url()) {
    $menu = 'active';
  }
  else {
    $menu = '';
  }

  return $menu;
}
