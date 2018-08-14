<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Facebook Class
 *
 * @package     CodeIgniter
 * @category    Library
 * @author      FIAND T
 * @link        https://www.facebook.com/alfianvega
 */

// masukkan SDK Facebook
require APPPATH .'third_party/Facebook/autoload.php';

use Facebook\Facebook as FB;
use Facebook\Authentication\AccessToken;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Helpers\FacebookJavaScriptHelper;
use Facebook\Helpers\FacebookRedirectLoginHelper;

Class Facebook
{
    /**
     * @var FB
     */
    private $fb;
    /**
     * @var FacebookRedirectLoginHelper|FacebookJavaScriptHelper
     */
    private $helper;

    /**
     * Facebook constructor.
     */
    public function __construct(){

        // Memuat konfigurasi facebook
        $this->load->config('facebook');

        if (!isset($this->fb)){
            $this->fb = new FB([
                'app_id'                => $this->config->item('facebook_app_id'),
                'app_secret'            => $this->config->item('facebook_app_secret'),
                'default_graph_version' => $this->config->item('facebook_graph_version')
            ]);
        }

        //Memuat helper Facebook sesuai tipe login
        switch ($this->config->item('facebook_login_type')){
            case 'js':
                $this->helper = $this->fb->getJavaScriptHelper();
                break;
            case 'canvas':
                $this->helper = $this->fb->getCanvasHelper();
                break;
            case 'page_tab':
                $this->helper = $this->fb->getPageTabHelper();
                break;
            case 'web':
                $this->helper = $this->fb->getRedirectLoginHelper();
                break;
        }

        if ($this->config->item('facebook_auth_on_load') === TRUE){

            // mengautentifikasi user dan dapatkan token akses yang valid)
            $this->autentifikasi();
        }
    }

    /**
     * @return FB
     */
    public function object(){
        return $this->fb;
    }

    /**
     * Cek apakah user sudah login menggunakan akses token
     *
     * @return mixed|boolean
     */
    public function diautentifikasi(){
        $access_token = $this->autentifikasi();
        if(isset($access_token)){
            return $access_token;
        }
        return false;
    }

    /**
     * Melakukan permintaan ke facebook
     *
     * @param       $method
     * @param       $endpoint
     * @param array $params
     * @param null  $access_token
     *
     * @return array
     */
    public function permintaan($method, $endpoint, $params = [], $access_token = null){
        try{
            $response = $this->fb->{strtolower($method)}($endpoint, $params, $access_token);
            return $response->getDecodedBody();
        }catch(FacebookResponseException $e){
            return $this->logError($e->getCode(), $e->getMessage());
        }catch (FacebookSDKException $e){
            return $this->logError($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Hasilkan url login Facebook untuk web
     *
     * @return  string
     */
    public function URLmasuk(){

        // Jenis login harus web, selain itu mengembalikan string kosong
        if($this->config->item('facebook_login_type') != 'web'){
            return '';
        }

        // Dapatkan Url login
        return $this->helper->getLoginUrl(
            base_url() . $this->config->item('facebook_login_redirect_url'),
            $this->config->item('facebook_permissions')
        );
    }

    /**
     * Hasilkan url logout Facebook untuk web
     *
     * @return string
     */
    public function logout_url(){

        // Jenis login harus web, selain itu mengembalikan string kosong
        if($this->config->item('facebook_login_type') != 'web'){
            return '';
        }
        // Dapatkan Url keluar
        return $this->helper->getLogoutUrl(
            $this->get_access_token(),
            base_url() . $this->config->item('facebook_logout_redirect_url')
        );
    }

    /**
     * Hapus sesi facebook
     */
    public function hapus_sesi(){
        $this->session->unset_userdata('fb_access_token');
    }

    /**
     * Dapatkan akses token baru dari facebook
     *
     * @return array|AccessToken|null|object|void
     */
    private function autentifikasi(){
        $access_token = $this->get_access_token();
        if($access_token && $this->get_expire_time() > (time() + 30) || $access_token && !$this->get_expire_time()){
            $this->fb->setDefaultAccessToken($access_token);
            return $access_token;
        }

        //Jika tidak memiliki token akses yang disimpan atau jika token telah kedaluwarsa, coba dapatkan akses token baru
        if(!$access_token){
            try{
                $access_token = $this->helper->getAccessToken();
            }catch (FacebookSDKException $e){
                $this->logError($e->getCode(), $e->getMessage());
                return null;
            }

            if(isset($access_token)){
                $access_token = $this->long_lived_token($access_token);
                $this->set_expire_time($access_token->getExpiresAt());
                $this->set_access_token($access_token);
                $this->fb->setDefaultAccessToken($access_token);
                return $access_token;
            }
        }

        if($this->config->item('facebook_login_type') === 'web'){
            if($this->helper->getError()){

                $error = array(
                    'error'             => $this->helper->getError(),
                    'error_code'        => $this->helper->getErrorCode(),
                    'error_reason'      => $this->helper->getErrorReason(),
                    'error_description' => $this->helper->getErrorDescription()
                );
                return $error;
            }
        }
        return $access_token;
    }

    /**
     * Tukarkan token berumur singkat menjadi umur panjang
     *
     * @param AccessToken $access_token
     *
     * @return AccessToken|null
     */
    private function long_lived_token(AccessToken $access_token){
        if(!$access_token->isLongLived()){
            $oauth2_client = $this->fb->getOAuth2Client();
            try{
                return $oauth2_client->getLongLivedAccessToken($access_token);
            }catch (FacebookSDKException $e){
                $this->logError($e->getCode(), $e->getMessage());
                return null;
            }
        }
        return $access_token;
    }

    /**
     * Dapatkan akses token yang disimpan
     *
     * @return mixed
     */
    private function get_access_token(){
        return $this->session->userdata('fb_access_token');
    }

    /**
     * Simpan akses token
     *
     * @param AccessToken $access_token
     */
    private function set_access_token(AccessToken $access_token){
        $this->session->set_userdata('fb_access_token', $access_token->getValue());
    }

    /**
     * @return mixed
     */
    private function get_expire_time(){
        return $this->session->userdata('fb_expire');
    }

    /**
     * @param DateTime $time
     */
    private function set_expire_time(DateTime $time = null){
        if ($time) {
            $this->session->set_userdata('fb_expire', $time->getTimestamp());
        }
    }

    /**
     * @param $code
     * @param $message
     *
     * @return array
     */
    private function logError($code, $message){
        log_message('error', '[FACEBOOK PHP SDK] code: ' . $code.' | message: '.$message);
        return ['error' => $code, 'message' => $message];
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
