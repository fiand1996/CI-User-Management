<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Template Class
 *
 * @package     CodeIgniter
 * @category    Library
 * @author      FIAND T
 * @link        https://www.facebook.com/alfianvega
 */

class Template
{
  public function view($template = NULL, $data = NULL, $script = NULL)
  {
      if ($template !== NULL)
      {
        if ($script !== NULL)
        {
          $script_custom = $this->load('script/'.$script, $data);
        }
        else
        {
          $script_custom = NULL;
        }

        $layout = [
          'head'    => $this->load('layout/head', $data),
          'sidebar' => $this->load('layout/sidebar', $data),
          'content' => $this->load($template, $data),
          'script'  => $this->load('layout/script', $data),
          'footer'  => $this->load('layout/footer', $data),
          'script_custom' => $script_custom
        ];

        echo $this->load->view('layout/template', $layout, TRUE);
      }
  }

  private function load($load, $data)
  {
    return $this->load->view($load, $data, TRUE);
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
