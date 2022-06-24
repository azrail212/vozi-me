<?php

  /**
  * @OA\Post(
  *     path="/ridepayments",
  *     description="Add a ride payment log",
  *     tags={"payments"},
  *     @OA\RequestBody(description="All ride payment info", required=true,
  *       @OA\MediaType(mediaType="application/json",
  *    			@OA\Schema(
  *           @OA\Property(property="ride_id", type="int", example="1",	description="Id of ride recorded")
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
  Flight::route('POST /ridepayments', function () {
      Flight::json(Flight::paymentService()->add(Flight::request()->data->getData()));
  });
