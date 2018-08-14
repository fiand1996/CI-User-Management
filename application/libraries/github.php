<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Github Class
 *
 * @package     CodeIgniter
 * @category    Library
 * @author      FIAND T
 * @link        https://www.facebook.com/alfianvega
 */

class GitHub
{
  private $apiURLBase;
  private $authorizeURL;
  private $tokenURL;
  private $clientID;
  private $clientSecret;

  public function __construct()
  {
    $this->authorizeURL = 'https://github.com/login/oauth/authorize';
    $this->tokenURL = 'https://github.com/login/oauth/access_token';
    $this->apiURLBase = 'https://api.github.com/';
    $this->clientID = pengaturan('git_client_id');
    $this->clientSecret = pengaturan('git_client_secret');
  }

  public function apiRequest($url)
  {
    $context  = stream_context_create([
      'http' => [
        'user_agent' => pengaturan('nama_aplikasi'),
        'header' => 'Accept: application/json'
      ]
    ]);
    $response = @file_get_contents($url, false, $context);
    return $response ? json_decode($response) : $response;
  }

  public function dapatkanAksesToken($code)
  {
    return $this->apiRequest($this->tokenURL . '?' . http_build_query([
      'client_id' => $this->clientID,
      'client_secret' => $this->clientSecret,
      'state' => $this->session->userdata('state'),
      'code' => $code
    ]));
  }

  public function verifikasiState()
  {
    if ( ! $this->input->get('state') || $this->session->userdata('state') != $this->input->get('state'))
    {
      redirect(base_url('auth/github'));
    }
  }

  public function setelSesiToken($token) {
    return $this->session->set_userdata('access_token', $token);
  }

  public function punyaToken()
  {
    if ($this->session->has_userdata('access_token') &&
        $this->session->userdata('access_token'))
    {
      return true;
    }
    return false;
  }

  public function hapusSesiToken()
  {
    return $this->session->unset_userdata(['state','access_token']);
  }

  public function dapatkanInfoUser()
  {
    return (array) $this->apiRequest($this->apiURLBase . 'user?access_token=' . $this->session->userdata('access_token'));
  }

  public function URLmasuk()
  {
    $state = hash('sha256', microtime(TRUE) . rand() . $_SERVER['REMOTE_ADDR']);
    $this->session->set_userdata('state', $state);

    return $this->authorizeURL . '?' . http_build_query([
      'client_id' => $this->clientID,
      'redirect_uri' => base_url('auth/github'),
      'state' => $this->session->userdata('state'),
      'scope' => 'user,gist,user:email'
    ]);
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
