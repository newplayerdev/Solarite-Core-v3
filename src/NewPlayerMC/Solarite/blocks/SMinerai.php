<?php


namespace NewPlayerMC\Solarite\blocks;


use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\Item;

class SMinerai implements \pocketmine\event\Listener
{
  public function onBreak(BlockBreakEvent $event) {
      if($event->getBlock()->getId() === 14) {
          if(!$event->getPlayer()->hasPermission("solarite.break")) {
              $event->setDrops(array(Item::get(0, 0, 0)));
              $event->getPlayer()->sendTip("§cTu dois être niveau §610 §cen métier de mineur");
          }
      }
  }
}