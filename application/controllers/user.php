<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Class
 *
 * @package     CodeIgniter
 * @category    Controller
 * @author      FIAND T
 * @link        https://www.facebook.com/alfianvega
 */

class User extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->library('template');
    $this->load->model('model_user');
    $this->sudah_login();
  }

	public function index()
	{
    $this->sesi_admin();

    $data = [
      'judul'      => 'List User',
      'user'       => $this->model_user->data_user_session(),
      'semua_user' => $this->model_user->tampil_user_dimana(['level' => 2])
    ];

    $this->template->view('user/user_list', $data, 'user_list');
	}

  public function sesi_tersimpan()
  {
    $this->sesi_admin();

    $data = [
      'judul'     => 'Sesi Aktif',
      'user'      => $this->model_user->data_user_session(),
      'sesi_user' => $this->db->get('users_session')
    ];

    $this->template->view('user/user_session', $data, 'user_session');
  }

  public function profile()
  {
    $data = [
      'judul' => 'Profile',
      'user'  => $this->model_user->data_user_session()
    ];

    $this->template->view('user/user_profile', $data, 'user_profile');
  }

  private function sesi_admin()
  {
    //Jika level bukan admin tampilkan error
    if ($this->session->userdata('u_level') !== "1") {

       $data = [
        'judul' => 'Salah Kamar',
        'user' => $this->model_user->data_user_session()
       ];

       $this->template->view('errors/error', $data);
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
