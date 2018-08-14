<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard Class
 *
 * @package     CodeIgniter
 * @category    Controller
 * @author      FIAND T
 * @link        https://www.facebook.com/alfianvega
 */

class Dashboard extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->library('template');
    $this->load->model('model_user');
    $this->sudah_login();
  }

	public function index()
	{
    $data = [
      'judul'       => 'Dashboard',
      'user'        => $this->model_user->data_user_session(),
      'jumlah_user' => $this->db->where('level', 2)->count_all_results('users'),
      'semua_user'  => $this->model_user->member_baru()
    ];

    $this->template->view('dashboard/dashboard', $data, 'dashboard');
	}

  private function sudah_login()
  {
    if ( ! $this->model_user->cek_session()) {
       redirect(base_url('login'));
    }
  }

}
