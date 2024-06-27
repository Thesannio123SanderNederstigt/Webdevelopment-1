<?php
namespace apiControllers;

use Dotenv\Dotenv;
use Exception;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use Services\userService;

class apiController
{
    function createObjectFromPostedJson($className)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $object = new $className();

        foreach ($data as $key => $value) {
            htmlspecialchars($value);
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

    public function generateJwt($user) {

        // phpdotenv utilization
        $dotenv = Dotenv::createImmutable(__DIR__ . '../../..');
        $dotenv->load();
        $dotenv->required(['SECRET_KEY', 'ISSUER', 'AUDIENCE']);

        $secret_key = $_ENV['SECRET_KEY'];
        $issuer = $_ENV['ISSUER'];
        $audience = $_ENV['AUDIENCE'];

        $issuedAt = time(); // issued at
        $notbefore = $issuedAt; //not valid before 
        $expire = $issuedAt + 900; // expiration time is set at +900 seconds (15 minutes)

        // JWT expiration times should be kept short (10-30 minutes)

        // note how these claims are 3 characters long to keep the JWT as small as possible
        $payload = array(
            "iss" => $issuer,
            "aud" => $audience,
            "iat" => $issuedAt,
            "nbf" => $notbefore,
            "exp" => $expire,
            "data" => array(
                "id" => $user->getId(),
                "username" => $user->getUsername(),
                "email" => $user->getEmail(),
                "isAdmin" => $user->getIsAdmin()
        ));

        $jwt = JWT::encode($payload, $secret_key, 'HS256');

        return 
            array(
                "message" => "Successful login",
                "jwt" => $jwt,
                "userId" => $user->getId(),
                "username" => $user->getUsername(),
                "userIsPremium" => $user->getIsPremium(),
                "userIsAdmin" => $user->getIsAdmin(),
                "expiresAt" => $expire
            );
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

        // phpdotenv utilization
       $dotenv = Dotenv::createImmutable(__DIR__ . '../../..');
       $dotenv->load();
       $dotenv->required(['SECRET_KEY', 'ISSUER', 'AUDIENCE']);

       // Decode JWT
       $secret_key = $_SERVER['SECRET_KEY'];

       if ($jwt) {
           try {
               $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
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

   private function JwtValidation($decodedJWT): bool
   {
        if($decodedJWT->iss !== $_SERVER['ISSUER'] || $decodedJWT->aud !== $_SERVER['AUDIENCE']) {
            return false;
        }

        if($decodedJWT->iat > time() || $decodedJWT->nbf > time() || $decodedJWT->exp < time()) {
            return false;
        }

        $userService = new UserService();
        $user = $userService->getOne($decodedJWT->data->id);

        if(!$user) {
            return false;
        }

        return true;
   }

   function checkApiKey()
   {
        try {
            //check api key header
            if(!isset($_SERVER['HTTP_X_API_KEY'])) {
                $this->respondWithError(401, "No api key provided");
                return;
            }

            //API key inlezen
            $apiKey = $_SERVER['HTTP_X_API_KEY'];
            
            // phpdotenv utilization
            $dotenv = Dotenv::createImmutable(__DIR__ . '../../..');
            $dotenv->load();
            $dotenv->required(['API_KEY']);

            if(!$apiKey)
            {
                return false;
            }

            if($apiKey !== $_SERVER['API_KEY'])
            {
                $this->respondWithError(401, "Incorrect api key provided");
                return;
            } 

            return true;
            
        } catch (Exception $e) {
            $this->respondWithError(401, $e->getMessage());
        return;
        }
    }
}
?>