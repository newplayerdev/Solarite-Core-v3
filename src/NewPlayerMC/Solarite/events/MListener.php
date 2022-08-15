<?php


namespace NewPlayerMC\Solarite\events;


use NewPlayerMC\Solarite\utils\HomeAPI;
use pocketmine\block\Block;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\Server;

class MListener implements \pocketmine\event\Listener
{
public function onMove(PlayerMoveEvent $event)
{
    $player = $event->getPlayer();
    $block = $player->getLevel()->getBlock($player->subtract(0, 1, 0));
    $lvl = $player->getLevel();
    if ($block->getId() === 246) {
        if (!$event->isCancelled()) {
            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::BLINDNESS), 20 * 20, 9));
            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SLOWNESS), 20 * 20, 3));
            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::NAUSEA), 20 * 20, 6));
            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::POISON), 20 * 20, 2));
            $player->setOnFire(20);
            $lvl->setBlock(new Vector3($block->getX(), $block->getY() + 1, $block->getZ()), Block::get(Block::COBWEB));
            $player->sendPopup("Tu a été pris au piège !");
        } else {

        }

    } elseif ($block->getId() === 29) {
        $player->jump();
        $player->setMotion($player->getDirectionVector()->multiply(4));

    } elseif ($block->getId() === 4) {
        HomeAPI::openMainTpMenu($player);
    }
    foreach (Server::getInstance()->getOnlinePlayers() as $player) {
        if ($player instanceof Player) {
            if($player->getLevel() === Server::getInstance()->getLevelByName("map2f")) {
                if ($player->getX() > 4200 or $player->getX() < -4200 or $player->getZ() > 4200 or $player->getZ() < -4200) {
                    $player->sendTip("§cTu ne peux pas dépasser la bordure");
                    $event->setCancelled(true);

                }
            }
            if($player->getLevel() === Server::getInstance()->getLevelByName("map2m2")) {
                if ($player->getX() > 3400 or $player->getX() < -3400 or $player->getZ() > 3400 or $player->getZ() < -3400) {
                    $player->sendTip("§cTu ne peux pas dépasser la bordure");
                    $event->setCancelled(true);
                }
            }
        }
    }
}
}