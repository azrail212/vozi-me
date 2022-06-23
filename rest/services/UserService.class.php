<?php

require_once __DIR__.'/BaseService.class.php';
require_once __DIR__.'/../dao/UserDao.class.php';

class UserService extends BaseService{

  protected $dao;

  public function __construct(){
    parent::__construct(new UserDao());
  }

  public function get_user_by_username($username)
  {
    return $this->dao->get_user_by_username($username);
  }


  public function get_by_email($email)
  {
    return $this->dao->get_by_email($email);
  }

}

 ?>
