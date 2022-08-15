<?php


namespace NewPlayerMC\Solarite\events;


use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;

class InvListener implements \pocketmine\event\Listener
{
    public function transacEvent(InventoryTransactionEvent $event)
    {
        if($event instanceof InventoryPickupItemEvent)
        {
            if($event->getItem()->getItem()->getCustomName() === "§cTerre de la loose") {
                $event->setCancelled(true);
            }
        }
    }
}