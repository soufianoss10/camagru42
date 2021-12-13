<?php 
    class Users extends Controller {
        public function __construct(){
            $this->userModel = $this->model('User'); // check model folder 
        }

		public function index() {
			redirect('users/login');
		}

        public function register(){
            //check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data =[ 
                    'username' => is_array($_POST['username']) ? "" : trim($_POST['username']),
                    'email' => is_array($_POST['email']) ? "": trim($_POST['email']),
                    'password' => is_array($_POST['password']) ? "" : $_POST['password'],
                    'confirm_password' => is_array($_POST['confirm_password']) ? "" :$_POST['confirm_password'],
                    'username_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => '',
                ];

                //validation email/username/passord/conf_passwd
                if(empty($data['email'])){
                    $data['email_error'] = 'Enter your email'; 
                } else if($this->userModel->findUserByEmail($data['email'])) {
                        $data['email_error'] = 'Email already used';
                }

                if(empty($data['username'])){
                    $data['username_error'] = 'Enter your a valid username'; 
                } else if ($this->userModel->findUserByUsername($data['username'])) {
					$data['username_error'] = 'Username already used';
				}

				if (empty($data['password']))
					$data['password_error'] = 'Enter your Password!';
				else if (strlen($data['password']) < 6)
					$data['password_error'] = 'Password must be at least 6 characters';
				else if (!preg_match('@[A-Z]@', $data['password']))
					$data['password_error'] = 'Password must contain an upper case';
				else if (!preg_match('@[a-z]@', $data['password']))
					$data['password_error'] = 'Password must contain a lower case';
				else if (!preg_match('@[0-9]@', $data['password']))
					$data['password_error'] = 'Password must contain a number';
				if ($data['password'] != $data['confirm_password'])
					$data['confirm_password_error'] = 'Passwords do not match !';

                if(empty($data['confirm_password'])){
                    $data['confirm_password_error'] = 'Confirm your Password'; 
                } else if ($data['password'] != $data['confirm_password']){
                        $data['confirm_password_error'] = 'Password not matched';
                }
				
				//	check that errors are empty
                
				if(empty($data['email_error']) && empty($data['username_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])){
                    
                    //hashing the password and generate token
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

					$token = openssl_random_pseudo_bytes(16);
					$token = strtolower(bin2hex($token));
                    $data['verification_status'] = false;
                    $data['token'] = $token;

                    //register user
                    if($userId = $this->userModel->register($data)){
						// Send verification email
						$flag = ft_send_mail($userId, $data['email'], "Verify your email", $token, $data["username"]);
						if($flag) {
							flash('register_success', 'Please check your email to verify your account!');
						} else {
							flash('register_error', 'Something went wrong', "alert alert-danger");
						}
						redirect('users/login');
                    } else {
                        die('something wrong');
                    }
                } else {
                    //load view with error
                    $this->view('users/register', $data);
                }

            } else {
                
                // init data
                $data =[ 
                    'username' => "",
                    'email' => "",
                    'password' => "",
                    'confirm_password' => "",
                    'username_error' => "",
                    'email_error' => "",
                    'password_error' => "",
                    'confirm_password_error' => "",
                ];

                // load view
               $this->view('users/register', $data);
            }
        }


        public function login(){
            //check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data =[
                    'username' => is_array($_POST['username']) ? "" : trim($_POST['username']),
                    'password' => is_array($_POST['password']) ? "" : $_POST['password'], 
                    'username_error' => '',
                    'password_error' => '',
                ];
                    //validate mail & passwd
                if(empty($data['username'])){
                    $data['username_error'] = 'Enter your username'; 
                }

                if(empty($data['password'])){
                    $data['password_error'] = 'Enter your Password'; 
                }

                //check user & mail
                if(!$this->userModel->findUserByUsername($data['username'])){
					flash('register_success', 'Something went wrong', "alert alert-danger");
					$this->view('users/login');
                }

                //check for errors
                if(empty($data['username_error']) && empty($data['password_error'])){
                  //check and set logged in user
                        $loggedUser = $this->userModel->login($data['username'], $data['password']);

                        if($loggedUser){
                            //create session
                            createUserSession($loggedUser);
                        } else {
							flash('register_success', 'Something went wrong', "alert alert-danger");
							$this->view('users/login', $data);
                        }
                    } else {
                        //load view with error
                        $this->view('users/login', $data);
                    }

            } else {
                // init data
                $data = [ 
                    'username' => '',
                    'passsword' => '', 
                    'username_error' => '',
                    'password_error' => '',
                ];

                // load view
               $this->view('users/login', $data);
            }
        }

        public function logout(){
            unset($_SESSION['id']);
            unset($_SESSION['username']);
            unset($_SESSION['email']);
            unset($_SESSION['notification']);
            session_destroy();
            redirect('users/login');
        }

		public function verification($id = null, $token = null) {
			if (preg_match('/^\d+$/m', $id) && preg_match('/^[a-z0-9]{32}$/m', $token)){
				$user = $this->userModel->validateUser($id, $token);
				if ($user){
					flash('register_success', 'Your account has been verified successfully!');
					redirect('users/login');
				} else {
					flash('register_success', 'Something went wrong!', "alert alert-danger");
					redirect('users/login');
				}
			} else {
				flash('register_success', 'Something went wrong!', "alert alert-danger");
				redirect('users/login');
			}
		}

		public function resetaccount ($id = null, $token = null){
			if (preg_match('/^\d+$/m', $id) && preg_match('/^[a-z0-9]{32}$/m', $token)){
				$user = $this->userModel->resetAccount($id, $token);
				if ($user){
					if ($_SERVER['REQUEST_METHOD'] == 'POST'){
						$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

						$data =[
							'password' => is_array($_POST['password']) ? "" : $_POST['password'],
							'password_error' => "",
						];
		
						if (empty($data['password']))
							$data['password_error'] = 'Enter your Password!';
						else if (strlen($data['password']) < 6)
							$data['password_error'] = 'Password must be at least 6 characters';
						else if (!preg_match('@[A-Z]@', $data['password']))
							$data['password_error'] = 'Password must contain an upper case';
						else if (!preg_match('@[a-z]@', $data['password']))
							$data['password_error'] = 'Password must contain a lower case';
						else if (!preg_match('@[0-9]@', $data['password']))
							$data['password_error'] = 'Password must contain a number';

						//check for errors
						if(empty($data['password_error'])){
							// update the password
							$password = password_hash($data['password'], PASSWORD_DEFAULT);
							$flag = $this->userModel->updatePassword($id, $password, $token);


							// response
							if ($flag) {
                                flash('register_success', 'Your account has been updated successfully!');
                                redirect('users/login');
							} else {
                                flash('register_error', 'Something went wrong!', "alert alert-danger");
                                redirect('users/login');
							}
						} else {
							// load view with flash
                            flash('register_error', 'Something went wrong!', "alert alert-danger");
							redirect('users/login');
						}
					} else {
						// load reset password view
						$this->view('/users/resetaccount');
					}
				} else {
					flash('register_success', 'Something went wrong!', "alert alert-danger");
					redirect('users/login');
				}
			} else {
				flash('register_success', 'Something went wrong!', "alert alert-danger");
				redirect('users/login');
			}

		}

		public function forgetpassword() {
			//check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data =[
                    'email' => is_array($_POST['email']) ? "" : trim($_POST['email']),
                ];

                //validate mail & passwd
                if(empty($data['email'])){
                    $data['email_error'] = 'Enter your email'; 
                }

                //check for errors
                if(empty($data['email_error'])){
                  //check and set logged in user
				  $token = openssl_random_pseudo_bytes(16);
				  $token = strtolower(bin2hex($token));

				  $user = $this->userModel->forgetPassword($data['email'], $token);
				  // get username and userId
				  if ($user) {
					$flag = send_reset_email($user, $data['email'], "Reset Camagru account", $token);
					flash('rest_success', 'Please check your email to reset your account!');
					redirect('users/forgetpassword');
				  } else {
					flash('rest_error', 'Something went wrong!', "alert alert-danger");
					redirect('users/forgetpassword');
				  }
				} else {
					//load view with error
					$this->view('users/forgetpassword', $data);
				}

            } else {
                // init data
                $data = [ 
                    'email' => '',
					'email_error' => '',
                ];
                // load view
               $this->view('users/forgetpassword', $data);
            }
		}

		public function profile(){
			if ($_SERVER['REQUEST_METHOD'] == 'GET') {
				$this->view('users/profile');
			} else {
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data =	[ 
                    'username' => is_array($_POST['username']) ? "" : trim($_POST['username']),
                    'email' => is_array($_POST['email']) ? "": trim($_POST['email']),
                    'password' => is_array($_POST['password']) ? "" : $_POST['password'],
                    'old_password' => is_array($_POST['old_password']) ? "" :$_POST['old_password'],
                    'username_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'old_password_error' => '',
                ];

				if(empty($data['email'])){
                    $data['email_error'] = 'Enter your email'; 
                } else if($this->userModel->findUserByEmailExcep($data['email'], $_SESSION['id'])) {
                        $data['email_error'] = 'Email already used';
                }

                if(empty($data['username'])){
                    $data['username_error'] = 'Enter your a valid username'; 
                } else if ($this->userModel->findUserByUsernameExcep($data['username'], $_SESSION['id'])) {
					$data['username_error'] = 'Username already used';
				}

				if (!empty($data['password'])) {
					if (strlen($data['password']) < 6)
						$data['password_error'] = 'Password must be at least 6 characters';
					else if (!preg_match('@[A-Z]@', $data['password']))
						$data['password_error'] = 'Password must contain an upp er case';
					else if (!preg_match('@[a-z]@', $data['password']))
						$data['password_error'] = 'Password must contain a lower case';
					else if (!preg_match('@[0-9]@', $data['password']))
						$data['password_error'] = 'Password must contain a number';
					if ($data['password'] != $data['confirm_password'])
						$data['confirm_password_error'] = 'Passwords do not match !';
				}

				if (empty($data['old_password'])){
					$data['old_password_error'] = "Please fill the old password!";
				}
				if (empty($data['email_error']) && empty($data['username_error']) && empty($data['password_error']) && empty($data['old_password_error'])){
					$isUser = $this->userModel->login($_SESSION['username'], $data['old_password']);

					// var_dump($isUser);
					// var_dump($data['password'] ?: $data['old_password']);
					// die("yaaaap");
					if ($isUser){
						$password = !empty($data['password']) ? password_hash($data['password'], PASSWORD_DEFAULT) : null;
						$row = $this->userModel->update_account($_SESSION['id'], $data['username'], $data['email'], $password, $_POST["notification"]);
						if ($row) {
							$newUser = $this->userModel->login($data['username'], empty($data['password']) ? $data['old_password'] : $data['password'] );

							// echo "<pre>";
							// var_dump($data['username'],$newUser, $data['old_password'], $data['password']);
							// echo "</pre>";
							// die();

							flash('updated_success', 'Your account has been updated successfully!');
							createUserSessionProfile($newUser);
							// $this->view('users/profile');
						} else {

							// echo "<pre>";
							// var_dump($_SESSION['id'], $data['username'], $data['email'], $password, $_POST["notification"]);
							// echo "</pre>";
							// die();

							flash('updated_error', 'Nothing changed!', "alert alert-danger");
							$this->view('users/profile');
						}
					} else {
						// echo $_SESSION['username'];
						// die();
						flash('updated_error', 'Something went wrong!', "alert alert-danger");
						redirect('users/profile');
					}
				} else {
					
					// echo $data['email_error'];
					// echo $data['username_error'];
					// echo $data['password_error'];
					// echo $data['old_password_error'];
					// die();

					flash('updated_error', 'Something went wrong!', "alert alert-danger");
					redirect('users/profile');
				}
			}
		}

    }