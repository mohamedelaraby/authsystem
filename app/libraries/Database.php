<?php

/** [ INFO ]:-
 * PDO Database class
 * Connect to database
 * Create prepared statements
 * Bind values
 * Return rows and  results
 */

class Database {
    /**
     *  Database host
     *  @param string $dbHost
     */
    private $dbHost = DB_HOST;
    
    /**
     *  Database user
     *  @param string $dbUser
     */
    private $dbUser = DB_USER;
    
    /**
     *  Database Password
     *  @param string $dbPass
     */
    private $dbPass = DB_PASS;
    
    /**
     *  Database name
     *  @param string $dbname
     */
    private $dbName = DB_NAME;
    
    /**
     *  Prepared statement for database connection
     *  @param string $statement
     */
    private $statement;
    
    /**
     *  Handler for database connection
     *  @param string $dbHandler
     */
    private $dbHandler;
    
    /**
     *   The error for database connection
     *  @param string $error
     */
    private $error;


    public function __construct(){
       // Conntect to database
       $this->databaseConntect(); 
    }

    /**
     *  Handle connection to the database
     *  
     *  @return Response
     */
    protected function databaseConntect(){
         // Set DSN
         $dsn = 'mysql:host='.$this->dbHost .';dbname='.$this->dbName;
         $options = array(
             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
             PDO::ATTR_PERSISTENT => true,
             PDO::ATTR_EMULATE_PREPARES => true   
         );
 
         // Create PDO instance
         try{
             $this->dbHandler = new PDO($dsn, $this->dbUser,$this->dbPass,$options);
         } catch (PDOException $e){
             $this->error = $e->getMessage();
             die("reload your page".$this->error);
             
         }
    }



    /**
     *  Prepare Sql statement 
     * 
     * @var mixed|null $sql
     * @return void
     */
    public function query($sql){
         $this->statement  = $this->dbHandler->prepare($sql);
    }

    /**
     * Bind Values to the sql statement
     * 
     *  @var mixed |null $paramter
     *  @var mixed |null $variable
     *  @var mixed |null $type
     * */
    public function bind($paramter,$variable,$type = null){
        // Check for the type of the variable
        if(is_null($type)){
            switch(true){
                case is_int($variable):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($variable):
                    $type = PDO::PARAM_BOOL;
                    break;    
                case is_null($variable):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                     
            }
        }

        //Bind the values
        $this->statement->bindValue($paramter,$variable,$type);
    }


    /**
     * Execute the prepared statement
     * 
     * @return void 
     * */ 
    public function execute(){
        return $this->statement->execute();
    }

   /**
    * Get Mutli Record as array of objects
    *
    * @return object
    */ 
    public function resultSet(){
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get  single record as an object
     * 
     * @return object
     */
    public function single(){
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    /**
     *  Get number of rows that affected by query
     * 
     * @return integer
     */
    public function rowCount(){
        return $this->statement->rowCount();
    }



}