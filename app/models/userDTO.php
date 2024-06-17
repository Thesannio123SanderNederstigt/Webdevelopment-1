<?php
namespace Models;

use Models\User;

include_once 'guid.php';

Class userDTO
{
    public string $username;
    public string $password;
    public string $email;

    public function __construct(){}

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

        return $user;
    }
}
?>