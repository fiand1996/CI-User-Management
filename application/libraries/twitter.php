<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Twitter Class
 *
 * @package     CodeIgniter
 * @category    Library
 * @author      FIAND T
 * @link        https://www.facebook.com/alfianvega
 */

// masukkan SDK Twitter
require APPPATH .'third_party/Twitter/twitteroauth.php';

class Twitter
{

  private $customer_key;
  private $customer_secret;
  private $oauth_callback;

  public function __construct()
  {
    $this->customer_key = pengaturan('tw_api_key');
    $this->customer_secret = pengaturan('tw_secret_key');
    $this->oauth_callback = base_url('auth/twitter');
  }

  public function URLmasuk()
  {
    //Fresh authentication
    $connection = new TwitterOAuth($this->customer_key, $this->customer_secret);
    $request_token = $connection->getRequestToken($this->oauth_callback);

    //Received token info from twitter

    $this->session->set_userdata([
      'token' => $request_token['oauth_token'],
      'token_secret' => $request_token['oauth_token_secret']

    ]);

    //Any value other than 200 is failure, so continue only if http code is 200
    if ($connection->http_code == '200') {
      //redirect user to twitter
       return $connection->getAuthorizeURL($request_token['oauth_token']);

    }
    else{
      die("error connecting to twitter! try again later!");
    }

  }

  public function dapatkanInfoUser()
  {
    //Successful response returns oauth_token, oauth_token_secret, user_id, and screen_name
    $connection = new TwitterOAuth($this->customer_key, $this->customer_secret, $this->session->userdata('token') , $this->session->userdata('token_secret'));
    $access_token = $connection->getAccessToken($this->input->get_post('oauth_verifier'));

    if($connection->http_code == '200')
    {
      //Redirect user to twitter
      //Insert user into the database
      $param = array(
          'include_entities' => 'false',
          'skip_status' => 'true',
          'include_email' => 'true'
      );

      return (array) $connection->get('account/verify_credentials', $param);
    }
    else{
      die("error, try again later!");
    }
  }

  public function hapusSesiToken()
  {
    return $this->session->unset_userdata(['token','token_secret']);
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
