<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Class
 *
 * @package     CodeIgniter
 * @category    Controller
 * @author      FIAND T
 * @link        https://www.facebook.com/alfianvega
 */

class Auth extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('model_user');
  }

	public function index()
	{
		redirect(base_url('login'));
	}

  public function login()
  {
    //Alihkan ke dashboard jika sudah mempunyai sesi
    $this->sudah_login();
    $this->load->view('auth/login');
  }

  public function keluar()
  {
    if ( ! $this->model_user->cek_session()) {
       redirect(base_url('login'));
    }

    $this->model_user->logout();
    $this->session->set_flashdata('sukses', 'Kamu berhasil keluar');
    redirect(base_url('login'));
  }

  public function daftar()
  {
    //Alihkan ke dashboard jika sudah mempunyai sesi
    $this->sudah_login();
    $this->load->view('auth/daftar');
  }

  public function aktivasi()
  {
    //Alihkan ke dashboard jika sudah mempunyai sesi
    $this->sudah_login();

    //Jika terdapat parameter email dan kode
    if ($this->input->get('email') && $this->input->get('kode')) {

        //Simpan pesan pemberitahuan di variable data
        $data['tipe'] = 'gagal';
        $data['pesan'] = 'Gagal mengaktifkan akun Anda';

        //Jika berhasil mengaktivasi akun
        if ($this->model_user->aktivasi_akun($this->input->get('email'), $this->input->get('kode'))) {
            $data['tipe'] = 'sukses';
            $data['pesan'] = 'Berhasil mengaktifkan akun Anda silahkan <a href="'.base_url('login?email='.$this->input->get('email')).'">Login</a> untuk melanjutkan';
        }

        //Tampilkan halaman aktivasi
        $this->load->view('auth/aktivasi', $data);
    }
    else {
      //Jika tidak terdapat parameter email dan kode dialihkan ke halaman login
      redirect(base_url('login'));
    }
  }

  public function reset_password()
  {
    //Alihkan ke dashboard jika sudah mempunyai sesi
    $this->sudah_login();
    $this->load->view('auth/reset_password');
  }

  public function facebook()
  {
    //Alihkan ke dashboard jika sudah mempunyai sesi
    $this->sudah_login();

      //Jika pengaturan Autentifikasi Facebook tidak aktif dialihkan ke halaman login
    if (pengaturan('fb_login') == 0) {
       kirim_pemberitahuan('error', 'Maaf untuk saat ini Autentifikasi Facebook tidak tersedia');
       redirect(base_url('login'));
    }

      //Memuat Library facebook
    $this->load->library('facebook');

      //Jika berhasil diautentifikasi
    if ($this->facebook->diautentifikasi()) {

      // Mengirim permintaan data user
      $fb = $this->facebook->permintaan('get', '/me?fields=id,name,email,picture');

      $FBdata = [
        'provider_oauth' => 'facebook',
        'id_oauth'       => $fb['id'],
        'nama'           => $fb['name'],
        'email'          => $fb['email'],
        'foto'           => $fb['picture']['data']['url']
     ];

      //Masukkan data user dalam model user yang kemudiakan akan diolah
      $IDuser = $this->model_user->oauth_data($FBdata);

      //Hapus sesi Akses Token
      $this->facebook->hapus_sesi();

      //Buat sesi jika berhasil mengolah data
      if ( ! empty($IDuser)) {
        $this->model_user->session_instan($IDuser);
        $this->model_user->simpan_session($IDuser);
        redirect(base_url('dashboard'));
      }
      else {
        //Alihkan ke halaman login jika gagal memproses data
        kirim_pemberitahuan('error', 'Maaf ada kesalahan dalam sistem kami. Ulangi beberapa saat lagi');
        redirect(base_url('login'));
      }
    }
    else {
      //Membuat url persetujuan masuk Facebook
      redirect($this->facebook->URLmasuk());
    }

  }

  public function google()
  {
    //Alihkan ke dashboard jika sudah mempunyai sesi
    $this->sudah_login();

    //Jika pengaturan Autentifikasi Google tidak aktif dialihkan ke halaman login
    if (pengaturan('g_login') == 0) {
       kirim_pemberitahuan('error', 'Maaf untuk saat ini Autentifikasi Google tidak tersedia');
       redirect(base_url('login'));
    }

    //Memuat Library Google
    $this->load->library('google');

    //Dapatkan kode akses dari google
    $kodeGoogle = $this->input->get('code');

    //Jika terdapat kode akses, kode akses akan ditukar dengan Akses Token
    if ($kodeGoogle) {
       $this->google->dapatkanOtentikasi($kodeGoogle);
       $this->google->setelSesiToken();
       redirect(base_url('auth/google'));
    }

    //Jika ada token maka akan dikirimkan ke resource google
    if ($this->google->punyaToken()) {
       $this->google->setelAksesToken($this->google->token());
    }

    //Jika token valid maka akan ditukarkan dengan data user
    if ($this->google->dapatkanAksesToken()) {

      //Mengirim permintaan data user
       $google = $this->google->dapatkanInfoUser();

       $Gdata = [
         'provider_oauth' => 'google',
         'id_oauth'       => $google['id'],
         'nama'           => $google['displayName'],
         'email'          => $google['emails'][0]['value'],
         'foto'           => $google['image']['url']
      ];

      //Masukkan data user dalam model user yang kemudiakan akan diolah
      $IDuser = $this->model_user->oauth_data($Gdata);

      //Hapus sesi Akses Token
      $this->google->hapusSesiToken();

      //Buat sesi jika berhasil mengolah data
      if ( ! empty($IDuser)) {
         $this->model_user->session_instan($IDuser);
         $this->model_user->simpan_session($IDuser);
         redirect(base_url('dashboard'));
      }
      else {
        //Alihkan ke halaman login jika gagal memproses data
        kirim_pemberitahuan('error', 'Maaf ada kesalahan dalam sistem kami. Ulangi beberapa saat lagi');
        redirect(base_url('login'));
      }
    }
    else {
      //Membuat url persetujuan masuk Google
      redirect($this->google->URLmasuk());
    }

  }

  public function github()
  {
    //Alihkan ke dashboard jika sudah mempunyai sesi
    $this->sudah_login();

    //Jika pengaturan Autentifikasi GitHub tidak aktif dialihkan ke halaman login
    if (pengaturan('git_login') == 0) {
       kirim_pemberitahuan('error', 'Maaf untuk saat ini Autentifikasi GitHub tidak tersedia');
       redirect(base_url('login'));
    }

    //Memuat Library GitHub
    $this->load->library('github');
    //Dapatkan kode akses dari google
    $kodeGitHub = $this->input->get('code');

    //Jika terdapat kode akses, kode akses akan ditukar dengan Akses Token
    if ($kodeGitHub) {
       $this->github->verifikasiState();
       $token = $this->github->dapatkanAksesToken($kodeGitHub);
       $this->github->setelSesiToken($token->access_token);
       redirect(base_url('auth/github'));
    }

    //Jika punya token, Token akan ditukar dengan data user
    if ($this->github->punyaToken()) {

      //Dapatkan info user dari GitHub
       $github = $this->github->dapatkanInfoUser();

       $Gitdata = [
         'provider_oauth' => 'github',
         'id_oauth'       => $github['id'],
         'nama'           => $github['name'],
         'email'          => $github['email'],
         'foto'           => $github['avatar_url']
        ];

        //Masukkan data user dalam model user yang kemudiakan akan diolah
        $IDuser = $this->model_user->oauth_data($Gitdata);

        //Hapus sesi Akses Token
        $this->github->hapusSesiToken();

        //Buat sesi jika berhasil mengolah data
        if ( ! empty($IDuser)) {
           $this->model_user->session_instan($IDuser);
           $this->model_user->simpan_session($IDuser);
           redirect(base_url('dashboard'));
        }
        else {
          //Alihkan ke halaman login jika gagal memproses data
          kirim_pemberitahuan('error', 'Maaf ada kesalahan dalam sistem kami. Ulangi beberapa saat lagi');
          redirect(base_url('login'));
        }
    }
    else
    {
      redirect($this->github->URLmasuk());
    }
  }

  public function twitter()
  {
    //Alihkan ke dashboard jika sudah mempunyai sesi
    $this->sudah_login();

    //Jika pengaturan Autentifikasi Twitter tidak aktif dialihkan ke halaman login
    if (pengaturan('git_login') == 0) {
       kirim_pemberitahuan('error', 'Maaf untuk saat ini Autentifikasi Twitter tidak tersedia');
       redirect(base_url('login'));
    }

    //Memuat library Twitter
    $this->load->library('twitter');

    if ($this->input->get_post('oauth_token') &&
        $this->session->userdata('token') !==
        $this->input->get_post('oauth_token'))
    {

    	//Jika token sudah kadaluwarsa
    	session_destroy();
    	redirect(base_url('login'));

      //Juka token masih aktif
    }elseif ($this->input->get_post('oauth_token') &&
             $this->session->userdata('token') ==
             $this->input->get_post('oauth_token'))
    {

      //Mendapatkan data user Twitter
      $twitter = $this->twitter->dapatkanInfoUser();

      //Hapus sesi Akses Token
      $this->twitter->hapusSesiToken();

      $TWdata = [
        'provider_oauth' => 'twitter',
        'id_oauth'       => $twitter['id'],
        'nama'           => $twitter['name'],
        'email'          => $twitter['email'],
        'foto'           => $twitter['profile_image_url']
       ];

       //Masukkan data user dalam model user yang kemudiakan akan diolah
       $IDuser = $this->model_user->oauth_data($TWdata);
     //Buat sesi jika berhasil mengolah data
       if ( ! empty($IDuser)) {
          $this->model_user->session_instan($IDuser);
          $this->model_user->simpan_session($IDuser);
          redirect(base_url('dashboard'));
       }
       else {
         //Alihkan ke halaman login jika gagal memproses data
         kirim_pemberitahuan('error', 'Maaf ada kesalahan dalam sistem kami. Ulangi beberapa saat lagi');
         redirect(base_url('login'));
       }

    }else{

    	if($this->input->get('denied')) {
        kirim_pemberitahuan('error', 'Autentifikasi Twitter gagal :(');
    		redirect(base_url('login'));
    	}

      redirect($this->twitter->URLmasuk());
    }
  }

  private function sudah_login()
  {
    if ($this->model_user->cek_session()) {
       redirect(base_url('dashboard'));
    }
  }

}
