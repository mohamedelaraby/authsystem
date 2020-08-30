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
            'title' => 'Login Page',
            'usernameError' => '',
            'passwordError' => '',
        ];

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
            'confirmpasswordError' => ''
        ];

        // Check for request method
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanatize post data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            
            // Trim post data
            $data = [
                'username' => trim($data['username']),
                'email' => trim($data['email']),
                'password' => trim($data['password']),
                'confirmpassword' => trim($data['confirmpassword']),
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
            } elseif(strlen($data['password'] < 6)){
                $data['passwordError'] = 'Password must be at least 8 charachers.';
            } elseif(!preg_match($passwordValidation,$data['password'])){
                $data['passwordError'] = 'Password must be at least one numeric value.';
            }

            // Validate confirm Password
            if(empty($data['confirmpassword'])){
                $data['confirmpasswordError'] = 'Please enter password again.';
            } else {
                // Check if the two passwords does not match
                if(!$data['password'] == $data['confirmpassword']){
                 $data['confirmpasswordError'] = 'Passwords do not matchm please try again.';
                }
            }

             // Make sure that errors are empties
             if(empty($data['usernameError']) &&
                empty($data['emailError']) &&
                empty($data['passwordError']) &&
                empty($data['confirmpasswordError'])){
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
}