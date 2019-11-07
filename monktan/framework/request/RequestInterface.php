<?php
namespace monktan\framework\config;

interface RequestInterface
{
    public function get($key);
    public function post($key);
}
