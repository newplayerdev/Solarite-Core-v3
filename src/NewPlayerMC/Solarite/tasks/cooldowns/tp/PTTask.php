<?php


namespace NewPlayerMC\Solarite\tasks\cooldowns\tp;


use NewPlayerMC\Solarite\Core;
use NewPlayerMC\Solarite\utils\ConfigAPI;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\PortalParticle;
use pocketmine\level\Position;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;

class PTTask extends \pocketmine\scheduler\Task
{
    /** @var Player  */
    private $player;

    private $homeLocation;

    private $time = 1;
    public function __construct(Player $player, $homeLocation) {
        $this->player = $player;
        $this->homeLocation = $homeLocation;
    }

    public function onRun(int $currentTick)
    {
        $player = $this->player;
        if ($this->time <= 5) {
            $this->circle3($player);
            $this->circle2($player);
            $this->circle1($player);
            $radio = 1;
            for ($y = 0; $y < 10; $y += 0.2) {
                $x = $radio * cos($y);
                $z = $radio * sin($y);
                $player->getLevel()->addParticle(new PortalParticle($player->getLocation()->add($x, $y, $z)));
            }
                $player->setImmobile(true);
                $player->getLevel()->broadcastLevelSoundEvent($player->asVector3(), LevelSoundEventPacket::SOUND_NOTE);
        } else {
            Core::getInstance()->getScheduler()->cancelTask($this->getTaskId());
            $player->teleport($this->homeLocation);
            $player->sendMessage("§5- §fVous avez été téléporté à votre point de téléportation !");
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
            $a = cos($i * M_PI / 180) * 3;
            $b = sin($i * M_PI / 180) * 3;
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