<?php
namespace Services;

use Repositories\userRepository;

class userService
{
    private $repository;

    function __construct()
    {
        $this->repository = new userRepository();
    }

    public function getAll($offset, $limit) {

        $users = $this->repository->getAll($offset, $limit);

        foreach($users as $user) {
            $userSportsclubIds = $this->getUserSportsclubIds($user->getId());
            $user->setSportsclubs($userSportsclubIds);
        }
        return $users;
    }

    public function getOne($id) 
    {
        $user = $this->repository->getOne($id);

        if($user != false)
        {
            $user->setSportsclubs($this->getUserSportsclubIds($id));
        }

        return $user;
    }

    public function create($user) 
    {
        $newUser = $this->repository->create($user);
        
        $userSportsclubs = $user->getSportsclubs();

        foreach($userSportsclubs as $sportsclub) {
            $this->addUserSportsclub($user->getId(), $sportsclub->getId());
        }

        return $newUser;
    }

    public function update($user, $id) 
    {       
        return $this->repository->update($user, $id);        
    }

    public function delete($id) 
    {       
        return $this->repository->delete($id);        
    }

    public function loginCheck($username, $password)
    {
        return $this->repository->loginCredentialsCheck($username, $password);
    }

    //koppeltabel (users-sportsclubs) functies zijn hieronder uitgewerkt

    public function getUserSportsclubIds($userId)
    {
        return $this->repository->getUserSportsclubIds($userId);
    }

    public function addUserSportsclub($userId, $sportsclubId)
    {
        return $this->repository->insertUserSportsclub($userId, $sportsclubId);
    }

    public function deleteUserSportsclub($userId, $sportsclubId)
    {
        return $this->repository->deleteUserSportsclub($userId, $sportsclubId);
    }
}
?>