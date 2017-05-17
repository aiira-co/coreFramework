<?php
// declare(strict_types=1);
    class Legacy{



        function set($key, $value)
        {
            $this->$key = $value;

        }

        function get($key)
        {
            return $this->$key ?? null;

        }


    }








// Parent Class for Controllers

    class CoreComponent{
         private $router= array();
         private $routerExist = false;
         private $component;

         private static $c = array();

        function __construct($component, $router){
            $this->router = $router;
            $this->component = $component;
            if(method_exists($component,'constructor')){
              $component->constructor();
            }
            // echo 'hello controller';
               $this->component();

        }

        static function Init(array $c){

          //Get the keys of the passed component
          $cFields = array_keys($c);
          //Get the length of the passed component
          $cLength = count($c);

          for($i = 0; $i < $cLength; $i++){
            //compare the passed component key to the original componenent key,
            //if there is a match, assign it, else die
            self::$c[$cFields[$i]] = $c[$cFields[$i]];



          }

        }

        // The component function must have an array as an argument not just variables
        function component(){

            $legacy = CORE::getInstance('Legacy');

            // Set Title if {{title}
            if(isset($legacy->routerPath['title']) && $legacy->routerPath['title'] == '{{title}}' ){
              $legacy->routerPath['title'] = $this->component->title??'Error: $title does not exist in component';
            }


            // Set STYLE
          if(isset(self::$c['style'])){
            $legacy->style = self::$c['style'];
          }elseif(isset(self::$c['styleUrls'])){
            $legacy->styleUrls = self::$c['styleUrls'];
          }

          // Set SCRIPT
        if(isset(self::$c['script'])){
          $legacy->script = self::$c['script'];
        }elseif(isset(self::$c['scriptUrls'])){
          $legacy->scriptUrls = self::$c['scriptUrls'];
        }

          if(isset(self::$c['template'])){

            CORE::render(self::$c['template'], $this->component, false);

          }elseif(isset(self::$c['templateUrl'])){

            CORE::render(self::$c['templateUrl'], $this->component);

          }else{
            CORE::render(DS.$this->router[0].DS.$this->router[0].'.view', $this->component);
          }


        }



    }






















// Parent Class for models



    class CoreModel{

         public static $pdo;
         public static $prefix;
          public static $sql;

        protected $data;
        public static $postId;
        protected $error;



        private static $s =[
          'table'=>'',
          'field'=>'t.*',
          'where'=>null,
          'order'=>null,
          'limit'=>null,
          'offset'=>null,
          'joinTables'=>array(),
          'joinOn'=>array(),
          'groupBy'=>null
        ];

        // function __construct()
        // {
        //     self::$pdo = CORE::GetInstance('pdo');
        //     require_once 'config.php';
        //     self::$prefix  = (new AdConfig)->dbprefix;
        //
        //     var_dump(CORE::GetInstance('pdo'));
        //
        // }

        //this function is to set and check is table exists
        public static function sql($sql): self{
          $this->dbSql = $sql ?? null;
          return new CoreModel;
        }


        //this function is to set and check is table exists
        public static function table(string $table): self{
          self::$pdo = CORE::getInstance('pdo');
          if(!class_exists('AdConfig')){

            require_once 'config.php';
          }
          self::$prefix  = (new AdConfig)->dbprefix;

          self::$s =[
            'table'=>'',
            'field'=>'t.*',
            'where'=>null,
            'order'=>null,
            'limit'=>null,
            'offset'=>null,
            'joinTables'=>array(),
            'joinOn'=>array(),
            'groupBy'=>null
          ];

          if(self::tableExists($table)){
            self::$s['table'] = $table;
          }else{
            die('The Table '.self::$prefix.$table.' does not exists');
          }
          return new CoreModel;

        }

        //this function is to set and check if fields exists
        public function fields(string $fields): self{
          if(! count(self::$s['joinTables']) ){
            self::$s['field'] = $this->fieldExists(self::$s['table'], $fields);
          }else{
            self::$s['field'] =  $fields;
          }
          return new CoreModel;
        }

        //this function is to set wheres for the statement
        public function where(string $field, string $opValue, string $value = null): self{
          if($field != null){
            $field = $this->fieldExists(self::$s['table'], $field);

            if($opValue == null){
              echo 'fill second arg';
            }elseif ($opValue == "=" ||
                     $opValue == "!=" ||
                     $opValue == "<" ||
                     $opValue == ">" ||
                     $opValue == "<=" ||
                     $opValue == ">=" ||
                     $opValue == "BETWEEN" ||
                     $opValue == "IN" ||
                     $opValue == "NOT IN" ||
                     $opValue == "LIKE" ) {
                if($value==null){
                  echo 'fill third arg';
                }else{
                  self::$s['where'] = $field.' '.$opValue.' '.$value;
                }
            }else{
              self::$s['where'] = $field.' = '.$opValue;
            }
          }

          // echo self::$dbWhere;

          return new CoreModel;
        }

        //this function is to set wheres for the statement
        public function orWhere(string $field, string $opValue, string $value = null): self{
          //checek if where is already set
          if(self::$s['where'] == null){
            die('Call the method Where(\'id\',$id) before calling this method "orWhere()"');
          }

          if($field != null){
            $field = $this->fieldExists(self::$s['table'], $field);

            if($opValue == null){
              echo 'fill second arg';
            }elseif ($opValue == "=" ||
                     $opValue == "!=" ||
                     $opValue == "<" ||
                     $opValue == ">" ||
                     $opValue == "<=" ||
                     $opValue == ">=" ||
                     $opValue == "BETWEEN" ||
                     $opValue == "IN" ||
                     $opValue == "NOT IN" ||
                     $opValue == "LIKE" ) {
                if($value==null){
                  echo 'fill third arg';
                }else{
                  $OrWhere = $field.' '.$opValue.' '.$value;
                  self::$s['where'] = self::$s['where'].' OR '.$OrWhere;
                }
            }else{
              $OrWhere = $field.' = '.$opValue;
              self::$s['where'] = self::$s['where'].' OR '.$OrWhere;
            }
          }

          // echo self::$dbWhere;

          return new CoreModel;
        }



        //this function is to set wheres for the statement
        public function andWhere(string $field, string $opValue, string $value = null): self{

            //checek if where is already set
            if(self::$s['where'] == null){
              die('Call the method Where(\'id\',$id) before calling this method "andWhere()"');
            }
          if($field != null){
            $field = $this->fieldExists(self::$s['table'], $field);

            if($opValue == null){
              echo 'fill second arg';
            }elseif ($opValue == "=" ||
                     $opValue == "!=" ||
                     $opValue == "<" ||
                     $opValue == ">" ||
                     $opValue == "<=" ||
                     $opValue == ">=" ||
                     $opValue == "BETWEEN" ||
                     $opValue == "IN" ||
                     $opValue == "NOT IN" ||
                     $opValue == "LIKE" ) {
                if($value==null){
                  echo 'fill third arg';
                }else{
                  $AndWhere = $field.' '.$opValue.' '.$value;
                  self::$s['where'] = self::$s['where'].' AND '.$AndWhere;
                }
            }else{
              $AndWhere = $field.' = '.$opValue;
              self::$s['where'] = self::$s['where'].' AND '.$AndWhere;
            }
          }

          // echo self::$dbWhere;

          return new CoreModel;
        }




        private function createStatement():string{
          $sql = 'SELECT '.self::$s['field'];
          $sql .=' FROM '.self::$prefix.self::$s['table'].' t';


          // Jion iteration


          if(count(self::$s['joinTables']) ){
            for($i =0; $i < count(self::$s['joinTables']); $i++)
            {
              $sql .= self::$s['joinTables'][$i].' '.self::$s['joinOn'][$i];
            }

          }


          $sql .= (self::$s['where'] == null) ? '' :' WHERE '.self::$s['where'];
          $sql .= (self::$s['groupBy'] == null) ? '' :' GROUP BY '.self::$s['groupBy'];
          $sql .= (self::$s['order'] == null) ? '' :' ORDER BY '.self::$s['order'];
          $sql .= (self::$s['limit'] == null) ? '' :' LIMIT '.self::$s['limit'];
          $sql .= (self::$s['offset'] == null) ? '' :' OFFSET '.self::$s['offset'];
          self::$sql = $sql; //want to have this static
          // echo $sql;
          return $sql;
        }

        //this function is to set wheres for the statement
        public function get(){
            $sql = $this->createStatement();
            return $this->query($sql);
        }

        public function count():int {
          self::$s['field'] = 'COUNT(*)';
          $sql = $this->createStatement();

          return json_decode(json_encode($this->query($sql)),true)[0]['COUNT(*)'];

        }

        public function distinct(): array{
          self::$s['field'] = 'DISTINCT '.self::$s['field'];
          return $this->get();

        }


        private function query(string $sql, bool $fetchAll = true){
          try{
              $query = self::$pdo->prepare($sql);

              if($query->execute())
              {
                if($sql[0]=='S')
                {
                  // $query->rowCount() > 1
                  return   $fetchAll ? $query->fetchAll(5): $query->fetch(5);
                }else{
                  if($sql[0]=='I'){
                    self::$postId = self::$pdo->lastInsertId();
                  }
                  return true;
                }


              }else
              {
                  return null;
              }


          }
          catch (PDOExeption $e) {
            echo '[{"error":"'.$e->message().'"}]';
          }
        }
        //this function is to set wheres for the statement
        function first(){
          self::$s['limit'] = 1;
          $sql = $this->createStatement();
          return $this->query($sql, false);
        }

        function single(){
          return $this->first();
        }

        //this function is to set wheres for the statement
        function last(){
          self::$s['limit'] = 1;
          $this->OrderBy('id');
          $sql = $this->createStatement();
          return $this->query($sql, false);
        }



        //this function is to set wheres for the statement
        function limit(int $limit): self{
          self::$s['limit'] = $limit;
          return new CoreModel;
        }


        //this function is to set wheres for the statement
        function offset(int $n){
          self::$s['offset'] = $n;
          $this->orderBy('id');
          return $this->get();
        }



        //this function is to set wheres for the statement
        function orderBy(string $field, int $order=1): self{
          $field = $this->fieldExists(self::$s['table'], $field);
          if($order==1){
            $o = 'DESC';
          }elseif($order == 2){
            $o= 'ASC';
          }else{
            die('Please specify the parameter for the second argument <br/> 1 for DSC, 2 for ASC');
          }

          self::$s['order']= $field.' '.$o;
          return new CoreModel;
        }

        // GROUP BY
        //this function is to set and check if fields exists
        public function groupBy(string $fields): self{
          if(! count(self::$s['joinTables']) ){
            self::$s['groupBy'] = $this->fieldExists(self::$s['table'], $fields);
          }else{
            self::$s['groupBy'] =  $fields;
          }
          return new CoreModel;
        }



        // Joining Tables
        // /INNER JOIN
        function join(string $table, string $alias):self{

          if(self::tableExists($table)){

            $join = array(' INNER JOIN '.self::$prefix.$table.' '.$alias);
            self::$s['joinTables'] = array_merge(self::$s['joinTables'], $join);


          }else{
            die('The Table '.$table.' does not exists');
          }

          return new CoreModel;
        }

        // /LEFT JOIN
        function leftJoin(string $table, string $alias):self{

          if(self::tableExists($table)){

            $join = array(' LEFT JOIN '.self::$prefix.$table.' '.$alias);
            self::$s['joinTables'] = array_merge(self::$s['joinTables'], $join);


          }else{
            die('The Table '.$table.' does not exists');
          }

          return new CoreModel;
        }

        // /RIGHT JOIN
        function rightJoin(string $table, string $alias):self{

          if(self::tableExists($table)){

            $join = array(' RIGHT JOIN '.self::$prefix.$table.' '.$alias);
            self::$s['joinTables'] = array_merge(self::$s['joinTables'], $join);


          }else{
            die('The Table '.$table.' does not exists');
          }

          return new CoreModel;
        }


        function on(string $jField, string $tField):self{
          // check if fields exists
          $on = array(' ON '.$jField.' = '.$tField);
            self::$s['joinOn'] = array_merge(self::$s['joinOn'], $on);
          return new CoreModel;
        }


        //this function is to set wheres for the statement
        function add(array $data):bool{

          $fields = array_keys($data);
          $length = count($fields);

          $field="";
          $values="";
          for($i=0; $i < $length; $i++)
          {
              $field .=", `".$fields[$i]."`";

              $values .=", '".$data[$fields[$i]]."'";
          }


          $field = trim($field,',');
          $values = trim($values,',');


          $sql = 'INSERT INTO '.self::$prefix;
          $sql .=self::$s['table'].' (';
          $sql .= $field.') VALUES ('.$values.')';
          // echo $sql;
          self::$sql = $sql;

          if($this->query($sql)){
            return true;
          }
          else {
            return false;
          }
        }






        //this function is to set wheres for the statement
        function update(array $data):bool{
          $fields = array_keys($data);

          // $basket->set("filds", $fields);

          $length = count($fields);

          // $basket->set("length", $length);

          $field="";
          $values="";
          for($i=0; $i < $length; $i++)
          {
              $values .=", `".$fields[$i]."` = '".$data[$fields[$i]]."'";


          }

          $values = trim($values,',');


          $sql = 'UPDATE '.self::$prefix;
          $sql .=self::$s['table'].' SET '.$values;

          if(self::$s['where'] == null){
            die('please specify data to delete. Call DB::Table(\'table\')->Where(\'id\',$id)->Update($arr)');
          }
          $sql .=' WHERE '.str_replace('t.', '',self::$s['where']);

          self::$sql = $sql;

          if($this->query($sql)){
            return true;
          }
          else {
            return false;
          }
        }

        //this function is to set wheres for the statement
        function delete():bool{
          $sql = 'DELETE FROM '.self::$prefix;
          $sql .=self::$s['table'];
          if(self::$s['where'] == null){
            die('please specify data to delete. Call DB::Table(\'table\')->Where(\'id\',$id)->Delete()');
          }
          $sql .=' WHERE '.str_replace('t.', '',self::$s['where']);

          // echo $sql;
          self::$sql = $sql;

          if($this->query($sql)){
            return true;
          }
          else {
            return false;
          }

        }





//Function to check is a table exist, if it does, it querys with it else it takes it out of the fields



	function tableExists($tables):bool
	{
		$tables = explode(',', trim($tables, ','));

		$length = count($tables);
		$exist = "";

		for($i = 0; $i < $length; $i++)
		{
			if(self::$pdo->query("SHOW TABLES LIKE '".self::$prefix.$tables[$i]."'")->rowCount() == 1)

			{
				$exist = true;
			}else
			{
				$exist = false;
			}


		}


		return $exist;

	}




//Function to check is a field exist, if it does,
//it querys with it else it takes it out of the fields



	function fieldExists($table, $field)
	{
		$field = explode(',', trim($field, ','));

		$length = count($field);
		$exist = "";

		for($i = 0; $i < $length; $i++)
		{
			if(self::$pdo->query("SHOW COLUMNS FROM ".self::$prefix.$table." LIKE '".$field[$i]."'")->rowCount() == 1)
			{
				$exist .= ',t.'.$field[$i];
        // echo $field[$i].'<br/>';
			}


		}


		return trim($exist,',');
	}






    }





















    //Sessions

    class CoreSession
{

// ==================================================================
//
// User Login
//
// ------------------------------------------------------------------
    private static $user_id;
    private static $table;
    private static $emailField;
    private static $usernameField;
    private static $hashField;

    public static $error;


    // Method for initializing Session
    function SessionInit($table='user', $emailField='email', $usernameField='username', $hashField='hashword'){
        self::$table = $table;
        self::$emailField = $emailField;
        self::$usernameField = $usernameField;
        self::$hashField = $hashField;
    }

    // Method to Login User
    public function SessionLogin($uname,$umail,$upass):bool
    {

       try
       {


        $pdo = CORE::getInstance('pdo');

        if(self::$table ==''){
          $this->SessionInit();
        }

        require_once 'config.php';
        $prefix  = (new AdConfig)->dbprefix;
        $sql = 'SELECT * FROM '.$prefix.self::$table.' WHERE ('.self::$usernameField.'=:uname || '.self::$emailField.'=:umail)  LIMIT 1';
          // echo $sql;
          $query = $pdo->prepare($sql);
          $query->execute(array(':uname'=>$uname, ':umail'=>$umail));
          $userRow=$query->fetch(5);


          if($query->rowCount() > 0)
          {
            // check if account is active
            // echo $userRow->acount_enabled;
            if($userRow->account_enabled){

                // check is the accout is on lockout
                if($userRow->lockout_enabled)
                {

                  echo 'current time is '.strtotime(date('Y-m-d h:i:s')).' <br>time left is:: '.(strtotime(date('Y-m-d h:i:s')) - $userRow->lockout_end);
                  if((strtotime(date('Y-m-d h:i:s')) - $userRow->lockout_end) > 0){
                    echo '<br> changing lock here --> '. $userRow->lockout_enabled.'<br/>';
                    CoreModel::table(self::$table)
                    ->where('id',$userRow->id)
                    ->update(
                              array(
                                'lockout_enabled' => false,
                                'lockout_end'=> 0
                              )
                            );

                    self::$error = '';
                    return false;

                  }else{

                    self::$error = 'locked';
                    return false;
                  }
                }
                else
                {

                  // verify password
                  if(password_verify($upass, $userRow->{self::$hashField}))
                  {
                    CoreModel::table(self::$table)
                    ->where('id',$userRow->id)
                    ->update(
                              array(
                                'access_failed_count'=>0,
                                'lockout_enabled' => false ,
                                'lockout_end'=> 0
                              )
                            );

                      $_SESSION['user_session'] = $userRow->id;
                      $_SESSION['count'] = 0;
                      self::$user_id = $userRow->id;
                      return true;





                  }
                  else
                  {
                    self::$error = 'passwordError';
                    echo 'failed:: '.$userRow->access_failed_count;
                    if($userRow->access_failed_count < 5){

                      CoreModel::table(self::$table)
                      ->where('id',$userRow->id)
                      ->update(array('access_failed_count'=>$userRow->access_failed_count + 1));
                    }elseif($userRow->access_failed_count == 5) {
                      CoreModel::table(self::$table)
                      ->where('id',$userRow->id)
                      ->update(
                                array(
                                  'access_failed_count'=>$userRow->access_failed_count + 1,
                                  'lockout_enabled' => true ,
                                  'lockout_end'=> strtotime(date('Y-m-d h:i:s')) + 300
                                )
                              );
                    }
                    elseif($userRow->access_failed_count < 10){

                      CoreModel::table(self::$table)
                      ->where('id',$userRow->id)
                      ->update(array('access_failed_count'=>$userRow->access_failed_count + 1));
                    }
                    elseif($userRow->access_failed_count == 10) {
                      CoreModel::table(self::$table)
                      ->where('id',$userRow->id)
                      ->update(
                                array(
                                  'account_enabled' => false,
                                  'access_failed_count'=>$userRow->access_failed_count + 1,
                                  'lockout_enabled' => true ,
                                  'lockout_end'=> strtotime(date('Y-m-d h:i:s')) + 86700
                                )
                              );
                    }
                    return false;
                  }

                }
            }
            else {

              self::$error = 'notActive';
              return false;

            }

          }
          else{
             self::$error = 'notExist';
            return false;
          }
       }
       catch(PDOException $e)
       {
         echo 'its false';
           echo $e->getMessage();
       }
   }



// ==================================================================
//
// Check If User is logged in
//
// ------------------------------------------------------------------

   public function IsLoggedIn():bool
   {
      if(isset($_SESSION['user_session']))
      {
         return true;
      }else {
        return false;
      }
   }




   public function SessionMessage(string $msg="")
   {
      if($_SESSION['message'] =="")
      {
        $_SESSION['message'] = $msg;
      }
      else
      {
        return $_SESSION['message'];
      }
   }



// ==================================================================
//
// Logs User Out
//
// ------------------------------------------------------------------



   public function SessionLogout(): bool
   {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
   }




}






















// this class is simply a filter between the component and the model
// They are effective in POST queries to strip tags and etc

class middleWare{

  static function filterPost( $default, array $post = null):array
  {
    // Set $post to default if its null
    $post = $post??$_POST;


    // store array keys or members for comparison
    $default = json_decode(json_encode($default),true);
    // print_r($default);

    $postKeys = array_keys($post);
    $defaultKeys = array_keys($default);

    // echo '<br/> post is';
    // print_r($postKeys);
    // echo '<br/> default is:';
    // print_r($defaultKeys);

    //count the numbers if members for the parameters

    $postCount = count($post);
    $defaultCount = count($default);

    // $update = [];

    for($i =0; $i < $postCount; $i++){

      // First check if the member exists,
      // if yes, compare values,
      //   if same, ignoire,
      //   if not the same value, add to a custom array,
      // if no, ignore

      // $update = array();

          if(in_array($postKeys[$i], $defaultKeys)){
            // echo $postKeys[$i].' --> '.$post[$postKeys[$i]].'<br/>';
            $key =$postKeys[$i];
            $value = $post[$key];
            if($post[$key] != $default[$key]){
              // echo 'changes found';

              $update[$key] = $value;
            }

          }
        }

        return $update?? array();

  }







}



?>
