<?php

require_once __DIR__.'/BaseService.class.php';
require_once __DIR__.'/../dao/RideDao.class.php';

class RideService extends BaseService
{
    protected $dao;

    public function __construct()
    {
        parent::__construct(new RideDao());
    }

    public function get_last_id()
    {
        return $this->dao->get_last_id();
    }
}
