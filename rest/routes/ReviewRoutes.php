<?php

 /**
 * @OA\Get(path="/reviews", tags={"reviews"}, security={{"ApiKeyAuth": {}}},
 *         summary="Return all documented reviews from the API. ",
 *         @OA\Response( response=200, description="List of all reviews.")
 * )
 */
  Flight::route('GET /reviews', function () {
      Flight::json(Flight::reviewService()->get_all());
  });

/**
* @OA\Get(path="/reviews/{id}", tags={"reviews"}, security={{"ApiKeyAuth": {}}},
*     @OA\Parameter(in="path", name="id", example=1, description="Id of review"),
*     @OA\Response(response="200", description="Fetch individual review"),
*     @OA\Response(
*         response=404,
*         description="review not found"
*     )
* )
*/
  Flight::route('GET /reviews/@id', function ($id) {
      Flight::json(Flight::reviewService()->get_by_id($id));
  });

  /**
  * @OA\Post(
  *     path="/reviews",
  *     description="Add a review",
  *     tags={"reviews"},
  *     @OA\RequestBody(description="All review info", required=true,
  *       @OA\MediaType(mediaType="application/json",
  *    			@OA\Schema(
  *         @OA\Property(property="id", type="int", example="1",	description="Review id"),
  *    			@OA\Property(property="rating", type="int", example="3",	description="Rating"),
  *    			@OA\Property(property="reviewer_id", type="int", example="1",	description="Id of user who left review" ),
  *    			@OA\Property(property="reviewed_id", type="int", example="2",	description="Id of reviewed user")
  *        )
  *     )),
  *     @OA\Response(
  *         response=200,
  *         description="Review documented"
  *     ),
  *     @OA\Response(
  *         response=404,
  *         description="Request failed"
  *     )
  * )
  */
  Flight::route('POST /reviews', function () {
      Flight::json(Flight::reviewService()->add(Flight::request()->data->getData()));
  });

  /**
  * @OA\Delete(
  *     path="/reviews/{id}",
  *     tags={"reviews"},
  *     @OA\Parameter(in="path", name="id", example=1, description="Id of review"),
  *     @OA\Response(
  *         response=200,
  *         description="Deleted"
  *     ),
  *     @OA\Response(
  *         response=404,
  *         description="Review cannot be found or deleted"
  *     )
  * )
  */
  Flight::route('DELETE /reviews/@id', function ($id) {
      Flight::reviewService()->delete($id);
      Flight::json(["message" => "deleted"]);
  });

/**
* @OA\Put(
*     path="/reviews/{id}",
*     tags={"reviews"},
*     @OA\RequestBody(description="All user info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="id", type="int", example="1",	description="Review id"),
*    				@OA\Property(property="rating", type="int", example="3",	description="Rating"),
*    				@OA\Property(property="reviewer_id", type="int", example="1",	description="Id of user who left review" ),
*    				@OA\Property(property="reviewed_id", type="int", example="2",	description="Id of reviewed user")
*        )
*     )),
*     @OA\Parameter(in="path", name="id", example=1, description="Id of review"),
*     @OA\Response(
*         response=200,
*         description="Get review listed as successful response"
*     ),
*     @OA\Response(
*         response=404,
*         description="Review cannot be found or updated | No review with such ID"
*     )
* )
*/
  Flight::route('PUT /reviews/@id', function ($id) {
      $data = Flight::request()->data->getData();
      $data['id'] = $id;
      Flight::json(Flight::reviewService()->update($id, $data));
  });
