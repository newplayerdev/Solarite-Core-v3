<?php


namespace NewPlayerMC\Solarite;

use NewPlayerMC\Solarite\events\{BBListener,
CListener,
DListener,
EListener,
HListener,
IListener,
InvListener,
JListener,
MListener,
PBListener};
use NewPlayerMC\Solarite\commands\ACommand;
use NewPlayerMC\Solarite\commands\homes\HomeCommand;
use NewPlayerMC\Solarite\blocks\{RandomOre, SMinerai};
use NewPlayerMC\Solarite\tasks\{BTask,
MTask};
use NewPlayerMC\Solarite\entity\Fireball;
use pocketmine\block\BlockFactory;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\entity\Entity;
use pocketmine\utils\Config;


class Core extends \pocketmine\plugin\PluginBase implements \pocketmine\event\Listener
{
    private static $instance;

    /** @var Config */
    public $config;

    /** @var Config */
    public $messages;

    /** @var Config */
    public $items;

    /** @var Config */
    public $cooldowns;

    public function onEnable()
    {
        $this->getLogger()->info("§6------------------------------------");
        $this->getLogger()->info("§e-- §bSolarite v3 §e--");
        $this->getLogger()->info("§6------------------------------------");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->initEvents();
        $this->initBlocks();
        $this->initEntity();
        $this->initCommands();
        self::$instance = $this;


        // [Config]
        @mkdir($this->getDataFolder());
        $this->saveResource('messages.yml', true);
        $this->saveResource('cooldowns.yml', true);
        $this->saveResource('items.yml', true);
        $this->saveResource('config.yml', true);

        // [Tasks]
        $this->getScheduler()->scheduleRepeatingTask(new BTask($this), 20);
        $this->getScheduler()->scheduleRepeatingTask(new MTask(), 20*10);
    }

    public function onDisable()
    {
        $this->getLogger()->info("§6------------------------------------");
        $this->getLogger()->info("§c-- §bSolarite v3 §c--");
        $this->getLogger()->info("§6------------------------------------");
        $this->getServer()->getCommandMap()->dispatch(new ConsoleCommandSender(), "stop");
    }

    public static function getInstance(): self {
        return self::$instance;
    }

    private function initEvents(): void {
        $events = [new BBListener(), new CListener(), new DListener(), new EListener(), new HListener($this), new IListener($this), new InvListener(), new JListener(), new MListener(), new PBListener($this)];
        foreach ($events as $event) {
            $this->getServer()->getPluginManager()->registerEvents($event, $this);
        }
    }

    private function initBlocks(): void {
        $blocks = [new SMinerai()];
        foreach ($blocks as $block) {
            $this->getServer()->getPluginManager()->registerEvents($block, $this);
        }
        BlockFactory::registerBlock(new RandomOre(), true);
    }

    private function initCommands(): void {
      $commands = [
          new ACommand($this)
      ];
      foreach ($commands as $command) {
          $this->getServer()->getCommandMap()->register("commands", $command);
        }
    }

    private function initEntity(): void {
        $entities = [
            Fireball::class
        ];
        foreach ($entities as $entity) {
            Entity::registerEntity($entity);
        }
    }

}