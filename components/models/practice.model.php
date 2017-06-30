<?php

use CoreModel as DB;

class PracticeModel{

  private $table = 'persons';

  //this is responsible for quering the database
  function getPersons($key){

      return DB::table($this->table)
                      ->where('name','LIKE','%'.$key.'%')
                      ->orderBy('id')
                      ->get();

  }


  function getPerson(int $id){
      return DB::table($this->table)->where('id',$id)->single();

  }


  function countPersons(){
    return DB::table($this->table)
                    ->count();
  }

  function addPerson(array $data):bool{

      return DB::table($this->table)->add($data);

  }

  function updatePerson(array $data, int $id):bool{

      return DB::Table($this->table)->where('id',$id)->update($data);
  }


  function deletePerson(int $n):bool{
      return DB::table($this->table)->where('id',$n)->delete();
  }

}



?>
