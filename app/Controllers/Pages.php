<?php



class Pages extends Controller{

    public function __construct()
    {
        // Get user model
        $this->userModel = $this->model('User');
    }



    public function index(){
        $users = $this->userModel->getUsers();

     
        $data = [
            'title' => 'home',
            'users' => $users,
        ];
        $this->view('pages/index',$data);
    }
    
    public function about(){
        $users = $this->userModel->getUsers();

        $data = [
            'users' => $users,
        ];
        $this->view('pages/about',$data);
    }
}