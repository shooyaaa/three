<?php

namespace Shooyaaa\Three\Database;

use Shooyaaa\Three\Contracts\Connection;
use Shooyaaa\Three\Contracts\Connector;

class MongoManager implements Connection {
    private $_config;
    private $_pool;

    public function __construct(array $config) {
        $this->_config = $config;
        $this->_pool = [];
    }

    public function connection($name) {
        if (!empty($this->_pool[$name])) {
            return $this->_pool[$name];
        }

        $connector = $this->resolve($name);
        $this->_pool[$name] = $connector;

        return $this->_pool[$name];
    }

    private function resolve($name) {
        if (empty($this->_config[$name]) || empty($this->_config[$name]['type'])) {
            throw new \InvalidArgumentException("$name not found in config");
        }
        $config = $this->_config[$name];
        $connector = $this->connector($config['type']);

        if (!$connector instanceof Connector) {
            throw new \InvalidArgumentException("not a connector $connector");
        }

        return $connector;
    }

    public function connector($type) {
        if ($type == 'mongo-php') {
            return new MongoConnector();
        }

        return null;
    }
}
