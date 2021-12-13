<?php
// $_SESSION['user'] = 'soufiane';

// unset($_SESSION['user']);

session_start();

function flash($name = '', $message = '', $class = 'alert alert-success'){
    if(!empty($name)){
        if(!empty($message) && empty($_SESSION[$name])){
            if(!empty($_SESSION[$name])){
                unset($_SESSION[$name]);
            }

            if(!empty($_SESSION[$name. '_class'])){
                unset($_SESSION[$name. '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name. '_class'] = $class;


        } else if(empty($message) && !empty($_SESSION[$name])){ 
          $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
          echo '<div class = "'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
          unset($_SESSION[$name]);
          unset($_SESSION[$name. '_class']);
        }
    }
}

function islogged(){
    if(isset($_SESSION['id'])){
        return true;
    } else {
        return false;
    }
}

function createUserSession($user){
	$_SESSION['id'] = $user->id;
	$_SESSION['email'] = $user->email;
	$_SESSION['username'] = $user->username;
	$_SESSION['notification'] = $user->notification;
	redirect('posts');
}

function createUserSessionProfile($user){
	$_SESSION['id'] = $user->id;
	$_SESSION['email'] = $user->email;
	$_SESSION['username'] = $user->username;
	$_SESSION['notification'] = $user->notification;
	redirect('users/profile');
}

