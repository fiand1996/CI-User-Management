<?php

defined('BASEPATH') or exit('No direct script access allowed');

function kirim_email(array $data = [])
{
  $config['useragent']      = 'codeigniter';
  $config['protocol']       = pengaturan('email_protocol');
  $config['mailpath']       = "/usr/bin/sendmail";
  $config['smtp_host']      = pengaturan('smtp_host');
  $config['smtp_user']      = pengaturan('smtp_username');
  $config['smtp_pass']      = pengaturan('smtp_password');
  $config['smtp_port']      = pengaturan('smtp_port');
  $config['smtp_timeout']   = 30;
  $config['smtp_crypto']    = pengaturan('smtp_encryption');
  $config['wordwrap']       = true;
  $config['mailtype']       = 'html';
  $config['charset']        = pengaturan('smtp_email_charset');
  $config['validate']       = false;
  $config['priority']       = 3;
  $config['newline']        = "\r\n";
  $config['crlf']           = "\r\n";
  $config['bcc_batch_mode'] = false;
  $config['bcc_batch_size'] = 200;

  $CI = & get_instance();
  $CI->load->library ('email');
  $CI->email->initialize($config);
  $CI->email->set_mailtype("html");
  $CI->email->set_newline("\r\n");

  $htmlContent = '<h1>Sending email via SMTP server</h1>';
  $htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application. 300000</p>';

  $CI->email->to($data['penerima']);
  $CI->email->from(pengaturan('smtp_email'), pengaturan('nama_aplikasi'));
  $CI->email->subject(subjek_email($data['tipe']));
  $CI->email->message(template_email($data));

  return $CI->email->send(true) ? true : false;
}

function template_email(array $data = [])
{
  switch ($data['tipe']) {
    case 'aktivasi':
    $html = '<h1>Halo '.$data['penerima'].', Terima kasih sudah mendaftar.</h1>';
    $html .= '<p>Silahkan klik tautan dibawah untuk menyelesaikan pendaftaran akun '.pengaturan('nama_aplikasi').' Anda.';
    $html .= '<p><a href="'.$data['link'].'">Aktivasi Akun Saya</a></p>';
      break;

    case 'reset_password':
    $html = '<h1>Halo '.$data['penerima'].', Kami telah menerima permintaan Anda.</h1>';
    $html .= '<p>Password baru untuk akun '.pengaturan('nama_aplikasi').' Anda adalah.</p>';
    $html .= '<p><strong>'.$data['link'].'</strong></p>';
      break;

    default:
    $html = '<h1>Halo '.$data['penerima'].',</h1>';
    $html .= '<p>Jika Anda menerima Email ini itu berarti konfigurasi email Anda telah sukses.';
      break;
  }

  return $html;
}

function subjek_email($tipe)
{
  switch ($tipe) {
    case 'aktivasi':
      $subject = 'Aktivasi akun kamu';
      break;

    case 'reset_password':
      $subject = 'Permintaan reset password';
      break;

    default:
      $subject = 'Test pengaturan email';
      break;
  }

  return $subject;
}
