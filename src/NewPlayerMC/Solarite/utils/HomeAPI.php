<?php


namespace NewPlayerMC\Solarite\utils;


use NewPlayerMC\Solarite\Core;
use NewPlayerMC\Solarite\tasks\cooldowns\tp\PTTask;
use NewPlayerMC\Solarite\tasks\cooldowns\tp\STTask;
use NewPlayerMC\Solarite\utils\forms\CustomForm;
use NewPlayerMC\Solarite\utils\forms\SimpleForm;
use pocketmine\level\Level;
use pocketmine\level\Location;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\utils\Config;

class HomeAPI
{

    public static function openMainTpMenu(Player $player) {
        if(!file_exists(Core::getInstance()->getDataFolder() . "homes/" . strtolower($player->getName()))){
            @mkdir(Core::getInstance()->getDataFolder() . "/homes/");
            $config = new Config(Core::getInstance()->getDataFolder() . "homes/" . strtolower($player->getName()) . ".yml", Config::YAML);
            $config->set("max-homes", 3);
            $config->save();
        }
        $form = new SimpleForm(function ($player, $data) {
           $result = $data;
           if (is_null($result)) return true;
            switch ($result) {
                case 0:
                    self::openTpMenu($player);
                    break;
                case 1:
                    self::openCreatePointsMenu($player);
                    break;
                case 2:
                    self::openDeleteHomeMenu($player);
                    break;
                case 3:
                    // TODO: Fonctionnalitée de contacts
                    break;
            }
        });
        $form->setTitle("§5- §fTéléportation §5-");
        $form->setContent("§e- §fChoisissez un bouton:");
        $form->addButton("§5- §fSe téléporter à un point de téléportation");
        $form->addButton("§5- §fCréer un point de téléportation");
        $form->addButton("§5- §fSupprimer un point de téléportation");
        $form->addButton("§5- §fSe téléporter à un de vos contacts");
        $form->addButton("§c- Fermer");
        $form->sendToPlayer($player);
        return $form;
    }

    public static function openTpMenu(Player $player) {
        $form = new SimpleForm(function (Player $player, $data) {
            $res = $data;
            if (is_null($res)) return true;
            switch ($res) {
                case 0:
                    Core::getInstance()->getScheduler()->scheduleRepeatingTask(new STTask($player), 20);
                    break;
                case 1:
                    // TP au royaume du joueur
                    /*
                    Check si le joueur a un royaume
                    Check si le royaume à un point de tp
                    */
                    break;
                case 2:
                    self::openTpPointsMenu($player);
                    break;
            }
        });
        $form->setTitle("§5- §fTéléportation §5-");
        $form->setContent("§5- §fTéléportez vous quelque part \n §e- §fVous pouvez vous téléporter au spawn, à un de vos points de spawn ou à votre royaume");
        $form->addButton("§5- §fSe téléporter au spawn");
        $form->addButton("§5- §fSe téléporter à votre royaume");
        $form->addButton("§5- §fSe téléporter à un de vos points de téléportation");
        $form->addButton("§5- §fSe téléporter à un royaume public");
        $form->addButton("§c- Fermer");
        $form->sendToPlayer($player);
        return $form;
    }

    public static function openTpPointsMenu(Player $player) {
        $list = self::getHomes($player);
        $form = new CustomForm(function (Player $player, $data) use ($list) {
        $res = $data;
        $home = $list[$res[1]];
        $homeLocation = self::getHome($player->getName(), $home);
        if (is_null($res)) return true;
        self::tpHome($player, $homeLocation);
        if ($list == null) {
            self::noHomes($player);
            return true;
        }
        });
        $form->setTitle("§5- §fTéléportation §5-");
        $form->addLabel("§e- §fSélectionnez un de vos points de téléportation");
        $form->addDropdown("Vos points de tp:", $list);
        $form->sendToPlayer($player);
        return $form;
    }

    public static function tpHome(Player $player, Location $homeLocation) {
        Core::getInstance()->getScheduler()->scheduleRepeatingTask(new PTTask($player, $homeLocation), 20);
        $player->sendMessage(ConfigAPI::getInConfig("messages", "home_tp"));
    }

    public static function openCreatePointsMenu(Player $player) {
        $form = new CustomForm(function (Player $player, $data) {
            $result = $data;
            if (is_null($result)) return true;
            $homeName = self::removeQuotes($result[1]);
            self::createPoint($player, $homeName, $player->getLocation(), $player->getYaw(), $player->getPitch());
        });
        $form->setTitle("§5- §fTéléportation §5-");
        $form->addLabel("§5- §fCréer votre point de téléportation");
        $form->addInput("Nom de votre point point");
        $form->sendToPlayer($player);
        return $form;
    }

    public static function createPoint(Player $player, string $home, Location $location, float $yaw, float $pitch): void {
        if (count(self::getHomes($player)) >= ConfigAPI::getInConfig("homes/" . strtolower($player->getName()), "max-homes")) {
            $player->sendMessage("§c- §eTu as atteint ta limite de points de téléportation !\nPour en obtenir plus tu peux en acheter sur notre boutique !");
            return;
        }
        $home = self::removeQuotes($home);
        $config = new Config(Core::getInstance()->getDataFolder() . "homes/" . strtolower($player->getName()) . ".yml", Config::YAML);
        $config->setNested("homes." . $home, self::__toArray($location, $yaw, $pitch));
        $config->save();
        $player->sendMessage(ConfigAPI::getInConfig("messages", "home_create"));
    }

    public static function openDeleteHomeMenu(Player $player) {
        $list = self::getHomes($player);
        $form = new CustomForm(function ($player, $data) use ($list) {
            $result = $data;
            if (is_null($result)) return true;
            $res = $data;
            $home = $list[$res[1]];
            self::deleteHomes($player, $home);
            if ($list == null) {
                self::noHomes($player);
                return true;
            }

        });
        $form->setTitle("§e5 §fTéléportation §5-");
        $form->addLabel("§e- §fSupprimer un point de téléportation");
        $form->addDropdown("Vos points de tp:", $list);
        $form->sendToPlayer($player);
        return $form;
    }

    public static function noHomes(Player $player) {
        $form = new SimpleForm(function (Player $player, $data) {
            if (is_null($data)) return true;
            self::openCreatePointsMenu($player);
        });
        $form->setTitle("§5- §fTéléportation §5-");
        $form->setContent("§- §cVous n'avez pas de homes, vous pouvez en créer en appuyant sur le bouton ci-dessuous");
        $form->addButton("§5- §fCréer un home");
        $form->addButton("§c- Fermer");
        $form->sendToPlayer($player);
        return $form;
    }

    public static function deleteHomes(Player $player, $home) {
        $home = self::removeQuotes($home);
        $config = new Config(Core::getInstance()->getDataFolder() . "homes/" . strtolower($player) . ".yml", Config::YAML);
        $config->removeNested("homes." . $home);
        $config->save();
    }

    public static function getHomes(Player $player): ?array{
        $config = ConfigAPI::getConfig("homes/". strtolower($player->getName()));
        return $config->exists("homes") ? array_map("strval", array_keys($config->getAll()["homes"])) : null;
    }

    public static function getHome(string $player, string $home): Location{
        $home = self::removeQuotes($home);
        $config = new Config(Core::getInstance()->getDataFolder() . "homes/" . strtolower($player) . ".yml", Config::YAML);
        $homeArray = $config->getNested("homes." . $home);

        $location = null;
        if(Core::getInstance()->getServer()->isLevelGenerated($homeArray[5])){
            if(!Core::getInstance()->getServer()->isLevelLoaded($homeArray[5])){
                Core::getInstance()->getServer()->loadLevel($homeArray[5]);
            }
            $location = self::__toLocation($homeArray, Core::getInstance()->getServer()->getLevelByName($homeArray[5]));
        }
        return $location;
    }

    /**
     * Converts the location, yaw and pitch to array.
     *
     * @param Location $location
     * @param float    $yaw
     * @param float    $pitch
     * @return array
     */
    public static function __toArray(Location $location, float $yaw = 0.0, float $pitch = 0.0): array{
        return [(int) $location->getX(), (int) $location->getY(), (int) $location->getZ(), $yaw, $pitch, $location->getLevel()->getFolderName()];
    }

    /**
     * @param string $string
     * @return string
     */
    public static function removeQuotes(string $string): string{
        return str_replace(["\"", "'"], "", $string);
    }

    /**
     * Converts the array to Location.
     *
     * @param array      $array
     * @param Level|null $level
     * @return Location
     */
    public static function __toLocation(array $array, Level $level = null): Location{
        return new Location($array[0], $array[1], $array[2], $array[3], $array[4], $level);
    }

}