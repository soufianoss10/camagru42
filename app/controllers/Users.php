<?php 
    class Users extends Controller {
        public function __construct(){
            $this->userModel = $this->model('User'); // check model folder 
            
        }

        public function register(){
            //check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    // die('submit');
                //sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data =[ 
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => $_POST['password'],
                    'confirm_password' => $_POST['confirm_password'],
                    'name_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => '',
                ];

                //validation email/name/passord/conf_passwd
                if(empty($data['email'])){
                    $data['email_error'] = 'Enter your email'; 
                } else {
                    if($this->userModel->findUserByEmail($data['email'])){
                        $data['email_error'] = 'Email already used';
                    }
                }

                if(empty($data['name'])){
                    $data['name_error'] = 'Enter your name'; 
                }

                if(empty($data['password'])){
                    $data['password_error'] = 'Enter your Password'; 
                } elseif(strlen($data['password']) < 6){
                    $data['password_error'] = 'Your Password must have minimum 6 characters';
                }

                if(empty($data['confirm_password'])){
                    $data['confirm_password_error'] = 'Confirm your Password'; 
                } else {
                    if($data['password'] != $data['confirm_password']){
                        $data['confirm_password_error'] = 'Password not matched';
                    }
                }
                    //check that errors are empty
                if(empty($data['email_error']) && empty($data['name_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])){
                    
                    //hashing the passwd
                    
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    //register user
                    if($this->userModel->register($data)){
                        flash('register_success', 'Congratulations Your are registred and u can log in');
                            redirect('users/login');
                    } else {
                        die('something wrong');
                    }
                } else{
                    //load view with error
                    $this->view('users/register', $data);
                }

            } else {
                
                // init data
                $data =[ 
                    'name' => "",
                    'email' => "",
                    'passsword' => "",
                    'confirm_password' => "",
                    'name_error' => "",
                    'email_error' => "",
                    'password_error' => "",
                    'confirm_password_error' => "",
                ];
                // $data = ["name" => "zab"];

                // load view
               $this->view('users/register', $data);
            //    echo "sons of bitch";
            }
        }


        public function login(){
            //check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data =[
                    'email' => trim($_POST['email']),
                    'password' => $_POST['password'], 
                    'email_error' => '',
                    'password_error' => '',
                    
                ];
                    //validate mail & passwd
                if(empty($data['email'])){
                    $data['email_error'] = 'Enter your email'; 
                }

                if(empty($data['password'])){
                    $data['password_error'] = 'Enter your Password'; 
                }

                //check user & mail
                if($this->userModel->findUserByEmail($data['email'])){
                    //user found
                } else {
                    $data['email_error'] = 'user Not found';
                }

                    //check for errors
                if(empty($data['email_error']) && empty($data['password_error'])){
                  //check and set logged in user
                        $loggedUser = $this->userModel->login($data['email'], $data['password']);

                        if($loggedUser){
                            //create session
                            // die('Success');
                            $this->createUserSession($loggedUser);
                        } else {
                            $data['password_error'] = 'Password incorrect';

                            $this->view('users/login', $data);
                        }
                    } else {
                        //load view with error
                        $this->view('users/login', $data);
                    }



            } else {
                
                // init data
                $data =[ 
        
                    'email' => '',
                    'passsword' => '', 
                    'email_error' => '',
                    'password_error' => '',
                   
                ];

                // load view
               $this->view('users/login', $data);
            //    echo "sons of bitch";
            }
        }

        public function createUserSession($user){
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_name'] = $user->name;
            redirect('posts');
        }

        public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            redirect('users/login');
        }

        
    }