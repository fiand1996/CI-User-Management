<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pengaturan Class
 *
 * @package     CodeIgniter
 * @category    Controller
 * @author      FIAND T
 * @link        https://www.facebook.com/alfianvega
 */

class Pengaturan extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->library('template');
    $this->load->model('model_user');
    $this->sudah_login();
    $this->sesi_admin();
  }

	public function index()
	{
    redirect(base_url('pengaturan/aplikasi'));
	}

  public function aplikasi()
  {
    if ($this->input->post('simpan_pengaturan')) {
      update_pengaturan('nama_aplikasi', $this->input->post('nama_aplikasi'));
    }

    $data = [
      'judul' => 'Pengaturan Aplikasi',
      'user'  => $this->model_user->data_user_session()
    ];
    $this->template->view('pengaturan/aplikasi', $data);
  }

  public function facebook()
  {
    $data = [
      'judul' => 'Pengaturan Autentifikasi Facebook',
      'user' => $this->model_user->data_user_session()
    ];
    $this->template->view('pengaturan/auth_facebook', $data, 'pengaturan_facebook');
  }

  public function google()
  {
    $data = [
      'judul' => 'Pengaturan Autentifikasi Google',
      'user' => $this->model_user->data_user_session()
    ];
    $this->template->view('pengaturan/auth_google', $data, 'pengaturan_google');
  }

  public function github()
  {
    $data = [
      'judul' => 'Pengaturan Autentifikasi GitHub',
      'user' => $this->model_user->data_user_session()
    ];
    $this->template->view('pengaturan/auth_github', $data, 'pengaturan_github');
  }

  public function twitter()
  {
    $data = [
      'judul' => 'Pengaturan Autentifikasi Twitter',
      'user' => $this->model_user->data_user_session()
    ];
    $this->template->view('pengaturan/auth_twitter', $data, 'pengaturan_twitter');
  }

  public function email()
  {
    if ($this->input->post('simpan_pengaturan')) {
      update_pengaturan('sistem_email', $this->input->post('sistem_email'));
      update_pengaturan('email_protocol', $this->input->post('email_protocol'));
      update_pengaturan('smtp_encryption', $this->input->post('smtp_encryption'));
      update_pengaturan('smtp_host', $this->input->post('smtp_host'));
      update_pengaturan('smtp_port', $this->input->post('smtp_port'));
      update_pengaturan('smtp_email', $this->input->post('smtp_email'));
      update_pengaturan('smtp_username', $this->input->post('smtp_username'));
      update_pengaturan('smtp_password', $this->input->post('smtp_password'));
      update_pengaturan('smtp_email_charset', $this->input->post('smtp_email_charset'));

    }

    $data = [
      'judul' => 'Pengaturan Sistem Email',
      'user' => $this->model_user->data_user_session()
    ];
    $this->session->set_flashdata("link", "pengaturan_email");
    $this->template->view('pengaturan/email', $data, 'pengaturan_email');
  }

  private function sesi_admin()
  {
    //Jika level bukan admin tampilkan error
    if ($this->session->userdata('u_level') !== "1") {

       $data = [
        'judul' => 'Salah Kamar',
        'user' => $this->model_user->data_user_session()
       ];

       $this->template->view('error', $data);
       exit();
    }
  }

  private function sudah_login()
  {
    if ( ! $this->model_user->cek_session()) {
       $url = urlencode(current_url());
       redirect(base_url('login?target=' . $url));
    }
  }

}
