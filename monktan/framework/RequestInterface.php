<?php
namespace monktan\framework;

interface RequestInterface
{
    public function ip();

    public function userAgent();
}
