<?php


/**
 * @OA\Info(title="VoziMe app API Specs", version="0.2", @OA\Contact(email="azra.becirovic@stu.ibu.edu.ba", name="Azra Kadric"))
 * @OA\OpenApi(
 *    @OA\Server(url="http://localhost/vozime/rest", description="Development Environment" ),
 *    @OA\Server(url="https://vozi-me-se.herokuapp.com/rest", description="Production Environment" )
 * ),
 * @OA\SecurityScheme(securityScheme="ApiKeyAuth", type="apiKey", in="header", name="Authorization" )
 */
