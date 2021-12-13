<?php

    // echo 'hello';
    // App core class 
    // Create URL and loads core controller
    // URL Format: /controller/method/param [] 
    
    class Src {
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct(){

            // $this->getUrl();
            $url = $this->getUrl();

            if(file_exists('../app/controllers/' . ucwords($url[0]). '.php' )){
                // if exist set as controller

                $this->currentController = ucwords($url[0]);
                unset($url[0]);
            }
            // require the controller
            require_once '../app/controllers/'. $this->currentController . '.php';

            //instantiate controller class
            $this->currentController = new $this->currentController;

            //check second part of url
            if(isset($url[1])){
				if ($url[1] != "__construct" && method_exists($this->currentController, $url[1]))
				{
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }

            //get params by ternary operator
            $this->params = $url ? array_values($url) : [];
			// var_dump([$this->currentController, $this->currentMethod]);
			// die();
            //call a callback with array of params
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }

        public function getUrl(){
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            }
        }
    }
