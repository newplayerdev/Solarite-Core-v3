<?php


namespace NewPlayerMC\Solarite\events;


use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\Item;

class BBListener implements \pocketmine\event\Listener
{
    public function onBreak(BlockBreakEvent $event)
    {
        $block = $event->getBlock();
        $player = $event->getPlayer();
        if($block->getId() === 236 && $block->getDamage() === 14) {
            if(!$player->hasPermission("solarite.break")) {
                $event->setDrops(array(Item::get(0, 0, 0)));
                $player->sendTip("§cTu dois être niveau §610 §cen métier de mineur");
            }
        }
        if($block->getId() === 244 && $block->getDamage() === 7) {
            if(!$player->hasPermission("topaze.break")) {
                $event->setDrops(array(Item::get(0, 0, 0)));
                $player->sendTip("§cTu dois être niveau §615 §cen compétence d'agriculteur");
            }
            $rand = mt_rand(1, 200);
            if($player->getInventory()->getItemInHand() === 747){
                if($rand >= 1 && $rand <= 1) {
                    $event->setDrops(array(Item::get(331, 0, 1)));
                } elseif ($rand >= 2 && $rand <= 40) {
                    $event->setDrops(array(Item::get(458, 0, 1)));
                } elseif ($rand >= 40 && $rand <= 200) {
                    $event->setDrops(array(Item::get(0, 0, 0)));
                }
            }
        } if($block->getId() === 31 && $block->getDamage() === 1) {
        if(!$player->hasPermission("topaze.break")) {
            $event->setDrops(array(Item::get(0, 0, 0)));
        }
        $rand = mt_rand(1, 200);
        if($player->getInventory()->getItemInHand() === 747){
            if($rand >= 1 && $rand <= 1) {
                $event->setDrops(array(Item::get(331, 0, 1)));
            } elseif ($rand >= 2 && $rand <= 40) {
                $event->setDrops(array(Item::get(458, 0, 1)));
            } elseif ($rand >= 40 && $rand <= 200) {
                $event->setDrops(array(Item::get(0, 0, 0)));
            }
        }
        $random = mt_rand(1, 150);
        if($random === 1) {
            $event->setDrops(array(Item::get(421, 0, 1)));
        }
     }
    }

}