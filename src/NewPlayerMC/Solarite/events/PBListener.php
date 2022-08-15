<?php


namespace NewPlayerMC\Solarite\events;


use NewPlayerMC\Solarite\Core;
use pocketmine\event\block\BlockPlaceEvent;

class PBListener implements \pocketmine\event\Listener
{
    public $main;
    public function __construct(Core $main) {
        $this->main = $main;
    }

    public function onPose(BlockPlaceEvent $event)
    {
        $block = $event->getBlock();
        $item = $event->getItem();
        $player = $event->getPlayer();

        if($block->getId() === 54) {
            if($player->getLevel()->getName() === "minagev2") {
                $event->setCancelled(true);
                $player->sendMessage("§cTu n'as pas le droit de poser ce bloc en minage");
            }
        }
        if($item->getCustomName() === "§cTerre de la loose") {
            $event->setCancelled(true);
        }
        if($block->getId() === 131) {
            $event->setCancelled(true);
        }
    }
}