<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once __DIR__.'/../vendor/autoload.php';
  require_once __DIR__.'/services/UserService.class.php';

  //we use this method so that we don't have to call dao each time we want to use it
  Flight::register('userService', 'UserService');

  Flight::map('error', function(Exception $ex){
    // Handle error
    Flight::json(['message' => $ex->getMessage()], 500);
});

  require_once __DIR__.'/routes/UserRoutes.php';

    /* REST API documentation endpoint */
    Flight::route('GET /docs.json', function(){
      $openapi = \OpenApi\scan('routes');
      header('Content-Type: application/json');
      echo $openapi->toJson();
    });


  Flight::start(); // start flight framework

?>
