<?php

 /**
 * @OA\Get(path="/rides", tags={"rides"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all documented rides from the API. ",
 *         @OA\Response( response=200, description="List of all rides.")
 * )
 */
  Flight::route('GET /rides', function () {
      Flight::json(Flight::rideService()->get_all());
  });

/**
* @OA\Get(path="/rides/{id}", tags={"rides"}, security={{"ApiKeyAuth": {}}},
*     @OA\Parameter(in="path", name="id", example=1, description="Id of ride"),
*     @OA\Response(response="200", description="Fetch individual ride"),
*     @OA\Response(
*         response=404,
*         description="Ride not found"
*     )
* )
*/
  Flight::route('GET /rides/@id', function ($id) {
      Flight::json(Flight::rideService()->get_by_id($id));
  });

  /**
  * @OA\Post(
  *     path="/rides",
  *     description="Add a ride",
  *     tags={"rides"},
  *     @OA\RequestBody(description="All ride info", required=true,
  *       @OA\MediaType(mediaType="application/json",
  *    			@OA\Schema(
  *           @OA\Property(property="driver_name", type="string", example="azraDriver",	description="Driver name"),
  *    				@OA\Property(property="passenger_name", type="string", example="azra",	description="Passenger name"),
  *    				@OA\Property(property="number_of_passengers", type="int", example="2",	description="Number of passengers"),
  *    				@OA\Property(property="luggage", type="string", example="yes",	description="Have luggage?" ),
  *    				@OA\Property(property="destination_address", type="string", example="Amira Krupalije 69",	description="Ride destination"),
  *           @OA\Property(property="arrival_time_requested", type="time", example="12:00:00",	description="Arrival time for the driver as requested")
  *        )
  *     )),
  *     @OA\Response(
  *         response=200,
  *         description="Ride documented"
  *     ),
  *     @OA\Response(
  *         response=404,
  *         description="Request failed"
  *     )
  * ),
  */
  Flight::route('POST /rides', function () {
      Flight::json(Flight::rideService()->add(Flight::request()->data->getData()));
  });

  /**
  * @OA\Get(path="/lastrideid", tags={"rides"}, security={{"ApiKeyAuth": {}}},
  *         summary="Return the last inserted ride id ",
  *         @OA\Response( response=200, description="Last inserted id")
  * )
  */
  Flight::route('GET /lastrideid', function () {
      Flight::json(Flight::rideService()->get_last_id());
  });
