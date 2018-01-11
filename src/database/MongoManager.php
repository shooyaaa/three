<?php

namespace Shooyaaa\Three\Database;

use Shooyaaa\Three\Contracts\Connection;

class MongoManager implements Connection {
    private $_config;
    private $_pool;

    public function __constrct(array $config) {
        $this->_config = $config;
        $this->_pool = [];
    }

    public function connection($name) {
        if ($this->_pool[$name]) {
            return $this->_pool[$name];
        }

        $connector = $this->resolve($name);
        $this->_pool[$name] = $connector;

        return $this->_pool[$name];
    }

    private function resolve($name) {
        $config = $this->_config[$name];
        if (!$config) {
            throw \Exception("$name not found in mongo config");
        }
        $connector = $this->connector($config['type']);

        return $connector;
    }

    public function connector($type) {
        return new MongoConnector();
    }
}
