<?php

require_once __DIR__.'/BaseDao.class.php';

class PaymentDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('payments');
    }
}
