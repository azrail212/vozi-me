<?php

require_once __DIR__.'/BaseService.class.php';
require_once __DIR__.'/../dao/PaymentDao.class.php';

class PaymentService extends BaseService
{
    protected $dao;

    public function __construct()
    {
        parent::__construct(new PaymentDao());
    }
}
