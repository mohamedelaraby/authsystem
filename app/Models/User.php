<?php 


class User {

    /**
     *  Instantiate database conntection
     *  
     * @var string $db
     */
    private $db;

    public function __construct()
    {  
        // Make new datbase connection
        $this->setDB(new Database);
    }

    /**
     *  Set  database conntection
     *  
     *  @return mixed
     */
    public function setDB($db){
        return $this->db = $db;
    }
    
    /**
     *  Obtain  database conntection
     *  
     *  @return object
     */
    public function getDB(){
        return $this->db;
    }

    /**
     *  Search about user input email
     *  
     * @var mixed| null $email
     *  @return boolean
     */
    public function findUserByEmail($email){
        //Prepared statement
        $this->getDB()->query('SELECT * FROM users WHERE email = :email');

        // Bind existed email with input email
        $this->getDB()->bind(':email',$email);

        // Check if email is already raken
        if($this->getDB()->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     *  Register new user
     * 
     * @param mixed | null $data
     * @return boolean
     */
    public function register($data){
        // prepared statement
        $this->getDB()
            ->query('INSERT INTO users (username,email,password)
            VALUES (:username,:email,:password)');
            
        // Bind values
        $this->getDB()->bind(':username',$data['username']);
        $this->getDB()->bind(':email',$data['email']);
        $this->getDB()->bind(':password',$data['password']);

        // Execute query
        if($this->getDB()->execute()){
            return true;
        } else{
            return false;
        }
    }

    /**
     *  Get all user in the database
     *  
     * @return query
     */
    public function getUsers(){
        $this->getDB()->query("SELECT * FROM users");
        $result = $this->getDB()->resultSet();
        return $result;
    }


}