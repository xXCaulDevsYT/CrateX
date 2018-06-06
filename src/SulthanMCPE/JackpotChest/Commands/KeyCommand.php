<?php

/**
 * ___  ___          _                  _____           _
 * |  \/  |         | |                /  __ \         | |
 * | .  . |_   _ ___| |_ ___ _ __ _   _| /  \/_ __ __ _| |_ ___
 * | |\/| | | | / __| __/ _ \ '__| | | | |   | '__/ _` | __/ _ \
 * | |  | | |_| \__ \ ||  __/ |  | |_| | \__/\ | | (_| | ||  __/
 * \_|  |_/\__, |___/\__\___|_|   \__, |\____/_|  \__,_|\__\___|
 *          __/ |                  __/ |
 *         |___/                  |___/  By @SulthanMCPE for PMMP
 *
 * JackpotChest, a Crate plugin for PocketMine-MP
 * Copyright (c) 2018 SulthanMCPE  < https://github.com/SulthanMCPE >
 *
 * Discord: SulthanMCPE#3717
 * Twitter: SulthanMCPE
 *
 * This software is distributed under "GNU General Public License v3.0".
 * This license allows you to use it and/or modify it but you are not at
 * all allowed to sell this plugin at any cost. If found doing so the
 * necessary action required would be taken.
 *
 * JackpotChest is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License v3.0 for more details.
 * You should have received a copy of the GNU General Public License v3.0
 * along with this program. If not, see
 * <https://opensource.org/licenses/GPL-3.0>.
 * ------------------------------------------------------------------------
 */

namespace SulthanMCPE\JackpotChest\Commands;

use SulthanMCPE\JackpotChest\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class KeyCommand extends PluginCommand
{
    /**
     * KeyCommand constructor.
     * @param string $name
     * @param Main $plugin
     */
    public function __construct(string $name, Main $plugin)
    {
        parent::__construct($name, $plugin);
        $this->setDescription("Give Crate Keys Player.");
        $this->setUsage("/key [type] [player] [amount]");
        $this->setPermission("mc.command.key");
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool|mixed
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
	if (!$this->testPermission($sender)) {
		return true;
	}
	
        $plugin = $this->getPlugin();
        if ($plugin instanceof Main) {
            if (!isset($args[0])) {
                $sender->sendMessage("Gunakan: /key [type] [player] [amount]");
                return true;
            }
            $target = $sender;
            $args[0] = strtolower($args[0]);
            if (isset($args[1])) {
                $target = $plugin->getServer()->getPlayer($args[1]);
                if (!$target instanceof Player) {
                    $sender->sendMessage(TextFormat::RED . "Player Tidak Ada.");
                    return true;
                }
            } else {
                if (!$target instanceof Player) {
                    $sender->sendMessage(TextFormat::RED . "Please Tulis Player.");
                    return true;
                }
            }
            if (!$plugin->getCrateType($args[0])) {
                $sender->sendMessage(TextFormat::RED . "Jenis Crate Tidak Ada.");
                return true;
            }
			if (isset($args[2]) and is_numeric($args[2])) {
				$amount = (int)$args[2];
			} else {
				$amount = (int)1;
			}
            $plugin->giveKey($target, $args[0], $amount);
            $sender->sendMessage(TextFormat::GREEN . ucfirst($args[0]) . " Key Berhasil Di Give.");
            return true;
        }
        return true;
    }
}
