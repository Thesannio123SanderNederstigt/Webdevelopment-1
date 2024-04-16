<?php
require __DIR__ . '/controller.php';
require __DIR__ . '/services/userservice.php';

class UserController extends Controller 
{
    private $userService;

    function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {
        $users = $this->userService->getAll();

        $this->checkMappingAndDisplayView($users);
    }

    /*public function create() {        
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            require '../views/user/create.php';
        }

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $title = htmlspecialchars($_POST['title']);
            $author = htmlspecialchars($_POST['author']);        
            $content = $_POST['content'];      
            
            $user = new \App\Models\User();
            $user->title = $title;
            $user->author = $author;
            $user->content = $content;

            $this->userService->insert($user);

            $this->index();
        }
    }*/
}
?>