<?php

class BaseDao{

  private $conn;

  private $table_name;

  /**
  *constructor of dao class
  */
  public function __construct($table_name){

    $this->table_name = $table_name;
    $servername = "localhost";
    $username = "root";
    $password = "17110000";
    $schema = "vozime";
    $this->conn = new PDO("mysql:host=$servername;dbname=$schema", $username, $password);

    //set PDO error mode to Exception
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  /**
  * Method to read all table objects
  **/
  public function get_all()
  {
    $stmt = $this->conn->prepare("SELECT * FROM ". $this->table_name);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Get individual object by its id
   */
   public function get_by_id($id)
   {
     $stmt = $this->conn->prepare("SELECT * FROM ".$this->table_name." WHERE id=:id");
     $stmt->execute(['id' => $id]);
     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
     return reset($result); //move the array's pointer to the first element, so that we get it returned
   }

  /**
  * delete object from db
  */
  public function delete($id){
    $stmt = $this->conn->prepare("DELETE FROM ".$this->table_name." WHERE id=:id");
    $stmt->bindParam(':id', $id); // SQL injection prevention
    $stmt->execute();
  }

  /**
  * add object to db
  */
  public function add($entity){
    $query = "INSERT INTO ".$this->table_name." (";
    foreach ($entity as $column => $value) {
      $query .= $column.", ";
    }
    $query = substr($query, 0, -2);
    $query .= ") VALUES (";
    foreach ($entity as $column => $value) {
      $query .= ":".$column.", ";
    }
    $query = substr($query, 0, -2);
    $query .= ")";

    $stmt= $this->conn->prepare($query);
    $stmt->execute($entity); // sql injection prevention
    $entity['id'] = $this->conn->lastInsertId();
    return $entity;
  }

  /**
  * update object
  */
  public function update($id, $entity, $id_column = "id"){
    $query = "UPDATE ".$this->table_name." SET ";
    foreach($entity as $name => $value){
      $query .= $name ."= :". $name. ", ";
    }
    $query = substr($query, 0, -2);
    $query .= " WHERE ${id_column} = :id";

    $stmt= $this->conn->prepare($query);
    $entity['id'] = $id;
    $stmt->execute($entity);
  }

  protected function query($query, $params){
    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  protected function query_unique($query, $params){
    $results = $this->query($query, $params);
    return reset($results);
  }

}
?>
