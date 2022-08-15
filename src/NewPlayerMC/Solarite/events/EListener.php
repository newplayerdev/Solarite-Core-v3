<?php


namespace NewPlayerMC\Solarite\events;


use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\player\PlayerItemConsumeEvent;

class EListener implements \pocketmine\event\Listener
{
    public function eat(PlayerItemConsumeEvent $ev)
    {
        if($ev->getItem()->getId() === 350) {
            $ev->getPlayer()->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 20*40, $ev->getPlayer()->getEffect(1)->getAmplifier() + 1));
            $ev->getPlayer()->getInventory()->removeItem($ev->getItem()->setCount(1));
        }
    }
}