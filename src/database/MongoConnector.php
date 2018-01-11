<?php
namespace Shooyaaa\Three\Database;

use Shooyaaa\Three\Contracts\Connector;

class MongoConnector implements Connector {

    public function connect(array $config) {
        var_dump($config);
    }
}
