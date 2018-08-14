<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * API Class
 *
 * @package     CodeIgniter
 * @category    Controller
 * @author      FIAND T
 * @link        https://www.facebook.com/alfianvega
 */

class Api extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('model_user');
    $this->permintaan_ajax();
  }

	public function index()
	{
		tampil_pesan_json(FALSE, 'Jangan nakal ya :)', 400);
	}

  public function login()
  {
      $this->permintaan_post();

      //Validasi inputan
      $validasi_login = [
        [
          'field' => 'email',
          'label' => 'Email',
          'rules' => 'required|valid_email',
          'errors' => [
                  'required' => '%s masih kosong.',
                  'valid_email' => '%s tidak valid.'
          ],
        ],
        [
          'field' => 'password',
          'label' => 'Password',
          'rules' => 'trim|required|min_length[7]',
          'errors' => [
                  'required' => '%s masih kosong.',
                  'min_length' => '%s tidak boleh kurang dari 7 karakter.'
          ],
        ]
      ];

      $this->form_validation->set_rules($validasi_login);
      $this->form_validation->set_error_delimiters('<li>', '</li>');

      //Jika validasi gagal
      if ($this->form_validation->run() == FALSE) {
          tampil_pesan_json(FALSE, validation_errors(), 200);
      }
      else {
        //Jika validasi berhasil
        $email = $this->input->post('email', TRUE);
        $password = $this->input->post('password', TRUE);
        $remember = $this->input->post('rememberme');

        //Jika gagal login
        if ($this->model_user->login($email, $password, $remember) === false) {
           tampil_pesan_json(FALSE, $this->model_user->getError(), 200);
        }

        //Jika berhasil login
        if ($this->input->post('target')) {
           $url = urldecode($this->input->post('target'));
        }else {
          $url = base_url('dashboard');
        }

        tampil_pesan_json(TRUE, $url, 200);
      }
  }

  public function daftar()
  {
      $this->permintaan_post();

      //Validasi inputan
      $validasi_daftar = [
          [
                  'field' => 'nama',
                  'label' => 'Nama',
                  'rules' => 'trim|required|min_length[3]|max_length[25]|alpha_numeric_spaces',
                  'errors' => [
                          'required' => '%s masih kosong.',
                          'min_length' => '%s minimal 3 karekter.',
                          'max_length' => '%s maksimal 12 karekter.',
                          'alpha_numeric_spaces' => '%s hanya boleh berisi karakter alfabet.'
                  ],
          ],
          [
                  'field' => 'email',
                  'label' => 'Email',
                  'rules' => 'trim|required|valid_email|is_unique[users.email]',
                  'errors' => [
                          'required' => '%s masih kosong.',
                          'valid_email' => '%s tidak valid.',
                          'is_unique' => '%s sudah digunakan.'
                  ],
          ],
          [
                  'field' => 'password',
                  'label' => 'Password',
                  'rules' => 'trim|required|min_length[5]',
                  'errors' => [
                          'required' => '%s masih kosong.',
                          'min_length' => '%s minimal 5 karekter atau lebih.'
                  ],
          ],
          [
                  'field' => 'repassword',
                  'label' => 'Konfirmasi Password',
                  'rules' => 'trim|required|matches[password]',
                  'errors' => [
                          'required' => '%s masih kosong.',
                          'matches' => '%s tidak sama dengan Password.'
                  ],
          ],
          [
                  'field' => 'ketentuan',
                  'label' => 'Syarat Ketentuan',
                  'rules' => 'trim|required',
                  'errors' => [
                          'required' => 'Anda harus menyetujui %s kami.'
                  ],
          ]
      ];

      $this->form_validation->set_rules($validasi_daftar);
      $this->form_validation->set_error_delimiters('<li>', '</li>');

      //Jika validasi gagal
      if ($this->form_validation->run() == FALSE) {
          tampil_pesan_json(FALSE, validation_errors(), 200);
      }else {
        //Jika validasi berhasil
        $nama = $this->input->post('nama', TRUE);
        $email = $this->input->post('email', TRUE);
        $password =$this->input->post('password', TRUE);
        $pesan_sukses = 'Pendaftaran Anda berhasil. Silahkan masuk untuk malanjutkan.';

        $data = [
          'nama' => $nama,
          'email' => $email,
          'password' => $this->model_user->buat_password($password),
          'status' => 1,
          'kunci_unik' => NULL
        ];

        //Jika pengatran sistem email aktif
        if (pengaturan('sistem_email') == 1) {

          //Buat kunci unik untuk aktivasi akun
          $acak = random_string('alnum', 64);
          $kodeUnik = hash("sha1", $acak);

          //Rubah data status user menjasi 0 (tidak aktif)
          $data['status'] = 0;
          $data['kunci_unik'] = $kodeUnik;
          $pesan_sukses = 'Pendaftaran Anda berhasil. Silahkan periksa email untuk proses aktivasi akun.';

          //Kirimkan email aktivasi
          kirim_email([
            'penerima' => $email,
            'tipe' => 'aktivasi',
            'link' => base_url('aktivasi?email='.$email.'&kode='.$kodeUnik)
          ]);

        }

        //tambah user baru ke dalam databse
        $daftar = $this->model_user->tambah($data);

        //Jika gagal menambahkan user
        if ($daftar === FALSE) {
            tampil_pesan_json(TRUE, 'Maaf terdapat kesalahan pada sistem kami, silahkan ulangi beberapa saat lagi.', 200);
        }

        //Jika berhasil menambahkan user
         kirim_pemberitahuan('sukses', $pesan_sukses);
         tampil_pesan_json(TRUE, base_url('login?email=' . $email), 200);
      }
  }

  public function reset_password()
  {
    $this->permintaan_post();

    //Validasi inputan
    $validasi_reset = [
      [
        'field' => 'email',
        'label' => 'Email',
        'rules' => 'required|valid_email',
        'errors' => [
                'required' => '%s masih kosong.',
                'valid_email' => '%s tidak valid.'
        ],
      ]
    ];

    $this->form_validation->set_rules($validasi_reset);
    $this->form_validation->set_error_delimiters('<li>', '</li>');

    //Jika validasi gagal
    if ($this->form_validation->run() == FALSE) {
        tampil_pesan_json(FALSE, validation_errors(), 200);
    }
    else {
      //Jika validasi berhasil
      $email = $this->input->post('email', TRUE);

      //Jika gagal
      if ($this->model_user->reset($email) === false) {
         tampil_pesan_json(FALSE, $this->model_user->getError(), 200);
      }

      kirim_pemberitahuan('sukses', 'Email berhasil terkirim, Cek email Anda untuk mendapatkan password baru');
      tampil_pesan_json(TRUE, base_url('login'), 200);
    }
  }

  public function sesi_tersimpan()
  {
    $this->permintaan_post();
    $this->sudah_login();
    $this->sesi_admin();

    $query = $this->db->get_where('users_session', array('id' => $this->input->post('id')));

    if ($query->row()) {
        $data = '<tr><td>ID User</td><td>' . $query->row('id_user') . '</td>
                 </tr><tr><td>Alamat IP</td><td>' . $query->row('ip') . '</td></tr>
                 <tr><td>Waktu</td><td>' . $query->row('time') . '</td></tr>
                 <tr><td>User Agent</td><td>' . $query->row('user_agent') . '</td></tr>';

        tampil_pesan_json(TRUE, $data, 200);
    }
  }

  public function edit_akun()
  {
    $this->permintaan_post();
    $this->sudah_login();

    //Validasi inputan
    $validasi = [
        [
          'field' => 'nama',
          'label' => 'Nama',
          'rules' => 'trim|required|min_length[3]|max_length[25]|alpha_numeric_spaces',
          'errors' => [
                  'required' => '%s masih kosong.',
                  'min_length' => '%s minimal 3 karekter.',
                  'max_length' => '%s maksimal 12 karekter.',
                  'alpha_numeric_spaces' => '%s hanya boleh berisi karakter alfabet.'
          ],
        ],
        [
          'field' => 'email',
          'label' => 'Email',
          'rules' => 'trim|required|valid_email',
          'errors' => [
                  'required' => '%s masih kosong.',
                  'valid_email' => '%s tidak valid.',
                  'is_unique' => '%s sudah digunakan.'
          ],
        ]
    ];

    $this->form_validation->set_rules($validasi);
    $this->form_validation->set_error_delimiters('<li>', '</li>');

    //Jika validasi gagal
    if ($this->form_validation->run() == FALSE) {
        tampil_pesan_json(FALSE, validation_errors(), 200);
    }
    else {

      $data = [
        'nama' => $this->input->post('nama'),
        'email' => $this->input->post('email')
      ];

      $this->model_user->perbaharui($this->session->userdata('u_id'), $data);
      tampil_pesan_json(TRUE, 'Berhasil mengedit akun', 200);
    }

  }

  public function edit_password()
  {
    $this->permintaan_post();
    $this->sudah_login();

    //Validasi inputan
    $validasi = [
        [
                'field' => 'pass_lama',
                'label' => 'Password',
                'rules' => 'trim|required|min_length[7]',
                'errors' => [
                        'required' => '%s masih kosong.',
                        'min_length' => '%s minimal 7 karekter atau lebih.'
                ],
        ],
        [
                'field' => 'pass_baru',
                'label' => 'Konfirmasi Password',
                'rules' => 'trim|required|min_length[7]',
                'errors' => [
                        'required' => '%s masih kosong.',
                        'min_length' => '%s minimal 7 karekter atau lebih.'
                ],
        ],
        [
                'field' => 'konfir_pass',
                'label' => 'Konfirmasi Password',
                'rules' => 'trim|required|matches[pass_baru]',
                'errors' => [
                        'required' => '%s masih kosong.',
                        'matches' => '%s tidak sama dengan Password.'
                ],
        ]
    ];

    $this->form_validation->set_rules($validasi);
    $this->form_validation->set_error_delimiters('<li>', '</li>');

    //Jika validasi gagal
    if ($this->form_validation->run() == FALSE) {
        tampil_pesan_json(FALSE, validation_errors(), 200);
    }
    else {

      $hasil = $this->model_user->tampil_user_dengan('id', $this->session->userdata('u_id'));

      if (password_verify($this->input->post('pass_lama'), $hasil->row('password'))) {

        $password = $this->model_user->buat_password($this->input->post('pass_baru'));

        $this->model_user->perbaharui($this->session->userdata('u_id'), ['password' => $password]);

          tampil_pesan_json(TRUE, 'Berhasil mengedit akun', 200);
      }

      tampil_pesan_json(FALSE, 'Password Lama kamu salah', 200);

    }

  }

  public function hapus_akun()
  {
    $this->permintaan_post();
    $this->sudah_login();

    //hapus user beserta datanya dari database
    $this->model_user->hapus($this->session->userdata('u_id'));
    tampil_pesan_json(TRUE, 'Berhasil menghapus akun', 200);
  }

  public function hapus_user()
  {
    $this->permintaan_post();
    $this->sudah_login();
    $this->sesi_admin();

    //hapus user beserta datanya dari database
    $this->model_user->hapus($this->input->post('id'));
    tampil_pesan_json(TRUE, 'Berhasil menghapus user', 200);

  }

  public function pengaturan_google()
  {
    $this->permintaan_post();
    $this->sudah_login();
    $this->sesi_admin();

    if ($this->input->post('simpan_pengaturan')) {
       update_pengaturan('g_login', $this->input->post('g_login'));
       update_pengaturan('g_client_id', $this->input->post('g_client_id'));
       update_pengaturan('g_client_secret', $this->input->post('g_client_secret'));
    }
    tampil_pesan_json(TRUE, 'Pengaturan berhasil disimpan', 200);
  }

  public function pengaturan_github()
  {
    $this->permintaan_post();
    $this->sudah_login();
    $this->sesi_admin();

    if ($this->input->post('simpan_pengaturan')) {
       update_pengaturan('git_login', $this->input->post('git_login'));
       update_pengaturan('git_client_id', $this->input->post('git_client_id'));
       update_pengaturan('git_client_secret', $this->input->post('git_client_secret'));
    }
    tampil_pesan_json(TRUE, 'Pengaturan berhasil disimpan', 200);
  }

  public function pengaturan_twitter()
  {
    $this->permintaan_post();
    $this->sudah_login();
    $this->sesi_admin();

    if ($this->input->post('simpan_pengaturan')) {
       update_pengaturan('tw_login', $this->input->post('tw_login'));
       update_pengaturan('tw_api_key', $this->input->post('tw_api_key'));
       update_pengaturan('tw_secret_key', $this->input->post('tw_secret_key'));
    }
    tampil_pesan_json(TRUE, 'Pengaturan berhasil disimpan', 200);
  }

  public function pengaturan_facebook()
  {
    $this->permintaan_post();
    $this->sudah_login();
    $this->sesi_admin();

    if ($this->input->post('simpan_pengaturan')) {
      update_pengaturan('fb_app_id', $this->input->post('fb_app_id'));
      update_pengaturan('fb_app_secret', $this->input->post('fb_app_secret'));
      update_pengaturan('fb_login', $this->input->post('fb_login'));
    }
    tampil_pesan_json(TRUE, 'Pengaturan berhasil disimpan', 200);
  }

  public function test_email()
  {
    $this->permintaan_post();
    $this->sudah_login();
    $this->sesi_admin();

    $email = kirim_email([
      'penerima' => $this->input->post('test_email'),
      'tipe' => ''
    ]);

    if ($email) {
      tampil_pesan_json(TRUE, 'Konfigurasi sukses ! Email berhasil terkirim', 200);
    }

      tampil_pesan_json(FALSE, 'Email tidak terkirim. Mohon untuk cek kembali konfigurasi email Anda', 200);
  }

  public function kirim_chat()
  {
    $this->permintaan_post();
    $this->sudah_login();
    $data = [
      'id_user' => $this->session->userdata('u_id'),
      'chat' => $this->input->post('pesan', TRUE),
      'waktu' => date('Y-m-d H:i:s')
    ];

    $this->db->insert('chat_room', $data);
    tampil_pesan_json(TRUE, '', 200);
  }

  public function muat_chat()
  {
    $this->permintaan_post();
    $this->sudah_login();

    $this->db->select('*');
    $this->db->from('chat_room');
    $this->db->join('users', 'users.id = chat_room.id_user');
    $query = $this->db->get();


    foreach ($query->result() as $value) {
      if ($value->id_user == $this->session->userdata('u_id'))
      {
        $chat= '<div class="direct-chat-msg right">
          <div class="direct-chat-info clearfix">
            <span class="direct-chat-name pull-right">'.$value->nama.' '.ini_admin($value->level).'</span>
            <span class="direct-chat-timestamp pull-left">'.$value->waktu.'</span>
          </div>
          <img class="direct-chat-img" src="'.base_url('assets/img/upload/' . $value->foto).'" alt="message user image">
          <div class="direct-chat-text">
            '.$value->chat.'
          </div>
        </div>';
      }
      else {
        $chat= '<div class="direct-chat-msg">
              <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-left">'.$value->nama.' '.ini_admin($value->level).'</span>
                <span class="direct-chat-timestamp pull-right">'.$value->waktu.'</span>
              </div>
              <img class="direct-chat-img" src="'.base_url('assets/img/upload/' . $value->foto).'" alt="message user image">
              <div class="direct-chat-text">
                '.$value->chat.'
              </div>
            </div>';
      }
      echo $chat;
    }

  }

  private function permintaan_post()
  {
    //Jika bukan permintaan post tampilkan error
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
       tampil_pesan_json(FALSE, 'Jangan nakal ya :)', 400);
    }
  }

  private function permintaan_ajax()
  {
    //Jika bukan permintaan ajax tampilkan error
    if( ! $this->input->is_ajax_request())  {
      tampil_pesan_json(FALSE, 'Jangan nakal ya :)', 400);
    }
  }

  private function sesi_admin()
  {
    //Jika level bukan admin tampilkan error
    if ($this->session->userdata('u_level') !== "1") {
       tampil_pesan_json(FALSE, 'Jangan nakal ya :)', 400);
    }
  }

  private function sudah_login()
  {
    //Jika belum login tampikan error
    if ( ! $this->model_user->cek_session()) {
       tampil_pesan_json(FALSE, 'Jangan nakal ya :)', 400);
    }
  }

}
