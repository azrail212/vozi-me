<?php

  /**
  * @OA\Post(
  *     path="/ridepayments",
  *     description="Add a ride payment log",
  *     tags={"payments"},
  *     @OA\RequestBody(description="All ride payment info", required=true,
  *       @OA\MediaType(mediaType="application/json",
  *    			@OA\Schema(
  *           @OA\Property(property="driver_name", type="string", example="azraDriver",	description="Driver name"),
  *    				@OA\Property(property="passenger_name", type="string", example="azra",	description="Passenger name"),
  *        )
  *     )),
  *     @OA\Response(
  *         response=200,
  *         description="Ride payment documented"
  *     ),
  *     @OA\Response(
  *         response=404,
  *         description="Request failed"
  *     )
  * ),
  */
  Flight::route('POST /ridepayments', function()
  {
    Flight::json(Flight::paymentDao()->add(Flight::request()->data->getData()));
  });


 ?>
