<?php
use CoreModel as DB;

class PracticeModel{

    //this is responsible for quering the database
    function getPersons(){

        // echo 'Yep Contact';

        // $db = new DB;
        return DB::Table('persons')->get();
        //  echo 'hello';



    }


    function getPerson(int $id){
        return DB::table('persons')->where('id',$id)->single();

    }




    function addPerson(array $data):bool{

        return DB::table('persons')->add($data);

    }



        function updatePerson(array $data, int $id):bool{

            return DB::Table('persons')->where('id',$id)->update($data);
        }




    function deletePerson(int $n):bool{
        return DB::table('persons')->where('id',$n)->delete();
    }

}



?>
