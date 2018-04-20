<?php

use CoreModel as DB;

class CheckModel
{
    private $table='persons';

    public function getPersons()
    {
        return DB::table($this->table)
                    ->where('gender', 1)
                    ->orWhere('id', 10)
                    ->orderBy('name')
                    ->get();
    }

    public function getSQL()
    {
        return DB::$sql;
    }
}
