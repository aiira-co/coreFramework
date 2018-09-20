<?php namespace Lynq\Core;

// declare(strict_types=1);
class Legacy
{
    public function set($key, $value)
    {
        $this->$key = $value;
    }

    public function get($key)
    {
        return $this->$key ?? null;
    }
}
