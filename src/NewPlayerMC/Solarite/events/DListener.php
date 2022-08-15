<?php


namespace NewPlayerMC\Solarite\events;


use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Armor;
use pocketmine\Player;
use pocketmine\Server;

class DListener implements \pocketmine\event\Listener
{
    public function onEntityDamage(EntityDamageEvent $event)
    {
        $player = $event->getEntity();
        if($player->getFloorY() < 0) {
            $event->setCancelled(true);
            $player->teleport(Server::getInstance()->getDefaultLevel()->getSpawnLocation());
        }
        if ($event instanceof EntityDamageByEntityEvent) {

            $player = $event->getEntity();
            $damager = $event->getDamager();

            if($damager instanceof Player and $player instanceof Player){

                $item = $damager->getInventory()->getItemInHand();

                if($item->getId() === 445){
                    $this->getDamage($event,$player,9);
                    $player->addEffect(new EffectInstance(Effect::getEffect(Effect::POISON), 20*12, 2));
                    $damager->getInventory()->removeItem($damager->getInventory()->getItemInHand()->setCount(1));
                }

            }

        }
        if($event->getCause() === EntityDamageEvent::CAUSE_FALL && $player instanceof Player){
            if($player->hasPermission('no.fall')) {
                $event->setCancelled(true);
            }
        }

    }

    public function getDamage($event , $player, int $basedamage )
    {
        $event->setModifier($basedamage,11);

        if($event->canBeReducedByArmor()){

            $event->setModifier(-$event->getFinalDamage() * $player->getArmorPoints() * 0.04, EntityDamageEvent::MODIFIER_ARMOR);

        }

        $cause = $event->getCause();

        if($player->hasEffect(Effect::DAMAGE_RESISTANCE) and $cause !== EntityDamageEvent::CAUSE_VOID and $cause !== EntityDamageEvent::CAUSE_SUICIDE){

            $event->setModifier(-$event->getFinalDamage() * min(1, 0.2 * $player->getEffect(Effect::DAMAGE_RESISTANCE)->getEffectLevel()), EntityDamageEvent::MODIFIER_RESISTANCE);

        }

        $totalEpf = 0;

        foreach($player->getArmorInventory()->getContents() as $item){

            if($item instanceof Armor){

                $totalEpf += $item->getEnchantmentProtectionFactor($event);

            }

        }

        $event->setModifier(-$event->getFinalDamage() * min(ceil(min($totalEpf, 25) * (mt_rand(50, 100) / 100)), 20) * 0.04, EntityDamageEvent::MODIFIER_ARMOR_ENCHANTMENTS);
        $event->setModifier(-min($player->getAbsorption(), $event->getFinalDamage()), EntityDamageEvent::MODIFIER_ABSORPTION);
    }

}