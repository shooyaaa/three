<?php

use PHPUnit\Framework\TestCase;
use Shooyaaa\Three\Contracts\Connector;

class FakeMongoConnector extends TestCase {
    private $stub;

    public function __construct() {

        $this->stub = $this->getMockForAbstractClass(Connector::class);
    }

    public function connect() {
        return $this->stub->connect();
    }

}
