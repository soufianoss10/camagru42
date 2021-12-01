<?php
class User {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    //register user
    public function register($data){
        $this->db->query('INSERT INTO users (name, email, password) VALUES(:name, :email, :password)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        //execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    //find user by mail to check if already exist in db
    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        //row checking
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }
}