<?php

 /**
 * @OA\Get(path="/drivers", tags={"drivers"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all drivers from the API. ",
 *         @OA\Response( response=200, description="List of categories.")
 * )
 */
  Flight::route('GET /drivers', function()
  {
    Flight::json(Flight::driverDao()->get_all_drivers());
  });

/**
* @OA\Get(path="/drivers/{id}", tags={"drivers"}, security={{"ApiKeyAuth": {}}},
*     @OA\Parameter(in="path", name="id", example=1, description="Id of driver"),
*     @OA\Response(response="200", description="Fetch individual driver")
* )
*/
  Flight::route('GET /drivers/@id', function($id)
  {
   Flight::json(Flight::driverDao()->get_driver_by_id($id));
  });


 /**
  * add driver to db
  */
  Flight::route('POST /drivers', function()
  {
    Flight::json(Flight::driverDao()->add(Flight::request()->data->getData()));
  });

/**
 * delete driver
 */
  Flight::route('DELETE /drivers/@id', function($id)
  {
    Flight::driverDao()->delete($id);
    Flight::json(["message" => "deleted"]);
  });

  /**
   * update driver by id
   */
  Flight::route('PUT /drivers/@id', function($id)
  {
    $data = Flight::request()->data->getData();
    $data['id'] = $id;
    Flight::json(Flight::driverDao()->update($id, $data));
  });

 ?>
