  <?php

  require_once __DIR__.'/BaseService.class.php';
  require_once __DIR__.'/../dao/DriverDao.class.php';

  class DriverService extends BaseService
  {
      protected $dao;

      public function __construct()
      {
          parent::__construct(new DriverDao());
      }

      public function get_driver_by_username($username)
      {
          return $this->dao->get_driver_by_username($username);
      }

      public function get_driver_by_id($id)
      {
          return $this->dao->get_driver_by_id($id);
      }

      public function get_driver_by_email($email)
      {
          return $this->dao->get_driver_by_email($email);
      }

      public function get_all_drivers()
      {
          return $this->dao->get_all_drivers();
      }
  }

 ?>
