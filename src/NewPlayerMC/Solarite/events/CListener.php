<?php


namespace NewPlayerMC\Solarite\events;


use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\inventory\FurnaceSmeltEvent;
use pocketmine\level\Explosion;
use pocketmine\level\Position;

class CListener implements \pocketmine\event\Listener
{
    public function onCraft(CraftItemEvent $e)
    {
        $player = $e->getPlayer();
        foreach ($e->getInputs() as $input) {
            foreach ($e->getOutputs() as $output) {
                if ($input->getId() === 742 && $player->getArmorInventory()->getHelmet()->getId() !== 397 && $player->getArmorInventory()->getHelmet()->getDamage() !== 1){
                    $rand = mt_rand(1, 2);
                    if ($rand === 1) {
                        $pos = new Position($e->getPlayer()->getX(), $e->getPlayer()->getY(), $e->getPlayer()->getZ(), $e->getPlayer()->getLevel());
                        $explod = new Explosion($pos, 1.5);
                        $explod->explodeA();
                        $explod->explodeB();
                        $player->getInventory()->remove($output->setCount($e->getRepetitions()-1));
                        $player->sendPopup("§cTon craft a été loupé");
                    }
                }
                if($output->getId() === 351 && $output->getDamage() === 8) {
                    if(!$player->hasPermission("marteau.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §63 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 285) {
                    if(!$player->hasPermission("piochesolarite.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §64 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 284) {
                    if(!$player->hasPermission("pellesolarite.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §65 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 409) {
                    if(!$player->hasPermission("batonsolarite.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §66 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 286) {
                    if(!$player->hasPermission("hachesolarite.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §68 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 744) {
                    if(!$player->hasPermission("pelleiterium.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §69 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 744) {
                    if(!$player->hasPermission("pelleiterium.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §69 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 746) {
                    if(!$player->hasPermission("hacheiterium.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §610 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 745) {
                    if(!$player->hasPermission("piocheiterium.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §611 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 742) {
                    if(!$player->hasPermission("iterium.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §12 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 370) {
                    if(!$player->hasPermission("topaze.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §613 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 341) {
                    if(!$player->hasPermission("batontopaze.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §614 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 305) {
                    if(!$player->hasPermission("bottestopaze.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §615 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 304) {
                    if(!$player->hasPermission("jambierestopaze.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §616 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 303) {
                    if(!$player->hasPermission("plastrontopaze.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §617 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 302) {
                    if(!$player->hasPermission("casquetopaze.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §618 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 352) {
                    if(!$player->hasPermission("epeetopaze.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §619 §cen compétence de forgeron");
                    }
                }
                if($output->getId() === 315) {
                    if(!$player->hasPermission("plastronsolarite.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §68 §cen compétence d'assassin'");
                    }
                }
                if($output->getId() === 283) {
                    if(!$player->hasPermission("epeesolarite.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §611 §cen compétence d'assassin");
                    }
                }
                if($output->getId() === 783) {
                    if(!$player->hasPermission("epeeiterium.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §616 §cen compétence d'assassin");
                    }
                }
                if($output->getId() === 314) {
                    if(!$player->hasPermission("casquesolarite.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §614 §cen compétence d'assassin");
                    }
                }
                if($output->getId() === 317) {
                    if(!$player->hasPermission("bottessolarite.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §67 §cen compétence d'agriclteur");
                    }
                }
                if($output->getId() === 294) {
                    if(!$player->hasPermission("houesolarite.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §611 §cen compétence d'agriclteur");
                    }
                }
                if($output->getId() === 747) {
                    if(!$player->hasPermission("houeiterium.craft")) {
                        $e->setCancelled(true);
                        $player->sendTip("§cTu dois être niveau §614 §cen compétence d'agriclteur");
                    }
                }
            }
        }
    }

}