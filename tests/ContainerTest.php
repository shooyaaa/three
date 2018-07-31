<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Shooyaaa\Three\Core\Container;

class Simple {
    public function say() {
    }
}

class Constructor {
    public function __construct() {
    }
}

class Dependency {
    public function __construct(Simple $s) {
    }
}
class DefaultValue {
    public function __construct($any = 3, Simple $s) {
    }
}

class NotMakeable {
    public function __construct($any) {
    }
}

final class ContainerTest extends TestCase {
    private $_container;

    public function setUp() {
        $this->_container = new Container();
    }

    public function failMakeDataProvider() {
        return [
            ['NotMakeable', NotMakeable::class]
        ];
    }
    /**
     *@dataProvider failMakeDataProvider
     * */
    public function testFailMake($type, $class) {
        $this->expectException('\Exception');
        $c = $this->_container->make($class);
    }

    public function makeDataProvider() {
        return [
            ['Simple', Simple::class],
            ['Constructor', Constructor::class],
            ['Dependency',  Dependency::class],
            ['DefaultValue', DefaultValue::class]
        ];
    }
    /**
     *@dataProvider makeDataProvider
     * */
    public function testMake($type, $class) {
        $c = $this->_container->make($class);
        $this->assertInstanceOf(
            $class,
            $c
        );
    }

}
