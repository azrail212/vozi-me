<?php

 /**
 * Function to list all categories
 */
  Flight::route('GET /users', function()
  {
    Flight::json(Flight::userService()->get_all());
  });

/**
 * Get individual category
 */
  Flight::route('GET /users/@id', function($id)
  {
   Flight::json(Flight::userService()->get_by_id($id));
  });

 /**
  * add category to db
  */
  Flight::route('POST /users', function()
  {
    Flight::json(Flight::userService()->add(Flight::request()->data->getData()));
  });

/**
 * delete category
 */
  Flight::route('DELETE /users/@id', function($id)
  {
    Flight::userService()->delete($id);
    Flight::json(["message" => "deleted"]);
  });

  /**
   * update category by id
   */
  Flight::route('PUT /users/@id', function($id)
  {
    $data = Flight::request()->data->getData();
    $data['id'] = $id;
    Flight::json(Flight::userService()->update($id, $data));
  });

 ?>
