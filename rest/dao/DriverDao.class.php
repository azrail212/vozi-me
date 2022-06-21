  <?php

  require_once __DIR__.'/BaseDao.class.php';

  class DriverDao extends BaseDao{

    public function __construct(){
      parent::__construct('drivers');
    }

    public function get_driver_by_username($username)
    {
      return $this->query_unique("SELECT * FROM users WHERE username = :username AND driver='yes';", ['username' => $username]);
    }

    public function get_driver_by_id($id)
    {
      return $this->query_unique("SELECT * FROM users WHERE id = :id AND driver='yes';", ['id' => $id]);
    }

    public function get_driver_by_email($email)
    {
      return $this->query_unique("SELECT * FROM users WHERE email = :email AND driver='yes';", ['email' => $email]);
    }

    public function get_all_drivers()
    {
      return $this->query("SELECT * FROM users where driver=:driver;", ['driver' => 'yes']);
    }
  }
 ?>
