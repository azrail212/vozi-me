<?php


 /**
 * Function to list all categories
 */
  Flight::route('GET /users', function()
  {
    Flight::json(Flight::userService()->get_all());
  });

/**
 * Get individual user
 */
  Flight::route('GET /users/@id', function($id)
  {
   Flight::json(Flight::userService()->get_by_id($id));
  });

 /**
  * add user to db
  */
  Flight::route('POST /users', function()
  {
    Flight::json(Flight::userService()->add(Flight::request()->data->getData()));
  });

/**
 * delete user
 */
  Flight::route('DELETE /users/@id', function($id)
  {
    Flight::userService()->delete($id);
    Flight::json(["message" => "deleted"]);
  });

  /**
   * update user by id
   */
  Flight::route('PUT /users/@id', function($id)
  {
    $data = Flight::request()->data->getData();
    $data['id'] = $id;
    Flight::json(Flight::userService()->update($id, $data));
  });

  /**
  * @OA\Post(
  *     path="/login",
  *     description="Login to the system",
  *     tags={"users"},
  *     @OA\RequestBody(description="Basic user info", required=true,
  *       @OA\MediaType(mediaType="application/json",
  *    			@OA\Schema(
  *    				@OA\Property(property="email", type="string", example="azra",	description="Email"),
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
        if($user['password'] == md5($login['password'])){
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
  *    				@OA\Property(property="email", type="string", example="azra@fixit.ba",	description="Email"),
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
  Flight::route('POST /register', function()
  {
    $register = Flight::request()->data->getData();
    $existingUser = Flight::userDao()->get_user_by_username($register['username']);

    if (isset($existingUser['username'])){
      Flight::json(["message" => "User already exists"], 403);
    }else if (empty($register['username']) || empty($register['password']) || empty($register['email']) || empty($register['phone_number'])) {
      Flight::json(["message" => "Make sure you filled all the fields."], 403);
    }else if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $register['username'])){
      Flight::json(["message" => "Username must not contain special characters."], 403);
    }else if(!preg_match("/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/", $register['email'])){
      Flight::json(["message" => "Email is invalid."], 403);
    }else if (strlen($register['password'])<8) {
      Flight::json(["message" => "Password must be longer than 8 characters"], 403);
    }else if (strlen($register['username'])<3){
      Flight::json(["message" => "Username too short."], 403);
    }else{
      Flight::json(Flight::userDao()->add(Flight::request()->data->getData()));
    }
  });


 ?>
