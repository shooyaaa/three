<?php
namespace Shooyaaa\Three\Core;

class Container {

    private $_singleton = [];
    private $_instance = [];
    private $_class = [];

    public function singleton($name, $instance) {
        $this->_singleton =[$name] = $instance;
    }

    public function instance($name, $instance) {
        $this->_singleton =[$name] = $instance;
    }

    public function regisite($name, $any) {
        $this->_class[$name] = $any;
    }

    public function make($class) {
        $reflection = new \ReflectionClass($class);

        if (!$reflection->isInstantiable()) {
            throw new \Exception("$class not instantiable");
        }

        $constructor = $reflection->getConstructor();
        if (is_null($constructor)) {
            return new $class;
        }

        $parameters = $constructor->getParameters();

        $dependecies = $this->getDependencies($parameters);
        return $reflection->newInstanceArgs($dependecies);
    }

    public function getDependencies($parameters) {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();

            if (is_null($dependency)) {
                $dependencies[] = $this->resolveNonClass($parameter);
            } else {
                $dependencies[] = $this->make($dependency->name);
            }
        }
        return $dependencies;
    }

    public function resolveNonClass($parameter) {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }
        throw new \Exception("can't resolve none class type with no default value");
    }
}
