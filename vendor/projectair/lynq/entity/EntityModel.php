<?php namespace Lynq\Entity;

use \PDO;
use Lynq\Core\Programe;

class EntityModel
{
    private $pdo;
    public $prefix;
    private $sql;

    protected $data;
    public $postId;
    protected $error;

    private $bindParam = [];


    //A static variable to hold all values of the chain methods for use in
    // the createStatement() Method

    private $statement = [];

    private $thisClass;



    // Connection Iterator
    public function __construct($dsn, $user, $password)
    {
        /* Connect to a MySQL database using driver invocation */
        // $dsn = 'mysql:dbname=testdb;host=127.0.0.1';
        // $user = 'dbuser';
        // $password = 'dbpass';

        try {
            $this->pdo = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            Programe::reportError($e->getMessage(), 'PDO Connection Failed');
        }
    }




    //This method is used to store raw sql statement for query
    // Not tested yet
    public function sql($sql):self
    {
        $this->statement =[];
        $this->statement['sql'] =  $sql ;
        return $this;
    }


    //this Method is the first to be called for chaining.
    //  It sets the table to query and resets all the other methods to default

    // makes use of the table_exits method to check is the table is part of the DB
    // / it has a default alias of 't',
    // SELECT t.* FROM table t

    public function table(string $table): self
    {
        $this->statement =[];

        $tables = $this->tableExists($table);
        if ($tables) {

            // set tables
            $this->statement['table'] = $tables['tables'];

            //set table alias
            if (!empty($tables['alias'])) {
                $this->statement['alias'] = $tables['alias'];

                // print_r($tables['alias']);
            }
        } else {
            Programe::reportError('The Table: <i  class="bg-dark color-yellow padding-sm">'.$this->prefix.$table.'</i> does not exists', 'Database Query Error');
        }
        return $this;
    }





    //This Method is to set the fields of the table
    //SELECT 'fields' FROM ...
    //return self
    public function fields(string $fields): self
    {
        if (!isset(explode('.', $fields)[1])) {
            $fieldss ='';
            for ($i=0; $i<count($this->statement['table']); $i++) {
                $fieldss.= $this->fieldExists($this->statement['table'][$i], $fields, $this->statement['alias'][$i]);
            }

            // echo $fieldss;
            $this->statement['field'] = trim($fieldss, ',');
        } else {
            $this->statement['field'] =  $fields;
        }

        return $this;
    }







    //This Method is to set wheres for the statement
    // i.e WhERE ...
    // returns EntityModel

    public function where(string $field, string $opValue, string $value = null): self
    {
        if ($field != null) {
            if (!isset(explode('.', $field)[1])) {
                for ($i = 0; $i < count($this->statement['table']); $i++) {
                    $fieldVerified = $this->fieldExists($this->statement['table'][$i], $field, $this->statement['alias'][$i]);
                }

                $field = $fieldVerified;
            }

            if ($opValue == null) {
                echo 'fill second arg';
            } elseif ($opValue == "=" ||
                   $opValue == "!=" ||
                   $opValue == "<" ||
                   $opValue == ">" ||
                   $opValue == "<=" ||
                   $opValue == ">=" ||
                   $opValue == "BETWEEN" ||
                   $opValue == "IN" ||
                   $opValue == "NOT IN" ||
                   $opValue == "LIKE") {
                if ($value==null) {
                    echo 'fill third arg';
                } else {
                    $this->statement['where'] = $field.' '.$opValue.' :'.str_replace('.', '_', $field);

                    $this->bindParam[':'.str_replace('.', '_', $field).''] = $value;
                }
            } else {
                $this->statement['where'] = $field.' = :'.str_replace('.', '_', $field);
                $this->bindParam[':'.str_replace('.', '_', $field).''] = $opValue;
            }
        }

        // echo $this->dbWhere;

        return $this;
    }






    //This Method is to set wheres for the statement. used after the where() is called
    // i.e WhERE ... || ..
    // returns EntityModel
    public function orWhere(string $field, string $opValue, string $value = null): self
    {
        //checek if where is already set
        if ($this->statement['where'] == null) {
            Programe::reportError('Call the method: <i  class="bg-dark color-yellow padding-sm">where(\'id\',$id) </i> before calling this method "orWhere()"', 'Database Query Error');
        }

        if ($field != null) {
            if (!isset(explode('.', $field)[1])) {
                for ($i = 0; $i < count($this->statement['table']); $i++) {
                    $fieldVerified = $this->fieldExists($this->statement['table'][$i], $field, $this->statement['alias'][$i]);
                }

                $field = $fieldVerified;
            }

            if ($opValue == null) {
                echo 'fill second arg';
            } elseif ($opValue == "=" ||
                   $opValue == "!=" ||
                   $opValue == "<" ||
                   $opValue == ">" ||
                   $opValue == "<=" ||
                   $opValue == ">=" ||
                   $opValue == "BETWEEN" ||
                   $opValue == "IN" ||
                   $opValue == "NOT IN" ||
                   $opValue == "LIKE") {
                if ($value==null) {
                    echo 'fill third arg';
                } else {
                    $OrWhere = $field.' '.$opValue.' :'.str_replace('.', '_', $field);
                    $this->statement['where'] = $this->statement['where'].' OR '.$OrWhere;
                    $this->bindParam[':'.str_replace('.', '_', $field).''] = $value;
                }
            } else {
                $OrWhere = $field.' = :'.str_replace('.', '_', $field);
                $this->statement['where'] = $this->statement['where'].' OR '.$OrWhere;
                $this->bindParam[':'.str_replace('.', '_', $field).''] = $opValue;
            }
        }

        // echo $this->dbWhere;

        return $this;
    }








    //This Method is to set wheres for the statement. used after the where() is called
    // i.e WhERE ... && ..
    // returns EntityModel

    public function andWhere(string $field, string $opValue, string $value = null): self
    {

        //checek if where is already set
        if ($this->statement['where'] == null) {
            Programe::reportError('Call the method: <i  class="bg-dark color-yellow padding-sm">where(\'id\',$id) </i> before calling this method "andWhere()"', 'Database Query Error');
        }
        if ($field != null) {
            if (!isset(explode('.', $field)[1])) {
                for ($i = 0; $i < count($this->statement['table']); $i++) {
                    $fieldVerified = $this->fieldExists($this->statement['table'][$i], $field, $this->statement['alias'][$i]);
                }

                $field = $fieldVerified;
            }

            if ($opValue == null) {
                echo 'fill second arg';
            } elseif ($opValue == "=" ||
                   $opValue == "!=" ||
                   $opValue == "<" ||
                   $opValue == ">" ||
                   $opValue == "<=" ||
                   $opValue == ">=" ||
                   $opValue == "BETWEEN" ||
                   $opValue == "IN" ||
                   $opValue == "NOT IN" ||
                   $opValue == "LIKE") {
                if ($value==null) {
                    echo 'fill third arg';
                } else {
                    $AndWhere = $field.' '.$opValue.' :'.str_replace('.', '_', $field);
                    $this->statement['where'] = $this->statement['where'].' AND '.$AndWhere;
                    $this->bindParam[':'.str_replace('.', '_', $field).''] = $value;
                }
            } else {
                $AndWhere = $field.' = :'.str_replace('.', '_', $field);
                $this->statement['where'] = $this->statement['where'].' AND '.$AndWhere;
                $this->bindParam[':'.str_replace('.', '_', $field).''] = $opValue;
            }
        }

        // echo $this->dbWhere;

        return $this;
    }






    //This Method is used at the end of a chain to query the DB.
    //it returns an array of objects
    public function get() : ?array
    {
        $sql = $this->statement['sql'] ?? $this->createStatement();
        return $this->query($sql);
    }





    // This Method counts the results of a query.
    // i.e SELECT COUNT(*) ...
    // returns an integer

    //Mostly use this method to chec is an item already exists and also for [pagination]
    public function count():int
    {
        $this->statement['field'] = 'COUNT(*)';
        $sql = $this->createStatement();

        return json_decode(json_encode($this->query($sql)), true)[0]['COUNT(*)']?? 0;
    }



    // This Method returns the Average results of a query.
    // i.e SELECT AVG(*) ...
    // returns an integer

    //Mostly use this method to chec is an item already exists and also for [pagination]
    public function avg($field='*'): ?int
    {
        $this->statement['field'] = 'AVG('.$field.')';
        $sql = $this->createStatement();

        return json_decode(json_encode($this->query($sql)), true)[0]['AVG('.$field.')'];
    }

    //This Method is used to query distinct rows
    // i.e SELECT COUNT(*) ...
    //used at the end of a chain method. it automatically calls the get method
    public function distinct(): ?array
    {
        $this->statement['field'] = 'DISTINCT '.$this->statement['field'];
        return $this->get();
    }




    //This Method is to set LIMIT for the statement, taking the last ID
    // i.e ... LIMIT 1 ORDER BY id ACS
    // Hence it will limit it to one, order by ID
    public function first()
    {
        $this->statement['limit'] = 1;
        $sql = $this->createStatement();
        return $this->query($sql, false);
    }





    // This Method is no different from the first() on
    // i.e ... LIMIT 1 ORDER BY id ASC
    // returns an object
    public function single()
    {
        return $this->first();
    }





    //This Method is to set LIMIT for the statement, taking the last ID
    // i.e ... LIMIT 1 ORDER BY id DESC
    // Hence it will limit it to one, order by ID
    // returns an object
    public function last()
    {
        $this->statement['limit'] = 1;
        $this->OrderBy('id');
        $sql = $this->createStatement();
        return $this->query($sql, false);
    }




    //This Method is to set LIMIT for the statement
    // i.e ... LIMIT 5
    // returns EntityModel for chaining methods
    public function limit(int $limit): self
    {
        $this->statement['limit'] = $limit;
        return $this;
    }





    //This Method is used to set OFFSET for the SQL statement
    // i.e ... OFFSET 5
    //returns objects. used for pagination
    public function offset(int $n)
    {
        $this->statement['offset'] = $n;
        if (!isset($this->statement['order'])) {
            $this->orderBy('id');
        }
        return $this->get();
    }





    //This Method sets the ORDER in which the queried data should display.
    // i.e ... ORDER BY 'id' 'ASC'
    //returns EntityModel
    public function orderBy(string $field, int $order = 1): self
    {

        // check if an alias or function exists in the query
        if (!isset(explode('.', $field)[1]) || !isset(explode('(', $field)[1])) {
            for ($i = 0; $i < count($this->statement['table']); $i++) {
                $fieldVerified = $this->fieldExists($this->statement['table'][$i], $field, $this->statement['alias'][$i]);
            }
            $field = $fieldVerified;
        }


        if ($order==1) {
            $o = 'DESC';
        } elseif ($order == 2) {
            $o= 'ASC';
        } else {
            Programe::reportError('Please specify : <i  class="bg-dark color-yellow padding-sm">the parameter </i> for the second argument <br/> 1 for DSC, 2 for ASC', 'Database Query Error');
        }

        $this->statement['order']= $field.' '.$o;
        return $this;
    }



    // GROUP BY
    //This Method is to group rows in a query.
    // best used in conjanction with count to get statistically data for graphs
    public function groupBy(string $fields): self
    {
        if (!isset(explode('.', $fields)[1])) {
            for ($i = 0; $i < count($this->statement['table']); $i++) {
                $fieldVerified = $this->fieldExists($this->statement['table'][$i], $fields, $this->statement['alias'][$i]);
            }
            $this->statement['groupBy'] = $fieldVerified;
        } else {
            $this->statement['groupBy'] =  $fields;
        }
        return $this;
    }




    // Joining Tables
    // /INNER JOIN
    public function join(string $table, string $alias):self
    {
        if ($this->ableExists($table)) {
            $join = [' INNER JOIN '.$this->prefix.$table.' '.$alias];
            if (!isset($this->statement['joinTables'])) {
                $this->statement['joinTables'] =[];
            }
            $this->statement['joinTables'] = array_merge($this->statement['joinTables'], $join);
        } else {
            Programe::reportError('The Table: <i  class="bg-dark color-yellow padding-sm">'.$table.'</i> does not exists', 'Database Query Error');
        }

        return $this;
    }

    // innerJoin
    public function innerJoin(string $table, string $alias):self
    {
        if ($this->ableExists($table)) {
            $join = [' INNER JOIN '.$this->prefix.$table.' '.$alias];
            if (!isset($this->statement['joinTables'])) {
                $this->statement['joinTables'] =[];
            }
            $this->statement['joinTables'] = array_merge($this->statement['joinTables'], $join);
        } else {
            Programe::reportError('The Table: <i  class="bg-dark color-yellow padding-sm">'.$table.'</i> does not exists', 'Database Query Error');
        }

        return $this;
    }

    // fullJoin
    public function fullJoin(string $table, string $alias):self
    {
        if ($this->ableExists($table)) {
            $join = [' FULL JOIN '.$this->prefix.$table.' '.$alias];
            if (!isset($this->statement['joinTables'])) {
                $this->statement['joinTables'] =[];
            }
            $this->statement['joinTables'] = array_merge($this->statement['joinTables'], $join);
        } else {
            Programe::reportError('The Table: <i  class="bg-dark color-yellow padding-sm">'.$table.'</i> does not exists', 'Database Query Error');
        }

        return $this;
    }

    // /LEFT JOIN
    public function leftJoin(string $table, string $alias):self
    {
        if ($this->ableExists($table)) {
            if (!isset($this->statement['joinTables'])) {
                $this->statement['joinTables'] =[];
            }
            $join = [' LEFT JOIN '.$this->prefix.$table.' '.$alias];
            $this->statement['joinTables'] = array_merge($this->statement['joinTables'], $join);
        } else {
            Programe::reportError('The Table: <i  class="bg-dark color-yellow padding-sm">'.$table.'</i> does not exists', 'Database Query Error');
        }

        return $this;
    }






    // /RIGHT JOIN
    public function rightJoin(string $table, string $alias):self
    {
        if ($this->ableExists($table)) {
            if (!isset($this->statement['joinTables'])) {
                $this->statement['joinTables'] =[];
            }
            $join = [' RIGHT JOIN '.$this->prefix.$table.' '.$alias];
            $this->statement['joinTables'] = array_merge($this->statement['joinTables'], $join);
        } else {
            Programe::reportError('The Table: <i  class="bg-dark color-yellow padding-sm">'.$table.'</i> does not exists', 'Database Query Error');
        }

        return $this;
    }




    //Used after a join method to set the condition of the joint table
    //i.e JOIN 'table2' q ON t.q_id = q.id
    public function on(string $jField, string $tField):self
    {
        // check if fields exists
        $on = [' ON '.$jField.' = '.$tField];
        if (!isset($this->statement['joinOn'])) {
            $this->statement['joinOn'] =[];
        }
        $this->statement['joinOn'] = array_merge($this->statement['joinOn'], $on);
        return $this;
    }









    //This Method is to ADD / INSERT row(s) of a table`
    //Last to be called at the end of a chain.

    public function add(array $data):bool
    {
        $fields = array_keys($data);
        $length = count($fields);

        $field="";
        $values="";


        for ($i=0; $i < $length; $i++) {
            $field .=", `".$fields[$i]."`";

            $values .=", :".$fields[$i]."";
        }


        $field = trim($field, ',');
        $values = trim($values, ',');


        $sql = 'INSERT INTO '.$this->prefix;
        $sql .=explode(' ', $this->enFieldsTables('tables'))[0].' (';
        $sql .= $field.') VALUES ('.$values.')';
        // echo $sql;

        for ($i=0; $i < $length; $i++) {
            $this->bindParam[':'.$fields[$i].''] = $data[$fields[$i]];
        }

        // print_r($this->bindParam);

        // return true;
        $this->sql = $sql;



        if ($this->query($sql)) {
            return true;
        } else {
            return false;
        }
    }






    //This Method is to update row(s) of a table`
    //Last to be called at the end of a chain.
    //mostly used with where() to specify the id of the table to update.

    public function update(array $data):bool
    {
        $fields = array_keys($data);

        // $basket->set("filds", $fields);

        $length = count($fields);

        // $basket->set("length", $length);

        $field="";
        $values="";
        for ($i=0; $i < $length; $i++) {
            $values .=", `".$fields[$i]."` = :".$fields[$i]."";
        }

        $values = trim($values, ',');


        $sql = 'UPDATE '.$this->prefix;
        $sql .=explode(' ', $this->enFieldsTables('tables'))[0].' t SET '.$values;

        if ($this->statement['where'] == null) {
            Programe::reportError('Please specify data to UPDATE: <i  class="bg-dark color-yellow padding-sm">Call DB::table(\'table\')->where(\'id\',$id)->update($arr)</i>', 'Database Query Error');
        }
        $sql .= ($this->statement['where'] == null) ? '' :' WHERE '.$this->statement['where'];

        $this->sql = $sql;


        // SET bindParam
        for ($i=0; $i < $length; $i++) {
            $this->bindParam[':'.$fields[$i].''] = $data[$fields[$i]];
        }
        // echo $sql;
        // print_r($this->bindParam);


        if ($this->query($sql)) {
            return true;
        } else {
            return false;
        }
    }





    //This Method is to delete row(s) of a table`
    //Last to be called at the end of a chain.
    //mostly used with where() to specify the id of the table to delete.

    public function delete():bool
    {
        $sql = 'DELETE FROM '.$this->prefix;
        $sql .= explode(' ', $this->enFieldsTables('tables'))[0];
        if ($this->statement['where'] == null) {
            Programe::reportError('Please specify data to DELETE: <i  class="bg-dark color-yellow padding-sm">Call DB::table(\'table\')->where(\'id\',$id)->delete()</i>', 'Database Query Error');
        }

        $sql .= ($this->statement['where'] == null) ? '' :' WHERE '.str_replace('t.', '', $this->statement['where']);
        // echo $this->statement['where'];

        // echo $sql;
        $this->sql = $sql;

        if ($this->query($sql)) {
            return true;
        } else {
            return false;
        }
    }



    private function genFieldsTables(string $get):string
    {
        //table iteration
        $tables ="";
        $fields ="";
        if (isset($this->statement['table'])) {
            for ($i =0; $i < count($this->statement['table']); $i++) {
                $fields .= $this->statement['alias'][$i].'.*,';
                $tables .= $this->statement['table'][$i].' '.$this->statement['alias'][$i].',';
            }
            // echo $tables;
        }

        $fields = $this->statement['field']??trim($fields, ',');
        $tables = trim($tables, ',');
        if ($get =="fields") {
            $results = $fields;
        } else {
            $results = $tables;
        }

        return $results;
    }

    //This Method is used mostly in GET request to create or generate the
    // sql statement from the chain methods called in the model.
    // the get method then assigns this return to a variable for use in the query()
    // /returns a string
    private function createStatement():string
    {




      // $tableAlias = isset($alias)?'':' t';
        // $sql .=' FROM '.$this->prefix.$this->statement['table'].$tableAlias;

        $sql = 'SELECT '.$this->genFieldsTables('fields');

        $sql .= ' FROM '.$this->genFieldsTables('tables');

        // Jion iteration


        if (isset($this->statement['joinTables'])) {
            for ($i =0; $i < count($this->statement['joinTables']); $i++) {
                $sql .= $this->statement['joinTables'][$i].' '.$this->statement['joinOn'][$i];
            }
        }

        $sql .= isset($this->statement['where']) ? ' WHERE '.$this->statement['where'] : '';
        $sql .= isset($this->statement['groupBy']) ? ' GROUP BY '.$this->statement['groupBy'] : '';
        $sql .= isset($this->statement['order']) ? ' ORDER BY '.$this->statement['order'] : '';
        $sql .= isset($this->statement['limit']) ? ' LIMIT '.$this->statement['limit'] : '';
        $sql .= isset($this->statement['offset']) ? ' OFFSET '.$this->statement['offset'] : '';
        $this->sql = $sql; //want to have this static
        //   echo $sql;
        return $sql;
    }





    //This Method is to makes use of the PDO prepare method to query the statement
    // (from $this->createStatement(), $this->add(), $this->update() & $this->delete())
    // When a query is executed, we check to see if the execution was a GET, POST, PULL or DELETE.

    // If it was a GET, we find out if its limited to a single row to bass pdo->fetch, if Multiple
    // rows were queried, pdo->fetchAll is used

    // On the other hand, if its not a get request, we simply return a boolean to denote success or failure

    // A static variable $postId is altered if the request was a post. this way we can get the lastInsertId of the postId
    // to implement in other queries if neccessary

    private function query(string $sql, bool $fetchAll = true)
    {
        try {
            $query = $this->pdo->prepare($sql);

            // Use bindParam to prevent injection

            $fields = array_keys($this->bindParam);
            $length = count($fields);

            for ($i=0; $i < $length; $i++) {
                $query->bindParam($fields[$i], $this->bindParam[$fields[$i]]);
            }


            //   print_r($this->bindParam);
            //Empty bindParam;
            $this->bindParam = [];

            if ($query->execute()) {
                // If its a SELECT statment
                if ($sql[0]=='S') {
                    // $query->rowCount() > 1
                    return   $fetchAll ? $query->fetchAll(5): $query->fetch(5);
                } else {
                    // If its an INSERT statment
                    if ($sql[0]=='I') {
                        $this->postId = $this->pdo->lastInsertId();
                    }
                    return true;
                }
            } else {
                return null;
            }
        } catch (PDOExeption $e) {
            echo '[{"error":"'.$e->message().'"}]';
        }
    }






    //Method to check if a table exist,
    // if it does, it querys with it else it takes it out of the fields
    private function tableExists($tables):array
    {
        //explode to see how many tables are being queried
        $tables = explode(',', trim($tables, ','));

        $length = count($tables);
        $tablesExist = [];
        $tableAlias =[];

        for ($i = 0; $i < $length; $i++) {
            // Now trim off any whitespaces
            $indexTable = trim($tables[$i], ' ');

            // Explode with DOT '.' to see if the databasename is attached to the table
            $indexTable = explode('.', $indexTable);
            if (isset($indexTable[1])) {
                $dbname= $indexTable[0].'.';
                // $dbname='';
                $table = $indexTable[1];
                $fromDB = 'FROM '.$indexTable[0].' ';
            } else {
                $dbname="";
                $table = $indexTable[0];
                $fromDB = '';
            }

            //now see if th table already has an alias set to it, then remove it.
            $aliasTable = explode(' ', $table);
            if (isset($aliasTable[1])) {
                // alias exists
                $alias = $aliasTable[1];
                echo  $alias;
                $table = $aliasTable[0];
            } else {
                if ($length == 1) {
                    $alias = "t";
                } else {
                    $alias = "t".$i;
                }
            }

            // SHOW TABLES FROM suiteinventory LIKE 'person'
            // if (is_array($this->connections) || ($this->connections instanceof Traversable)) {
            if (false) {
                $exists = false;
                // check all the connnections untill its true;
                for ($j = 0; $j < count($this->connections); $j++) {
                    // print_r($this->connections[$j]);
                    if ($this->checkTableField('table', $this->connections[$j], $fromDB, $table)) {
                        $exists = true;
                    }
                }



                if ($exists) {
                    $tablesExist[$i]=$dbname.$this->prefix.$table;
                    $tableAlias[$i] = $alias;
                } else {
                    Programe::reportError('The Table: <i  class="bg-dark color-yellow padding-sm">'.$dbname.$table.'</i> does not exist in the database', 'Database Query Error');
                }
            } else {

              //Single Connection
                if ($this->checkTableField('table', $this->pdo, $fromDB, $table)) {
                    $tablesExist[$i]=$dbname.$this->prefix.$table;
                    $tableAlias[$i] = $alias;
                } else {
                    Programe::reportError('The Table: <i  class="bg-dark color-yellow padding-sm">'.$dbname.$table.'</i> does not exist in the database', 'Database Query Error');
                }
            }
        }


        return ['tables'=>$tablesExist,'alias'=>$tableAlias];
    }



    // Iterator Method to query for the existence of fields and tables
    private function checkTableField($type, $con, $subject, $table):bool
    {
        switch ($type) {
      case 'field':
        return $con->query("SHOW COLUMNS FROM ".$this->prefix.$table." LIKE '".$subject."'") != null;
        break;

      default:
        $tableExists = $con->query("SHOW TABLES ".$subject."LIKE '".$this->prefix.$table."'");
        return $tableExists && $tableExists->rowCount() == 1;
        break;
    }

        return false;
    }




    //Method to check is a field exist, if it does,
    //it querys with it else it takes it out of the fields

    private function fieldExists($table, $field, $alias):string
    {

        // echo 'table is: '.$table.' --- fields is: '.$field.' ---- alias is: '.$alias;
        $field = explode(',', trim($field, ','));

        $length = count($field);
        $exist = "";

        for ($i = 0; $i < $length; $i++) {
            // var_dump($field);
            if ($this->checkTableField('field', $this->pdo, $field[$i], $table)) {
                $exist .= ','.$alias.'.'.trim($field[$i], ' ');
                // echo $field[$i].'<br/>';
            }
        }


        return trim($exist, ',');
    }
}
