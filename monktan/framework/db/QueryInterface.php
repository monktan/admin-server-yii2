<?php
namespace monktan\framework\db;

interface QueryInterface
{
    public function one();

    public function fields();

    public function value();
}

