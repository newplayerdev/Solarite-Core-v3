<?php


namespace NewPlayerMC\Solarite\utils;


use NewPlayerMC\Solarite\Core;
use pocketmine\utils\Config;

class ConfigAPI
{
    public static function getConfig($playerName) {
        return new Config(Core::getInstance()->getDataFolder() . "{$playerName}.yml", Config::YAML);
    }

    public static function getInConfig($config, $key) {
        $config = new Config(Core::getInstance()->getDataFolder() . "$config.yml", Config::YAML);
        return $config->get($key);
    }

    public static function setInConfig($config, $key, $value) {
        $config = new Config(Core::getInstance()->getDataFolder() . "$config.yml", Config::YAML);
        $config->set($key, $value);
        $config->save();
    }

    public static function setNestedInConfig($config,$key, $value) {
        $config->setNested("homes." . $key, $value);
        $config->save();
    }

    public static function removeInConfig($config, $key) {
        $config = new Config(Core::getInstance()->getDataFolder() . "$config.yml", Config::YAML);
        $config->remove($key);
        $config->save();
    }

    public static function saveConfig($config) {
        $config = new Config(Core::getInstance()->getDataFolder() . "$config.yml", Config::YAML);
        $config->save();
    }

}