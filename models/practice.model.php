<?php

use CoreModel as DB;

class PracticeModel
{
    private $table = 'persons';

    //this is responsible for quering the database
    public function getItems($key)
    {
        return DB::table($this->table)
                      ->where('name', 'LIKE', '%'.$key.'%')
                      ->orderBy('id')
                      ->get();
    }


    public function getItem(int $id)
    {
        return DB::table($this->table)->where('id', $id)->single();
    }


    public function countItems()
    {
        return DB::table($this->table)
                    ->count();
    }

    public function addItem(array $data):bool
    {
        return DB::table($this->table)->add($data);
    }

    public function updateItem(array $data, int $id):bool
    {
        return DB::Table($this->table)->where('id', $id)->update($data);
    }


    public function deleteItem(int $n):bool
    {
        return DB::table($this->table)->where('id', $n)->delete();
    }
}
