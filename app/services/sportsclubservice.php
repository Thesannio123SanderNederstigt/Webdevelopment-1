<?php
namespace Services;

use Repositories\sportsclubRepository;

class sportsclubService
{
    private $repository;

    function __construct()
    {
        $this->repository = new sportsclubRepository();
    }

    public function getAll($offset, $limit)
    {
        return $this->repository->getAll($offset, $limit);
    }

    public function getOne($id)
    {
        return $this->repository->getOne($id);
    }

    public function create($sportsclub)
    {       
        return $this->repository->create($sportsclub);        
    }

    public function update($sportsclub, $id)
    {
        return $this->repository->update($sportsclub, $id);        
    }

    public function delete($id) 
    {       
        return $this->repository->delete($id);        
    }
}
?>