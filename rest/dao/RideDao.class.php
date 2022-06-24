<?php

require_once __DIR__.'/BaseDao.class.php';

class RideDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('rides');
    }

    public function get_last_id()
    {
        return $this->query_unique("SELECT * FROM rides ORDER BY ID DESC LIMIT 1", []);
    }
}
