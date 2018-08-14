<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model_user Class
 *
 * @package     CodeIgniter
 * @category    Model
 * @author      FIAND T
 * @link        https://www.facebook.com/alfianvega
 */

class Model_user extends CI_Model
{

  protected $error;

  public function __call($function, $args)
  {
      $functionType = strtolower(substr($function, 0, 3));
      $propName = lcfirst(substr($function, 3));

      switch ($functionType) {
          case 'get':
              if (property_exists($this, $propName)) {
                  return $this->$propName;
              }
              break;
          case 'set':
              if (property_exists($this, $propName)) {
                  $this->$propName = $args[0];
              }
              break;
      }
  }

  /**
   * Tambah data user
   * Mengambalikan nilai user_id jika berhasil menambahkan user dan mengambalikan nilai false jika gagal
   *
   * @param array $data
   *
   * @return int|boolean
   *
   */
  public function tambah(array $data = [])
  {
    //Menguraikan data user yang mana berupa array
    foreach ($data as $field => $nilai) {
      $this->db->set($field, $nilai);
    }

    //Eksekusi dengan menginputkan data ke dalam table users
    $this->db->insert('users');

    //Mengembalikan hasil berupa int atau boolean
    return $this->db->affected_rows() > 0 ? $this->db->insert_id() : false;
  }

  /**
   * Perbaharui data user
   * Mengambalikan nilai user_id jika berhasil menambahkan user dan mengambalikan nilai false jika gagal
   *
   * @param array $data
   *
   * @return int|boolean
   *
   */
  public function perbaharui($id, array $data = [])
  {
    //Menguraikan data user yang mana berupa array
    foreach ($data as $field => $nilai) {
      $this->db->set($field, $nilai);
    }

    //Memasukkan kondisi user dengan id berapa yang akan diedit
    $this->db->where("id", (int)$id);

    //Eksekusi dengan mengupdate data user dengan id yang telah ditentukan
    $this->db->update("users");

    //Mengembalikan hasil berupa int atau boolean
    return $this->db->affected_rows() > 0;
  }

  /**
   * Menghapus data user
   * Mengambalikan nilai false jika data yang akan dihapus sudah tidak ada
   *
   * @param int $user_id
   *
   * @return boolean
   *
   */
  public function hapus($user_id)
  {
    //Mengambil data user berdasarkan id
    $hasil = $this->tampil_user_dengan('id', $user_id);

    //Mengembalikan nilai false jika tidak ada hasil data
    if( ! $hasil->row()) {
       return false;
    }

    //Menghapus gambar yang ada di dalam directory /assets/img/upload/ jika nama gambar bukan user.png
    if ($hasil->row('foto') !== 'user.png') {
       unlink('./assets/img/upload/' . $hasil->row('foto'));
    }

    //Menghapus data user di database
    $this->db->where('id_user', $user_id)->delete('users_log');
    $this->db->where('id_user', $user_id)->delete('users_session');
    $this->db->where('id_user', $user_id)->delete('chat_room');
    $this->db->where('id', $user_id)->delete('users');
  }

  public function oauth_data(array $data = [])
  {
      $this->load->helper('oauth');
      $user = $this->tampil_user_dimana(['id_oauth' => $data['id_oauth'], 'provider_oauth' => $data['provider_oauth'] ]);

      if($user->num_rows() > 0)
      {
        $this->perbaharui($user->row('id'), [
          'nama' => $data['nama'],
          'email' => $data['email'],
        ]);

        $IDuser = $user->row('id');
      }
      else
      {
        $this->tambah([
          'id_oauth' => $data['id_oauth'],
          'provider_oauth' => $data['provider_oauth'],
          'nama' => $data['nama'],
          'email' => $data['email'],
          'foto' => simpan_gambar_oauth($data['foto'])
        ]);

        $IDuser = $this->db->insert_id();
      }

      return $IDuser ? $IDuser : false;
  }

  /**
   * Menampilkan data user
   * Mengambalikan hasil dalam bentuk object
   *
   * @param string $field
   * @param mixed $nilai
   *
   * @return object
   *
   */
  public function tampil_user_dengan($field, $nilai)
  {
    //Menampilkan user bersadarkan field dan nilai tertentu
    $this->db->from('users');
    $this->db->where($field, $nilai);
    $this->db->limit(1);

    //Mengembalikan hasil berupa object
    return $this->db->get();
  }

  /**
   * Tambah data user
   * Mengambalikan nilai user_id jika berhasil menambahkan user dan mengambalikan nilai false jika gagal
   *
   * @param array $data
   *
   * @return int|boolean
   *
   */
  public function tampil_user_dimana(array $data = [])
  {
    $this->db->from('users');

    foreach ($data as $field => $nilai) {
      $this->db->where($field, $nilai);
    }

    return $this->db->get();
  }

  public function member_baru()
  {
    return $this->db->from('users')->where('level', 2)->limit(8)->get();
  }

  public function aktivasi_akun($email, $kode)
  {
    $query = $this->tampil_user_dimana(['email' => $email, 'kunci_unik' => $kode]);

    if ($query->num_rows() == 1) {
        $this->perbaharui($query->row('id'), ['status' => 1, 'kunci_unik' => NULL]);
        return true;
    }
    return false;
  }

  public function session_instan($id)
  {
    $hasil = $this->tampil_user_dengan('id', $id);
    $this->buat_session([
      'u_id' => $hasil->row('id'),
      'u_email' => $hasil->row('email'),
      'u_level' => $hasil->row('level'),
      'u_session' => TRUE
    ]);

    $this->model_user->simpan_aktifitas($hasil->row('id'), 'login');
  }

  public function cek_rememberMe()
  {
    $query = $this->db->select('*')
                      ->from('users_session')
                      ->where('id_user', $this->decrypt(get_cookie('verifyKey')))
                      ->where('ip', $this->input->ip_address())
                      ->where('user_agent', $this->user_agent())
                      ->get();

    return $query->num_rows() == 1 ? true : false;
  }

  public function encrypt($text)
  {
    return $this->encryption->encrypt($text);
  }

  public function decrypt($text)
  {
    return $this->encryption->decrypt($text);
  }

  /**
   * Tambah data user
   * Mengambalikan nilai user_id jika berhasil menambahkan user dan mengambalikan nilai false jika gagal
   *
   * @param array $data
   *
   * @return int|boolean
   *
   */
  public function data_user_session()
  {
    $query = $this->db->get_where('users', array('id' => $this->session->userdata('u_id')));
    return $query->row();
  }

  /**
   * Login user
   * Membuat sesi user
   *
   * @param mixed $email
   * @param mixed $password
   * @param mixed $remember
   *
   * @return false
   *
   */
  public function login($email, $password, $remember = NULL)
  {
    //Cari user dengan email
    $hasil = $this->tampil_user_dengan('email', $email);

    //Jika email atau password salah
    if ( ! $this->check_password($password, $hasil->row('password'))) {
       $this->setError('Email atau password yang Anda masukkan salah');
       return false;
    }

    //Jika user belum aktif
    if ($hasil->row('status') == 0) {
       $this->setError('Akun belum aktif, Cek email Anda dan ikuti langkah yang ada');
       return false;
    }

    //Jika ingin menyimpan sesi
    if ($remember) {
       $this->simpan_session($hasil->row('id'));
    }

    $this->session_instan($hasil->row('id'));
  }

  public function reset($email)
  {

    $hasil = $this->tampil_user_dengan('email', $email);

    if ($hasil->num_rows() == 1) {

      $password = random_string('alnum', 12);

      $this->perbaharui($hasil->row('id'), [
        'password' => $this->buat_password($password),
      ]);

      $email =  kirim_email([
        'penerima' => $email,
        'tipe' => 'reset_password',
        'link' => $password
      ]);

      if ( ! $email) {
        $this->setError('Maaf sistem kami ada kesalahan, mohon ulangi beberapa saat lagi');
        return false;
      }
      return true;
    }
    $this->setError('Email yang anda masukkan tidak ditemukan');
    return false;
  }

  /**
   * Tambah data user
   * Mengambalikan nilai user_id jika berhasil menambahkan user dan mengambalikan nilai false jika gagal
   *
   * @param array $data
   *
   * @return int|boolean
   *
   */
  public function cek_session()
  {
    if ($this->session->has_userdata('u_session') &&
        $this->session->userdata('u_session') === TRUE)
    {
      $query = $this->db->select('*')
                        ->from('users')
                        ->where('id', $this->session->userdata('u_id'))
                        ->get();

      if ($query->num_rows() === 1) {

        return TRUE;
      }
    }
    elseif ($this->cek_rememberMe()) {
      $this->session_instan($this->decrypt(get_cookie('verifyKey')));
      return TRUE;
    }
    else {
      $this->logout();

      return FALSE;
    }

  }

  public function simpan_session($id)
  {
    $query = $this->db->get_where('users_session', array('id_user' => $id, 'user_agent' => $this->user_agent(), 'ip' => $this->input->ip_address()));

    $this->db->set('ip', $this->input->ip_address());
    $this->db->set('user_agent', $this->user_agent());
    $this->db->set('time', date('Y-m-d H:i:s'));
    $this->db->set('id_user', $id);

    if ($query->num_rows() === 0)
    {
      $this->input->set_cookie([
        'name'   => 'verifyKey',
        'value'  => $this->encrypt($id),
        'expire' => 3600*24*365.2425,
        'path'   => '/',
        'secure' => FALSE
      ]);

      $this->db->insert('users_session');
    }
  }

  public function hapus_session()
  {
    $this->db->where('id_user', $this->decrypt(get_cookie('verifyKey')))
             ->where('ip', $this->input->ip_address())
             ->where('user_agent', $this->user_agent())
             ->delete('users_session');

    delete_cookie('verifyKey');
  }

  /**
   * Tambah data user
   * Mengambalikan nilai user_id jika berhasil menambahkan user dan mengambalikan nilai false jika gagal
   *
   * @param array $data
   *
   * @return int|boolean
   *
   */
  public function logout()
  {
    $this->hapus_session();
    //$this->simpan_aktifitas($this->session->userdata('u_id'), 'logout');
    return $this->session->unset_userdata(['u_id', 'u_email', 'u_level', 'u_session']);
  }

  public function buat_session(array $data = [])
  {
    return $this->session->set_userdata($data);
  }

  /**
   * Tambah data user
   * Mengambalikan nilai user_id jika berhasil menambahkan user dan mengambalikan nilai false jika gagal
   *
   * @param array $data
   *
   * @return int|boolean
   *
   */
  public function check_password($password, $passwordDb)
  {
    return password_verify($password, $passwordDb) ? true : false;
  }

  /**
   * Tambah data user
   * Mengambalikan nilai user_id jika berhasil menambahkan user dan mengambalikan nilai false jika gagal
   *
   * @param array $data
   *
   * @return int|boolean
   *
   */
  public function buat_password($password)
  {
    $options = [
        'memory_cost' => 1024,
        'time_cost'   => 4,
        'threads'     => 3,
    ];

    return password_hash($password, PASSWORD_ARGON2I, $options);
  }

  public function user_agent()
  {
    return $_SERVER['HTTP_USER_AGENT'];
  }

  public function error()
  {
    return $this->error();
  }

  public function simpan_aktifitas($user_id, $nama_aktifitas)
  {
    switch ($nama_aktifitas) {
      case 'login':
        $log = 'Melakukan login';
        break;

      case 'logout':
        $log = 'Melakukan logout';
        break;

      case 'ubah_pw':
        $log = 'Mengubah password';
        break;

      case 'ubah_img':
        $log = 'Mengubah gambar profile';
        break;

      default:
        $log = 'Tidak diketahui';
        break;
    }

    $data = [
      'id_user' => $user_id,
      'log' => $log,
      'time' =>  date('Y-m-d H:i:s')
    ];

    $this->db->insert('users_log', $data);
  }

  public function tampilkan_json($status, $message, $code)
  {
    $data = [
      'status' => $status,
      'message'  => $message,
    ];

    $this->output
      ->set_status_header($code)
      ->set_header('Cache-Control: no-store, no-cache, must-revalidate')
      ->set_header('Cache-Control: post-check=0, pre-check=0')
      ->set_header('Pragma: no-cache')
      ->set_header('Access-Control-Allow-Headers: Authorization, Content-Type')
      ->set_header('Access-Control-Max-Age: 600')
      ->set_header('Vary: Accept')
      ->set_content_type('application/json', 'utf-8')
      ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
      ->_display();
    exit;
  }

}
