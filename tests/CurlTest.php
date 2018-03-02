<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Shooyaaa\Three\Utils\Curl;

final class CurlTest extends TestCase {
    private $curl;
    private $testUrl;

    public function setUp() {
        $this->curl = new Curl();
        $pwd = dirname(__FILE__);
        system("php -S localhost:1234 -t " . $pwd . ">/dev/null 2>&1 &");
        $this->testUrl = "http://localhost:1234/";
    }

    public function testGet() {
        $content = $this->curl->get($this->testUrl)->go();
        $this->assertEquals(true, $content, "Web page {$this->testUrl} content not empty");
    }

    public function testPost() {
        $post = ['a' => 111111];
        $content = $this->curl->post($this->testUrl, $post)->getContent()->go();
        $this->assertEquals($post, json_decode($content, true), "Web page {$this->testUrl} content not equals");
    }

    public function testCookie() {
        $content = $this->curl->get($this->testUrl)->withCookie()->go();
        $this->assertNotEmpty($this->curl->cookies());
    }

    public function testRedirect() {
        $params = ["abc", "redirected"];
        $redirectUrl = $this->testUrl . "?" . implode("=", $params);
        $content = $this->curl->get($this->testUrl . "?redirect=" . $redirectUrl)->redirect()->getContent()->go();
        $this->assertEquals(key(json_decode($content, true)), $params[0]);
    }

}
