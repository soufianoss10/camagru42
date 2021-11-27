<?php 
    class Users extends Controller {
        public function __construct(){
            
        }

        public function register(){
            //check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

            } else {
                // init data
                $data =[ 
                    'name' => '',
                    'email' => '',
                    'passsword' => '',
                    'confirm_password' => '',
                    'name_error' => '',
                    'email error' => '',
                    'password_error' => '',
                    'confirm_password_error' => '',
                ];

                // load view
                $this->view('users/register', $data);
            }
        }
    }