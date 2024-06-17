<?php
namespace Services;

use Repositories\cardItemRepository;

class cardItemService
{
    private $repository;

    function __construct()
    {
        $this->repository = new cardItemRepository();
    }

    public function getAll($offset, $limit) 
    {
        return $this->repository->getAll($offset, $limit);
    }

    public function getOne($id) 
    {
        return $this->repository->getOne($id);
    }

    public function create($cardItem) 
    {       
        return $this->repository->create($cardItem);        
    }

    public function update($cardItem, $id) 
    {       
        return $this->repository->update($cardItem, $id);        
    }

    public function delete($id) 
    {       
        return $this->repository->delete($id);        
    }
}
?>