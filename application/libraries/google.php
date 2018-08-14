<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Google Class
 *
 * @package     CodeIgniter
 * @category    Library
 * @author      FIAND T
 * @link        https://www.facebook.com/alfianvega
 */

// masukkan SDK Google
require APPPATH .'third_party/Google/autoload.php';

class Google
{
    private $client;
    private $Oauth2;

    public function __construct()
    {
      $this->client = new Google_Client();

      $this->client->setApplicationName(pengaturan('nama_aplikasi'));
      $this->client->setClientId(pengaturan('g_client_id'));
      $this->client->setClientSecret(pengaturan('g_client_secret'));
      $this->client->setRedirectUri(base_url('auth/google'));
      $this->client->setScopes([
        "https://www.googleapis.com/auth/plus.login",
        "https://www.googleapis.com/auth/userinfo.email",
        "https://www.googleapis.com/auth/userinfo.profile",
        "https://www.googleapis.com/auth/plus.me",
      ]);

      // Send Client Request
      $this->plus = new Google_Service_Plus($this->client);
    }

    public function punyaToken() {
      if ($this->session->has_userdata('access_token') &&
          $this->session->userdata('access_token'))
      {
        return true;
      }
      return false;
    }

    public function URLmasuk() {
      return $this->client->createAuthUrl();
    }

    public function token() {
      return $this->session->userdata('access_token');
    }

    public function setelSesiToken() {
      return $this->session->set_userdata('access_token', $this->dapatkanAksesToken());
    }

    public function dapatkanOtentikasi($kode) {
      return $this->client->authenticate($kode);
    }

    public function dapatkanAksesToken() {
      return $this->client->getAccessToken();
    }

    public function setelAksesToken($token) {
      return $this->client->setAccessToken($token);
    }

    public function hapusToken() {
      return $this->client->revokeToken();
    }

    public function hapusSesiToken() {
      return  $this->session->unset_userdata('access_token');
    }

    public function dapatkanInfoUser() {
      return $this->plus->people->get("me");
    }

    /**
     * Memungkinkan mengakses fungsi CI tanpa harus mendefinisikan variabel tambahan.
     *
     * @param $var
     *
     * @return mixed
     */
    public function __get($var){
        return get_instance()->$var;
    }

}
