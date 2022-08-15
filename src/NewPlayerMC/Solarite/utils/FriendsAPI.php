<?php


namespace NewPlayerMC\Solarite\utils;


use NewPlayerMC\Solarite\Core;
use NewPlayerMC\Solarite\utils\forms\CustomForm;
use NewPlayerMC\Solarite\utils\forms\SimpleForm;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;

class FriendsAPI
{
    private static $playerList = [];

    public static function friendsMenu(Player $player) {
        $form = new SimpleForm(function (Player $player, $data) {
         $res = $data;
         if (is_null($res)) return true;
         switch ($res) {
             case 0:
                self::addFriendMenu($player);
                 break;
             case 1:

                 break;
         }
        });
        $form->setTitle("§e- §fAmis §e-");
        $form->setContent("§e- §fQue voulez-vous faire ?");
        $form->addButton("§e- §fAjouter un amis");
        $form->addButton("§e- §fSupprimer un amis");
        $form->addButton("§e- §fVoir vos demandes");
        $form->addButton("§e- §fVoir vos amis");
        $form->addButton("§c- Fermer");
        $form->sendToPlayer($player);
        return $form;
    }

    public static function addFriendMenu(Player $player) {
        $form = new CustomForm(function (Player $player, $data) {

            if ($data[1] == true) {
                $list = [];
                foreach (Server::getInstance()->getOnlinePlayers() as $p) {
                    $list[] = $p->getName();
                }
                self::$playerList[$player->getName()] = $list;
                $index = $data[2];
                $playerName = self::$playerList[$player->getName()][$index];
                if ($playerName === $player->getName()) {
                    $player->sendMessage(ConfigAPI::getInConfig("messages", "friends_add_self"));
                    return true;
                }
                self::addFriend($player, $playerName);
                $message = str_replace("{friend}", $playerName, ConfigAPI::getInConfig("messages", "friends_send_succes"));
                $player->sendMessage($message);
            } else {
                $playerName = Server::getInstance()->getPlayerExact($data[0]);
                if ($playerName === $player->getName()) {
                    $player->sendMessage(ConfigAPI::getInConfig("messages", "friends_add_self"));
                    return true;
                }
                self::addFriend($player, $playerName);
                $message = str_replace("{friend}", $playerName, ConfigAPI::getInConfig("messages", "friends_send_succes"));
                $player->sendMessage($message);
            }
        });
        $form->setTitle("§e- §fAmis §e-");
        $form->addLabel("§e- §fQuel joueur voulez-vous ajouter commee amis ?");
        $form->addInput("§e- §fNom du joueur");
        $form->addToggle("§e- §fEntrer un nom, choisir un joueur");
        $form->addDropdown("§e- §fSéléctionner un joueur", Server::getInstance()->getOnlinePlayers());
        $form->sendToPlayer($player);
        return $form;
    }


    private static function addFriend(Player $player, Player $friend) {
        $config = new Config(Core::getInstance()->getDataFolder() . "friends/".strtolower($player->getName()), Config::YAML);
        ConfigAPI::setNestedInConfig($config, "friends", $friend);
    }

}