<?php

class Posts extends Controller {
    public function __construct()
    {
        if(!islogged()){
            redirect('users/login'); 
        }

        $this->postModel = $this->model('Post');
        //v2
        // $this->postModel = $this->model('User');
    }
    public function index(){
        //getting posts
        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts
        ];

        $this->view('posts/index', $data);
    }

    public function add(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // die('heeheh');
            //sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_error' => '',
                'body_error' => ''
            ];
            //validation of title & body
            if(empty($data['title'])){
                $data['title_error'] = 'Enter a Title';
            }

            if(empty($data['body'])){
                $data['body_error'] = 'Enter a Body text';
            }

            //checking errors
            if(empty($data['title_error'])&& empty($data['body_error'])){
                //validation
                if($this->postModel->addPost($data)){
                    flash('post_added', 'Post Added Successfully!');
                    redirect('posts');
                } else {
                    die('Something wrong!');
                }
            } else{
                $this->view('posts/add', $data);
            }
        } else{
            $data = [
                'title' => '',
                'body' => '',
            ];
    
            $this->view('posts/add', $data);

        }
    }

    public function edit($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // die('heeheh');
            //sanitize post array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => is_array($_POST['title']) ? "" : trim($_POST['title']),
                'body' => is_array($_POST['body']) ? "" : trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_error' => '',
                'body_error' => ''
            ];
            //validation of title & body
            if(empty($data['title'])){
                $data['title_error'] = 'Enter a Title';
            }

            if(empty($data['body'])){
                $data['body_error'] = 'Enter a Body text';
            }

            //checking errors
            if(empty($data['title_error'])&& empty($data['body_error'])){
                //validation
                if($this->postModel->addPost($data)){
                    flash('post_added', 'Post Added Successfully!');
                    redirect('posts');
                } else {
                    die('Something wrong!');
                }
            } else{
                $this->view('posts/add', $data);
            }
        } else{

            $data = [
                'title' => '',
                'body' => '',
            ];
    
            $this->view('posts/edit', $data);

        }
    }
}