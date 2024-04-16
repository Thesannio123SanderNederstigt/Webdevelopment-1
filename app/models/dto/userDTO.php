<?php
namespace Models;

include_once '../user.php';
include_once 'guid.php';

Class userDTO
{
    public string $username;
    public string $password;
    public string $email;

    /*
    public function userDTO()
    {
    }
    */

    public function __construct($_username, $_password, $_email)
    {
        $this->username = $_username;
        $this->password = $_password;
        $this->email = $_email;
    }

    public function userMapper(): User
    {
        $user = new User();
        $user->setId(createGuid());
        $user->setUsername($this->username);
        $user->setPassword($this->password);
        $user->setEmail($this->email);

        $user->setIsAdmin(false);
        $user->setIsPremium(false);
        $user->setCardsAmount(0);
        $user->setSharedCardsAmount(0);
        $user->setBingocards(array());
        $user->setSportsclubs(array());
        //$user->setBingocards([]); //?
        //$user->setSportsclubs([]); //? is initialization required/necessary/desired here? idk... (I'll have to find out in testing/trial & error I guess...)

        return $user;
    }
}
?>