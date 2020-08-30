<?php


/**
 *  Core Class which controll the entire app 
 */

 class Core {
     
    /**
      * Hold current controller
      * @param mixed|null $currentController
      */
      protected $currentController = 'Pages';
      
      /**
      * Hold current Method
      * @param mixed|null $currentMethod
      */
      protected $currentMethod = 'index';
      
      /**
      * Get URL params
      * @param array $params
      */
      protected $params = [];

      /**
       *  Constructor
       */
      public function __construct()
      {
          $url = $this->getUrl();

          // Look inside 'controllers' for first value, ucwords will capitalize first letter
           $this->loadCurrentController($url);

           //Check for second part of URL
           $this->getURLSecondPart($url);

           // Set url parts to params array
           $this->setURLparts($url);
           // Kame a call bakc with url params
           $this->callbackWithURLParts();

        } 

      /**
       *  Get URL parts
       *  
       * @return array
       */
      public function getUrl(){

        // Check if url is set
    
        if(isset($_GET['url'])){
            // trim slash in url
            $url = rtrim($_GET['url'],'/');

            //Allows to filter variables as string/numbers
            $url = filter_var($url, FILTER_SANITIZE_URL);

            // Breaking url into an array
            $url = explode('/',$url);

            //return url
            return $url;
        }
      }


    


      /**
       *  Loads current cotnroller
       *  
       *  @param  array $url
       *  @return void 
       */
      private function loadCurrentController($url){
        
         if($this->isControllerExists($url[0])){
                 
            // Set new controller
            $this->currentController = ucwords($url[0]);

            // Unset current url
            unset($url[0]);
        }

        // Require the controller
        require_once '../app/Controllers/' . $this->currentController . '.php';

        // Instantiate the controller
        $this->currentController = new $this->currentController;
      }


      /**
       *  Get second part of url
       * 
       *  @param  array $url
       *  @return void
       */
      private function getURLSecondPart($url){
         

        if(isset($url[1])){
            // Check if method exists
            if(method_exists($this->currentController,$url[1])){
                // Set current method
                $this->currentMethod = $url[1];
                // unset url second part
                unset($url[1]);
            }
        }
      }

      /**
       *  Get URL parts 
       *  
       * @param  array $url
       * @return array
       */
      private function setURLparts($url){
          //Get params
          return $this->params = $url ? array_values($url) : [];
      }

      /**
       *  Call a call back with array of url parts
       * 
       *  @return array
       */
      private function callbackWithURLParts(){
          return call_user_func_array([$this->currentController,$this->currentMethod],$this->params);
      }


        /**
       *  Check if controller exists inside controller folder
       *  
       * @return boolean
       */
      private function isControllerExists($url){
        return file_exists('../app/Controllers/' . ucwords($url). '.php');
      }
 }
 