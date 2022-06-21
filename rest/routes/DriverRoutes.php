<?php

 /**
 * @OA\Get(path="/drivers", tags={"drivers"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all drivers from the API. ",
 *         @OA\Response( response=200, description="List of all drivers.")
 * )
 */
  Flight::route('GET /drivers', function()
  {
    Flight::json(Flight::driverDao()->get_all_drivers());
  });

/**
* @OA\Get(path="/drivers/{id}", tags={"drivers"}, security={{"ApiKeyAuth": {}}},
*     @OA\Parameter(in="path", name="id", example=1, description="Id of driver"),
*     @OA\Response(response="200", description="Fetch individual driver"),
*     @OA\Response(
*         response=404,
*         description="Driver doesn't exist"
*     )
* )
*/
  Flight::route('GET /drivers/@id', function($id)
  {
   Flight::json(Flight::driverDao()->get_driver_by_id($id));
  });

 ?>
