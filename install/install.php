<?php
error_reporting(0);
session_start();

define('ABSPATH',dirname(__FILE__).'/');
define('BASEPATH',dirname($_SERVER['PHP_SELF']));
/**
 * dapatkan_url_protokol
 *
 * @return string
 */
function dapatkan_url_protokol() {
    $ini_aman = false;
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        $ini_aman = true;
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
        $ini_aman = true;
    }
    return $ini_aman ? 'https' : 'http';
}


/**
 * dapatkan_url_sistem
 *
 * @return string
 */
function dapatkan_url_sistem() {
    $protokol = dapatkan_url_protokol();
    $url_sistem =  $protokol."://".$_SERVER['HTTP_HOST'].BASEPATH;
    return rtrim($url_sistem,'/');
}


/**
 * cek_url_sistem
 *
 * @return void
 */
function cek_url_sistem() {
    $protokol = dapatkan_url_protokol();
    $parsed_url = parse_url(SYS_URL);
    if( ($parsed_url['scheme'] != $protokol) || ($parsed_url['host'] != $_SERVER['HTTP_HOST']) ) {
        header('Location: '.SYS_URL);
    }
}

function baseDomain(){
      if (isset($_SERVER['HTTP_HOST'])) {
          $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
          $hostname = $_SERVER['HTTP_HOST'];
          $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

          $tmplt = "%s://%s%s";
          $end = $dir;
          $base_url = sprintf( $tmplt, $http, $hostname, $end );
      }
      else $base_url = 'http://localhost/';

      return str_replace("/install","",$base_url);
  }

function simpan_dbconfig($data) {

    // Config path
    $template_path  = 'include/database.php';
    $output_path    = '../application/config/database.php';

    // Open the file
    $database_file = file_get_contents($template_path);

    $new  = str_replace("%HOSTNAME%",$data['dbhost'],$database_file);
    $new  = str_replace("%USERNAME%",$data['dbusername'],$new);
    $new  = str_replace("%PASSWORD%",$data['dbpassword'],$new);
    $new  = str_replace("%DATABASE%",$data['dbname'],$new);

    // Write the new database.php file
    $handle = fopen($output_path,'w+');

    // Chmod the file, in case the user forgot
    @chmod($output_path,0777);

    // Verify file permissions
    if(is_writable($output_path)) {

        // Write the file
        if(fwrite($handle,$new)) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }
}

function simpan_webconfig($data) {

    // Config path
    $template_path  = 'include/config.php';
    $output_path    = '../application/config/config.php';

    // Open the file
    $config_file = file_get_contents($template_path);

    $new  = str_replace("%BASE_URL%",$data,$config_file);

    // Write the new database.php file
    $handle = fopen($output_path,'w+');

    // Chmod the file, in case the user forgot
    @chmod($output_path,0777);

    // Verify file permissions
    if(is_writable($output_path)) {

        // Write the file
        if(fwrite($handle,$new)) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }
}

function tampil_json($status, $pesan)
{
	$data = [
		'status' => $status,
		'pesan' => $pesan
	];
    header('Content-Type: application/json;charset=utf-8');
	echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
	tampil_json(FALSE, 'Jangan nakal ya :)');
}

if (isset($_POST['halaman_requirement']))
{
	include "template/halaman_requirement.php";
}

if (isset($_POST['halaman_database']))
{
	include "template/halaman_database.php";
}

if (isset($_POST['koneksi_sukses']))
{
	include "template/koneksi_sukses.php";
}

if (isset($_POST['cek_koneksi']))
{
  $db = new mysqli($_POST["dbhost"], $_POST["dbusername"], $_POST["dbpassword"], $_POST["dbname"]);
	if($db->connect_error)
	{
		tampil_json(FALSE, 'Ups!!! Gagal melakukan koneksi ke database. Silahkan periksa kembali detail database Anda :)');
	}

  $_SESSION['dbhost'] = $_POST["dbhost"];
  $_SESSION['dbusername'] = $_POST["dbusername"];
  $_SESSION['dbpassword'] = $_POST["dbpassword"];
  $_SESSION['dbname'] = $_POST["dbname"];

  include "template/koneksi_sukses.php";
}


if (isset($_POST['install']))
{
	$db = new mysqli($_SESSION["dbhost"], $_SESSION["dbusername"], $_SESSION["dbpassword"], $_SESSION["dbname"]);
	if($db->connect_error)
	{
		tampil_json(FALSE, 'Ups!!! Gagal melakukan koneksi ke database. Silahkan periksa kembali detail database Anda :)');
	}

  $db->set_charset("utf8");

  $structure = "";

  $sqlquery = file_get_contents('dump/dump.sql');
  $db->query( 'SET @@global.max_allowed_packet = ' . 6 * 1024 * 1024 );
  $db->multi_query($sqlquery) or tampil_json(FALSE, $db->error);
  $count = 0;
  // flush multi_queries
  do{

     //require_once("progress.php");

    } while(mysqli_more_results($db) && mysqli_next_result($db));


      if (simpan_dbconfig($_SESSION) && simpan_webconfig(baseDomain())) {
        include "template/install_sukses.php";

      }
      else {
        tampil_json(FALSE, 'Tidak bisa membuat file konfigurasi');
      }

  session_destroy();

}
