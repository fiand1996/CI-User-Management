<?php

defined('BASEPATH') or exit('No direct script access allowed');

function simpan_gambar_oauth($url)
{

  $dir = './assets/img/upload/';
  $opt = [
      'ssl' => [
        "verify_peer"=> false,
        "verify_peer_name"=> false
      ]
  ];

  $name = random_string('numeric', 10);
  $img_name = 'user.png';

  if (write_file($dir . $name . '.jpg', file_get_contents($url, false, stream_context_create($opt))))
  {
    $img_name = $name . '.jpg';
  }

  return $img_name;
}
