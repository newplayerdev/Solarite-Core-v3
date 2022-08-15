<?php


namespace NewPlayerMC\Solarite\tasks;


use NewPlayerMC\Solarite\Core;
use NewPlayerMC\Solarite\utils\ConfigAPI;
use pocketmine\Server;

class MTask extends \pocketmine\scheduler\Task
{

    public static $c;
    public function onRun(int $currentTick)
    {
        $messages = array(ConfigAPI::getConfig("messages")->getAll()["messages"]);
        self::$c = count(array(ConfigAPI::getConfig("messages")->getAll()["messages"]));
    }
}