<?php

require_once __DIR__.'/BaseDao.class.php';

class UserDao extends BaseDao{

  public $table = 'users';

  public function __construct(){
    parent::__construct('users');
  }

  public function get_user_by_username($username)
  {
    return $this->query_unique("SELECT * FROM users WHERE username = :username", ['username' => $username]);
  }


  public function get_by_email($email)
  {
    return $this->query_unique("SELECT * FROM users WHERE email = :email", ['email' => $email]);
  }
}
 ?>
