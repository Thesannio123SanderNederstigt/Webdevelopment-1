<?php
namespace apiControllers;

use Exception;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class apiController
{
    function createObjectFromPostedJson($className)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $object = new $className();
        foreach ($data as $key => $value) {
            htmlspecialchars($value); //TODO: check of dit een goed idee is als filter om te doen of niet...
            if(is_object($value)) {
                continue;
            }
            $object->{$key} = $value;
        }
        return $object;
    }

    function respond($data)
    {
        $this->respondWithCode(200, $data);
    }

    function respondWithError($httpcode, $message)
    {
        $data = array('errorMessage' => $message);
        $this->respondWithCode($httpcode, $data);
    }

    private function respondWithCode($httpcode, $data)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($httpcode);
        echo json_encode($data);
    }

    function checkForJwt() {
        // Check for token header
        if(!isset($_SERVER['HTTP_AUTHORIZATION'])) {
           $this->respondWithError(401, "No token provided");
           return;
       }

       // Read JWT from header
       $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
       // Strip the part "Bearer " from the header
       $arr = explode(" ", $authHeader);
       $jwt = $arr[1];

       // Decode JWT
       $secret_key = "YOUR_SECRET_KEY";

       if ($jwt) {
           try {
               $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
               // username is now found in
               // echo $decoded->data->username;
               if($this->JwtValidation($decoded))
               {
                return $decoded;
               }

           } catch (Exception $e) {
               $this->respondWithError(401, $e->getMessage());
               return;
           }
       }
   }

   function JwtValidation($decodedJWT): bool
   {
        return true;
   }
}
?>