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

            if(!empty($_SESSION[$name. 'class'])){
                unset($_SESSION[$name. 'class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name. 'class'] = $class;


        } else if(empty($message) && !empty($_SESSION[$name])){ 
          $class = !empty($_SESSION[$name. 'class']) ? $_SESSION[$name. 'class'] : '';
          echo '<div class = "'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
          unset($_SESSION[$name]);
          unset($_SESSION[$name. 'class']);
        }
    }
}