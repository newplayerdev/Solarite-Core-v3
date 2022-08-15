<?php


namespace NewPlayerMC\Solarite\events;


use NewPlayerMC\Solarite\Core;
use pocketmine\entity\Entity;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\level\particle\DustParticle;
use pocketmine\level\sound\PopSound;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Server;
use pocketmine\utils\Config;

class JListener implements \pocketmine\event\Listener
{
    public function onJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        if (!$player->hasPlayedBefore()) {
            $event->setJoinMessage(null);
            Server::getInstance()->broadcastMessage("§b-- §6{$player->getName()} §fvient d'arriver dans le royaume de Solarite pour la première fois! §b--\n§b-- §fUtilisez la commande §6/bvn §epour lui souhaiter la bienvenue !§b --");
            $player->sendMessage("§b-- §eBienvenue sur le royaume de Solarite! §b--\n§b-- §fPour te souhaiter la bienvenue tu as reçu un stuff de départ, bonne chance pour ton aventure sur Solarite! §b--");
            $player->getLevel()->addSound(new PopSound($player->asVector3()));
            $player->getLevel()->broadcastLevelSoundEvent($player->asVector3(), LevelSoundEventPacket::SOUND_LAUNCH);
            $minX = $player->x - rand(1, 5);
            $maxX = $player->x + rand(1, 5);
            $minY = $player->y - 1;
            $maxY = $player->y + rand(1, 2);
            $minZ = $player->z - rand(1, 5);
            $maxZ = $player->z + rand(1, 5);
            for ($x = $minX; $x <= $maxX; $x++) {
                for ($y = $minY; $y <= $maxY; $y++) {
                    for ($z = $minZ; $z <= $maxZ; $z++) {
                        $player->getLevel()->addParticle(new DustParticle(new Vector3($x, $y, $z), rand(0,255), rand(0,255), rand(0,255)));
                    }
                }
            }
            $items = [
                Item::get(Item::IRON_SWORD),
                Item::get(Item::DIAMOND_PICKAXE),
                Item::get(Item::TORCH, 0, 32),
                Item::get(Item::STEAK, 0, 32)
            ];
            $player->getArmorInventory()->setHelmet(Item::get(Item::IRON_HELMET));
            $player->getArmorInventory()->setChestplate(Item::get(Item::IRON_CHESTPLATE));
            $player->getArmorInventory()->setLeggings(Item::get(Item::IRON_LEGGINGS));
            $player->getArmorInventory()->setBoots(Item::get(Item::IRON_BOOTS));
            foreach ($items as $item) {
                $player->getInventory()->addItem($item);
            }
        } else {
            $event->setJoinMessage(null);
            Server::getInstance()->broadcastPopup("§b[§6+ §f{$player->getName()}§b]");
        }
    }

    public function onLeave(PlayerQuitEvent $event)
    {
        $player = $event->getPlayer();
        $event->setQuitMessage(" ");
        Server::getInstance()->broadcastTip("§c- §7[§c" . $player->getName() . "§7]");
    }

    public function onPreLogin(PlayerPreLoginEvent $event) {

        if(!$event->getPlayer()->isWhitelisted()) {
            $event->setKickMessage("§cLe serveur est actuelement en maitenance");
            $event->setCancelled(true);
        }
    }
}