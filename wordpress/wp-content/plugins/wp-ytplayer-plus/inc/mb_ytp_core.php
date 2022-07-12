<?php
/**
 * Created by mb.ideas.
 * User: pupunzi
 * Date: 10/12/16
 * Time: 22:28
 */

if (!class_exists("ytp_mb_core")) {

  class ytp_mb_core
  {
    function __construct($name_space, $lic_key, $plugin_base)
    {
      $this->name_space = $name_space;
      $this->lic_key = $lic_key;
      $this->base = $plugin_base;

      $this->server_url = 'https://pupunzi.com/wpPlus/controller.php';

      $dir_name = dirname($plugin_base);
      $lic_file_path = $dir_name . "/" . $name_space . ".lic";
      $this->lic_path = $lic_file_path;

      if (!extension_loaded('openssl')) {
        die ('This plug-in needs the Open SSL PHP extension to work. Activate this module or remove this plug-in');
      }
    }

    public function get_lic_domain()
    {
      // Set unique string for this site
      $lic_domain = $_SERVER['HTTP_HOST'];
      if (!isset($lic_domain) || empty($lic_domain))
        $lic_domain = $_SERVER['SERVER_NAME'];
      if (!isset($lic_domain) || empty($lic_domain))
        $lic_domain = $_SERVER['SERVER_ADDR'];
      if (!isset($lic_domain) || empty($lic_domain))
        $lic_domain = get_bloginfo('name');

      return $lic_domain;
    }

    public function validate_local_lic()
    {
      $rnd_verify = rand(0, 10);
      $lic_domain = $this->get_lic_domain();
      $lic_key = $this->lic_key;
      $xxx = 0;
      $is_local_server =
        strpos($_SERVER['REMOTE_ADDR'], '127.0.0.1') !== false ||
        strpos($_SERVER['REMOTE_ADDR'], '::1') !== false
        || strpos($lic_domain, 'localhost') !== false;

      if (isset($lic_key) && !empty($lic_key)) {
        $lic = $this->readLic();

        if ($rnd_verify == 4 && is_admin())
          $lic = $this->get_lic_from_server();

        //The lic has probably the wrong encryption reload it from the server
        if ((!$lic || !$lic["lic_state"]) && is_admin())
          $lic = $this->get_lic_from_server();

        if ($lic)
          $xxx = (($lic["lic_domain"] == $lic_domain) || ($lic["lic_type"] == "DEV" && $lic["lic_theme"] == get_template()) || $is_local_server) && $lic["plugin_prefix"] == $this->name_space && $lic["lic_state"] == "ACTIVE" && !$this->isExpired($lic);
        else { //The server can not be contacted
          $xxx = true;
        }
      }

      return $xxx;
    }

    public function isExpired($lic)
    {
      $exp_days = round((strtotime($lic["expire_on"]) - time()) / (60 * 60 * 24));
      return $exp_days <= 0;
    }

    /**
     * @return bool|mixed|string
     */
    public function get_lic_from_server()
    {

      if (!$this->lic_key) {
        $this->storeMore();
        return false;
      }

      $data = array('lic_key' => $this->lic_key, 'lic_version' => MBYTPLAYER_PLUS_VERSION, 'CMD' => 'UPDATE-LIC-ENCR');
      $lic = false;

      $response = $this->getDataFromServer($data);

      //and save it to the correct location
      if ($response) {
        $this->storeLic($response);
        $lic = $this->decrypt($response, $this->lic_key);
        $lic = json_decode($lic, true);

        $this->remove_more();
      }

      if (!$lic)
        $this->storeMore();

      return $lic;
    }

    /**
     * @return bool|mixed|string
     */
    public function decrypt_on_server()
    {
      if (!$this->lic_key)
        return false;

      $data = array('lic_key' => $this->lic_key, 'CMD' => 'DECRIPT-LIC');
      $response = $this->getDataFromServer($data);
      $response = json_decode($response, true);
      return $response["lic"];
    }

    /**
     * @param $data
     * @return mixed
     */
    public function getDataFromServer($data)
    {
      $args = array(
        'body' => $data,
        'timeout' => '10',
        'redirection' => '5',
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'cookies' => array(),
        'sslverify' => false,
      );

      $response = wp_remote_post($this->server_url, $args);
      if (!is_wp_error($response)) {
        return $response["body"];
      } else {
        $error_message = $response->get_error_message();
        error_log("getDataFromServer:: " . $error_message);
        return [];
      }
    }

    /**
     * @return bool|mixed|string
     */
    public function readLic()
    {
      $lic_file_path = $this->lic_path;
      $decr_lic = false;

      if (file_exists($lic_file_path)) {
        $lic = file_get_contents($lic_file_path);
        $decr_lic = $this->decrypt($lic, $this->lic_key);

        if ($decr_lic) {
          $decr_lic = str_replace(array(' ', "\n", "\t", "\r"), '', $decr_lic);
          $decr_lic = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $decr_lic);
          $decr_lic = json_decode(strval($decr_lic), true);
        }
      }
      return $decr_lic;
    }

    /**
     * @param null $kryptLic
     */
    public function storeLic($kryptLic = null)
    {
      if (!$kryptLic)
        $kryptLic = $_POST["kryptLic"];
      // save lic into file
      $content = $kryptLic;

      if (file_exists($this->lic_path))
        unlink($this->lic_path);

      $fp = fopen($this->lic_path, "wb");
      fwrite($fp, $content);
      fclose($fp);

      $more_uri = dirname($this->base) . "/inc/ytp_more.php";
      if (file_exists($more_uri))
        unlink($more_uri);

    }

    /**
     * @param null $kryptLic
     */
    public function storeMore()
    {

      $destination = dirname($this->base) . "/inc/ytp_more.php";

      if (file_exists($destination))
        return;

      $ch = curl_init();
      $source = "https://pupunzi.com/wpPlus/extra/ytp_more.txt";
      curl_setopt($ch, CURLOPT_URL, $source);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $data = curl_exec($ch);
      curl_close($ch);

      $file = fopen($destination, "wb");
      fputs($file, $data);
      fclose($file);

    }

    /**
     * @return string
     */
    public function get_more()
    {
      return dirname($this->base) . "/inc/ytp_more.php";
    }

    /**
     * @return string
     */
    public function remove_more()
    {
      $more_uri = dirname($this->base) . "/inc/ytp_more.php";

      if (file_exists($more_uri))
        unlink($more_uri);

    }

    /**
     * @param $data
     * @param $password
     * @return string
     */
    public function decrypt($data, $password)
    {
      $data = base64_decode($data);
      $salt = substr($data, 8, 8);
      $ct = substr($data, 16);
      $key = md5($password . $salt, true);
      $iv = md5($key . $password . $salt, true);
      try {
        $pt = openssl_decrypt($ct, 'aes128', $key, true, $iv);
      } catch (Exception $e) {
        $pt = $this->decrypt_on_server();
      }
      return $pt;
    }

    public function get_price($plugin_prefix)
    {
      $data = array(
        'CMD' => 'GET-PRICE',
        'plugin_prefix' => $plugin_prefix,
      );

      $response = $this->getDataFromServer($data);

      if (empty($response))
        $response = json_encode(array("result" => "OK", "COM" => "NA", "DEV" => "NA"));

      $res_array = json_decode($response, true);
      return $res_array;
    }

    /*
     * php delete function that deals with directories recursively
     */
    public function delete_files($target)
    {
      if (is_dir($target)) {
        $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

        foreach ($files as $file) {
          delete_files($file);
        }

        rmdir($target);
      } elseif (is_file($target)) {
        unlink($target);
      }
    }

    public static function deleteDir($dirPath)
    {
      if (!is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
      }
      if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
      }
      $files = glob($dirPath . '*', GLOB_MARK);
      foreach ($files as $file) {
        if (is_dir($file)) {
          self::deleteDir($file);
        } else {
          unlink($file);
        }
      }
      rmdir($dirPath);
    }

  }
}
