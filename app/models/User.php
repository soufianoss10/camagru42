<?php
class User {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    //register user
    public function register($data){
        $this->db->query('INSERT INTO users (username, email, password, verification_status, notification, token) VALUES(:username, :email, :password, :verification_status, :notification, :token)');
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':verification_status', $data['verification_status']);
        $this->db->bind(':notification', true);
        $this->db->bind(':token', $data['token']);

        //execute and return user id
        if($this->db->execute()){
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    //login user
    public function login($username, $password){
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();
        $hashed_password = $row->password;

        if(password_verify($password, $hashed_password) && $row->verification_status != 0){
            return $row;
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

	public function findUserByEmailExcep($email, $id){
        $this->db->query('SELECT * FROM users WHERE email = :email AND id != :id');
        $this->db->bind(':email', $email);
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        //row checking
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        } 
    }

	public function findUserByUsername($username){
        $this->db->query('SELECT * FROM users WHERE `username` = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        //row checking
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        } 
    }

	public function findUserByUsernameExcep($username, $id){
        $this->db->query('SELECT * FROM users WHERE `username` = :username AND id != :id');
        $this->db->bind(':username', $username);
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        //row checking
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        } 
    }

	public function validateUser($userId, $token){
		$this->db->query('SELECT `token` FROM `users` WHERE `id` = :id AND `verification_status` != 1');
        $this->db->bind(':id', $userId);

		$row = $this->db->single();
		
		if ($this->db->rowCount() > 0) {
			if($row->token == $token) {
				$this->db->query('UPDATE `users` SET `verification_status` = 1, token = NULL WHERE id = :id');
				$this->db->bind(':id', $userId);
				return $this->db->execute();
			}
		}
		return false;
	}

	public function resetAccount($userId, $token) {
		$this->db->query('SELECT `token` FROM `users` WHERE `id` = :id AND `verification_status` != 0');
        $this->db->bind(':id', $userId);

		$row = $this->db->single();
		
		if ($this->db->rowCount() > 0) {
			if($row->token == $token) {
				return true;
			}
		}
		return false;
	}

	public function updatePassword($userId, $newPassword, $token) {
		$this->db->query('UPDATE `users` SET `password` = :password, `token` = NULL WHERE id = :id AND `token` = :token');
		$this->db->bind(':password', $newPassword);
		$this->db->bind(':id', $userId);
		$this->db->bind(':token', $token);
		if($this->db->execute())
			return $this->db->rowCount();
		return false;
	}

	public function forgetPassword ($email, $token) {
		$this->db->query('SELECT `id` FROM `users` WHERE `email` = :email AND `verification_status` != 0');
        $this->db->bind(':email', $email);

		$row = $this->db->single();

		if ($this->db->rowCount() > 0) {
			$this->db->query('UPDATE `users` SET `token` = :token WHERE id = :id');
			$this->db->bind(':token', $token);
			$this->db->bind(':id', $row->id);
			if ($this->db->execute()) {
				$this->db->query('SELECT `id`, `username` FROM `users` WHERE `email` = :email');
				$this->db->bind(':email', $email);
				$row = $this->db->single();
			}
			return $row ?: false;
		}
		return false;
	}

	public function update_account($id, $username, $email, $password, $notification = null) {
		if ($password) {
			$this->db->query('UPDATE `users` SET `username` = :username, `email` = :email, `password` = :password, `notification` = :notification WHERE `id` = :id');
			$this->db->bind(':username', $username);
			$this->db->bind(':email', $email);
			$this->db->bind(':password', $password);
			$this->db->bind(':notification', $notification == "on" ? true : false);
			$this->db->bind(':id', $id);
			$this->db->execute();
		} else {
			$this->db->query('UPDATE `users` SET `username` = :username, `email` = :email, `notification` = :notification WHERE `id` = :id');
			$this->db->bind(':username', $username);
			$this->db->bind(':email', $email);
			$this->db->bind(':notification', $notification == "on" ? true : false);
			$this->db->bind(':id', $id);
			$this->db->execute();
		}
		return  $this->db->rowCount();
	}
}