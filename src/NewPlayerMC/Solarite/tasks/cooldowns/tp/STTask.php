<?php


namespace NewPlayerMC\Solarite\tasks\cooldowns\tp;


use NewPlayerMC\Solarite\Core;
use pocketmine\level\particle\CriticalParticle;
use pocketmine\level\particle\DustParticle;
use pocketmine\level\particle\GenericParticle;
use pocketmine\level\particle\HappyVillagerParticle;
use pocketmine\level\particle\HeartParticle;
use pocketmine\level\particle\PortalParticle;
use pocketmine\level\particle\WaterDripParticle;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;
use pocketmine\scheduler\Task;

class STTask extends Task
{
    /** @var Player */
    private $player;

    private $time = 1;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function onRun(int $currentTick)
    {
        $player = $this->player;
        if ($this->time <= 5) {
            $this->circle1($player);
            $this->circle2($player);
            $this->circle3($player);
            $player->setImmobile(true);
            $player->getLevel()->broadcastLevelSoundEvent($player->asVector3(), LevelSoundEventPacket::SOUND_NOTE);
        }else {
            Core::getInstance()->getScheduler()->cancelTask($this->getTaskId());
            $player->teleport(Core::getInstance()->getServer()->getDefaultLevel()->getSpawnLocation());
            $player->sendMessage("§5- §fVous avez été téléporté au spawn !");
            $player->setImmobile(false);
        }
        $this->time++;
    }

    public function circle1(Player $player) {
        for ($i = 1; $i <= 360; $i++) {
            $a = cos($i * M_PI / 180) * 1;
            $b = sin($i * M_PI / 180) * 1;
            $player->getLevel()->addParticle(new PortalParticle($player->getPosition()->add($a, 0.5, $b)));
            $player->getLevel()->addParticle(new PortalParticle($player->getPosition()->add($a, 3, $b)));
            $player->getLevel()->addParticle(new PortalParticle($player->getPosition()->add($a, 5, $b)));
        }
    }

    public function circle2(Player $player) {
        for ($i = 1; $i <= 360; $i++) {
            $a = cos($i * M_PI / -180) * 3;
            $b = sin($i * M_PI / -180) * 3;
            $player->getLevel()->addParticle(new PortalParticle($player->getPosition()->add($a, 0.5, $b)));
            $player->getLevel()->addParticle(new PortalParticle($player->getPosition()->add($a, 3, $b)));
        }
    }

    public function circle3(Player $player) {
        for ($i = 1; $i <= 360; $i++) {
            $a = cos($i * M_PI / 180) * 5;
            $b = sin($i * M_PI / 180) * 5;
            $player->getLevel()->addParticle(new PortalParticle($player->getPosition()->add($a, 0.5, $b)));
            $player->getLevel()->addParticle(new PortalParticle($player->getPosition()->add($a, 3, $b)));
        }
    }



}