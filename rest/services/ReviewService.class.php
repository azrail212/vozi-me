<?php

require_once __DIR__.'/BaseService.class.php';
require_once __DIR__.'/../dao/ReviewDao.class.php';

class ReviewService extends BaseService{

  protected $dao;

  public function __construct(){
    parent::__construct(new ReviewDao());
  }

}

 ?>
