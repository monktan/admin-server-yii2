<?php
namespace monktan\framework;

interface ContainerInterface
{
    public function get($interface);
    public function set($interface, $class);
}
