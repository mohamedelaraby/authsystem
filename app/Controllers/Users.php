<?php




class Users extends Controller{

    /**
     *  Constructor
     */
    public function __construct()
    {
       $this->userModel = $this->model('User');
    }

    /**
     *  Login current user
     * 
     *  @return void
     */
    public function login(){
        $data = [
            'username' => '',
            'password' => '',
            'usernameError' => '',
            'passwordError' => '',
        ];

         // Check for request method
         if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanatize post data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            
            // Trim post data
            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'usernameError' => '',
                'passwordError' => '',
            ];

            // Validate username
            if(empty($data['username'])){
                $data['Error'] = 'Please enter a username';
            }
            //validate password
            if(empty($data['password'])){
                $data['passwordError'] = 'Please enter a password';
            }
            // check if errors array is empty
            if(empty($data['usernameError']) && empty($data['passwordError'])){
                $loggedInUser = $this->userModel->login($data['username'],$data['password']);
            
                // Check if user logged in
                if($loggedInUser){
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['passwordError'] = 'Password  or username is incorrect, please try again';
                    $this->view('users/login',$data);
                }

            }

        } else {
            $data = [
                'username' => '',
                'password' => '',
                'usernameError' => '',
                'passwordError' => '',
            ];
        }

        $this->view('users/login',$data);
    } 
    
    /**
     * Register new user
     * 
     *  @return void
     */
    public function register(){
        $data = [
            'username' => '',
            'email' => '',
            'password' => '',
            'confirmpassword' => '',
            'usernameError' => '',
            'emailError' => '',
            'passwordError' => '',
            'confirmPasswordError' => ''
        ];

        // Check for request method
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanatize post data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            
           

            // Trim post data
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirmpassword' => trim($_POST['confirmpassword']),
                'usernameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPasswordError' => ''
            ];

          

            // Validation rules
            $nameValidation = "/^[a-zA-Z0-9]*$/";
            $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";

            /// Validate username in letters and numbers
            if(empty($data['username'])){
                $data['usernameError'] = 'Please enter username.';
            } elseif(!preg_match($nameValidation,$data['username'])){
                $data['usernameError'] = 'Name can only contain letters and numbers.';
            }

            // Validate email
            if(empty($data['email'])){
                $data['emailError'] = 'Please enter email address.';
            } elseif(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
                $data['emailError'] = 'Please enter a valid email address.';
            } else{
                // Check if email exists
                if($this->userModel->findUserByEmail($data['email'])){
                    $data['emailError'] = 'Email is already taken.';
                    
                }
            }
            
            // Validate password on length and numeric values
            if(empty($data['password'])){
                $data['passwordError'] = 'Please enter password.';
            } elseif(strlen($data['password'] <= 6)){
                $data['passwordError'] = 'Password must be at least 8 charachers.';
            } elseif(!preg_match($passwordValidation,$data['password'])){
                $data['passwordError'] = 'Password must be at least one numeric value.';
            }

            // Validate confirm Password
            if(empty($data['confirmpassword'])){
                $data['confirmPasswordError'] = 'Please enter password again.';
            } else {
                // Check if the two passwords does not match
                if($data['password'] !== $data['confirmpassword']){
                 $data['confirmPasswordError'] = 'Passwords do not matchm please try again.';
                }
            }

             // Make sure that errors are empties
             if(empty($data['usernameError']) &&
                empty($data['emailError']) &&
                empty($data['passwordError']) &&
                empty($data['confirmPasswordError'])){
                    // Hash password using one-ways hashing algorithm
                    $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                    
                    // Registenew user from model function
                    if($this->userModel->register($data)){
                        // Redirect to login page
                        header('location: '. URL_ROOT . 'users/login');
                    } else {
                        die('Something went wrong');
                    }
                }

        }

        $this->view('users/register',$data);
    }


    /**
     *  Start new session with logged user
     * 
     *  @return session
     */
    public function createUserSession($user){
        //start session
        session_start();

        // Assign user id and user name to session
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;

    }
}