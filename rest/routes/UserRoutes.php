<?php

  use Firebase\JWT\JWT;
  use Firebase\JWT\Key;

  /**
  * @OA\Get(path="/users", tags={"users"}, security={{"ApiKeyAuth": {}}},
  *         summary="Return all users from the API. ",
  *         @OA\Response( response=200, description="List of categories.")
  * )
  */
   Flight::route('GET /users', function()
   {
     Flight::json(Flight::userDao()->get_all());
   });

 /**
 * @OA\Get(path="/users/{id}", tags={"users"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(in="path", name="id", example=1, description="Id of user"),
 *     @OA\Response(response="200", description="Fetch individual user")
 * )
 */
   Flight::route('GET /users/@id', function($id)
   {
    Flight::json(Flight::userDao()->get_by_id($id));
   });

   /**
   * @OA\Post(
   *     path="/users",
   *     description="Add a user; please use register method instead to avoid duplicates!",
   *     tags={"users"},
   *     @OA\RequestBody(description="All user info", required=true,
   *       @OA\MediaType(mediaType="application/json",
   *    			@OA\Schema(
   *    				@OA\Property(property="username", type="string", example="azra",	description="Username"),
   *    				@OA\Property(property="email", type="string", example="azra@gmail.com",	description="Email"),
   *    				@OA\Property(property="password", type="string", example="12345678",	description="Password" ),
   *    				@OA\Property(property="licence_id", type="string", example="123456",	description="user licence ID"),
   *            @OA\Property(property="driver", type="string", example="no",	description="Is driver?")
   *        )
   *     )),
   *     @OA\Response(
   *         response=200,
   *         description="Get user listed as successful response"
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="Password too weak | User already exists"
   *     )
   * ),
   */
   Flight::route('POST /users', function()
   {
     Flight::json(Flight::userDao()->add(Flight::request()->data->getData()));
   });
   Flight::route('POST /users', function()
   {
     Flight::json(Flight::userDao()->add(Flight::request()->data->getData()));
   });

   /**
   * @OA\Delete(
   *     path="/users/{id}",
   *     tags={"users"},
   *     @OA\Parameter(in="path", name="id", example=1, description="Id of user"),
   *     @OA\Response(
   *         response=200,
   *         description="Deleted"
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="User cannot be found or deleted"
   *     )
   * )
   */
   Flight::route('DELETE /users/@id', function($id)
   {
     Flight::userDao()->delete($id);
     Flight::json(["message" => "deleted"]);
   });

/**
* @OA\Put(
*     path="/users/{id}",
*     tags={"users"},
*     @OA\RequestBody(description="All user info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*    				@OA\Property(property="username", type="string", example="azra",	description="Username"),
*    				@OA\Property(property="email", type="string", example="azra@gmail.com",	description="Email"),
*    				@OA\Property(property="password", type="string", example="12345678",	description="Password" ),
*    				@OA\Property(property="licence_id", type="string", example="123456",	description="User licence ID"),
*           @OA\Property(property="driver", type="string", example="yes",	description="Is driver?")
*        )
*     )),
*     @OA\Parameter(in="path", name="id", example=1, description="Id of user"),
*     @OA\Response(
*         response=200,
*         description="Get user listed as successful response"
*     ),
*     @OA\Response(
*         response=404,
*         description="User cannot be found or updated | No user with such ID"
*     )
* )
*/
   Flight::route('PUT /users/@id', function($id)
   {
     $data = Flight::request()->data->getData();
     $data['id'] = $id;
     Flight::json(Flight::userDao()->update($id, $data));
   });
  /**
  * @OA\Post(
  *     path="/login",
  *     description="Login to the system",
  *     tags={"users"},
  *     @OA\RequestBody(description="Basic user info", required=true,
  *       @OA\MediaType(mediaType="application/json",
  *    			@OA\Schema(
  *    				@OA\Property(property="username", type="string", example="azra",	description="Username"),
  *    				@OA\Property(property="password", type="string", example="12345678",	description="Password" )
  *        )
  *     )),
  *     @OA\Response(
  *         response=200,
  *         description="JWT Token on successful response"
  *     ),
  *     @OA\Response(
  *         response=404,
  *         description="Wrong Password | User doesn't exist"
  *     )
  * )
  */
  Flight::route('POST /login', function(){
      $login = Flight::request()->data->getData();
      $user = Flight::userDao()->get_user_by_username($login['username']);
      if (isset($user['id'])){
        if($user['password'] == $login['password']){
          unset($user['password']);
          $jwt = JWT::encode($user, Config::JWT_SECRET(), 'HS256');
          Flight::json(['token' => $jwt]);
        }else{
          Flight::json(["message" => "Wrong password"], 404);
        }
      }else{
        Flight::json(["message" => "User doesn't exist"], 404);
      }
  });

  /**
  * @OA\Post(
  *     path="/register",
  *     description="Register to the system",
  *     tags={"users"},
  *     @OA\RequestBody(description="Basic user info", required=true,
  *       @OA\MediaType(mediaType="application/json",
  *    			@OA\Schema(
  *           @OA\Property(property="username", type="string", example="azra",	description="Username"),
  *    				@OA\Property(property="email", type="string", example="azra@gmail.com",	description="Email"),
  *    				@OA\Property(property="password", type="string", example="12345678",	description="Password" ),
  *    				@OA\Property(property="licence_id", type="string", example="123456",	description="User licence ID"),
  *           @OA\Property(property="driver", type="string", example="yes",	description="Is driver?")
  *        )
  *     )),
  *     @OA\Response(
  *         response=200,
  *         description="JWT Token on successful response"
  *     ),
  *     @OA\Response(
  *         response=404,
  *         description="Wrong Password | User doesn't exist"
  *     )
  * )
  */
  Flight::route('POST /register', function()
  {
    $register = Flight::request()->data->getData();
    $existingUser = Flight::userDao()->get_user_by_username($register['username']);

    if (isset($existingUser['username'])){
      Flight::json(["message" => "User already exists"], 403);
    }else if (empty($register['username']) || empty($register['password']) || empty($register['email'])  || empty($register['licence_id'])) {
      Flight::json(["message" => "Make sure you filled all the fields."], 403);
    }else if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $register['username'])){
      Flight::json(["message" => "Username must not contain special characters."], 403);
    }else if (strlen($register['password'])<8) {
      Flight::json(["message" => "Password must be longer than 8 characters"], 403);
    }else if (strlen($register['username'])<3){
      Flight::json(["message" => "Username too short."], 403);
    }else{
      Flight::json(Flight::userDao()->add(Flight::request()->data->getData()));
    }
  });


 ?>
