<?php


namespace NewPlayerMC\Solarite\tasks;

use NewPlayerMC\Solarite\Core;
use pocketmine\Player;
use pocketmine\Server;

class BTask extends \pocketmine\scheduler\Task
{

    private $plugin;

    public function __construct(Core $plugin) {
        $this->plugin = $plugin;
    }

    public function onRun($tick) {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            if ($player instanceof Player) {
                $faction = Server::getInstance()->getLevelByName("factionv2");
                if($player->getLevel() === $faction) {
                    if ($player->getX() > 4200 or $player->getX() < -4200 or $player->getZ() > 4200 or $player->getZ() < -4200) {
                        $player->sendTip("§cTu ne peux pas dépasser la bordure");
                    }
                }
                if($player->getLevel() === Server::getInstance()->getLevelByName("map2m2")) {
                    if ($player->getX() > 3400 or $player->getX() < -3400 or $player->getZ() > 3400 or $player->getZ() < -3400) {
                        $player->sendTip("§cTu ne peux pas dépasser la bordure");
                    }
                }
            }
        }
    }

}