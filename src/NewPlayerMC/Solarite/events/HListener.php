<?php


namespace NewPlayerMC\Solarite\events;


use NewPlayerMC\CarteTask;
use NewPlayerMC\Solarite\Core;
use NewPlayerMC\Solarite\tasks\CTask;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\item\Item;
use pocketmine\Player;

class HListener implements \pocketmine\event\Listener
{
    public $using=array();
    public $core;
    public function __construct(Core $core) {
        $this->events = $core;
    }

    public function onHeld(PlayerItemHeldEvent $event){
        $this->checkAndStart($event->getPlayer(),$event->getItem());
    }

    private function checkAndStart(Player $player,Item $itemHeld): void{
        $item = Item::get('414', 0);
        $name = $player->getName();

        if($itemHeld->equals($item,true,false)){
            if(empty($this->using[$name])){
                $this->core->getScheduler()->scheduleRepeatingTask(new CTask($player,$this, $this->core),3*20);
                $this->using[$name]=true;
            }
        }
    }
}