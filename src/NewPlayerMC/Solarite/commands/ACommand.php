<?php


namespace NewPlayerMC\Solarite\commands;


use NewPlayerMC\Solarite\Core;
use NewPlayerMC\Solarite\utils\FriendsAPI;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;

class ACommand extends \pocketmine\command\PluginCommand
{
    public function __construct(Core $core)
    {
        parent::__construct("amis", $core);
        $this->setDescription("Menu des amis");
        $this->setUsage("/amis");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player) {
            return true;
        }
        FriendsAPI::friendsMenu($sender);
    }

}