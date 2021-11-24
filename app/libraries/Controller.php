<?php
// load models & views

class Controller{
    // load model
    public function model($model){

        require_once '../app/models/' . $model . '.php';
    //    require_once '../app/models/Post.php';
        //instantiate mode
        return new $model();
    }

    //load view
    public function view($view, $data = []){
        //check for view file
        if(file_exists('../app/views/' . $view . '.php')){
            require_once'../app/views/' . $view . '.php';
        }
        else{
            die('view does not exists');
        }
    }
}
?>