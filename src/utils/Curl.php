<?php
namespace Shooyaaa\Three\Utils;

use Shooyaaa\Three\Contracts\Url;

class Curl implements Url {
    private $ch;
    private $uuid;

    public function __construct() {
        $this->ch = curl_init();
        $this->uuid = uniqid("curl_cookie");
    }

    public function get($url) {
        curl_setopt($this->ch, CURLOPT_POST, 0);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        return $this;
    }

    public function go() {
        $rs = curl_exec($this->ch);
        return $rs;
    }

    public function post($url, $data) {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        return $this;
    }

    public function redirect() {
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
        return $this;
    }

    //todo add capctcha support
    public function login($name, $password) {

    }

    public function cookieFile() {
        return '/tmp/' . $this->uuid;
    }

    public function withCookie() {
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, $this->cookieFile());
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, $this->cookieFile());
        return $this;
    }

    public function setAgent($agent) {
        curl_setopt($this->ch, CURLOPT_USERAGENT, $agent);
        return $this;
    }

    public function responseCode() {
        return curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
    }

    public function redirectUrl() {
        return curl_getinfo($this->ch, CURLINFO_REDIRECT_URL);
    }

    public function cookies() {
        return curl_getinfo($this->ch, CURLINFO_COOKIELIST);
    }

    public function getContent() {
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        return $this;
    }

    public function __destruct() {
        curl_close($this->ch);
        if (file_exists($this->cookieFile())) {
            unlink($this->cookieFile());
        }
    }
}
