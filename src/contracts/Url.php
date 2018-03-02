<?php
namespace Shooyaaa\Three\Contracts;

interface Url {
    public function get($url);
    public function post($url, $data);
    public function redirect();

    //todo add capctcha support
    public function login($name, $password);
    public function cookieFile();
    public function withCookie();
    public function setAgent($agent);
    public function responseCode();
    public function redirectUrl();
    public function cookies();
    public function getContent();
}
