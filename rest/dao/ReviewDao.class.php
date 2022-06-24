  <?php

  require_once __DIR__.'/BaseDao.class.php';

  class ReviewDao extends BaseDao
  {
      public function __construct()
      {
          parent::__construct('reviews');
      }
  }
 ?>
