<?php


namespace NewPlayerMC\Solarite\events;


use NewPlayerMC\Events;
use NewPlayerMC\Solarite\Core;
use NewPlayerMC\Solarite\utils\ConfigAPI;
use NewPlayerMC\Solarite\utils\HomeAPI;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockIds;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\item\Tool;
use pocketmine\level\particle\HeartParticle;
use pocketmine\math\Vector3;
use pocketmine\tile\EnderChest;
use pocketmine\tile\Tile;
use pocketmine\utils\Config;

class IListener implements \pocketmine\event\Listener
{
    /**
     * @var Config
     */
    public $db;


    /**
     * @var int
     */
    public $count = 0;

    public $cooldown = [];
    public $main;

    public function __construct(Core $main) {
        $this->main = $main;
        $this->db = new Config($this->main->getDataFolder() . 'db', Config::YAML);
    }

    public function onInteract(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $block = $event->getBlock();
        if ($item->getId() === 288) {
            HomeAPI::openMainTpMenu($player);
        }
        if ($item->getId() === ItemIds::DYE && $item->getDamage() === 8) {
            foreach($player->getInventory()->getContents() as $index => $item){
                if($this->isRepairable($item)){
                    if($item->getDamage() > 0){
                        $player->getInventory()->setItem($index, $item->setDamage(0));
                    }
                }
            }
            $player->sendMessage("§aTous vos items ont été réparés");
            foreach($player->getArmorInventory()->getContents() as $index => $item){
                if($this->isRepairable($item)){
                    if($item->getDamage() > 0){
                        $player->getArmorInventory()->setItem($index, $item->setDamage(0));
                    }
                }
            }
        }
        if ($item->getId() === 433) {
            $effects = [
                new EffectInstance(Effect::getEffect(Effect::SPEED), 20*30, 1),
                new EffectInstance(Effect::getEffect(Effect::STRENGTH), 20*30, 1),
                new EffectInstance(Effect::getEffect(Effect::HEALTH_BOOST), 20*30,1)
            ];
            $time = $this->db->get($player->getName());
            $timeN = time();
            if(empty($time)) {
                $time = 0;
            }
            if($timeN - $time >= 1.5*60) {
                $this->db->set($player->getName(), $timeN);
                $this->db->save();
                foreach ($effects as $effect) {
                    $player->addEffect($effect);
                }
            } else {
                $hms = explode(":", gmdate("i:s", (1.5*60) - ($timeN - $time)));
                $player->sendTip("§c$hms[0] minute(s) et $hms[1] seconde(s)");
            }
        }
        if($event->getItem()->getId() === 465) {
            $c = 0;
            foreach ($player->getInventory()->getContents() as $item) {
                if ($item instanceof Item && $item->getId() == 4 && $item->getDamage() == 0) $c += $item->getCount();
            }
            $player->sendMessage("$c pierres ont été supprimées de votre inventaire !");
            $player->getInventory()->removeItem(Item::get(4, 0, $c));
        }

    }

    public function isRepairable(Item $item): bool{
        return $item instanceof Tool || $item instanceof Armor;
    }
}