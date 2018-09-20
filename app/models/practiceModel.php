<?php
namespace App\Models;

use Lynq\Entity\EntityModel;

class PracticeModel
{
    private $coreDB;
    private $table = 'persons';


    public function __construct()
    {
        /* Connect to a MySQL database using driver invocation */
        $dsn = 'mysql:dbname=coredb;host=127.0.0.1';
        $user = 'root';
        $password = 'glory';

        //initialize and connnect to database;
        $this->coreDB = new EntityModel($dsn, $user, $password);

        // $this->coreDB->prefix = '' to set table_name prefix is any
    }


    //this is responsible for quering the database
    public function getItems($key)
    {
        return  $this->coreDB->table($this->table)
                            ->where('name', 'LIKE', '%'.$key.'%')
                            ->orderBy('id')
                            ->get();
    }


    public function getItem(int $id)
    {
        return $this->coreDB->table($this->table)
                            ->where('id', $id)
                            ->single();
    }


    public function countItems()
    {
        return $this->coreDB->table($this->table)
                            ->count();
    }

    public function addItem(array $data):bool
    {
        return $this->coreDB->table($this->table)
                            ->add($data);
    }

    public function updateItem(array $data, int $id):bool
    {
        return $this->coreDB->table($this->table)
                            ->where('id', $id)
                            ->update($data);
    }


    public function deleteItem(int $n):bool
    {
        return $this->coreDB->table($this->table)
                            ->where('id', $n)
                            ->delete();
    }
}
