<?php

require_once __DIR__.'/BaseDao.class.php';

class RideDao extends BaseDao{

  public function __construct(){
    parent::__construct('rides');
  }
}
?>
