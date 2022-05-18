<?php

require_once __DIR__.'/BaseDao.class.php';

class UserDao extends BaseDao{

  public $table = 'users';

  public function __construct(){
    parent::__construct('users');
  }

  public function execute_user_query($query, $params){
    return $this->execute_query($query, $params);
  }

  public function get_user_by_username($username)
  {
    return $this->query("SELECT * FROM users where username = :username", ['username' => $username]);
  }
}
 ?>
