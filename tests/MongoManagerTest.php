<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Shooyaaa\Three\Database\MongoManager;
use Shooyaaa\Three\Database\MongoConnector;

final class MongoManagerTest extends TestCase {
    protected $mongoManager;

    /**
     *@dataProvider mongoConfigProvider
     */
    public function setUp() {
        $this->mongoManager = new MongoManager($this->mongoConfigProvider());
    }

    /**
     *@dataProvider connectionDataProvider
     */
    public function testConnection($type, $instance) {
        $f = new FakeMongoConnector();
        if (strstr($instance, 'Exception') !== false) {
            $this->expectException($instance);
            $this->mongoManager->connection($type);
        } else {
            $this->assertInstanceOf(
                $instance,
                $this->mongoManager->connection($type)
            );
        }
    }

    public function connectionDataProvider() {
        return [
            [
                'mongo',
                MongoConnector::class
            ],
            [
                'error',
                \InvalidArgumentException::class
            ],
            [
                'unknow_type',
                \InvalidArgumentException::class
            ],
            [
                'unknow',
                \InvalidArgumentException::class
            ]
        ];
    }


    public function mongoConfigProvider() {
        return [
                'mongo' => [
                    'uri' => '127.0.0.1:27017',
                    'type' => 'mongo-php'
                ],
                'unknow_type' => [
                    'uri' => '127.0.0.1:27017',
                    'type' => 'mongo-xxx'
                ],
                'unknow' => [
                    'uri' => '127.0.0.1:27014'
                ],
        ];
    }
}
