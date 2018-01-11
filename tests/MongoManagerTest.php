<?php

declare(struct_types=1);

use PHPUnit\Framework\TestCase;

final class MongoManagerTest extends TestCase {
    public function testConnect() {
        $this->assertInstanceOf(
            MongoManger::class,
            new MongoManger()
        );
    }
}
