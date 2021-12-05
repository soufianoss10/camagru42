<?php

    class Pages extends Controller {
         public function __construct(){
            //  echo 'pages is ok';
        //    $this->postModel = $this->model('Post');
        }
    // }
        //default method
        public function index(){
            if(islogged()){
                redirect('posts');
            }
            // $posts = $this->postModel->getPosts();

            $data = ['title' => 'Welcome'
        ];

            

            $this->view('pages/index', $data);
           // echo $user;
            // echo "Hello from index page";
        }
    
        public function about(){
            $data = ['title' => 'About us'];
        
            // echo "this is about page";
            $this->view('pages/about', $data);
        }
    
        
    }
    
    ?>