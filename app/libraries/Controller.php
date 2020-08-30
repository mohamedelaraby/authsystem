<?php


// Load the model and the view
class Controller{

    /**
     *  Load the model file
     * 
     *  @param mixed $model
     *  @return model 
     */
    public function model($model){

          //Require model file
          require_once '../app/models/' . $model . '.php';
          //Instantiate model
          return new $model();
    }


    /**
     *  Load the view
     *  
     *  @param mixed $view 
     *  @param array $data 
     *  @return view 
     */
   
        public function view($view, $data = []) {
         
            if ($this->isView($view)) {
                require_once '../app/Views/' . $view . '.php';
            } else {
                die("View does not exists.");
            }
            
        }
    


    /**
     *  Find  View file
     *  
     * @param mixed $view
     * @return Boolean
     */
    private function isView($view){
        return file_exists('../app/Views/' . $view . '.php');      
    } 
    

}