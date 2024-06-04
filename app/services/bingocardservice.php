<?php
namespace Services;
use Models\Bingocard;
use Repositories\bingocardRepository;

class bingocardService
{
    private $repository;

    function __construct()
    {
        $this->repository = new bingocardRepository();
    }

    public function getAll($offset, $limit) {

        $bingocards = $this->repository->getAll($offset, $limit);

        foreach($bingocards as $bingocard) {
            $cardItemIds = $this->getBingocardItemIds($bingocard->getId());
            $bingocard->setItems($cardItemIds);
        }

        return $bingocards;
    }

    public function getOne($id) 
    {
        $bingocard = $this->repository->getOne($id);

        $bingocard->setItems($this->getBingocardItemIds($id));

        return $bingocard;
    }

    public function getUserBingocards($userId) //Deze service wordt voor deze methode/functie toegevoegd aan de usercontroller om bingokaarten van een user op te kunnen halen
    {
        $userBingocards = $this->repository->getUserBingocards($userId);

        foreach($userBingocards as $bingocard)
        {
            $cardItemIds = $this->getBingocardItemIds($bingocard->getId());
            $bingocard->setItems($cardItemIds);
        }

        return $userBingocards;
    }

    public function create($bingocard) 
    {
        $newBingocard = $this->repository->create($bingocard);

        $bingocardItems = $bingocard->getItems();

        foreach($bingocardItems as $cardItem) {
            $this->addBingocardItem($bingocard->getId(), $cardItem->getId());
        }

        return $newBingocard;
    }

    public function update($bingocard, $id) 
    {       
        return $this->repository->update($bingocard, $id);        
    }

    public function updateLastAccessedOn($id)
    {
        return $this->repository->updateLastAccessedOn($id);
    }

    public function delete($id) 
    {       
        return $this->repository->delete($id);        
    }


    //koppeltabel (bingocard-carditem) functies zijn hieronder uitgewerkt

    public function getBingocardItemIds($bingocardId)
    {
        return $this->repository->getBingocardItemIds($bingocardId);
    }

    public function addBingocardItem($bingocardId, $cardItemId)
    {
        return $this->repository->insertBingocardItem($bingocardId, $cardItemId);
    }

    public function deleteBingocardItem($bingocardId, $cardItemId)
    {
        return $this->repository->deleteBingocardItem($bingocardId, $cardItemId);
    }
}
?>